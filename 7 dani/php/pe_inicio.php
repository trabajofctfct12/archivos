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
       //CERRAMOS LA CONEXIÓN CON LA BASE DE DATOS
    if(isset($_SESSION["Nombre"])){
?>
<html>
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
