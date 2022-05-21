<?php
    session_start();
    if (!isset($_SESSION["Nombre"])) {
      //Cerrar sesion
      session_unset();
      session_destroy();
      //Mensaje
      header("location:../pe_login.php");
    } else {
    require_once '../funciones/funcion_pe_consped.php';
    require_once ("../funcionesComunes/funcionesComunes.php");
    $conn = abrirConexion();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/pe_login.css">
    <title>Consulta pedidos</title>
</head>
<body>
  <h1>Cafetería Santa Marta</h1>
    <?php
    $nombre=$_SESSION["Nombre"];
    $contra=$_SESSION["usuarioContraseña"];
    echo "<center><br><div class='opciones'><h2>Pedidos en el local</h2>";
    consultaPedidos1($conn,$nombre,$contra);
    echo "</div><div class='opciones'><h2>Pedidos por reserva</h2>";
        consultaPedidos2($conn,$nombre,$contra);
        echo "</div><div class='opciones'><h2>Pedidos a domicilio</h2>";
            consultaPedidos3($conn,$nombre,$contra);
            echo "</div><center>";
    cerrarConexión($conn);
    }
    ?>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div><center><a href="pe_inicio.php">Volver al menu de usuario</a></center></div>
</body>
</html>
