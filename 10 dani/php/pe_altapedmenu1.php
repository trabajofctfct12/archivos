<?php
    session_start();
    require_once ("../funciones/funcionespe_altapedmenu1.php");
    require_once ("../funcionesComunes/funcionesComunes.php");
    	include 'apiRedsys.php';
    $conexion = abrirConexion(); //Se establece la conexión.
    //1.- Se mira si hay o no una sesión abierta.
    if (!isset($_SESSION["Nombre"])) {//Si no hay sesión iniciada no nos permite acceder la programa y nos saca un mensaje de error
      //Cerrar sesion
      session_unset();
      session_destroy();
      //Mensaje
      header("location:../pe_login.php");
    }
    // Si el carrito no ha sido inicializando, lo creamos
    if (!isset($_SESSION['CARROCOMPRA'])) {
        $_SESSION['CARROCOMPRA'] = array();
        $carroCompra = $_SESSION['CARROCOMPRA']; //el contenido del array de carroCompra se pasa a la variable $carroCompra sobre la que se va a trabajar.
    } else {
      $carroCompra = $_SESSION['CARROCOMPRA'];
    }
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
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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
<br><br>
      <center style="color:white;"><h2>REPARTO A DOMICILIO</h2>
      <h2 style="color:black;">MENÚ 1</h2></center>
      <div class="usuariologin3">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label> Primeros: <label><br>
        <select name="Id_plato">
            <?php
                $desplegableProductos= desplegableProductos($conexion); //Se despliegan los productos QUE TENGAN STOCK.
                while ($fila=$desplegableProductos->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <option value="<?php echo $fila['Id_plato']?>" > <?php echo $fila['Nombre'] ?> </option>
            <?php
                } //fin while
             ?>
        </select>
        <br><br>
            <input type="submit" value="Añadir primero"  name="agregar">
            <!-- <input type="submit" value="Vaciar cesta" name="vaciar"> -->
            <input type="submit" value="Ver platos añadidos"  name="verCesta">
            <br>
    </form>
       <?php
        if($_POST){
            //recogida y limpieza de valores introducidos por el usuario.
            $codigoProducto = test_input($_POST['Id_plato']);
            $cantidadProducto = 1;

            //Ahora hay que establecer las funciones para cada uno de los botones:
            if (isset($_POST['agregar'])) {
            //Si se pulsa agregar hay que comprobar que hay stock suficiente según el número de unidades que quiera el cliente de cada producto.
                $cantidadStock = consultaValor($conexion, "SELECT Stockplato FROM almacen WHERE Id_plato = '$codigoProducto'");

                if ($cantidadStock>=$cantidadProducto) { //si la cantidad en stock es mayor o igual que las unidades del producto que se han pedido, entonces se agrega el producto al carro.
                        if (!array_key_exists($codigoProducto, $carroCompra)) { //se comprueba si el código producto existe en el carro de la compra.
                            $carroCompra[$codigoProducto]=$cantidadProducto; //Si el producto no estaba en el carro previamente, entonces se puede añadir.
                            echo "Producto añadido correctamente <br>";
                        }//fin if
                    else {//se comprueba si el código producto existe en el carro de la compra.
                          $_SESSION['CARROCOMPRA'] = $carroCompra;
                                $carroCompra[$codigoProducto]=$cantidadProducto+$carroCompra[$codigoProducto]; //Si el producto estaba en el carro previamente, se puede añadir también.
                                echo "Producto añadido correctamente. <br>";
                      }//fin if
                } else {
                    echo "No hay suficiente stock del artículo que has seleccionado";
                 }//fin else
                $_SESSION['CARROCOMPRA'] = $carroCompra; //una vez que se ha añadido al array $carroCompra los productos, pasamos esos datos al array sesión para que se quede ahí guardado.
                header("location: ./pe_altapedmenu11.php");
            }// fin if agregar
            //visualizar la cesta
            if (isset($_POST["verCesta"])) { //Si se pulsa ver cesta, se visualiza la tabla.
                if (empty($carroCompra)) {
                  echo "No hay productos en la cesta<br>";
                }
                else {
                  echo "<center> <table border='2'><br>";
                  echo "<thead> <tr> <th colspan='3'> CARRO DE LA COMPRA </th> </tr> </thead>
                  <tbody>
                  <tr> <th> Nombre del producto </th> <th> Cantidad </th></tr>";
                  foreach ($carroCompra as $codigoProducto => $cantidadProducto) {
                      $nombreProducto = consultaValor($conexion, "SELECT Nombre FROM platos where Id_plato = '$codigoProducto'");
                      echo   "<tr>
                                  <td>".$nombreProducto."</td>
                                  <td>".$cantidadProducto."</td>
                              </tr>";
                  }
                  echo "</tbody></table></center>";
                  echo "<br>";
                }
            }
        }//fin post
        ?>
      <br><br>
    </div>
</BODY>
</HTML>
