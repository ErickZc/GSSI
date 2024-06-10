<?php
// Agregando scripts necesarios
require_once("IDao.php");
require_once("../ds/DataSource.php");
require_once("../dto/Persona.php");

// DAO para la tabla personas
class PersonaDao
{
    // Implementando metodo READ
    public function mostrar()
    {
        // Creando objeto del DataSource
        $conexion = new DataSource();
        // Conectando y comprobando conexion
        if (!$conexion->conectar()) {
            echo "La conexion fallo";
            exit;
        } else {
            // Variable que contendra objeto DTO
            $persona = null;
            // Arreglo que contendra los objetos DTO
            $personas = array();
            // Variable con llamada al procedimiento almacenado
            $sql = "CALL mostrarPersonas()";
            // Preparando sentencia y evaluando preparacion
            if ($stmt = $conexion->preparar($sql)) {
                // Ejecutando sentencia
                $stmt->execute();
                // Vinculando variables a los campos de la tabla
                $stmt->bind_result($id, $nombre, $apellido);
                // Evaluando existencia de registros e iterando cada uno
                while ($stmt->fetch()) {
                    // Objeto del tipo persona
                    $persona = new Persona();
                    // Asignando los registros al objeto
                    $persona->id = $id;
                    $persona->nombre = $nombre;
                    $persona->apellido = $apellido;
                    // Agregando el objeto al arreglo personas
                    array_push($personas, $persona);
                }
                // Cerrando conexiones y liberando recursos
                $stmt->close();
                $conexion->desconectar();
                // Retornando arreglo con los empleados
                return $personas;
            } else {
                // Cerrando conexiones y liberando recursos
                $conexion->desconectar();
                echo "Ocurrio un error al llamar al PS";
                exit;
            }
        }
    }

    // Implementando metodo INSERT
    public function agregar($objeto)
    {
        // Creando objeto del DataSource
        $conexion = new DataSource();
        // Conectando y comprobando conexion
        if (!$conexion->conectar()) {
            echo "La conexion fallo";
            exit;
        } else {
            // Variable que contendra objeto DTO pasado como parametro
            $persona = $objeto;
            // Variable con llamada al procedimiento almacenado
            $sql = "CALL agregarPersona(?, ?)";
            // Preparando sentencia y evaluando preparacion
            if ($stmt = $conexion->preparar($sql)) {
                // Asignando variables para enviar como parametros al SP
                $stmt->bind_param("ss", $nombre, $apellido);
                // Obteniendo valores del objeto y asignandolos a las variables
                $nombre = $persona->nombre;
                $apellido = $persona->apellido;
                // Ejecutando sentencia
                $stmt->execute();
                // Obteniendo cantidad de registros afectados
                $registros = $stmt->affected_rows;
                // Cerrando conexiones y liberando recursos
                $stmt->close();
                $conexion->desconectar();
                // Retornando cantidad de registros afectados
                return $registros;
            } else {
                // Cerrando conexion y liberando recursos
                $conexion->desconectar();
                echo "Ocurrio un error al llamar al PS";
                exit;
            }
        }
    }

    // Implementando metodo UPDATE
    public function modificar($objeto)
    {
        $conexion = new DataSource();
        if(!$conexion->conectar()){
            echo 'No se pudo conectar';
            exit;
        }else{
            $persona = $objeto;
            $sql = "CALL modificarPersona(?, ?, ?)";

            if ($stmt = $conexion->preparar($sql)) {
                
                $stmt->bind_param("sss", $id, $nombre, $apellido);
                
                $nombre = $persona->nombre;
                $apellido = $persona->apellido;
                $id = $persona->id;
                
                $stmt->execute();
                
                $registros = $stmt->affected_rows;
                
                return $registros;
            } else {
                // Cerrando conexion y liberando recursos
                $conexion->desconectar();
                echo "Ocurrio un error al llamar al PS";
                exit;
            }

        }
    }

    // Implementando metodo DELETE
    public function eliminar($objeto)
    {
        // Creando objeto del DataSource
        $conexion = new DataSource();
        // Conectando y comprobando conexion
        if (!$conexion->conectar()) {
            echo "La conexion fallo";
            exit;
        } else {
            // Variable que contendra objeto DTO pasado como parametro
            $persona = $objeto;
            // Variable con llamada al procedimiento almacenado
            $sql = "CALL eliminarPersona(?)";
            // Preparando sentencia y evaluando preparacion
            if ($stmt = $conexion->preparar($sql)) {
                // Asignando variables para enviar como parametros al SP
                $stmt->bind_param("i", $id);
                // Obteniendo valores del objeto y asignandolos a las variables
                $id = $persona->id;
                // Ejecutando sentencia
                $stmt->execute();
                // Obteniendo cantidad de registros afectados
                $registros = $stmt->affected_rows;
                // Cerrando conexiones y liberando recursos
                $stmt->close();
                $conexion->desconectar();
                // Retornando cantidad de registros afectados
                return $registros;
            } else {
                // Cerrando conexion y liberando recursos
                $conexion->desconectar();
                echo "Ocurrio un error al llamar al PS";
                exit;
            }
        }
    }
}
