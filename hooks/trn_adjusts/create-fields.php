<?php

use Core\Database;

$db = new Database;

unset($fields['created_at']);
unset($fields['created_by']);
unset($fields['updated_at']);
unset($fields['updated_by']);

$fields['unit']['attr'] = [
    'readonly' => 'readonly'
];

$fields['item_id']['type'] = 'options-obj:mst_items,id,name|status,ACTIVE';

$db->query = "SELECT COUNT(*) as `counter` FROM trn_adjusts WHERE created_at LIKE '%".date('Y-m')."%'";
$counter = $db->exec('single')?->counter ?? 0;

$counter = sprintf("%05d", $counter+1);
$fields['code']['attr'] = [
    'value' => 'SRA' . date('Ym'). $counter,
    'readonly' => 'readonly'
];

return $fields;