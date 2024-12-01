<?php

if(!isset($data['receive_id']) && isset($_GET['filter']['receive_id']))
{
    $data['receive_id'] = $_GET['filter']['receive_id'];
}

$item = $db->single('mst_items', [
    'id' => $data['item_id']
]);

$data['item_object'] = json_encode($item);
$data['created_by'] = auth()->id;