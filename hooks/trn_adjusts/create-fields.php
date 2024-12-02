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

$db->query = "SELECT COUNT(*) as `counter` FROM trn_adjusts WHERE created_at LIKE '%".date('Y-m')."%'";
$counter = $db->exec('single')?->counter ?? '00001';

$counter = sprintf("%05d", $counter);
$fields['code']['attr'] = [
    'value' => 'SRA' . date('Ym'). $counter,
    'readonly' => 'readonly'
];

return $fields;