<?php
    session_start();
    require_once ("../funcionesComunes/funcionesComunes.php");
    //ABRIMOS CONEXIÓN CON LA BASE DE DATOS
    $conn = abrirConexion();
    //INICIAMOS LA SESIÓN
     if (isset($_POST["cerrarSesion"])) {
            header("location:../pe_login.php");
          session_start();
          session_unset();
          session_destroy();
          cerrarConexión($conn);
       }//fin if
    if(isset($_SESSION["Nombre"])){
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Cafetería</title>
   </head>
   <link rel="stylesheet" href="../css/menu.css">
   <link rel="icon" href="../img/cafe.png">
   <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
   <link rel="stylesheet" href="http://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
   <script type='text/javascript' src='../js/menu.js'></script>
   <script type='text/javascript' src='../js/botonlogin.js'></script>
   <style>
   @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Roboto+Condensed:wght@700&display=swap');
   </style>
   <body class="body2">
     <!-- no se expande -->
   <div class="text">CAFETERÍA SANTA MARTA<img src="../img/cafesinfondo.png" alt="cafe" class="cafe"></div>
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
     <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
       <div class="opciones"><center>    <?php echo "Has iniciado sesion como: <b>".$_SESSION["Nombre"]."</b>";?></center></div>
       <div class="opciones"><center>   <a href='../cuenta/cambiar_contraseña.php'>Cambiar Contraseña</a></center></div>
      <div class="opciones"><center>Cerrar sesión click aquí:
        <br><br><input type="submit" value="Cerrar Sesion" name="cerrarSesion"/></center></div>
    </form>
<?php
      } else{
          header("location:../pe_login.php");
      }
?>
  </body>
</html
