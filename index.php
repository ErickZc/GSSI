<?php
// Indicando manejo de sesiones
session_start();
// Evaluando si existe sesion activa
if (isset($_SESSION["activo"])) {
    // En caso de sesion activa, redirecciona al dashboard
    header("Location: vistas/dashboard.php");
    exit;
} else {

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Login -->
    <link rel="stylesheet" href="css/styles.css">
    <title>Login del sistema</title>
</head>
<body class="text-center">
    <div class="container">
        <form class="form-signin" action="controladores/controlador.php" method="post">
            <img class="mb-4" src="img/login.svg" alt="" width="50%">
            <h1 class="h3 mb-3 font-weight-normal">Bienvenido</h1>
            <label for="inputUsuario" class="sr-only">Usuario</label>
            <input type="text" id="inputUsuario" class="form-control" name="usuario" placeholder="Ingrese usuario" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Ingrese password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
            <p class="mt-5 mb-3 text-muted">DAW &copy; <?php echo date("Y"); ?></p>
        </form>
    </div>
</body>
</html>
<?php
// Cerrando el if
}
?>