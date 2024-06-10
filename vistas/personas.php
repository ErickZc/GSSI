<?php
require_once("../dto/Persona.php");
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
        <h3 style="padding: 1rem 0;">Listado de personas</h3>
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // En el caso que la vista haya pasado por el conrolador
                    if (isset($_SESSION["personas"])) {
                        // Obteniendo listado de personas mediante variable de sesion
                        $personas = $_SESSION["personas"];
                        // Recorriendo cada DTO de personas para mostrarlos en la tabla
                        foreach ($personas as $registro) {
                    ?>
                    <tr>
                        <td><?php echo $registro->id; ?></td>
                        <td><?php echo $registro->nombre; ?></td>
                        <td><?php echo $registro->apellido; ?></td>
                        <td>
                            <a href="../vistas/modificarpersona.php?id=<?php echo $registro->id?>" class="btn btn-info btn-sm">Modificar</a>
                            <a href="../controladores/controlador.php?persona=eliminar&id=<?php echo $registro->id ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                    <?php }
                    }; ?>
            </tbody>
        </table>
        <a href="../controladores/controlador.php?persona=agregar" class="btn btn-primary">Agregar persona</a>
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