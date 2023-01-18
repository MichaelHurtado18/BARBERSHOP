<?php

use Dotenv\Dotenv;
use Model\ActiveRecord;

require __DIR__ . "/../vendor/autoload.php";
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
require 'database.php';
require 'funciones.php';





ActiveRecord::setConectar($conexion);
