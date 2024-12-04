<?php

use Core\Database;

$db = new Database;

if($db->exists('trn_outgoings', ['customer_id' => $data->id]))
{
    redirectBack(['error' => 'Data tidak bisa dihapus karena sedang digunakan!','old' => $data]);
    die;
}