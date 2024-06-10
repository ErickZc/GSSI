<?php
// DTO que representa a la tabla personas
class Persona
{
    // Atributos que corresponden con los campos de la tabla
    private $id;
    private $nombre;
    private $apellido;

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
        $this->nombre = "Guillermo";
        $this->apellido = "Vasquez";
    }
}
