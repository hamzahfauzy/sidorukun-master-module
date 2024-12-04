<?php

use Core\Database;

$db = new Database;

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
    'type' => 'options-obj:mst_suppliers,id,name|status,ACTIVE'
];

$fields['description'] = [
    'label' => 'Deskripsi',
    'type' => 'textarea',
    'attr' => [
        'class' => 'form-control select2-search__field'
    ]
];

$db->query = "SELECT COUNT(*) as `counter` FROM trn_receives WHERE created_at LIKE '%".date('Y-m')."%'";
$counter = $db->exec('single')?->counter && $db->exec('single')?->counter > 0 ? $db->exec('single')?->counter : 1;

$counter = sprintf("%05d", $counter);
$fields['code']['attr'] = [
    'value' => 'SRT' . date('Ym'). $counter,
    'readonly' => 'readonly'
];

return $fields;