<?php

use Core\Database;
use Core\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$db = new Database;

$fields = [
    'receive_date' => [
        'label' => 'Tanggal Terima',
        'type' => 'date'
    ],
    'code' => [
        'label' => 'No. Terima',
        'type' => 'text'
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

$query = "SELECT 
    trn_receive_items.id id,
    trn_receives.receive_date, 
    trn_receives.code, 
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
JOIN trn_receives ON trn_receives.id = trn_receive_items.receive_id
$where";

$db->query = "$query ORDER BY ".$col_order." ".$order[0]['dir'];
$data  = $db->exec('all');

$filename = "receive-download-".date('Y-m-d H:i:s').".xlsx";

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'No');
$i=1;
foreach($fields as $index => $field)
{
    $sheet->setCellValue(chr($i+65).'1', $field['label']);
    $i++;
}

foreach($data as $no => $d)
{
    $cell = $no + 2;
    $sheet->setCellValue('A'.$cell, $no+1);
    $i=1;
    foreach($fields as $index => $field)
    {
        $sheet->setCellValue(chr($i+65).$cell, $d->{$index});
        $i++;
    }
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet, 'Xlsx');
$writer->save('php://output');

// header('location:'.$filename);

// use exit to get rid of unexpected output afterward
exit();