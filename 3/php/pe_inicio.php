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
<?php echo "Has iniciado sesion: <b>".nombreCliente($_SESSION['Nombre'],$conn)."</b>";?>
  <head>
    <title>Menú de Inicio</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/pe_inicio.css">
  </head>
  <body>
    <h1>Web Pedidos</h1>
    <ul>
      <li><a href="pe_altaped.php">Realizar Pedido</a></li>
      <li><a href="pe_consped.php">Consultar Pedidos</a></li>
      <li><a href="pe_consprodstock.php">Consultar Stock Producto</a></li>
      <li><a href="pe_constock.php">Consultar Stock Total</a></li>
      <li><a href="pe_topprod.php">Consultar Ventas</a></li>
      <li><a href="pe_conspago.php">Consultar Pagos</a></li>
    </ul>
    <br><br>
     <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <input type="submit" value="Cerrar Sesion" name="cerrarSesion"/>
    </form>
    <!-- SECRETO -->
    <div class="secreto"><img src="https://static.paraloscuriosos.com/img/articles/13952/470x470/orig.58ec8ebcc9f73_14916087571498622.gif"></div>
<?php
      } else{
          header("location:../pe_login.php");
      }

?>
  </body>
</html
