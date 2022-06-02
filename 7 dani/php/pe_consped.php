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
  <meta charset="utf-8" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/pe_login.css">
</head>
<body>
  <h1>Cafetería Santa Marta</h1>
  <br>
  <div class="menulateral">
    <a href="../index.php">Inicio</a>
    <a href="pe_altaped.php">Realizar Pedido</a>
    <a href="pe_consped.php">Consultar Pedidos</a>
    <a href="../pe_menudia.php">Menú del día</a>
    <a href="../pe_nuestrolocal">Nuestro local</a>
    <a href="#">Contacto</a>
    <a href="#">Dónde estamos</a>
  </div>
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
</body>
</html>
