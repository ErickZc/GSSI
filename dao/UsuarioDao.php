<?php
// Agregando scripts necesarios
require_once("IDao.php");
require_once("../ds/DataSource.php");
require_once("../dto/Usuario.php");

// DAO para la tabla usuarios
class UsuarioDao 
{
    // Implementando metodo READ
    public function mostrar()
    {

        $conexion = new DataSource();
        
        if (!$conexion->conectar()) {
            echo "La conexion fallo";
            exit;
        } else {
            
            $usuario = null;
            
            $usuarios = array();
            
            $sql = "CALL mostrarUsuarios()";
            
            if ($stmt = $conexion->preparar($sql)) {
              $stmt->execute();
              $stmt->bind_result($a, $b, $c);
              while ($stmt->fetch()) {
                    $usuario = new Usuario();
                    $usuario->id = $a;
                    $usuario->usuario = $b;
                    $usuario->password = $c;
                    array_push($usuarios, $usuario);
                }
                
                $stmt->close();
                $conexion->desconectar();
                
                return $usuarios;
            } else {
                
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
            $usuario = $objeto;
            // Variable con llamada al procedimiento almacenado
            $sql = "CALL agregarUsuario(?, ?)";
            // Preparando sentencia y evaluando preparacion
            if ($stmt = $conexion->preparar($sql)) {
                // Asignando variables para enviar como parametros al SP
                $stmt->bind_param("ss", $nombre, $password);
                // Obteniendo valores del objeto y asignandolos a las variables
                $nombre = $usuario->usuario;
                // Encriptando el password del usuario
                $password = $usuario->password;
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
            $usuario = $objeto;
            $sql = "CALL modificarUsuario(?, ?, ?)";

            if ($stmt = $conexion->preparar($sql)) {
                
                $stmt->bind_param("sss", $id, $user, $password);
                
                $user = $usuario->usuario;
                $password = $usuario->password;
                $id = $usuario->id;
                
                $stmt->execute();
                
                $registros = $stmt->affected_rows;
                
                return $registros;
            } else {
                
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
            $user = $objeto;
            // Variable con llamada al procedimiento almacenado
            $sql = "CALL eliminarUsuario(?)";
            // Preparando sentencia y evaluando preparacion
            if ($stmt = $conexion->preparar($sql)) {
                // Asignando variables para enviar como parametros al SP
                $stmt->bind_param("i", $id);
                // Obteniendo valores del objeto y asignandolos a las variables
                $id = $user->id;
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

    public function verificarUsuario($usuario)
    {

        $conexion = new DataSource();

        if (!$conexion->conectar()) {
            echo "La conexion fallo";
            exit;
        } else {

            $valido = false;
            $sql = "CALL verificarDatos(?, ?)";
            if ($stmt = $conexion->preparar($sql)) {

                $stmt->bind_param("ss", $nombre, $pass);
                $nombre = $usuario->usuario;
                $pass = $usuario->password;
                $stmt->execute();

                while ($stmt->fetch()) {
                    if($stmt == true){
                        $valido = true;
                    }
                }

                $stmt->close();
                $conexion->desconectar();
                return $valido;
            } else {
                $conexion->desconectar();
                echo "Ocurrio un error al llamar al PS";
                exit;
            }
        }
    }
}
