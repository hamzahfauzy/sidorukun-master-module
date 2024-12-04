<?php

use Core\Database;

$db = new Database;

unset($fields['total_items']);
unset($fields['status']);
unset($fields['total_qty']);
unset($fields['customer_name']);
unset($fields['channel_name']);
unset($fields['created_at']);
unset($fields['created_by']);
unset($fields['updated_at']);
unset($fields['updated_by']);

$fields['customer_id'] = [
    'label' => 'customer',
    'type' => 'options-obj:mst_customers,id,name|status,ACTIVE',
    'attr' => [
        'required' => 'required'
    ]
];

$fields['channel_id'] = [
    'label' => 'channel',
    'type' => 'options-obj:mst_channels,id,name',
    'attr' => [
        'required' => 'required'
    ]
];

$fields['description'] = [
    'label' => 'Deskripsi',
    'type' => 'textarea',
    'attr' => [
        'class' => 'form-control select2-search__field'
    ]
];

$db->query = "SELECT COUNT(*) as `counter` FROM trn_outgoings WHERE created_at LIKE '%".date('Y-m')."%'";
$counter = $db->exec('single')?->counter ?? 0;

$counter = sprintf("%05d", $counter+1);
$fields['code']['attr'] = [
    'value' => 'SRK' . date('Ym'). $counter,
    'readonly' => 'readonly'
];

return $fields;