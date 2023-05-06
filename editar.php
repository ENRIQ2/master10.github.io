<?php
include_once ('conexion.php');
$pdo = Conexion::conectar();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}
if (null == $id) {
    header("Location: index.php/..");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $identificacion = $_POST['identificacion'];
    $identificacionvieja = $_POST['identificacionvieja'];

    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    $ocupacion = $_POST['ocupacion'];

    function validaridentificacion($identificacion, $identificacionvieja) { // validar si cambio o no la idntificacion
        if ($identificacion != $identificacionvieja) {
            $cantidad = 1;
        } else {
            $cantidad = 0;
        }
        return $cantidad;
    }

    $sqlcantidad = "SELECT COUNT(*) FROM nomina WHERE identificacion = '" . $identificacion . "'";
    $ejecutarcant = $pdo->query($sqlcantidad);
    $cantidad = $ejecutarcant->fetchColumn();

    $sql = " UPDATE nomina SET identificacion = ?, nombres = ?, apellidos = ?, correo = ?,  celular = ?, ocupacion = ? WHERE id = ?;";

    $verificar = validaridentificacion($identificacion, $identificacionvieja);


    if ($verificar == 1) { // actualiza los dos
        if ($cantidad != 0) {
            echo '<script language="javascript">alert("Ya esta una persona registrada con esta identiciación");</script>';
        } else {
            $ejecutar = $pdo->prepare($sql);
            $ejecutar->execute(array($identificacion, strtoupper($nombres), strtoupper($apellidos), strtolower($correo), $celular, $ocupacion, $id));
            echo '<script language="javascript">alert("Actualizacion Exitosa");</script>';
            Conexion::desconectar();
        }
    } elseif ($verificar == 0) { // actualiza Datos sin nueva Identificacion 
        $ejecutar = $pdo->prepare($sql);
        $ejecutar->execute(array($identificacionvieja, strtoupper($nombres), strtoupper($apellidos), strtolower($correo), $celular, $ocupacion, $id));

        echo '<script language="javascript">alert("Actualizacion Exitosa");</script>';
        Conexion::desconectar();
    }
}

$buscar = 'SELECT * FROM nomina WHERE id = ?';
$q = $pdo->prepare($buscar);
$q->execute(array($id));
$datob = $q->fetch(PDO::FETCH_ASSOC);

$id = $datob['id'];
$identificacion = $datob['identificacion'];
$nombres = $datob['nombres'];
$apellidos = $datob['apellidos'];
$correo = $datob['correo'];
$celular = $datob['celular'];
$ocupacion = $datob['ocupacion'];
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

    <center><h3>ACTUALIZAR LOS DATOS DE : <?php echo $nombres . " " . $apellidos ?></h3></center>

    <div>
        <form action="" method="POST">
            <input type="hidden" class="form-control" id="id" name="id"  value = "<?php echo!empty($id) ? $id : ''; ?>">
            <label for="fname">No. de Identificación:</label>
            <input type="number" id="identificacion" name="identificacion" placeholder="Ingrese No. Identificación" value = "<?php echo!empty($identificacion) ? $identificacion : ''; ?>" required>

            <input type="hidden" id="identificacionvieja" name="identificacionvieja" placeholder="Ingrese No. Identificación" value = "<?php echo!empty($identificacion) ? $identificacion : ''; ?>">

            <label for="fname">Nombres:</label>
            <input type="text" id="nombres" name="nombres" placeholder="Ingrese Nombres"  value = "<?php echo!empty($nombres) ? $nombres : ''; ?>" required>

            <label for="fname">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" placeholder="Ingrese Apellidos" value = "<?php echo!empty($apellidos) ? $apellidos : ''; ?>" required>

            <label for="fname">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" placeholder="Ingrese Email" value = "<?php echo!empty($correo) ? $correo : ''; ?>" required >

            <label for="fname">Celular:</label>
            <input type="number" id="celular" name="celular" placeholder="Ingrese Celular" value = "<?php echo!empty($celular) ? $celular : ''; ?>" required>

            <label for="fname">Ocupación:</label>
            <input type="text" id="ocupacion" name="ocupacion" placeholder="Ingrese Ocupación" value = "<?php echo!empty($ocupacion) ? $ocupacion : ''; ?>" required>

            <input type="submit" value="Aceptar">
        </form>
    </div>

</body>
</html>


