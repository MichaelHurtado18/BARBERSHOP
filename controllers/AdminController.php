<?php

namespace Controller;

use MVC\Router;

class AdminController
{

    public static function index()
    {
        Router::render("admin/index", [
            "nombre" => $_SESSION["nombre"]
        ]);
    }
}
