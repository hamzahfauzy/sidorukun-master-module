<?php

use Core\Validation;

Validation::run([
    'item_id' => [
        'required'
    ],
    'qty' => [
        'required',
        'gte:1'
    ]
], $data);

if(!isset($data['outgoing_id']) && isset($_GET['filter']['outgoing_id']))
{
    $data['outgoing_id'] = $_GET['filter']['outgoing_id'];
}

$item = $db->single('mst_items', [
    'id' => $data['item_id']
]);

$data['item_object'] = json_encode($item);
$data['created_by'] = auth()->id;