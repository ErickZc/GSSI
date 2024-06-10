<?php
// DTO que representa a la tabla usuarios
class Usuario
{
    // Atributos que corresponden con los campos de la tabla
    private $id;
    private $usuario;
    private $password;

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
    public function __construct($id = 1)
    {
        $this->id = $id;
        $this->usuario = "Erick";
        $this->password = "admin";
    }

    //public function __toString() { return $this->usuario; } 

}
