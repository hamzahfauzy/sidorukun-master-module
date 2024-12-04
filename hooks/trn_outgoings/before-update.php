<?php
$customer = $db->single('mst_customers', [
    'id' => $data['customer_id']
]);
$channel = $db->single('mst_channels', [
    'id' => $data['channel_id']
]);
$data['customer_name'] = $customer->name;
$data['channel_name'] = $channel->name;
$data['updated_by'] = auth()->id;
$data['updated_at'] = date('Y-m-d H:i:s');