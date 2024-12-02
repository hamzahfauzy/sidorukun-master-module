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
    'type' => 'options-obj:mst_customers,id,name'
];

$fields['channel_id'] = [
    'label' => 'channel',
    'type' => 'options-obj:mst_channels,id,name'
];

$fields['description'] = [
    'label' => 'Deskripsi',
    'type' => 'textarea'
];

$db->query = "SELECT COUNT(*) as `counter` FROM trn_outgoings WHERE created_at LIKE '%".date('Y-m')."%'";
$counter = $db->exec('single')?->counter ?? '00001';

$counter = sprintf("%05d", $counter);
$fields['code']['attr'] = [
    'value' => 'SRK' . date('Ym'). $counter,
    'readonly' => 'readonly'
];

return $fields;