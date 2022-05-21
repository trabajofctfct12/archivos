<?php
session_start();
if (!isset($_SESSION["customerNumber"])) {
  //Cerrar sesion
  session_unset();
  session_destroy();
  //Mensaje
  header("location:../pe_login.php");
} else {
  require_once '../funciones/funcionespe_conspago.php';
  require_once ("../funcionesComunes/funcionesComunes.php");
  //ABRIMOS LA CONEXIÓN CON LA BASE DE DATOS
  $conn = abrirConexion();
  //COMPROBAMOS QUE HAY UNA SESION ABIERTA

  $cliente = $_SESSION['customerNumber'];
  ?>
  <html lang=es dir=ltr>
  <head>
    <meta charset=utf-8>
    <title>Ver pagos realizados</title>
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
    <h1>Ver pagos realizados</h1>
    <form method=post action = <?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>>
      <p>Inicio: <input type="date" name="inicio"></p>
      <p>Fin: <input type="date" name="fin"></p>
      <p><input type=submit name=ver value="Ver pagos"></p>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      //LIMPIAMOS LOS PARAMETROS QUE NOS PASAN
      $cliente = "103";
      $inicio = test_input($_POST['inicio']);
      $fin = test_input($_POST['fin']);
      //LOGICA DEL PROGRAMA
      if (empty($_POST['inicio']) || empty($_POST['fin'])) {//En caso de que no se indiquen las fechas mostramos un historico con los pagos del cliente
        $pagos = verHistoricoPagos($cliente,$conn);
        $size = count($pagos);
        ?>
        <table border=1>
          <tr>
            <th>ID_PAGO</th>
            <th>Fecha pago</th>
            <th>Coste</th>
          </tr>
          <?php
          for ($i=0; $i < $size; $i+=3) {//Recorremos el array "pagos" y vamos mostrando los resultados en una tabla
            echo "<tr>";
            echo "<td>$pagos[$i]</td>";
            echo "<td>".$pagos[$i+1]."</td>";
            echo "<td>".$pagos[$i+2]." €</td>";
            echo "</tr>";
          }
          ?>
        </table>
        <?php
      }//Cierre del if
      else {//En caso de que nos pasen fechas mostramos cuantos pagos ha realizado el clinete y cual es el total de los mismos
        $pagos = verPagos($cliente,$inicio,$fin,$conn);

        if ($pagos[0] == 0) {
          echo "No se han realizado pagos en estas fechas";
        }
        else {
          echo "En estas fechas <b>".nombreCliente($cliente,$conn)."</b> ha hecho $pagos[0] pagos <br>";
          echo "El importe total es <b>$pagos[1]€</b>";
        }
      }
      //CERRAMOS LA CONEXIÓN CON LA BASE DE DATOS
      cerrarConexión($conn);
    }
  }?>
  <p><a href="pe_inicio.php">Volver al menu de usuario</a></p>
</body>
</html>
