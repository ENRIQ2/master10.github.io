<?php
include_once ('conexion.php');
$pdo = Conexion::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identificacion = $_POST['identificacion'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    $ocupacion = $_POST['ocupacion'];
    $sqlcantidad = "SELECT COUNT(*) FROM nomina WHERE identificacion = '" . $identificacion . "'";


    $query = $pdo->query($sqlcantidad);
    $cantidad = $query->fetchColumn();

    if ($cantidad != 0) {
        echo '<script language="javascript">alert("Ya esta una persona registrada con esta identiciación");</script>';
    } else {


        $sql = "INSERT INTO nomina (identificacion, nombres, apellidos, correo, celular, ocupacion) VALUES (?, ?, ?, ?, ?, ?)";

        $ejecutar = $pdo->prepare($sql);
        $ejecutar->execute(array($identificacion, strtoupper($nombres), strtoupper($apellidos), strtolower($correo), $celular, $ocupacion));

        echo '<script language="javascript">alert("Registro Exitoso");</script>';
        Conexion::desconectar();
    }
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

    <body>
    <center><h3>REGISTRO DE UN NUEVO PERSONAL</h3></center>

    <div>
        <form action="" method="POST">
            <label for="fname">No. de Identificación:</label>
            <input type="number" id="identificacion" name="identificacion" placeholder="Ingrese No. Identificación" required>

            <label for="fname">Nombres:</label>
            <input type="text" id="nombres" name="nombres" placeholder="Ingrese Nombres" required>

            <label for="fname">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" placeholder="Ingrese Apellidos" required>

            <label for="fname">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" placeholder="Ingrese Email" required>

            <label for="fname">Celular:</label>
            <input type="number" id="celular" name="celular" placeholder="Ingrese Celular" required>

            <label for="fname">Ocupación:</label>
            <input type="text" id="ocupacion" name="ocupacion" placeholder="Ingrese Ocupación" required>

            <input type="submit" value="Aceptar">
        </form>
    </div>

</body>
</html>


