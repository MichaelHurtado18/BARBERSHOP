<?php


namespace Controller;

use Model\Citas;
use Model\Servicios;
use Model\CitasServicios;

class APIController
{
    public static function index()
    {
        $servicios = Servicios::all();
        echo json_encode($servicios);
    }

    public static function guardar()
    {

        $citas = new Citas($_POST);
        $servicios = explode(",", $_POST["servicios"]);

        @session_start();
        $citas->fk_usuario = $_SESSION["id"] ?? 1;

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


    /* */
    public static function admin()
    {
        $fecha = $_POST["fecha"] ?? date('Y-m-d');
        $query = " SELECT  ta_citas.id as id, CONCAT(ta_usuarios.nombre , ' ' , ta_usuarios.apellido )  as fk_usuario, GROUP_CONCAT(ta_servicios.nombre) as producto, fecha, hora, SUM(ta_servicios.precio) as precio FROM ta_citas 
         LEFT JOIN citasservicios ON citasservicios.citaId=ta_citas.id 
         LEFT JOIN ta_servicios ON citasservicios.servicioId=ta_servicios.id
         LEFT JOIN ta_usuarios ON ta_citas.fk_usuario=ta_usuarios.id 
         WHERE ta_citas.fecha = '$fecha'  GROUP BY ta_citas.id";
        $resultado = Citas::SQL($query);
        echo json_encode($resultado);
    }
}
