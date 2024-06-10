<?php
// Indicando manejo de sesiones
session_start();
// Evaluando si existe sesion activa
if (isset($_SESSION["activo"])) {
    // Incluyendo cabecera y barra de navegacion del sitio
    require_once("template/header.php");
    require_once("template/navbar.php");
?>
<body>
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-3">Bienvenido <?php echo $_SESSION["activo"]; ?>!</h1>
            <p>Este sistema de pruebas permite gestionar personas mediante DAO</p>
            <p><a class="btn btn-primary btn-lg" href="../controladores/controlador.php?persona=leer" role="button">Probar ahora &raquo;</a></p>
        </div>
    </div>
    <?php
    // Incluyendo pie de pagina
    require_once("template/footer.php");
    ?>
</body>
</html>
<?php
} else {
    // En caso de no existir sesion activa, se redirecciona al login
    header("Location: ../index.php");
    exit;
}
?>