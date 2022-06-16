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
      <h2 style="color:white;">PEDIDO A DOMICILIO DE MENÚ DEL DÍA A ELEGIR</h2>
      Echar un vistazo al menú del dia <a href="../menudeldia/menudeldia1.php"> Menú 1 </a><br><br>
      Echar un vistazo al menú del dia <a href="../menudeldia/menudeldia2.php"> Menú 2 </a><br><br>
       <a href="./pe_altapedmenu1.php">Hacer mi pedido 1 </a><br><br>
       <a href="./pe_altapedmenu2.php">Hacer mi pedido 2</a>
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
  //recogida y limpieza de valores introducidos por el usuario.
  // $mesa = test_input($_POST['mesa']);
  $fechainicio = test_input($_POST['enviar']);
  // $telf = test_input($_POST['telf']);
  // $email = test_input($_POST['email']);
  // $usuario=$_SESSION["Nombre"];

  if (isset($_POST['agregar'])) {
    echo "FECHA FINAL $fechainicio <BR><BR>HOLAAAAAAAAAAAAA HOLAAAAAAAAAAAAA";
    //sacamos el id del usuario a través de la sesión
    // $idusuario=sacaridusuario($usuario,$conexion);
    // echo "$idusuario";
    // //creamos la reserva
    // crearreserva($idusuario,$mesa,$telf,$email,$fechainicio,$conexion);

  }
}
  ?>