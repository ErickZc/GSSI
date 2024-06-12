<?php
session_start();
use Firebase\JWT\JWT;
require_once("../vendor/autoload.php");


if (isset($_SESSION["activo"])) {
   
    if (isset($_GET["cerrar"]) && $_GET["cerrar"] == "true") {
       
        cerrarSesion();
    } else if(isset($_GET["user"]) && $_GET["user"] == "agregar") {
        
        agregarEditarUsuario();
    } else if(isset($_POST["addUser"]) && isset($_POST["addPassword"])) {
        
        agregarUsuario();
    } else if(isset($_POST["modUsuario"]) && isset($_POST["modPassword"]) && isset($_SESSION['id_user'])) {
        
        editarUsuario();
    } else if(isset($_GET["user"]) && $_GET["user"] == "eliminar" && isset($_GET['id'])) {
        
        eliminarUsuario();
    } else if(isset($_GET["user"]) && $_GET["user"] == "leer") {
        
        mostrarUsuario();
    } else {
        
        mostrarPrincipal();
    }
} else if (isset($_POST["usuario"]) && isset($_POST["password"])) {
    ingresar();
} else {
    index();
}


function index()
{
    header("Location:../index.php");
    exit;
}


function mostrarPrincipal()
{
    header("Location: ../vistas/dashboard.php");
    exit;
}


function cerrarSesion()
{
    session_destroy();
    index();
}


function mostrarUsuario()
{

    require_once("../dao/UsuarioDao.php");
    $usuario = new Usuario();
    $usuarioDao = new UsuarioDao();

    $_SESSION["user"] = $usuarioDao->mostrar();
    header("Location: ../vistas/usuario.php");
    exit;
}


function agregarUsuario()
{

    require_once("../dao/UsuarioDao.php");
    $usuarioDao = new UsuarioDao();
    
    $token = $_SESSION['jwt'];

    if ($decoded = $usuarioDao->verificarToken($token)) {
        $usuario = new Usuario();
        $usuario->usuario = $_POST["addUser"];
        $usuario->password = hash('sha256', $_POST["addPassword"]);

        $sha256_hash = hash('sha256', $_POST["addPassword"]);  
        $usuario->password  = $sha256_hash;

        $usuarioDao = new UsuarioDao();
        if ($usuarioDao->agregar($usuario) > 0) {
            $_SESSION['alerta'] = true;
            mostrarUsuario();
        } else {
            unset($_SESSION['activo']);
            $_SESSION['alerta'] = false;
            header("Location: ../index.php");
        }
    } else {
        $_SESSION['alerta'] = false;
        unset($_SESSION['activo']);
        header("Location: ../index.php");
    }
}



function ingresar()
{
    
    require_once("../dao/UsuarioDao.php");
    require_once("../vendor/autoload.php");

    $usuario = new Usuario();
    $usuario->usuario = $_POST["usuario"];
    $usuario->password = $_POST["password"];
    $usuarioDao = new UsuarioDao();
    
    if ($usuarioDao->verificarUsuario($usuario)) {
        $secretKey = "J1UX1%[3d>TIv+HwsS3;";
        $issuedAt = time();
        $expirationTime = $issuedAt + 30;
        $payload = array(
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'usuario' => $usuario->usuario
        );

        $jwt = JWT::encode($payload, $secretKey, 'HS256');
        $_SESSION["jwt"] = $jwt;
        $_SESSION["activo"] = $usuario->usuario;

        mostrarPrincipal();
    } else {
        index();
    }
}

function agregarEditarUsuario()
{
    header("Location: ../vistas/editarusuario.php");
    exit;
}

function editarUsuario()
{
    require_once("../dao/UsuarioDao.php");
    $usuarioDao = new UsuarioDao();
    
    $token = $_SESSION['jwt'];

    if ($decoded = $usuarioDao->verificarToken($token)) {
        $usuario = new Usuario();
        $usuario->id = $_SESSION['id_user'];
        $usuario->usuario = $_POST['modUsuario'];
        $usuario->password = hash('sha256', $_POST['modPassword']);

        $usuarioDao = new UsuarioDao();
        if ($usuarioDao->modificar($usuario) > 0) {
            $_SESSION['alerta'] = true;
            mostrarUsuario();
        } else {
            unset($_SESSION['activo']);
            $_SESSION['alerta'] = false;
            header("Location: ../index.php");
        }
    } else {
        $_SESSION['alerta'] = false;
        unset($_SESSION['activo']);
        header("Location: ../index.php");
    }

    
}

function eliminarUsuario()
{

    require_once("../dao/UsuarioDao.php");
    $usuarioDao = new UsuarioDao();
    
    $token = $_SESSION['jwt'];

    if ($decoded = $usuarioDao->verificarToken($token)) {
        $usuario = new Usuario();
        $usuario->id = $_GET["id"];

        $usuarioDao = new UsuarioDao();
        if ($usuarioDao->eliminar($usuario) > 0) {
            $_SESSION['alerta'] = true;
            mostrarUsuario();
        } else {
            unset($_SESSION['activo']);
            $_SESSION['alerta'] = false;
            header("Location: ../index.php");
        }
    } else {
        $_SESSION['alerta'] = false;
        unset($_SESSION['activo']);
        header("Location: ../index.php");
    }

}
