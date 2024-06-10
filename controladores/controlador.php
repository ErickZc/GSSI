<?php

session_start();

if (isset($_SESSION["activo"])) {
   
    if (isset($_GET["cerrar"]) && $_GET["cerrar"] == "true") {
       
        cerrarSesion();
    } else if (isset($_POST["nombre"]) && isset($_POST["apellido"])) {
        
        agregarPersona();
    } else if(isset($_GET["persona"]) && $_GET["persona"] == "agregar") {
        
        agregarEditarPersona();
    } else if(isset($_GET["persona"]) && $_GET["persona"] == "leer") {
        
        mostrarPersonas();
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
    }else if(isset($_POST['addNombre']) && isset($_POST['addApellido'])){
        
        editarPersona();
    }else if(isset($_GET["persona"]) && $_GET["persona"] == "modificar" && isset($_GET['id'])) {

        agregarModificarPersona();
    }else if(isset($_GET["persona"]) && $_GET["persona"] == "eliminar" && isset($_GET["id"]) && $_GET["id"] > 0) {
        
        eliminarPersona();
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


function mostrarPersonas()
{

    require_once("../dao/PersonaDao.php");
    $persona = new Persona();
    $personaDao = new PersonaDao();
    
    $_SESSION["personas"] = $personaDao->mostrar();
    header("Location: ../vistas/personas.php");
    exit;
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



function agregarPersona()
{

    require_once("../dao/PersonaDao.php");

    $persona = new Persona();
    $persona->nombre = $_POST["nombre"];
    $persona->apellido = $_POST["apellido"];
    $personaDao = new PersonaDao();
    if ($personaDao->agregar($persona) > 0) {
        
        mostrarPersonas();
    } else {
        
        header("Location: ../vistas/editarpersona.php");
        exit;
    }
}

function agregarUsuario()
{

    require_once("../dao/UsuarioDao.php");
    $usuario = new Usuario();
    $usuario->usuario = $_POST["addUser"];
    $usuario->password = $_POST["addPassword"];
    $usuarioDao = new usuarioDao();
    if ($usuarioDao->agregar($usuario) > 0) {
        
        mostrarUsuario();
    } else {
        
        header("Location: ../vistas/editarusuario.php");
        exit;
    }
}


function ingresar()
{
    
    require_once("../dao/UsuarioDao.php");
    $usuario = new Usuario();
    $usuario->usuario = $_POST["usuario"];
    $usuario->password = $_POST["password"];
    $usuarioDao = new UsuarioDao();
    if ($usuarioDao->verificarUsuario($usuario)) {
        $_SESSION["activo"] = $usuario->usuario;
        mostrarPrincipal();
    } else {

        index();
    }
}


function agregarEditarPersona()
{
    header("Location: ../vistas/editarpersona.php");
    exit;
}

function agregarEditarUsuario()
{
    header("Location: ../vistas/editarusuario.php");
    exit;
}

function agregarModificarPersona(){
    header("Location: ../vistas/modificarpersona.php");
}

function editarPersona(){
    require_once('../dao/PersonaDao.php');
    $persona = new Persona();
    $persona->id = $_SESSION['id_us'];
    $persona->nombre = $_POST['addNombre'];
    $persona->apellido = $_POST['addApellido'];
    $personaDao = new PersonaDao();
    if($personaDao->modificar($persona) > 0){
        mostrarPersonas();
    }else{
        header("Location: ../vistas/personas.php");
        
    }
}

function editarUsuario(){
    require_once('../dao/UsuarioDao.php');
    $usuario = new Usuario();
    $usuario->id = $_SESSION['id_user'];
    $usuario->usuario = $_POST['modUsuario'];
    $usuario->password = $_POST['modPassword'];
    $usuarioDao = new UsuarioDao();
    if($usuarioDao->modificar($usuario) > 0){
        mostrarUsuario();
    }else{
        header("Location: ../vistas/usuario.php");
        
    }
}


function eliminarPersona()
{
    
    require_once("../dao/PersonaDao.php");
    $persona = new Persona();
    $persona->id = $_GET["id"];
    $personaDao = new PersonaDao();
    if ($personaDao->eliminar($persona) > 0) {
        
        mostrarPersonas();
    } else {
        
        agregarEditarPersona();
    }
}

function eliminarUsuario()
{
    
    require_once("../dao/UsuarioDao.php");
    $usuario = new Usuario();
    $usuario->id = $_GET["id"];
    $usuarioDao = new UsuarioDao();
    if ($usuarioDao->eliminar($usuario) > 0) {
        
        mostrarUsuario();
    } else {
        
        
    }
}