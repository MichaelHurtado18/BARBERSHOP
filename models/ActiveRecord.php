<?php


namespace Model;

class ActiveRecord
{
    protected static $table_name = '';
    protected static $alertas = [];
    public static  $primary_key = '';
    public  static $db;
    public $id;
    public static $database = 'appSalon';
    protected static $columns = [];


    public static function setConectar($conexion)
    {
        return self::$db = $conexion;
    }


    public static function debug($variable)
    {
        echo "<pre>";
        var_dump($variable);
        echo "</pre>";
    }
    // Esta funcion crea las alertas
    public static function setAlertas($tipo, $mensaje)
    {
        self::$alertas[$tipo][] = $mensaje;
    }

    /*Obtenemos el array alertas y lo asignamos a uyna variable en crear.php */
    public static function getAlertas()
    {
        return static::$alertas;
    }
    /*Metodo que me tra todos los registros de la BD */
    public  static function all()
    {
        $query = "SELECT * FROM " . static::$table_name;
        $resultado = self::consultBD($query);
        return $resultado;
    }
    /*Me trae un solo registro de la BD */
    public static function find($id)
    {
        $query = " SELECT * FROM " . static::$table_name . " WHERE " . static::$primary_key . "  =  '$id' ";
        $resultado = static::consultBD($query);
        return ($resultado);
    }

    // Esta funcion realiza una consulta dependiento de la clausula Where
    public static function where($columna, $valor)
    {
        $query = "SELECT * FROM " . static::$table_name . " WHERE " . $columna . " =" . " '{$valor}' ";
        $resultado = self::consultBD($query);

        return array_shift($resultado);
    }



    // Consultas planas (ejecutar cuando las demas funciones no son de utilidad)

    static function SQL($query)
    {
        $resultado = self::consultBD($query);
        return $resultado;
    }
    /*Crea un nuevo registro o lo actualiza dependiendo si existe un id en memoria */
    public function save()
    {
        if (empty($this->id)) {
            $this->create();
        } else {
            $this->update();
        }
    }

    // Esta funcion crea un nuevo registro
    public function create()
    {
        $atributos = $this->sanitizarAtributos();
        if (empty($this->id)) {
            $columBD = implode(',', array_keys($atributos));
            $campoBD = implode("','", array_values($atributos));
            $query = self::$db->query("INSERT INTO " . static::$table_name . " ($columBD) VALUES ('$campoBD')");
            if ($query == false) {
                die("ERROR MYSQL " . self::$db->error);
            }
            return  [
                "resultado" => true,
                "id" => self::$db->insert_id
            ];
        }
    }

    // Esta funcion actualiza un  registro
    public function update()
    {
        $atributos = $this->sanitizarAtributos();
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }
        $string = implode(", ", $valores);
        $query = self::$db->query(" UPDATE " .  static::$table_name . " SET $string WHERE "  . static::$primary_key .  " = " . " {$this->id} ");
    
        return $query;
    }
    /*Elimina un registro con el id que esta en memoria */
    public  function delete()
    {
        $query = self::$db->query(" DELETE FROM " .  static::$table_name . " WHERE id =   '$this->id' ");
        return $query;
    }

    /*
     Recorre un array con el nombre de las comlunas de la tabla y guarda el nombre de la columa y el valor de valor de la comlumna en un array
    */
    public  function atributos()
    {
        $v = [];
        foreach (static::$columns as $columna) {
            if ($columna === 'id') continue;
            $v[$columna] = $this->$columna;
        }
        return $v;
    }
    /*
    Sanitiza los datos que trae la funcion atributos()  
    */
    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    /*
    Ejecuta las consultas  y pasa el registro a la funcion CreateObject
     */
    public static function consultBD($query)
    {
        $resultado =  self::$db->query($query);
        $valores = [];
        while ($registro = $resultado->fetch_assoc()) {
            $valores[] = self::createObject($registro);
        }

        return $valores;
    }
    /*
    Sincroniza el registro con los atributos de la clase
     */
    public static function createObject($registro)
    {
        $objeto = new static;
        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    /*Realiza lo mismo que createObject */
    public  function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        return $this;
    }

    /*METODO PARA VALIDAR CAMPOS  */
    public   function validar()
    {
        return static::$alertas;
    }
}
