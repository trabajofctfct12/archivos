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
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Cafetería</title>
  </head>
  <link rel="stylesheet" href="../css/menu.css">
  <link rel="icon" href="../img/cafe.png">
  <!-- esencial para que funcione -->
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <!-- esencial para que funcione -->
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script type='text/javascript' src='../js/menu.js'></script>
  <style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Roboto+Condensed:wght@700&display=swap');
  </style>
    <body class="body1">
      <div class="text" style="float:left;">CAFETERÍA SANTA MARTA<img src="../img/cafesinfondo.png" alt="cafe" class="cafe"></div>
      <div class="usuariologin2" style="float:left; margin-right: 0px; position: absolute; top: -3%; right: 1%;">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" accept-charset="ISO-8859-1">
          <?php echo "Has iniciado sesión como: <b>".$_SESSION["Nombre"]."</b>";?><br>
          <a href='../cuenta/cambiar_contraseña.php'>Cambiar Contraseña</a>
          <input type="submit" value="Cerrar Sesion" name="cerrarSesion"/>
       </form>
       </div>
  <div class="menu-tab">
    <div id="one"></div>
    <div id="two"></div>
    <div id="three"></div>
  </div>
  <div class="menu-hide">
    <nav>
      <ul>
        <li><a href="../pe_login.php">MI CUENTA <img src="../img/cuenta.png" alt="micuenta" class="micuenta"></a></li>
        <li id="mostrar"><a href="../menudeldia/menudeldia1.php">MENÚ DEL DÍA <img src="../img/menudeldia.png" alt="menudeldia" class="menudeldia">
        </a></li>
        <li><a href="../carta.php">CARTA <img src="../img/carta.png" alt="carta" class="carta"></a></li>
        <li><a href="../nuestrolocal.php">NUESTRO LOCAL <img src="../img/local1.png" alt="local" class="local"></a></li>
        <li><a href="../contacto.php">CONTACTO <img src="../img/contacto.png" alt="contacto" class="contacto"></a></li>
        <li><a href="../preguntas.php">PREGUNTAS <img src="../img/pregunta.png" alt="preguntas frecuentes" class="pregunta"></a></li>
        <li>
        <a target="_blank" href="https://www.instagram.com/cafeteriasantamarta/">INSTAGRAM<img src="../img/instagram.png" alt="instagram" class="instagram"></a>
        </li>
      </ul>
    </nav>
  </div>
    <?php
    $nombre=$_SESSION["Nombre"];
    $contra=$_SESSION["usuarioContraseña"];
    echo "<center><br><div class='usuariologin3'><h2>Pedidos en el local</h2>";
    consultaPedidos1($conn,$nombre,$contra);
    echo "</div><div class='usuariologin3'><h2>Pedidos por reserva</h2>";
        consultaPedidos2($conn,$nombre,$contra);
        echo "</div><div class='usuariologin3'><h2>Pedidos a domicilio</h2>";
            consultaPedidos3($conn,$nombre,$contra);
            echo "</div><center>";
    cerrarConexión($conn);
    }
    ?>
</body>
</html>
