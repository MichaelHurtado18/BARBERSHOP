<?php

namespace Model;


class Usuarios extends ActiveRecord
{

    protected static $table_name = 'ta_usuarios';
    protected static $columns = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];
    public static $primary_key = 'id';

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;


    public function __construct($argumentos = [])
    {
        $this->id = $argumentos["id"] ?? null;
        $this->nombre = $argumentos["nombre"] ?? '';
        $this->apellido = $argumentos["apellido"] ?? '';
        $this->email = $argumentos["email"] ?? '';
        $this->password = $argumentos["password"] ?? '';
        $this->telefono = $argumentos["telefono"] ?? '';
        $this->admin = $argumentos["admin"] ?? '0';
        $this->confirmado = $argumentos["confirmado"] ?? '0';
        $this->token = $argumentos["token"] ?? '';
    }

    // Validar con las campos de inicio de sesión
    public function validarLogin()
    {

        if (!$this->email) {
            self::$alertas["error"]["email"] = "El campo del email esta vacio";
        }

        if (!$this->password) {
            self::$alertas["error"]["password"] = "El Campo de Password no puede quedar vacio";
        }
        return self::$alertas;
    }

    // Esta funcion valida que la contraseña que ingresa el usuario sea la correcta para iniciar sesion y confirma que ya este confirmada la cuenta
    public function validarPassword($password)
    {

        $resultado = password_verify($password, $this->password);
        if (!$resultado) {
            self::$alertas["error"]["password"] = "El Password es incorrecto";
        }
        if (!$this->confirmado) {
            self::$alertas["error"]["confirmado"] = "Tu cuenta no esta verificada, confirmala en el correo";
        }
        return self::$alertas;
    }


    // Esta function valida la creacion de una nuea cuenta
    public  function validarNuevaCuenta()
    {
        if (empty($this->nombre)) {
            self::$alertas["error"]["nombre"] = "El nombre del usuario esta vacio";
        } else if (strlen($this->nombre) > 60) {
            self::$alertas["error"]["nombre"] = "El nombre es muy largo";
        } else if (!preg_match("/^[a-zA-Z\s]+$/", $this->nombre)) {
            self::$alertas["error"]["nombre"] = "El campo de nombre solo puede tener letras";
        }


        if (empty($this->apellido)) {
            self::$alertas["error"]["apellido"] = "El apellido del usuario esta vacio";
        } else if (strlen($this->apellido) > 60) {
            self::$alertas["error"]["apellido"] = "El apellido es muy largo";
        } else if (!preg_match("/^[a-zA-Z\s]+$/", $this->apellido)) {
            self::$alertas["error"]["apellido"] = "El campo de apellido solo puede tener letras";
        }
        if (!$this->telefono) {
            self::$alertas["error"]['telefono'] = "El telefono del votante no puede quedar vacio";
        } else if (!preg_match("/^[0-9]+$/", $this->telefono)) {
            self::$alertas["error"]['telefono'] = "El campo del telefono solo puede tener numeros";
        } else if (strlen($this->telefono) > 10) {
            self::$alertas["error"]['telefono'] = "El telefono del usuario es muy largo";
        }


        if (empty($this->email)) {
            self::$alertas["error"]["email"] = "El email del usuario esta vacio";
        } else if (strlen($this->email) > 30) {
            self::$alertas["error"]["email"] = "El email es muy largo";
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas["error"]["email"] = "El E-mail no es correcto";
        }

        if (empty($this->password)) {
            self::$alertas["error"]["password"] = "El password del usuario esta vacio";
        } else if (strlen($this->password) < 6) {
            self::$alertas["error"]["password"] = "El password es muy largo";
        }


        return self::$alertas;
    }

    public function validarEmail()

    {
        if (!$this->email) {
            self::$alertas["error"]["email"] = "El email del usuario esta vacio";
        }
        return self::$alertas;
    }

    public function validarCampoPass()
    {
        if (!$this->password) {
            self::$alertas["error"]["password"] = "El contraseña del usuario esta vacio";
        }
        return self::$alertas;
    }

    public function actualizarPass($password)
    {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $this->password = $password;
    }
    // Esta function valida si un correo ya esta registrado 
    public function validarCorreo()
    {

        $query = self::$db->query(" SELECT * FROM " . self::$table_name .  " WHERE email = '" .   $this->email   . "' LIMIT 1 ");

        if ($query->num_rows) {
            self::$alertas["error"]["email"]  = "El E-mail ya esta registrado";
        }
        return $query;
    }

    // Hasheamos la contraseña del usuario

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken()
    {
        $this->token = uniqid();
    }
    public function destruirToken()
    {
        $this->token = "";
    }
}
