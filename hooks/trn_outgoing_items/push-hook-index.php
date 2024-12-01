<?php

use Core\Database;
use Core\Route;

$db = new Database;
$outgoing = $db->single('trn_outgoings', [
    'id' => $_GET['filter']['outgoing_id']
]);

if($outgoing->status != 'NEW')
{
    Route::additional_allowed_routes([
        'route_path' => '!crud/create?table=trn_outgoing_items',
    ]);
    Route::additional_allowed_routes([
        'route_path' => '!crud/edit?table=trn_outgoing_items',
    ]);
    Route::additional_allowed_routes([
        'route_path' => '!crud/delete?table=trn_outgoing_items',
    ]);
}