<?php
require_once("IDao.php");
require_once("../ds/DataSource.php");
require_once("../dto/Usuario.php");
require_once("../vendor/autoload.php");
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class UsuarioDao 
{

    function verificarToken($jwt)
    {
        $secretKey = "J1UX1%[3d>TIv+HwsS3;";

        try {
            return JWT::decode($jwt, new Key($secretKey, 'HS256'));
        } catch (Exception $e) {
            return null;
        }

    }
    
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

    public function agregar($objeto)
    {
        $conexion = new DataSource();

        if (!$conexion->conectar()) {
            echo "La conexion fallo";
            exit;
        } else {

            $usuario = $objeto;
            $sql = "CALL agregarUsuario(?, ?)";
            if ($stmt = $conexion->preparar($sql)) {
                $stmt->bind_param("ss", $nombre, $password);
                $nombre = $usuario->usuario;
                $password = $usuario->password;
                $stmt->execute();
                $registros = $stmt->affected_rows;
                $stmt->close();
                $conexion->desconectar();
                return $registros;
            } else {
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
        $conexion = new DataSource();
        if (!$conexion->conectar()) {
            echo "La conexion fallo";
            exit;
        } else {
            $user = $objeto;
            $sql = "CALL eliminarUsuario(?)";
            if ($stmt = $conexion->preparar($sql)) {
                $stmt->bind_param("i", $id);
                $id = $user->id;
                $stmt->execute();
                $registros = $stmt->affected_rows;
                $stmt->close();
                $conexion->desconectar();
                return $registros;
            } else {
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
                $pass = hash('sha256', $usuario->password);
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
