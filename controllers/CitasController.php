<?php


namespace Controller;

use MVC\Router;
use Model\Citas;
use Model\CitasServicios;

class CitasController
{

    public static function index()
    {
        $nombre = $_SESSION["nombre"];
        Router::render('citas/index', [
            "nombre" => $nombre
        ]);
    }


    public static function store()
    {
        $citas = new Citas($_POST);

        $servicios = explode(",", $_POST["servicios"]);

        @session_start();
        $citas->fk_usuario = $_SESSION["id"];

        $resultado = $citas->create();

        foreach ($servicios as $key) {
            $atributos = [
                "citaId" => $resultado["id"],
                "servicioId" => $key
            ];
            $citaServicio = new CitasServicios($atributos);
            $citaServicio->create();
        }

        echo json_encode($resultado);
    }


    /*ELIMINAMOS LAS CITAS */
    public static function destroy()
    {

        $id = $_POST["id"];
        $citas = new Citas;
        $citas->sincronizar($_POST);
        if ($citas->delete()) {
            echo json_encode([
                "message" => "Eliminado correctamente"
            ]);
        }
    }
}
