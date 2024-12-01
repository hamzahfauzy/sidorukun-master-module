<?php

$total_items = $db->exists('trn_outgoing_items', [
    'outgoing_id' => $data->outgoing_id
]);

$db->query = "SELECT SUM(qty) total FROM trn_outgoing_items WHERE outgoing_id = $data->outgoing_id";
$qty = $db->exec('single');

$db->update('trn_outgoings', [
    'total_qty' => $qty->total ?? 0,
    'total_items' => $total_items,
],[
    'id' => $data->outgoing_id
]);