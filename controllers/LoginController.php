<?php

namespace Controller;

use Classes\Email;
use Model\ActiveRecord;
use Model\Usuarios;
use MVC\Router;

class LoginController
{



    // Para hacer Login al sistema
    public static function login()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $auth = new Usuarios($_POST);
            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                $usuario = Usuarios::where('email', $auth->email);

                if ($usuario) {

                    $resultado =  $usuario->validarPassword($auth->password);
                    if (empty($resultado)) {
                        session_start();
                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["nombre"] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["login"] = true;
                        $_SESSION["admin"] = $usuario->admin;
                        if ($usuario->admin == "1") {
                            $_SESSION["admin"] = $usuario->admin ?? false;
                            header("Location: /admin/citas");
                        } else {
                            header("Location: /citas");
                        }
                    }
                } else {
                    Usuarios::setAlertas("error", "Cuenta no existe");
                }
            }
        }

        $alertas = Usuarios::getAlertas();
        Router::render('auth/login', [
            "alertas" => $alertas
        ]);
    }



    // Para Cerrar Sesión
    public static function logout()
    {
        @session_start();
        $_SESSION = [];

        header("Location: /");
    }


    // Para crear una nueva cuenta
    public static function crear()
    {
        $usuarios = new Usuarios;
        $alertas = Usuarios::getAlertas();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $usuarios->sincronizar($_POST);
            $alertas = $usuarios->validarNuevaCuenta();

            //Validamos que el array alertas este vacio
            if (empty($alertas)) {
                if ($usuarios->validarCorreo()->num_rows) {
                    $alertas = Usuarios::getAlertas();
                } else {
                    //Hasheamos el password y creamos el token
                    $usuarios->hashPassword();
                    $usuarios->crearToken();
                    //Enviar E-mail de confirmacion de cuentas
                    $email = new Email($usuarios->nombre, $usuarios->email, $usuarios->token);
                    $email->enviarConfirmacion();
                    $usuarios->save();
                    header("Location:/mensaje-registro");

                    debug($usuarios);
                }
            }
        }
        Router::render('auth/crear-cuenta', [
            'usuarios' => $usuarios,
            'alertas' => $alertas,
        ]);
    }


    // Para confirmar una cuenta
    public static function confirmar()
    {
        $token = s($_GET["token"]) ?? "0";
        $usuarios = Usuarios::where('token', $token);

        if ($usuarios) {
            $usuarios->confirmado = '1';
            $usuarios->token = "";
            $usuarios->save();
            Usuarios::setAlertas("exito", "Registrado Correctamente");
        } else {
            Usuarios::setAlertas("Error", "Token Invalido");
        }
        $alertas = Usuarios::getAlertas();
        Router::render('/auth/confirmar-cuenta', [
            "alertas" => $alertas
        ]);
    }


    // Para enviar E-mail y resestablecer conraseña
    public static function olvide()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $auth = new Usuarios($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                $usuario = Usuarios::where('email', $auth->email);
                if ($usuario) {
                    //Creamos el Token y lo guardamos
                    $usuario->crearToken();
                    $usuario->save();

                    //Enviamos el Email de reestablecimiento
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->ReestablecerContra();
                    // Creamos la alerta
                    Usuarios::setAlertas("exito", "Revisa tu E-mail");
                } else {
                    Usuarios::setAlertas('error', "Usuario no existe o no esta confirmado");
                }
            }
        }

        $alertas = Usuarios::getAlertas();
        Router::render('auth/olvide-password', [
            "alertas" => $alertas
        ]);
    }




    // Para cambiar la contraseña despues del E-mail 
    public static function recuperar()
    {
        $token = s($_GET["token"]) ?? null;
        $usuarios = Usuarios::where("token", $token);

        if (!$usuarios) { // Validamos si existe un usuario con el Token
            Usuarios::setAlertas("error", "Token Invalido");
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($usuarios)) {
            $auth = new Usuarios($_POST);
            $alertas = $auth->validarCampoPass();

            if (empty($alertas)) {

                $usuarios->actualizarPass($auth->password);   // Actualizamos contraseña
                $usuarios->destruirToken();   //  destruimos e token
                $usuarios->save();  // actualizamos

                // Enviamos alerta
                Usuarios::setAlertas("exito", "Contraseña Actualizada Correctamente");
            }
        }
        $alertas = Usuarios::getAlertas();
        Router::render('auth/recuperar-cuenta', ["alertas" => $alertas]);
    }





    // Mensaje de registro
    public static function mensaje()
    {
        Router::render('/auth/mensaje-registro');
    }
}
