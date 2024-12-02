<?php

$auth = auth();

if(!is_allowed($route, $auth->id))
{
    die('Error 403. Unauthorized');
}