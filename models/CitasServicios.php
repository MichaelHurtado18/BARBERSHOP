<?php

namespace Model;

class CitasServicios extends ActiveRecord
{

    protected static $table_name = 'citasservicios';
    public static  $primary_key = 'id';
    protected static $columns = ['id', 'citaId', 'servicioId'];
    public $id;
    public $citaId;
    public $servicioId;



    function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->citaId = $args["citaId"] ?? "";
        $this->servicioId = $args["servicioId"] ?? "";
    }
}
