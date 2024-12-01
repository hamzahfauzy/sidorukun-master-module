<?php

use Core\Database;

$db = new Database();

$db->update('trn_receives', [
    'status' => 'CANCEL'
], [
    'id' => $_GET['id']
]);

set_flash_msg(['success'=>"Data berhasil di cancel"]);

header('location:'.crudRoute('crud/index','trn_receives'));
die();