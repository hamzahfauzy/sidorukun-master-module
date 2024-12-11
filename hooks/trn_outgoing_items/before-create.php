<?php

use Core\Validation;

if(!isset($data['outgoing_id']) && isset($_GET['filter']['outgoing_id']))
{
    $data['outgoing_id'] = $_GET['filter']['outgoing_id'];
}

$outgoing = $db->single('trn_outgoings', ['id' => $data['outgoing_id']]);

$db->query = "Select Result.KodeProduk, Result.NamaProduk, Result.Satuan, SUM(Result.JlhQty) As Stok 
From 
(
	Select 1 As Jenis, Z.id As KodeProduk, Z.name As NamaProduk, Z.unit As Satuan, 
		SUM(Case When Y.qty Is Null Then 0 Else Y.qty End) As JlhQty, X.Code As IdTransaksi  
	From trn_receives X
		Inner Join trn_receive_items Y On X.id = Y.receive_id 
		Left Join mst_items Z On Y.item_id = Z.id  
	Where X.receive_date <= '$outgoing->outgoing_date' And Y.item_id = '$data[item_id]' And X.status <> 'CANCEL' 
	Group By Z.id, Z.name, Z.unit, X.Code 

	Union 

	Select 2 As Jenis, C.id As KodeProduk, C.name As NamaProduk, C.unit As Satuan, 
		  SUM(Case When -B.qty Is Null Then 0 Else -B.qty End) As JlhQty, A.Code As IdTransaksi 
	From trn_outgoings A
		Inner Join trn_outgoing_items B On A.id = B.outgoing_id  
		Left Join mst_items C On B.item_id = C.id  
	Where A.outgoing_date <= '$outgoing->outgoing_date' And B.item_id = '$data[item_id]' And A.status <> 'CANCEL'
	Group By C.id, C.name, C.unit, A.Code  

	Union 

	Select 3 As Jenis, O.id As KodeProduk, O.name As NamaProduk, O.unit As Satuan, 
		  SUM(Case When M.qty Is Null Then 0 Else M.qty End) As JlhQty, M.Code As IdTransaksi 
	From trn_adjusts M 
		Left Join mst_items O On M.item_id = O.id  
	Where M.adjust_date <= '$outgoing->outgoing_date' And M.item_id = '$data[item_id]' 
	Group By O.id, O.name, O.unit, M.Code 
) Result 
Group By Result.KodeProduk, Result.NamaProduk, Result.Satuan
Having SUM(Result.JlhQty) >= $data[qty]";

$stockExists = $db->exec('single');
$stock = $stockExists->Stok ?? 0;

Validation::run([
    'item_id' => [
        'required'
    ],
    'qty' => [
        'required',
        'gte:1',
        'lte:'.$stock
    ]
], $data);

$item = $db->single('mst_items', [
    'id' => $data['item_id']
]);

$data['item_object'] = json_encode($item);
$data['created_by'] = auth()->id;
$data['created_at'] = date('Y-m-d H:i:s');