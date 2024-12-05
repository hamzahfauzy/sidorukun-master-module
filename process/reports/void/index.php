<?php

use Core\Database;
use Core\Page;
use Core\Request;
$db = new Database;

$fields = [
    'NoDokumen' => [
        'label' => 'No. Dokumen',
        'type' => 'text'
    ],
    'TglDokumen' => [
        'label' => 'Tgl. Dokumen',
        'type' => 'date'
    ],
    'NamaRelasi' => [
        'label' => 'Nama Relasi',
        'type' => 'text'
    ],
    'Alasan' => [
        'label' => 'Alasan Cancel',
        'type' => 'text'
    ],
    'NamaProduk' => [
        'label' => 'Nama Barang',
        'type' => 'text'
    ],
    'qty' => [
        'label' => 'Qty',
        'type' => 'number'
    ],
    'Satuan'
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
    if (isset($filter['type_d'])) {
        $where = $where . " And C.type_id = '$filter[type_d]' ";
    }
    if (isset($filter['size_id'])) {
        $where = $where . " And C.size_id = '$filter[size_id]' ";
    }
    if (isset($filter['brand_id'])) {
        $where = $where . " And C.brand_id = '$filter[brand_id]' ";
    }
    if (isset($filter['motif_id'])) {
        $where = $where . " And C.motif_id = '$filter[motif_id]' ";
    }
    if (isset($filter['color_id'])) {
        $where = $where . " And C.color_id = '$filter[color_id]' ";
    }

    $col_order = $order[0]['column']-1;
    $col_order = $col_order < 0 ? 'NoDokumen' : $columns[$col_order];

    $query = "Select * From
(
Select 1 As Jenis, A.code As NoDokumen, Date(A.receive_date) As TglDokumen, 
	A.supplier_id As KodeRelasi, A.supplier_name As NamaRelasi, A.total_items, A.total_qty, 
	A.cancel_reason As Alasan, A.description As Keterangan, 
	B.item_id As KodeProduk, C.name As NamaProduk, B.qty, B.unit As Satuan 
From trn_receives A
	Inner Join trn_receive_items B On A.id = B.receive_id 
	Left Join mst_items C On B.item_id = C.id 
Where A.receive_date >= '$searchByDate[startDate] 00:00:00' 
	And A.receive_date <= '$searchByDate[endDate] 23:59:59' 
	And A.Status = 'CANCEL' 
$where

Union

Select 2 As Jenis, A.code As NoDokumen, Date(A.outgoing_date) As TglDokumen, 
	A.channel_id As KodeRelasi, A.channel_name As NamaRelasi, A.total_items, A.total_qty, 
	A.cancel_reason As Alasan, CONCAT(A.customer_name, ' - ', A.outgoing_type, ' - ', A.order_code, ' - ', A.receipt_code) As Keterangan, 
	B.item_id As KodeProduk, C.name As NamaProduk, B.qty, B.unit As Satuan 
From trn_outgoings A
	Inner Join trn_outgoing_items B On A.id = B.outgoing_id 
	Left Join mst_items C On B.item_id = C.id 
Where A.outgoing_date >= '$searchByDate[startDate] 00:00:00'
	And A.outgoing_date <= '$searchByDate[endDate] 23:59:59'
	And A.Status = 'CANCEL' 
$where

) Result

Order By Result.Jenis, Result.TglDokumen, Result.NoDokumen";

    $db->query = $query;
    $data  = $db->exec('all');

    $total = count($data);

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

$title = 'Laporan Cancel/Void';
Page::setActive("master.reports.void");
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

return view('master/views/reports/void/index', compact('fields'));