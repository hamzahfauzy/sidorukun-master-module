<?php

$auth = auth();

if(!$auth || !is_allowed($route, $auth->id))
{
    die('Error 403. Unauthorized');
}