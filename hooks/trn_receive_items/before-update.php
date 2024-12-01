<?php

$item = $db->single('mst_items', [
    'id' => $data['item_id']
]);

$data['item_object'] = json_encode($item);
$data['updated_by'] = auth()->id;
$data['updated_at'] = date('Y-m-d H:i:s');