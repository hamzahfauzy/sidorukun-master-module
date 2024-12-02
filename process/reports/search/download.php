<?php

use Core\Database;
use Core\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
	Select Z.id As KodeProduk, Z.name As NamaProduk, Z.unit As Satuan, 
		SUM(Case When Y.qty Is Null Then 0 Else Y.qty End) As JlhQty 
	From trn_receives X
		Inner Join trn_receive_items Y On X.id = Y.receive_id 
		Inner Join mst_items Z On Y.item_id = Z.id  
	Where X.receive_date <= '$searchByDate[endDate]' And X.status <> 'CANCEL' 
		$clause1
	Group By Z.id, Z.name, Z.unit 

	Union 

	Select C.id As KodeProduk, C.name As NamaProduk, C.unit As Satuan, 
		  SUM(Case When -B.qty Is Null Then 0 Else -B.qty End) As JlhQty
	From trn_outgoings A
		Inner Join trn_outgoing_items B On A.id = B.outgoing_id  
		Inner Join mst_items C On B.item_id = C.id  
	Where A.outgoing_date <= '$searchByDate[endDate]' And A.status <> 'CANCEL'
		$clause2
	Group By C.id, C.name, C.unit 

	Union 

	Select O.id As KodeProduk, O.name As NamaProduk, O.unit As Satuan, 
		  SUM(Case When M.qty Is Null Then 0 Else M.qty End) As JlhQty
	From trn_adjusts M 
		Inner Join mst_items O On M.item_id = O.id  
	Where M.adjust_date <= '$searchByDate[endDate]' 
		$clause3
	Group By O.id, O.name, O.unit 
) Result 
$where
Group By Result.KodeProduk, Result.NamaProduk, Result.Satuan";

$db->query = "$query ORDER BY ".$col_order." ".$order[0]['dir'];
$data  = $db->exec('all');

$filename = "search-download-".date('Y-m-d H:i:s').".xlsx";

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