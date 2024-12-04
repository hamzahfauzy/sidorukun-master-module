<?php

use Core\Database;

unset($fields['receive_id']);
unset($fields['created_at']);
unset($fields['created_by']);
unset($fields['updated_at']);
unset($fields['updated_by']);

$fields['unit']['attr'] = [
    'readonly' => 'readonly'
];

$id = $_GET['filter']['receive_id'];
$db = new Database();
$db->query = "SELECT id, name FROM mst_items WHERE status = 'ACTIVE' AND id NOT IN (SELECT item_id FROM trn_receive_items WHERE receive_id = $id)";
$items = $db->exec('all');
$lists = [];
foreach($items as $item)
{
    $lists[$item->name] = $item->id;
}

$fields['item_id']['type'] = 'options:'.json_encode($lists);
return $fields;