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
    'SaldoAwal' => [
        'label' => 'Saldo Awal',
        'type' => 'number'
    ],
    'Terima' => [
        'label' => 'Terima',
        'type' => 'number'
    ],
    'Keluar' => [
        'label' => 'Keluar',
        'type' => 'number'
    ],
    'Penyesuaian' => [
        'label' => 'Penyesuaian',
        'type' => 'number'
    ],
    'SaldoAkhir' => [
        'label' => 'Saldo Akhir',
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

// if($searchByDate)
// {
//     $where = (empty($where) ? "WHERE " : " AND ") . " receive_date BETWEEN '$searchByDate[startDate]' AND '$searchByDate[endDate]'";
// }

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

$query = "Select Result.KodeProduk, Result.NamaProduk, Result.Satuan,
	SUM(Coalesce(Result.SaldoAwal, 0)) As SaldoAwal, 
	SUM(Coalesce(Result.Terima, 0)) As Terima, 
	SUM(Coalesce(Result.Keluar, 0)) As Keluar, 
	SUM(Coalesce(Result.Penyesuaian, 0)) As Penyesuaian, 
	SUM(Coalesce(Result.SaldoAwal, 0)) + SUM(Coalesce(Result.Terima, 0)) - SUM(Coalesce(Result.Keluar, 0)) + SUM(Coalesce(Result.Penyesuaian, 0)) As SaldoAkhir,
    Result.type_id, Result.size_id, Result.brand_id, Result.motif_id, Result.color_id
From 
	(
	Select 0 As Jenis, F.id As KodeProduk, F.name As NamaProduk, F.unit As Satuan, 0 As SaldoAwal,
		0 As Terima, 0 As Keluar, 0 As Penyesuaian, 0 As SaldoAkhir, F.type_id, F.size_id, F.brand_id, F.motif_id, F.color_id, 0 As IdTransaksi 
	From mst_items F 
	
	Union
	
	Select 0 As Jenis, Z.id As KodeProduk, Z.name As NamaProduk, Z.unit As Satuan, 
		SUM(Case When Y.qty Is Null Then 0 Else Y.qty End) As SaldoAwal,
		0 As Terima, 0 As Keluar, 0 As Penyesuaian, 0 As SaldoAkhir,
        Z.type_id, Z.size_id, Z.brand_id, Z.motif_id, Z.color_id, X.Code As IdTransaksi 
	From trn_receives X
		Inner Join trn_receive_items Y On X.id = Y.receive_id 
		Left Join mst_items Z On Y.item_id = Z.id  
	Where X.receive_date < '$searchByDate[startDate]' And X.status <> 'CANCEL' 
	Group By Z.id, Z.name, Z.unit, Z.type_id, Z.size_id, Z.brand_id, Z.motif_id, Z.color_id, X.Code  

	Union 

	Select 0 As Jenis, C.id As KodeProduk, C.name As NamaProduk, C.unit As Satuan, 
		SUM(Case When -B.qty Is Null Then 0 Else -B.qty End) As SaldoAwal, 
		0 As Terima, 0 As Keluar, 0 As Penyesuaian, 0 As SaldoAkhir,
        C.type_id, C.size_id, C.brand_id, C.motif_id, C.color_id, A.Code As IdTransaksi 
	From trn_outgoings A
		Inner Join trn_outgoing_items B On A.id = B.outgoing_id  
		Left Join mst_items C On B.item_id = C.id  
	Where A.outgoing_date < '$searchByDate[startDate]' And A.status <> 'CANCEL' 
	Group By C.id, C.name, C.unit, C.type_id, C.size_id, C.brand_id, C.motif_id, C.color_id, A.Code

	Union 

	Select 0 As Jenis, O.id As KodeProduk, O.name As NamaProduk, O.unit As Satuan, 
		SUM(Case When M.qty Is Null Then 0 Else M.qty End) As SaldoAwal, 
		0 As Terima, 0 As Keluar, 0 As Penyesuaian, 0 As SaldoAkhir,
        O.type_id, O.size_id, O.brand_id, O.motif_id, O.color_id, M.Code As IdTransaksi
	From trn_adjusts M 
		Inner Join mst_items O On M.item_id = O.id  
	Where M.adjust_date < '$searchByDate[startDate]' 
	Group By O.id, O.name, O.unit, O.type_id, O.size_id, O.brand_id, O.motif_id, O.color_id, M.Code

	Union 

	Select 1 As Jenis, Z.id As KodeProduk, Z.name As NamaProduk, Z.unit As Satuan, 
		0 As SaldoAwal, SUM(Case When Y.qty Is Null Then 0 Else Y.qty End) As Terima, 
		0 As Keluar, 0 As Penyesuaian, 0 As SaldoAkhir,
        Z.type_id, Z.size_id, Z.brand_id, Z.motif_id, Z.color_id, X.Code As IdTransaksi 
	From trn_receives X
		Inner Join trn_receive_items Y On X.id = Y.receive_id 
		Left Join mst_items Z On Y.item_id = Z.id  
	Where X.receive_date >= '$searchByDate[startDate]' And X.receive_date <= '$searchByDate[endDate]' And X.status <> 'CANCEL' 
	Group By Z.id, Z.name, Z.unit, Z.type_id, Z.size_id, Z.brand_id, Z.motif_id, Z.color_id, X.Code

	Union

	Select 2 As Jenis, C.id As KodeProduk, C.name As NamaProduk, C.unit As Satuan, 
		0 As SaldoAwal, 0 As Terima, SUM(Case When B.qty Is Null Then 0 Else B.qty End) As Keluar, 
		0 As Penyesuaian, 0 As SaldoAkhir,
        C.type_id, C.size_id, C.brand_id, C.motif_id, C.color_id, A.Code As IdTransaksi 
	From trn_outgoings A
		Inner Join trn_outgoing_items B On A.id = B.outgoing_id  
		Left Join mst_items C On B.item_id = C.id  
	Where A.outgoing_date >= '$searchByDate[startDate]' And A.outgoing_date <= '$searchByDate[endDate]' And A.status <> 'CANCEL' 
	Group By C.id, C.name, C.unit, C.type_id, C.size_id, C.brand_id, C.motif_id, C.color_id, A.Code 

	Union 

	Select 3 As Jenis, O.id As KodeProduk, O.name As NamaProduk, O.unit As Satuan, 
		0 As SaldoAwal, 0 As Terima, 0 As Keluar, 
		SUM(Case When M.qty Is Null Then 0 Else M.qty End) As Penyesuaian, 0 As SaldoAkhir,
        O.type_id, O.size_id, O.brand_id, O.motif_id, O.color_id, M.Code As IdTransaksi 
	From trn_adjusts M 
		Inner Join mst_items O On M.item_id = O.id  
	Where M.adjust_date >= '$searchByDate[startDate]' And M.adjust_date <= '$searchByDate[endDate]' 
	Group By O.id, O.name, O.unit, O.type_id, O.size_id, O.brand_id, O.motif_id, O.color_id, M.Code  
	) Result 
GROUP BY Result.KodeProduk, Result.NamaProduk, Result.Satuan, Result.type_id, Result.size_id, Result.brand_id, Result.motif_id, Result.color_id
$where";

$db->query = "$query ORDER BY ".$col_order." ".$order[0]['dir'];
$data  = $db->exec('all');

$filename = "stock-download-".date('Y-m-d H:i:s').".xlsx";

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