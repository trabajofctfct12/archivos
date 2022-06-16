<?php
session_start();
require_once ("../funcionesComunes/funcionesComunes.php");
require_once ("../funciones/funciones_reserva.php");
//ABRIMOS CONEXIÓN CON LA BASE DE DATOS
$conexion = abrirConexion();
//INICIAMOS LA SESIÓN
if (isset($_POST["cerrarSesion"])) {
  header("location: ../pe_login.php");
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
    <meta http-equiv="content-type" content="text/html" charset="utf-8">
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
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
    <center>
      <br><br><br><h2 style="color:white;">RESERVA EN LOCAL</h2>
    <div class="reserva">

      <img style="height:650px;width:650px;float:left;"src="../img/planoscafeteria/CENITALCAFETERIARESERVAS.png" alt="vistacenitalcafeteria">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      Seleccione su mesa:<br><br>
      <select class="inputs" name="mesa" required>
        <option value="1">Mesa 1</option>
        <option value="2">Mesa 2</option>
        <option value="3">Mesa 3</option>
        <option value="4">Mesa 4</option>
        <option value="5">Mesa 5</option>
        <option value="6">Mesa 6</option>
        <option value="7">Mesa 7</option>
        <option value="8">Mesa 8</option>
        <option value="9">Mesa 9</option>
      </select><br><br>
      Seleccione la fecha:<br><br>
      <input class="inputs" type="datetime-local" name="fechainicio" min="2022-01-01"><br><br>
      Teléfono de contacto:<br><br>
      <input class="inputs" type="text" name="telf" value=""><br><br>
      Email:<br>
      <input class="inputs" type="email" name="email" value=""><br><br><br>
      <input class="inputbutton" type="submit" name="enviar" value="REALIZAR RESERVA">
    </div>
    </form>
    </center>
    <?php
  }else{
    header("location:../pe_login.php");
  }
  ?>
</body>
</html
<?php
    if($_POST){
  // recogida y limpieza de valores introducidos por el usuario.
  $mesa = test_input($_POST['mesa']);
  $fechainicio = test_input($_POST['fechainicio']);
  $telf = test_input($_POST['telf']);
  $email = test_input($_POST['email']);
  $usuario=$_SESSION["Nombre"];

  $fechainicio1=substr($fechainicio,0,10);
  $fechainicio2=substr($fechainicio,11,5);
  $fechatotal=$fechainicio1." ".$fechainicio2;

  if (isset($_POST['enviar'])) {
    //sacamos el id del usuario a través de la sesión
     $idusuario=sacaridusuario($usuario,$conexion);
     //creamos la reserva
     $funciona=crearreserva($idusuario,$mesa,$telf,$email,$fechatotal,$conexion);
     if ($funciona==1) {
       echo "<div style='float:left;'><center><h3 style='color:white;float:left;'>Reserva realizada por $usuario para el $fechainicio1 a las $fechainicio2 en la mesa $mesa</h3></center></div>";
     }
     }
 }
  ?>
