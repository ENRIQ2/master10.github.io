<?php
include_once ('Conexion.php');
$pdo = Conexion::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $eliminar = "DELETE FROM nomina WHERE id = ?";
    $ejecutar = $pdo->prepare($eliminar);
    $ejecutar->execute(array($id));
    header("Location: index.php/..");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="shortcut icon" href="">
        <title>Nomina</title>
        <link href="css/estilo.css" rel="stylesheet">

    </head>
    <body>

        <?php include('menu.php') ?>

    <center><h3>LISTADO DE NOMINA</h3></center>

    <form action="buscar.php" method="GET">
        <input type="number" id="dato" name="dato" placeholder="Busque por No. Identificación" required>
    </form>

    <table id="tabla">
        <thead>
            <tr>  
                <th>Identificac&oacute;n</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Celular</th>
                <th>Ocupación</th>
                <th>Actualizar</th>                           
                <th>Eliminar</th>
            </tr>
        <tbody>
            <?php
            $listar = 'SELECT * FROM nomina ORDER BY apellidos ASC;';

            foreach ($pdo->query($listar) as $dato) {
                ?>

                <tr>
                    <td><?php echo $dato['identificacion'] ?></td>
                    <td><?php echo $dato['nombres'] ?></td>
                    <td><?php echo $dato['apellidos'] ?></td>
                    <td><?php echo $dato['correo'] ?></td>
                    <td><?php echo $dato['celular'] ?></td>
                    <td><?php echo $dato['ocupacion'] ?></td>

                    <td >
            <center>
                <a   href="editar.php?id=<?php echo $dato['id'] ?>"><button class="actualizar" >Actualizar</button> </a>
            </center></td>
        <td>
        <center>
            <form  action="" method="POST" onSubmit="return confirm('¿Desea eliminar la informacion?')">
                <input type="hidden" name="id"  id="id"  value = "<?php echo $dato['id'] ?>">
                <button  class="eliminar">Eliminar</button>
            </form>
        </center>
    </td>
    </tr>
    </tbody>
<?php } ?>  
</table>

</body>
</html>


