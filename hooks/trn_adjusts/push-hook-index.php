<?php

use Core\Route;

Route::additional_allowed_routes([
    'route_path' => '!crud/edit?table=trn_adjusts',
]);
Route::additional_allowed_routes([
    'route_path' => '!crud/delete?table=trn_adjusts',
]);