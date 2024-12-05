<?php

use Core\Database;
use Core\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$db = new Database;

$fields = [
    'Nomor' => [
        'label' => 'Nomor'
    ],
    'Jenis' => [
        'label' => 'Jenis'
    ],
    'NoDokumen' => [
        'label' => 'No. Dokumen',
        'type' => 'text'
    ],
    'TglDokumen' => [
        'label' => 'Tgl. Dokumen',
        'type' => 'date'
    ],
    'Relasi' => [
        'label' => 'Relasi'
    ],
    'StokPenerimaan' => [
        'label' => 'Terima',
        'type' => 'number'
    ],
    'StokPengeluaran' => [
        'label' => 'Keluar',
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
    $where = (empty($where) ? "WHERE " : " AND ") . " TglDokumen BETWEEN '$searchByDate[startDate]' AND '$searchByDate[endDate]'";
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
	Select 0 As Nomor, 'SALDOAWAL' As Jenis, Concat(Result.KodeProduk, ' - ', Result.NamaProduk) As NoDokumen, 
		'$searchByDate[startDate]' As TglDokumen, Result.Satuan As Relasi, 
		SUM(Result.JlhQty) As StokPenerimaan, 0 As StokPengeluaran 
	From 
		(
		Select F.id As KodeProduk, F.name As NamaProduk, F.unit As Satuan, 0 As JlhQty 
		From mst_items F Where F.id $filter_item
		
		Union
		
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

	Select 3 As Nomor, 'PENYESUAIAN' As Jenis, A.code As NoDokumen, A.adjust_date As TglDokumen, A.description As Relasi, 
		SUM(Case When COALESCE(A.qty, 0) > 0 Then COALESCE(A.qty, 0) Else 0 End) As StokPenerimaan, 
		SUM(Case When COALESCE(A.qty, 0) < 0 Then COALESCE(-A.qty, 0) Else 0 End) As StokPengeluaran
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

$filename = "stock-card-download-".date('Y-m-d H:i:s').".xlsx";

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'No');
$i=1;
foreach($fields as $index => $field)
{
    $sheet->setCellValue(chr($i+65).'1', $field['label']);
    $i++;
}

$sheet->setCellValue(chr($i+65).'1', 'Saldo');

$saldo = 0;
foreach($data as $no => $d)
{
    $cell = $no + 2;
    $sheet->setCellValue('A'.$cell, $no+1);
    $i=1;
    $saldo += $d->StokPenerimaan-$d->StokPengeluaran;
    foreach($fields as $index => $field)
    {
        $sheet->setCellValue(chr($i+65).$cell, $d->{$index});
        $i++;
    }
    $sheet->setCellValue(chr($i+65).$cell, $saldo);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet, 'Xlsx');
$writer->save('php://output');

// header('location:'.$filename);

// use exit to get rid of unexpected output afterward
exit();