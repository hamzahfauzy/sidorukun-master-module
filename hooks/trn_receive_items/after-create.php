<?php

$total_items = $db->exists('trn_receive_items', [
    'receive_id' => $data->receive_id
]);

$db->query = "SELECT SUM(qty) total FROM trn_receive_items WHERE receive_id = $data->receive_id";
$qty = $db->exec('single');

$db->update('trn_receives', [
    'total_qty' => $qty->total,
    'total_items' => $total_items,
],[
    'id' => $data->receive_id
]);