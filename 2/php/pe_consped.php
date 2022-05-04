<?php
    session_start();
    if (!isset($_SESSION["customerNumber"])) {
      //Cerrar sesion
      session_unset();
      session_destroy();
      //Mensaje
      header("location:../pe_login.php");
    } else {
    require_once '../funciones/funcion_pe_consped.php';
    require_once ("../funcionesComunes/funcionesComunes.php");
    $conn = abrirConexion();
    $customer_number = $_SESSION["customerNumber"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/pe_consped.css">
    <title>Consulta pedidos</title>
</head>
<body>
<h3>Consulta de pedidos</h3>
    <?php
    echo "Bienvenido/a <b>".nombreCliente(($_SESSION['customerNumber']),$conn)."</b><br><br>";
    consultaPedidos($conn,$customer_number);
    cerrarConexión($conn);
    }?>
    <p><a href="pe_inicio.php">Volver al menu de usuario</a></p>
</body>
</html>
