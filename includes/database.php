<?php

$conexion = new mysqli(
    $_ENV["DB_HOST"],
    $_ENV["DB_USER"],
    $_ENV["DB_PASSWORD"],
    $_ENV["DB_NAME"]
);


if ($conexion->connect_errno) {
    die("LA CONEXION ES FALLIDA" .  $conexion->connect_errno);
}
