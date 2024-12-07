<?php

use Core\Database;
use Core\Page;
use Core\Request;
$db = new Database;

$fields = [
    'KodeProduk' => [
        'label' => 'Kode Produk',
        'type' => 'text'
    ],
    'NamaProduk' => [
        'label' => 'Nama Produk',
        'type' => 'text'
    ],
    'Satuan' => [
        'label' => 'Satuan',
        'type' => 'text',
    ],
    'Stok' => [
        'label' => 'Stok',
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

    $col_order = $order[0]['column']-1;
    $col_order = $col_order < 0 ? 'KodeProduk' : $columns[$col_order];

    // $having = "";
    $clause1 = "";
    $clause2 = "";
    $clause3 = "";

    if($filter)
    {
        $filter_query = [];
        $filter_query2 = [];
        $filter_query3 = [];
        foreach($filter as $f_key => $f_value)
        {
            $filter_query[] = "Z.$f_key = '$f_value'";
            $filter_query2[] = "C.$f_key = '$f_value'";
            $filter_query3[] = "O.$f_key = '$f_value'";
        }

        $filter_query = implode(' AND ', $filter_query);
        $filter_query2 = implode(' AND ', $filter_query2);
        $filter_query3 = implode(' AND ', $filter_query3);

        $clause1 = " AND ($filter_query)";
        $clause2 = " AND ($filter_query2)";
        $clause3 = " AND ($filter_query3)";
    }

    $query = "Select Result.KodeProduk, Result.NamaProduk, Result.Satuan, SUM(Result.JlhQty) As Stok 
From 
(
	Select 1 As Jenis, Z.id As KodeProduk, Z.name As NamaProduk, Z.unit As Satuan, 
		SUM(Case When Y.qty Is Null Then 0 Else Y.qty End) As JlhQty, X.Code As IdTransaksi  
	From trn_receives X
		Inner Join trn_receive_items Y On X.id = Y.receive_id 
		Left Join mst_items Z On Y.item_id = Z.id  
	Where X.receive_date <= '$searchByDate[endDate]' And X.status <> 'CANCEL' 
    $clause1
	Group By Z.id, Z.name, Z.unit, X.Code 

	Union 

	Select 2 As Jenis, C.id As KodeProduk, C.name As NamaProduk, C.unit As Satuan, 
		  SUM(Case When -B.qty Is Null Then 0 Else -B.qty End) As JlhQty, A.Code As IdTransaksi 
	From trn_outgoings A
		Inner Join trn_outgoing_items B On A.id = B.outgoing_id  
		Left Join mst_items C On B.item_id = C.id  
	Where A.outgoing_date <= '$searchByDate[endDate]' And A.status <> 'CANCEL'
    $clause2
	Group By C.id, C.name, C.unit, A.Code  

	Union 

	Select 3 As Jenis, O.id As KodeProduk, O.name As NamaProduk, O.unit As Satuan, 
		  SUM(Case When M.qty Is Null Then 0 Else M.qty End) As JlhQty, M.Code As IdTransaksi 
	From trn_adjusts M 
		Left Join mst_items O On M.item_id = O.id  
	Where M.adjust_date <= '$searchByDate[endDate]' 
    $clause3
	Group By O.id, O.name, O.unit, M.Code 
) Result 
$where
Group By Result.KodeProduk, Result.NamaProduk, Result.Satuan";

    $db->query = "$query ORDER BY ".$col_order." ".$order[0]['dir']." LIMIT $start,$length";
    $data  = $db->exec('all');

    $db->query = $query;
    $total = $db->exec('exists');

    $results = [];
    
    foreach($data as $key => $d)
    {
        $results[$key][] = $start+$key+1;
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
    }

    return json_encode([
        "draw" => $draw,
        "recordsTotal" => (int)$total,
        "recordsFiltered" => (int)$total,
        "data" => $results
    ]);
}

$title = 'Laporan Pencarian';
Page::setActive("master.reports.search");
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

return view('master/views/reports/search/index', compact('fields'));