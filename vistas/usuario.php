<?php
require_once("../dto/Usuario.php");
// Indicando manejo de sesiones
session_start();
// Evaluando si existe sesion activa
if (isset($_SESSION["activo"])) {
    // Incluyendo cabecera y barra de navegacion del sitio
    require_once("template/header.php");
    require_once("template/navbar.php");
?>
<body>
    <div class="container text-center">
        <h3 style="padding: 1rem 0;">Listado de usuarios</h3>
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Password</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php

                    if (isset($_SESSION["user"])) {
                        $usuari = $_SESSION["user"];
                        foreach ($usuari as $registro) {

                    ?>
                    <tr>
                        <td><?php echo $registro->id; ?></td>
                        <td><?php echo $registro->usuario; ?></td>
                        <td><?php echo $registro->password; ?></td>
                        <td>
                            <a href="../vistas/modificarusuario.php?id=<?php echo $registro->id?>" class="btn btn-info btn-sm">Modificar</a>
                            <a href="../controladores/controlador.php?user=eliminar&id=<?php echo $registro->id ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                    <?php }
                    }; ?>
            </tbody>
        </table>
        <a href="../controladores/controlador.php?user=agregar" class="btn btn-primary">Agregar Usuario</a>
    </div>
    <?php

    require_once("template/footer.php");
    ?>
</body>
</html>
<?php
} else {

    header("Location: ../index.php");
    exit;
}
?>