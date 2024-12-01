<?php
$supplier = $db->single('mst_suppliers', [
    'id' => $data['supplier_id']
]);
$data['supplier_name'] = $supplier->name;
$data['updated_by'] = auth()->id;
$data['updated_at'] = date('Y-m-d H:i:s');