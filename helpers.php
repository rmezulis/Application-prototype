<?php

use App\Core\Database;

function database()
{
    $config = require 'config.php';
    return Database::getInstance($config)->connection();
}