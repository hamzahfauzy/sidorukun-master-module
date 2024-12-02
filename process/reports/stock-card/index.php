<?php

use Core\Database;
use Core\Page;
use Core\Request;
$db = new Database;

$fields = [
    'Nomor',
    'Jenis',
    'NoDokumen' => [
        'label' => 'No. Dokumen',
        'type' => 'text'
    ],
    'TglDokumen' => [
        'label' => 'Tgl. Dokumen',
        'type' => 'date'
    ],
    'Relasi',
    'StokPenerimaan' => [
        'label' => 'Stok Penerimaan',
        'type' => 'number'
    ],
    'StokPengeluaran' => [
        'label' => 'Stok Pengeluaran',
        'type' => 'number'
    ],
];

if(isset($_GET['draw']))
{
    $draw    = Request::get('draw', 1);
    $start   = Request::get('start', 0);
    $length  = Request::get('length', 20);
    $search  = Request::get('search.value', '');
    $order   = Request::get('order', [['column' => 1,'dir' => 'asc']]);
    $filter  = Request::get('filter', []);

    $searchByDate = Request::get('searchByDate', ['startDate' => date('Y-m-d'), 'endDate' => date('Y-m-d')]);
    $filter_item = Request::get('filter_item');
    $filter_item = $filter_item ? " = $filter_item " : " <> 0";
    
    $columns = [];
    $search_columns = [];
    foreach($fields as $key => $field)
    {
        $columns[] = is_array($field) ? $key : $field;
        if(is_array($field) && isset($field['search']) && !$field['search']) continue;
        $search_columns[] = is_array($field) ? $key : $field;
    }

    $where = "";

    if(!empty($search))
    {
        $_where = [];
        foreach($search_columns as $col)
        {
            $_where[] = "$col LIKE '%$search%'";
        }

        $where = "WHERE (".implode(' OR ',$_where).")";
    }

    if($searchByDate)
    {
        $where = (empty($where) ? "WHERE " : " AND ") . " Tampil.TglDokumen BETWEEN '$searchByDate[startDate]' AND '$searchByDate[endDate]'";
    }

    $col_order = $order[0]['column']-1;
    $col_order = $col_order < 0 ? 'id' : $columns[$col_order];

    $having = "";

    if($filter)
    {
        $filter_query = [];
        foreach($filter as $f_key => $f_value)
        {
            $filter_query[] = "$f_key = '$f_value'";
        }

        $filter_query = implode(' AND ', $filter_query);

        $having = (empty($having) ? 'HAVING ' : ' AND ') . $filter_query;
    }

    $where = $where ." ". $having;

    $query = "Select Tampil.Nomor, Tampil.Jenis, Tampil.NoDokumen, Tampil.TglDokumen, Tampil.Relasi,
	Tampil.StokPenerimaan, Tampil.StokPengeluaran 
From 
(
	Select 0 As Nomor, 'SALDOAWAL' As Jenis, Concat(Result.KodeProduk, ' - ', Result.NamaProduk ) As NoDokumen, 
		'$searchByDate[startDate]' As TglDokumen, Result.Satuan As Relasi, 
		SUM(Result.JlhQty) As StokPenerimaan, 0 As StokPengeluaran 
	From 
		(
		Select Z.id As KodeProduk, Z.name As NamaProduk, Z.unit As Satuan, 
			SUM(Case When Y.qty Is Null Then 0 Else Y.qty End) As JlhQty 
		From trn_receives X
			Inner Join trn_receive_items Y On X.id = Y.receive_id 
			Left Join mst_items Z On Y.item_id = Z.id  
		Where X.receive_date < '$searchByDate[startDate]' And X.status <> 'CANCEL' 
			And Y.item_id $filter_item 
		Group By Z.id, Z.name, Z.unit 

		Union 

		Select C.id As KodeProduk, C.name As NamaProduk, C.unit As Satuan, 
			SUM(Case When -B.qty Is Null Then 0 Else -B.qty End) As JlhQty
		From trn_outgoings A
			Inner Join trn_outgoing_items B On A.id = B.outgoing_id  
			Left Join mst_items C On B.item_id = C.id  
		Where A.outgoing_date < '$searchByDate[startDate]' And A.status <> 'CANCEL'
			And B.item_id $filter_item 
		Group By C.id, C.name, C.unit 
	
		Union 

		Select O.id As KodeProduk, O.name As NamaProduk, O.unit As Satuan, 
			SUM(Case When M.qty Is Null Then 0 Else M.qty End) As JlhQty
		From trn_adjusts M 
			Inner Join mst_items O On M.item_id = O.id  
		Where M.adjust_date < '$searchByDate[startDate]' 
			And M.item_id $filter_item 
		Group By O.id, O.name, O.unit 
		
	) Result 
	
	Group By Result.KodeProduk, Result.NamaProduk, Result.Satuan 
		
	Union 

	Select 1 As Nomor, 'PENERIMAAN' As Jenis, A.code As NoDokumen, A.receive_date As TglDokumen, 
		Concat(C.name, ' - ', C.phone) As Relasi, SUM(COALESCE(B.qty, 0)) As StokPenerimaan, 0 As StokPengeluaran 
	From trn_receives A
		Inner Join trn_receive_items B On A.id = B.receive_id 
		Left Join mst_suppliers C On A.supplier_id = C.id 
	Where A.receive_date >= '$searchByDate[startDate]' And A.receive_date <= '$searchByDate[endDate]' 
		And A.status <> 'CANCEL' And B.item_id $filter_item 
	Group By A.code, A.receive_date, Concat(C.name, ' - ', C.phone)  

	Union

	Select 2 As Nomor, 'PENGELUARAN' As Jenis, A.code As NoDokumen, A.outgoing_date As TglDokumen, 
		Concat(A.channel_name, ' - ', A.customer_name) As Relasi, 0 As StokPenerimaan, SUM(COALESCE(B.Qty, 0)) As StokPengeluaran
	From trn_outgoings A
		Inner Join trn_outgoing_items B On A.id = B.outgoing_id 
	Where A.outgoing_date >= '$searchByDate[startDate]' And A.outgoing_date <= '$searchByDate[endDate]' 
		And A.status <> 'CANCEL' And B.item_id $filter_item 
	Group By A.code, A.outgoing_date, Concat(A.channel_name, ' - ', A.customer_name)  

	Union 

	Select 3 As Nomor, 'PENYESUAIAN' As Jenis, A.code As NoDokumen, A.adjust_date As TglDokumen, 
		A.description As Relasi, 0 As StokPenerimaan, -SUM(COALESCE(A.qty, 0)) As StokPengeluaran
	From trn_adjusts A 
	Where A.adjust_date >= '$searchByDate[startDate]' And A.adjust_date <= '$searchByDate[endDate]' 
		And A.item_id $filter_item  
	Group By A.code, A.adjust_date, A.description  
		
) Tampil 
$where
Order By Tampil.TglDokumen, Tampil.Nomor, Tampil.NoDokumen
    ";

    $db->query = $query;
    $data  = $db->exec('all');

    $total = count($data);

    $results = [];
    
    $saldo = 0;
    foreach($data as $key => $d)
    {
        $results[$key][] = $start+$key+1;
        $saldo += $d->StokPenerimaan-$d->StokPengeluaran;
        foreach($columns as $col)
        {
            $field = '';
            if(isset($fields[$col]))
            {
                $field = $fields[$col];
            }
            else
            {
                $field = $col;
            }
            $data_value = "";
            if(is_array($field))
            {
                $data_value = \Core\Form::getData($field['type'],$d->{$col},true);
                if($field['type'] == 'number')
                {
                    $data_value = (int) $data_value;
                    $data_value = number_format($data_value);
                }

                if($field['type'] == 'file')
                {
                    $data_value = '<a href="'.asset($data_value).'" target="_blank">Lihat File</a>';
                }
            }
            else
            {
                $data_value = $d->{$field};
            }

            $results[$key][] = $data_value;
        }

        $results[$key][] = $saldo;
    }

    return json_encode([
        "draw" => $draw,
        "recordsTotal" => (int)$total,
        "recordsFiltered" => (int)$total,
        "data" => $results
    ]);
}
$fields['Saldo'] = [
    'label' => 'Saldo',
    'type' => 'number'
];

$title = 'Laporan Kartu Stok';
Page::setActive("master.reports.stock-card");
Page::setTitle($title);
Page::setModuleName('master.reports');
Page::setBreadcrumbs([
    [
        'url' => routeTo('/'),
        'title' => __('crud.label.home')
    ],
    [
        'title' => $title
    ]
]);

Page::pushHead('<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />');
Page::pushHead('<style>.select2,.select2-selection{height:38px!important;} .select2-container--default .select2-selection--single .select2-selection__rendered{line-height:38px!important;}.select2-selection__arrow{height:34px!important;}</style>');
Page::pushFoot('<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>');
Page::pushFoot("<script src='https://cdnjs.cloudflare.com/ajax/libs/qs/6.11.0/qs.min.js'></script>");
Page::pushFoot("<script src='".asset('assets/master/js/reports.js')."'></script>");

return view('master/views/reports/stock-card/index', compact('fields'));