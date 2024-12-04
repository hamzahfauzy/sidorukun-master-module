<?php

use Core\Database;


unset($fields['outgoing_id']);
unset($fields['created_at']);
unset($fields['created_by']);
unset($fields['updated_at']);
unset($fields['updated_by']);

$fields['unit']['attr'] = [
    'readonly' => 'readonly'
];

$id = $_GET['filter']['outgoing_id'];
$db = new Database;
$db->query = "SELECT id, name FROM mst_items WHERE status = 'ACTIVE' AND id NOT IN (SELECT item_id FROM trn_outgoing_items WHERE outgoing_id = $id)";
$items = $db->exec('all');
$lists = [__('crud.label.choose') => -1];
foreach($items as $item)
{
    $lists[$item->name] = $item->id;
}

$fields['item_id']['type'] = 'options:'.json_encode($lists);
return $fields;