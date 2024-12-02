<?php

unset($fields['total_items']);
unset($fields['status']);
unset($fields['total_qty']);
unset($fields['supplier_name']);
unset($fields['created_at']);
unset($fields['created_by']);
unset($fields['updated_at']);
unset($fields['updated_by']);

$fields['supplier_id'] = [
    'label' => 'Supplier',
    'type' => 'options-obj:mst_suppliers,id,name'
];

$fields['description'] = [
    'label' => 'Deskripsi',
    'type' => 'textarea'
];

return $fields;