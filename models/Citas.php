<?php



namespace Model;

class Citas extends ActiveRecord
{

    protected static $table_name = 'ta_citas';
    public static  $primary_key = 'id';
    protected static $columns = ['id', 'fecha', 'hora', 'fk_usuario'];
    public $id;
    public $fecha;
    public $hora;
    public $fk_usuario;
    public $producto;
    public $precio;


    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->fecha = $args["fecha"] ?? '';
        $this->hora = $args["hora"] ?? '';
        $this->fk_usuario = $args["fk_usuario"] ?? '';
        $this->producto = $args["producto"] ?? '';
        $this->precio = $args["precio"] ?? '';
    }
}
