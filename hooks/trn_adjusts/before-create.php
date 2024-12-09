<?php
$item = $db->single('mst_items', [
    'id' => $data['item_id']
]);

$data['item_object'] = json_encode($item);
$data['created_by'] = auth()->id;
$data['created_at'] = date('Y-m-d H:i:s');