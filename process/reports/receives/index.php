<?php

use Core\Database;
use Core\Page;
use Core\Request;
$db = new Database;

$fields = [
    'code' => [
        'label' => 'No. Terima',
        'type' => 'text'
    ],
    'receive_date' => [
        'label' => 'Tanggal Terima',
        'type' => 'date'
    ],
    'supplier_name' => [
        'label' => 'Nama Supplier',
        'type' => 'text',
    ],
    'item_name' => [
        'label' => 'Nama Barang',
        'type' => 'text'
    ],
    'qty_unit' => [
        'label' => 'QTY / Satuan',
        'type' => 'text'
    ]
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

    if($searchByDate)
    {
        $where = (empty($where) ? "WHERE " : " AND ") . " receive_date BETWEEN '$searchByDate[startDate]' AND '$searchByDate[endDate]'";
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

    $order_clause = "ORDER BY ".$col_order." ".$order[0]['dir'];
    if($draw == 1)
    {
        $order_clause = "ORDER BY code, receive_date, trn_receive_items.id";
    }

    $query = "SELECT 
        trn_receive_items.id id,
        trn_receives.code, 
        trn_receives.receive_date, 
        trn_receives.supplier_name, 
        mst_items.name item_name, 
        CONCAT(trn_receive_items.qty,' ',trn_receive_items.unit) qty_unit,
        mst_brands.name brand_name,
        mst_colors.name color_name,
        mst_motifs.name motif_name,
        mst_types.name type_name,
        mst_sizes.name size_name
    FROM 
        `trn_receive_items` 
    JOIN mst_items ON mst_items.id = trn_receive_items.item_id 
    JOIN mst_brands ON mst_brands.id = mst_items.brand_id
    JOIN mst_sizes ON mst_sizes.id = mst_items.size_id
    JOIN mst_colors ON mst_colors.id = mst_items.color_id
    JOIN mst_motifs ON mst_motifs.id = mst_items.motif_id
    JOIN mst_types ON mst_types.id = mst_items.type_id
    JOIN trn_receives ON trn_receives.id = trn_receive_items.receive_id AND trn_receives.status <> 'CANCEL'
    $where";

    $db->query = "$query $order_clause LIMIT $start,$length";
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

$title = 'Laporan Penerimaan Barang';
Page::setActive("master.reports.receives");
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

return view('master/views/reports/receives/index', compact('fields'));