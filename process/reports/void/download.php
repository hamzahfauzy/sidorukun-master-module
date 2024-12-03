<?php

use Core\Database;
use Core\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

$draw    = Request::get('draw', 1);
    $start   = Request::get('start', 0);
    $length  = Request::get('length', 20);
    $search  = Request::get('search.value', '');
    $order   = Request::get('order', [['column' => 1,'dir' => 'asc']]);
    $filter  = Request::get('filter', []);

    $searchByDate = Request::get('searchByDate', ['startDate' => date('Y-m-d'), 'endDate' => date('Y-m-d')]);

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

$filename = "void-download-".date('Y-m-d H:i:s').".xlsx";

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