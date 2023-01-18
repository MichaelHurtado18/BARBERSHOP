<?php

namespace Model;

class Servicios extends ActiveRecord
{

    protected static $table_name = 'ta_servicios';
    public static  $primary_key = 'id';
    protected static $columns = ['id', 'nombre', 'precio'];
    public $id;
    public $nombre;
    public $precio;


    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? '';
        $this->precio = $args["precio"] ?? '';
    }


    /* CAMBIAMOS EL FORMATO DEL PRECIO */
    public function precioFormat()
    {
        if (strpos($this->precio, ",")) {
            $this->precio = str_replace(',', '.', $this->precio);
        } elseif (!strpos($this->precio, '.')) {
            $this->precio = number_format($this->precio);
            $this->precio = str_replace(',', '.', $this->precio);
        }
        return $this->precio;
    }

    /*VALIDAMOS LOS DATOS INGRESADOS */
    public function validacion()
    {
        if (!$this->nombre) {
            self::$alertas["error"]["nombre"] = "El nombre del servicio esta vacio";
        } else if (strlen($this->nombre) > 60) {
            self::$alertas["error"]["nombre"] = "El nombre es muy largo";
        } else if (!preg_match("/^[a-zA-Z\s]+$/", $this->nombre)) {
            self::$alertas["error"]["nombre"] = "El campo de nombre solo puede tener letras";
        }

        if (!$this->precio) {
            self::$alertas["error"]["precio"] = "El precio del servicio esta vacio";
        } else if (strlen($this->precio) > 8) {
            self::$alertas["error"]["nombre"] = "El precio es muy largo";
        }

        return self::$alertas;
    }
}
