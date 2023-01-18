<?php

use MVC\Router;
use Controller\ServicioController;
use Controller\APIController;
use Controller\AdminController;
use Controller\CitasController;
use Controller\LoginController;

require '../includes/app.php';



$router = new Router();
//Iniciar Sesión
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);

//Cerrar Sesión
$router->get('/logout', [LoginController::class, 'logout']);

//Recuperar Password
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/recuperar-cuenta', [LoginController::class, 'recuperar']);
$router->post('/recuperar-cuenta', [LoginController::class, 'recuperar']);

//Crear Cuenta
$router->get('/crear-cuenta', [LoginController::class, 'crear']);
$router->post('/crear-cuenta', [LoginController::class, 'crear']);

//Mensaje de registro
$router->get('/mensaje-registro', [LoginController::class, 'mensaje']);

//Confirmar Token
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);


//AREA PRIVADA


//CITAS 
$router->get('/admin/citas', [AdminController::class, 'index'], true, true); // Mostrar citas al admin
$router->get('/citas', [CitasController::class, 'index'], true); // Mostrar citas al Usuario
$router->post('/citas', [CitasController::class, 'store'], true); // crear una cita
$router->post('/citas/delete', [CitasController::class, 'destroy'], true, true); // Eliminar Cita


//SERVICIOS
$router->get('/admin/servicios', [ServicioController::class, 'index'], true, true); // Mostrar servicios al admin
$router->get('/servicios/create', [ServicioController::class, 'create'], true, true); // Mostrar formulario Servicio
$router->post('/servicios/create', [ServicioController::class, 'store'], true, true); // Crear Servicio
$router->post('/servicios/delete', [ServicioController::class, 'destroy'], true, true); // Eliminar Servicio
$router->post('/servicios/update', [ServicioController::class, 'update'], true, true); // Actualiar Servicio

//API
$router->get('/api/servicios', [APIController::class, 'index'], true);
$router->post('/api/citas', [APIController::class, 'guardar'],  true, true);
$router->get('/api/reservaciones', [APIController::class, 'admin'], true, true);
$router->post('/api/reservaciones', [APIController::class, 'admin'], true, true);
// $router->post('/api/citas/delete', [APIController::class, 'delete'], true, true);
// $router->post('/api/delete', [APIController::class, 'delete'], true, true);




$router->comprobarRutas();
