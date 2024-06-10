<?php
// DS que permite conectarnos con nuestra fuente de datos
class DataSource
{
    // Atributos
    private $conexion;
    private $host;
    private $usuario;
    private $password;
    private $db;

    // Setter
    public function __set($nombre, $valor)
    {
        $this->$nombre = $valor;
    }

    // Getter
    public function __get($nombre)
    {
        return $this->$nombre;
    }

    // Constructor
    public function __construct()
    {
        // Valores por defecto al crear el objeto
        $this->host = "localhost";
        $this->usuario = "root";
        $this->password = "";
        $this->db = "daw";
    }

    // Metodo que conecta con la base de datos
    public function conectar()
    {
        // Conectandose con la base de datos
        $this->conexion = new mysqli($this->host, $this->usuario, $this->password, $this->db);
        // Evaluando exito de la conexion
        if ($this->conexion->connect_errno) {
            return false;
        } else {
            return true;
        }
    }

    // Metodo que permite preparar sentencias
    public function preparar($sql)
    {
        return $this->conexion->prepare($sql);
    }

    // Metodo que cierra la conexion
    public function desconectar()
    {
        $this->conexion->close();
    }
}