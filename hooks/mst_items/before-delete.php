<?php

use Core\Database;

$db = new Database;

if($db->exists('trn_receive_items', ['item_id' => $data->id]))
{
    redirectBack(['error' => 'Data tidak bisa dihapus karena sedang digunakan!','old' => $data]);
    die;
}

if($db->exists('trn_outgoing_items', ['item_id' => $data->id]))
{
    redirectBack(['error' => 'Data tidak bisa dihapus karena sedang digunakan!','old' => $data]);
    die;
}