<?php

use Core\Database;
use Core\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$db = new Database;

$fields = [
    'code' => [
        'label' => 'No. Keluar',
        'type' => 'text'
    ],
    'outgoing_date' => [
        'label' => 'Tanggal Keluar',
        'type' => 'date'
    ],
    'customer_name' => [
        'label' => 'Nama Customer',
        'type' => 'text',
    ],
    'channel_name' => [
        'label' => 'Nama Channel',
        'type' => 'text',
    ],
    'outgoing_type' => [
        'label' => 'Jenis',
        'type' => 'text',
    ],
    'item_name' => [
        'label' => 'Nama Barang',
        'type' => 'text'
    ],
    'qty_unit' => [
        'label' => 'QTY / Satuan',
        'type' => 'text'
    ],
    'receipt_code' => [
        'label' => 'No. Resi',
        'type' => 'text'
    ],
    'order_code' => [
        'label' => 'No. Pesanan',
        'type' => 'text'
    ],
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
    $where = (empty($where) ? "WHERE " : " AND ") . " outgoing_date BETWEEN '$searchByDate[startDate]' AND '$searchByDate[endDate]'";
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
    $order_clause = "ORDER BY outgoing_date desc, code asc";
}

$query = "SELECT 
    trn_outgoing_items.id id,
    trn_outgoings.code, 
    trn_outgoings.outgoing_date, 
    trn_outgoings.customer_name, 
    trn_outgoings.channel_name, 
    trn_outgoings.outgoing_type, 
    mst_items.name item_name, 
    CONCAT(trn_outgoing_items.qty,' ',trn_outgoing_items.unit) qty_unit,
    trn_outgoings.receipt_code, 
    trn_outgoings.order_code, 
    mst_brands.name brand_name,
    mst_colors.name color_name,
    mst_motifs.name motif_name,
    mst_types.name type_name,
    mst_sizes.name size_name
FROM 
    `trn_outgoing_items` 
JOIN mst_items ON mst_items.id = trn_outgoing_items.item_id 
JOIN mst_brands ON mst_brands.id = mst_items.brand_id
JOIN mst_sizes ON mst_sizes.id = mst_items.size_id
JOIN mst_colors ON mst_colors.id = mst_items.color_id
JOIN mst_motifs ON mst_motifs.id = mst_items.motif_id
JOIN mst_types ON mst_types.id = mst_items.type_id
JOIN trn_outgoings ON trn_outgoings.id = trn_outgoing_items.outgoing_id AND trn_outgoings.status <> 'CANCEL'
$where";

$db->query = "$query $order_clause";
$data  = $db->exec('all');

$filename = "outgoing-download-".date('Y-m-d H:i:s').".xlsx";

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