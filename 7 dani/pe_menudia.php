<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Cafetería</title>
  </head>
  <link rel="stylesheet" href="css/menu.css">
  <link rel="icon" href="img/cafe.png">
  <!-- links estilos menu del dia -->
  <link rel="stylesheet" type="text/css" href="bootstrap.css">
  <link rel="stylesheet" type="text/css" href="font.css">
  <link rel="stylesheet" type="text/css" href="animacion.css">
  <link rel="stylesheet" type="text/css" href="select.css">
  <link rel="stylesheet" type="text/css" href="scroll.css">
  <link rel="stylesheet" type="text/css" href="util1.css">
  <link rel="stylesheet" type="text/css" href="util2.css">
    <!-- cierre links estilos menu del dia -->
  <!-- esencial para que funcione -->
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <!-- esencial para que funcione -->
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script type='text/javascript' src='js/menu.js'></script>
  <style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Roboto+Condensed:wght@700&display=swap');
  </style>
    <body>
    <div class="text">CAFETERÍA SANTA MARTA<img src="img/cafesinfondo.png" alt="cafe" class="cafe"></div>
  <div class="menu-tab">
    <div id="one"></div>
    <div id="two"></div>
    <div id="three"></div>
  </div>
  <div class="menu-hide">
    <nav>
      <ul>
        <li><a href="pe_login.php">MI CUENTA <img src="img/cuenta.png" alt="micuenta" class="micuenta"></a></li>
        <li id="mostrar"><a href="menudeldia/menudeldia1.html">INICIO <img src="img/menudeldia.png" alt="menudeldia" class="menudeldia">
        </a></li>
        <li><a href="nuestrolocal.php">NUESTRO LOCAL <img src="img/local1.png" alt="local" class="local"></a></li>
        <li><a href="contacto.php">CONTACTO <img src="img/contacto.png" alt="contacto" class="contacto"></a></li>
      </ul>
    </nav>
  </div>

  <form action="pe_login.php" method="POST">
            <label>USUARIO: </label>
            <input type="text" name="usuario" required/><br/><br>
            <label>CONTRASEÑA: </label>
            <input type="password" name="password" required/><br/><br>
            <input type="submit" value="LOGIN"/>
        </form>
            <a href="cuenta/crear_cuenta.php">Crear cuenta</a>
            <a href="cuenta/cambiar_contraseña">Cambiar contraseña</a>
<?php
$fecha = date('d');
if (intval($fecha)%2==0) {
 echo "par (foto) MENU DIA 1";
}else {
  echo "impar (foto) MENU DIA 2";
}
 ?>
        </div>
    </body>
</html>
