<?php

use Core\Database;
use Core\Route;

$db = new Database;
$receive = $db->single('trn_receives', [
    'id' => $_GET['filter']['receive_id']
]);

if($receive->status != 'NEW')
{
    Route::additional_allowed_routes([
        'route_path' => '!crud/create?table=trn_receive_items',
    ]);
    Route::additional_allowed_routes([
        'route_path' => '!crud/edit?table=trn_receive_items',
    ]);
    Route::additional_allowed_routes([
        'route_path' => '!crud/delete?table=trn_receive_items',
    ]);
}