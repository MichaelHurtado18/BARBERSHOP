<?php


namespace Controller;

use MVC\Router;
use Model\Citas;
use Model\CitasServicios;
use Model\Servicios;
use Random\Engine\Secure;

class ServicioController
{

    public static function index()
    {
        $servicios = Servicios::all();
        Router::render('admin/servicios', [
            "nombre" => $_SESSION["nombre"],
            "servicios" => $servicios
        ]);
    }

/*MOSTRAR FORMULARIO SERVICIO */
    public static function create()
    {
        $alertas = [];
        $servicio = new Servicios($_POST);
        Router::render('admin/create', [
            "nombre" => $_SESSION["nombre"],
            "alertas" => $alertas,
            "servicio" => $servicio
        ]);
    }


    /*GUARDAR UN SERVICIO */
    public static function store()
    {
        $alertas = [];
        $servicio = new Servicios($_POST);
        $alertas =  $servicio->validacion();

        if (empty($alertas)) {
            $servicio->precioFormat();
            $servicio->create();
            header("Location: /admin/servicios");
            return;
        }
        Router::render('admin/create', [
            "nombre" => $_SESSION["nombre"],
            "alertas" => $alertas,
            "servicio" => $servicio
        ]);
    }


    /*ELIMINAMOS LAS CITAS */
    public static function destroy()
    {
        $id = $_POST["id"]; // Recibimo el ID del servicio
        $resultado =  CitasServicios::where('servicioId', $id); // Validamos que el servicio no este solicitado por un usuario
        if ($resultado) {
            echo json_encode(["message" => "NO SE PUEDE ELIMINAR EL SERVICIO PORQUE UN USUARIO LO SOLICITO, ELIMINE LA CITA Y DESPUES ELIMINE EL SERVICIO", "solicitud" => false]);
            return;
        }

        $servicios = new Servicios;
        $servicios->sincronizar($_POST);
        if ($servicios->delete()) {
            echo json_encode([
                "message" => "Eliminado correctamente", "solicitud" => true
            ]);
            return;
        }
    }


    /*ACTUALIZAMOS UN SERVICIO, LA SOLICITUD VIENE DESDE JAVASCRIPT */
    public static function update()
    {
        $servicio = new Servicios;
        $servicio->sincronizar($_POST);
        if ($servicio->update()) {
            echo json_encode(["message" => true]);
        } else {
            echo json_encode(["message" => false]);
        }
    }
}
