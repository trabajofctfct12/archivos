<?php
session_start();
if (!isset($_SESSION["customerNumber"])) {//Si no hay sesión iniciada no nos permite acceder la programa y nos saca un mensaje de error
  //Cerrar sesion
  session_unset();
  session_destroy();
  //Mensaje
  header("location:../pe_login.php");
} else {
  require_once '../funciones/funcionespe_topprod.php';
  require_once ("../funcionesComunes/funcionesComunes.php");
  //ABRIMOS LA CONEXIÓN CON LA BASE DE DATOS
  $conn = abrirConexion();
  //COMPROBAMOS QUE HAY UNA SESIÓN ABIERTA

  $cliente = $_SESSION["customerNumber"];
  ?>
  <html lang=es dir=ltr>
  <head>
    <meta charset=utf-8>
    <title>Ver prodcutos comprados</title>
    <style>
            body {
              background-color:  #9c370a ;
              color: white;
              font-size: 14pt;
              font-family: Arial;
            }
            a {color: white;}
            a:hover{
              color: black;
              font-size: 16pt;
            }
    </style>
  </head>
  <body>
    <?php
    echo "Ha iniciado sesión como: <b>".nombreCliente($cliente,$conn)."</b>";
    ?>
    <h1>Ver productos comprados</h1>
    <form method=post action = <?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>>
      <p>Inicio: <input type="date" name="inicio"></p>
      <p>Fin: <input type="date" name="fin"></p>
      <p><input type=submit name=ver value="Ver ventas"></p>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      //LIMPIAMOS LOS PARAMETROS
      $inicio = test_input($_POST['inicio']);
      $fin = test_input($_POST['fin']);
      //LOGICA DEL PROGRAMA
      $ventas = ComprobarVentas($cliente,$inicio,$fin,$conn);
      $size = count($ventas);
      if (empty($_POST['inicio']) || empty($_POST['fin'])) {
        echo "Se deben introducir las fechas";
      }
      else if ($size == 0) {echo "Al <b>".nombreCliente($cliente,$conn)."</b> no se le vendieron productos en esas fechas";}
      else {
        ?>
        <table border=1>
          <tr>
            <th>Nombre del producto</th>
            <th>Cantidad vendida</th>
          </tr>
          <?php
          for ($i=0; $i < $size; $i+=2) {//Recorremos el array "ventas" y vamos mostrando los resultados en una tabla
            echo "<tr>";
            echo "<td>$ventas[$i]</td>";
            echo "<td>".$ventas[$i+1]."</td>";
            echo "</tr>";
          }
          ?>
        </table>
        <?php
      }//Cierre del else
      //CERRAMOS LA CONEXIÓN
      cerrarConexión($conn);
    }
  }?>
  <p><a href="pe_inicio.php">Volver al menu de usuario</a></p>
</body>
</html>
