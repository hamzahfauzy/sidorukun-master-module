<?php

use Core\Database;

$db = new Database();

$db->update('trn_outgoings', [
    'status' => 'APPROVE'
], [
    'id' => $_GET['id']
]);

set_flash_msg(['success'=>"Data berhasil di approve"]);

header('location:'.crudRoute('crud/index','trn_outgoings'));
die();