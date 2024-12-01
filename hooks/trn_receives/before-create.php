<?php
$supplier = $db->single('mst_suppliers', [
    'id' => $data['supplier_id']
]);
$data['supplier_name'] = $supplier->name;
$data['total_items'] = 0;
$data['total_qty'] = 0;
$data['status'] = 'NEW';
$data['created_by'] = auth()->id;