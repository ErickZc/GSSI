<?php
require_once __DIR__ . '/../vendor/autoload.php';

class DataSource
{
    private $conexion;
    private $host;
    private $usuario;
    private $password;
    private $db;

    public function __set($nombre, $valor)
    {
        $this->$nombre = $valor;
    }

    public function __get($nombre)
    {
        return $this->$nombre;
    }

    //Gestión de la Seguridad de la Información
    #Aunque las credenciales están hardcodeadas (lo cual no es una práctica segura), 
    #el diseño permite la posibilidad de mejorar la seguridad almacenando las credenciales 
    # en un lugar más seguro (como variables de entorno).
    public function __construct()
    {
        // Cargar las variables de entorno desde el archivo .env
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
        $dotenv->load();

        // Asignar las variables de entorno a las propiedades de la clase
        $this->host = $_ENV['DB_HOST'];
        $this->usuario = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];
        $this->db = $_ENV['DB_NAME'];

        if (!$this->host || !$this->usuario || !$this->db) {
            throw new Exception('No se pudieron cargar las variables de entorno correctamente.');
        }
    }

    // Metodo que conecta con la base de datos
    public function conectar()
    {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->password, $this->db);
        if ($this->conexion->connect_errno) {
            return false;
        } else {
            return true;
        }
    }

    public function preparar($sql)
    {
        return $this->conexion->prepare($sql);
    }

    public function desconectar()
    {
        $this->conexion->close();
    }
}