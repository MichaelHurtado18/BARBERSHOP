<?php

namespace MVC;

class Router
{

    public $rutasGET = [];
    public $rutasPOST = [];
    public $rutasPrivadas = [];
    public $rutasAdmin = [];
    public function get($url, $fn, $private = false, $admin = false)
    {
        $this->rutasGET[$url] = $fn;

        if ($private) {
            $this->rutasPrivadas[] = $url;
        }

        if ($admin) {
            $this->rutasAdmin[] = $url;
        }
    }
    public function post($url, $fn, $private = false, $admin = false)
    {
        $this->rutasPOST[$url] = $fn;
        if ($private) {
            $this->rutasPrivadas[] = $url;
        }

        if ($admin) {
            $this->rutasAdmin[] = $url;
        }
    }


    public function comprobarRutas()
    {
        session_start();

        $auth = $_SESSION["login"] ?? false;

        $urlActual = $_SERVER["REQUEST_URI"]  === '' ? '/' :  $_SERVER["REQUEST_URI"];

        $methodActual = $_SERVER["REQUEST_METHOD"];

        if ($methodActual  == "GET") {
            $fn = $this->rutasGET[$urlActual] ?? false;
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? false;
        }

        if (in_array($urlActual, $this->rutasPrivadas) and !$auth) {
            header("Location: /");
        }


        if (in_array($urlActual, $this->rutasAdmin) && !$_SESSION["admin"]) {
            header("Location: /citas");
        }

        if ($fn) {
            call_user_func($fn, $this);
        } else {
            echo "Pagina No Encontrada";
        }
    }



    public static function render($views, $datos = [])
    {

        foreach ($datos as $key  => $value) {
            $$key = $value;
        }
        ob_start();
        require __DIR__ . "./views/$views.php";
        $contenido = ob_get_clean();
        require __DIR__ . "./views/layout.php";
    }
}
