<?php
    session_start();
    require_once ("../funciones/funcionespe_altaped.php");
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
    } else {
        echo "Bienvenido/a <b>".nombreCliente($_SESSION['Nombre'],$conexion)."</b><br><br>";
    }
    // Si el carrito no ha sido inicializando, lo creamos
    if (!isset($_SESSION['CARROCOMPRA'])) {
        $_SESSION['CARROCOMPRA'] = array();
        $carroCompra = $_SESSION['CARROCOMPRA']; //el contenido del array de carroCompra se pasa a la variable $carroCompra sobre la que se va a trabajar.
    } else {
      $carroCompra = $_SESSION['CARROCOMPRA'];
    }
?>

<HTML>

<BODY>
    <h1> PEDIDO A DOMICILIO </h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label> Productos disponibles <label>
        <select name="Id_plato">
            <?php
                $desplegableProductos= desplegableProductos($conexion); //Se despliegan los productos QUE TENGAN STOCK.
                while ($fila=$desplegableProductos->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <option value="<?php echo $fila['Id_plato']?>"> <?php echo $fila['Nombre']." - ".$fila['precio']."€" ?> </option>
            <?php
                } //fin while
             ?>
        </select> <br>

        <p> <label> Selecciona la cantidad: </label>
            <input type='number' name='cantidad' value="1" placeholder='Cantidad' min="1">
        </p>
            <input type="submit" value="Añadir plato"  name="agregar">
            <input type="submit" value="Vaciar pedido" name="vaciar">
            <input type="submit" value="Ver Platos"  name="verCesta">
            <br><br>
    </form>
       <?php
        if($_POST){

            //recogida y limpieza de valores introducidos por el usuario.
            $codigoProducto = test_input($_POST['Id_plato']);
            $cantidadProducto = test_input($_POST['cantidad']);

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
            }// fin if agregar

            if (isset($_POST['vaciar'])) {//Si se pulsa el botón vaciar. Se vuelve a los orígenes.
                    $carroCompra = array();
                    $_SESSION['CARROCOMPRA'] = $carroCompra;

            } //fin if vaciar

            //visualizar la cesta
            if (isset($_POST["verCesta"])) { //Si se pulsa ver cesta, se visualiza la tabla.
                if (empty($carroCompra)) {
                  echo "No hay productos en la cesta<br>";
                }
                else {
                  echo "<br> <br> <table border='2'>";
                  echo "<thead> <tr> <th colspan='3'> CARRO DE LA COMPRA </th> </tr> </thead>
                  <tbody>
                  <tr> <th> Nombre del producto </th> <th> Cantidad </th> <th> Precio </th> </tr>";
                  foreach ($carroCompra as $codigoProducto => $cantidadProducto) {
                      $nombreProducto = consultaValor($conexion, "SELECT Nombre FROM platos where Id_plato = '$codigoProducto'");
                      $precio = consultaValor($conexion, "SELECT Precio FROM platos where Id_plato = '$codigoProducto'"); //se extrae el nombre del producto en base a la id.
                      echo   "<tr>
                                  <td>".$nombreProducto."</td>
                                  <td>".$cantidadProducto."</td>
                                  <td>".$precio*$cantidadProducto."</td>
                              </tr>";
                  }
                  echo "</tbody></table>";
                  echo "<br>";
                }
            }

                $sumaCompra=0; //variable en la que se irán haciendo las sumas.
                //También tienen que aparecer reflejadas las cantidades. Es decir, del array, tengo que acceder a cada una de las cantidades y hacer la suma por cantidades de cada producto.
                foreach ($carroCompra as $codigoProducto => $cantidadProducto) {
                    $precioProducto = consultaValor($conexion, "SELECT Precio FROM platos where Id_plato = '$codigoProducto'"); //Se devuelve el precio de cada producto
                    $precioConCantidades = $precioProducto * $cantidadProducto; //en cada pasada, se multiplica ese precio por la cantidad introducida.
                    $sumaCompra+=$precioConCantidades; //se va acumulando el precio total en la variable $sumacompra.
                }

                echo "Cantidad total: " . $sumaCompra . "€";

                //Una vez hecho esto, queda: 1) Hacer la compra con el tema de las fechas. 2) Actualizar el stock 3) Todo esto SOLO ES POSIBLE si hay un checkNumber (un cheque en el que cargar la compra);
                //checkNumber con formato AA99999

        }//fin post
        ?>
                <br>
                <label> Ubicación donde enviar el pedido: </label>
                <input type="text" name="ubicacion">
                <br><br>
                <input type="submit" name="comprar" value="Comprobar Pago">
                <br>

        <?php

            if (isset($_POST['comprar'])) { //Si se pulsa el botón de comprar:
              $miObj = new RedsysAPI;
            $ubicacion = test_input($_POST['ubicacion']);
              //pedidos_online
                $numPedido = consultaValor($conexion, "SELECT MAX(Id_pedido) FROM Enviodomicilio");

            	// Valores de entrada que no hemos cmbiado para ningun ejemplo
            	$fuc="999008881";
            	$terminal="1";
            	$moneda="978";
            	$trans="0";
            	$url="";
            	$urlOK="http://localhost/TRABAJO%20FCT/php/pe_altaped.php";
            	$urlOKKO="http://localhost/TRABAJO%20FCT/php/pe_altaped.php";
            	$id=intval($numPedido)+1;
            	$amount=doubleval($sumaCompra*100);

            	// Se Rellenan los campos
            	$miObj->setParameter("DS_MERCHANT_AMOUNT",$amount);
            	$miObj->setParameter("DS_MERCHANT_ORDER",$id);
            	$miObj->setParameter("DS_MERCHANT_MERCHANTCODE",$fuc);
            	$miObj->setParameter("DS_MERCHANT_CURRENCY",$moneda);
            	$miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE",$trans);
            	$miObj->setParameter("DS_MERCHANT_TERMINAL",$terminal);
            	$miObj->setParameter("DS_MERCHANT_MERCHANTURL",$url);
            	$miObj->setParameter("DS_MERCHANT_URLOK",$urlOK);
            	$miObj->setParameter("DS_MERCHANT_URLKO",$urlOKKO);

            	//Datos de configuración
            	$version="HMAC_SHA256_V1";
            	$kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';//Clave recuperada de CANALES
            	// Se generan los parámetros de la petición
            	$request = "";
            	$params = $miObj->createMerchantParameters();
            	$signature = $miObj->createMerchantSignature($kc);




              //-------------------
              $nomnrecli= $_SESSION['Nombre'];
              $telefonocli =  $_SESSION['usuarioContraseña'];
              $saldo = consultaValor($conexion, "SELECT saldo FROM Usuarios where Nombre = '$nomnrecli' AND Telefono = '$telefonocli'");
              echo "Su saldo ha quedaría con: ".(intval($saldo)-intval($sumaCompra))."€";

                          if($saldo>=$sumaCompra){


                          ?>
                          <html lang="es">
                          <head>
                          </head>
                          <body>
                          <form name="frm" action="https://sis-t.redsys.es:25443/sis/realizarPago" method="POST" target="_blank">
                           <input hidden type="text" name="Ds_SignatureVersion" value="<?php echo $version; ?>"/>
                           <input hidden type="text" name="Ds_MerchantParameters" value="<?php echo $params; ?>"/>
                           <input hidden type="text" name="Ds_Signature" value="<?php echo $signature; ?>"/></br>
                          <input type="submit" name="pago" value="Hacer Pago con Tarjeta" >
                          </form>

                          </body>
                          </html>
                          <?php

                          //--------------
                          //Si no se repite, entonces se inicia el proceso que engloba toda la compra. //INSERTAR DATOS Y ACTUALIZAR STOCK Y ACTUALIZAR PAYMENTS.
                            $paymentDate = date('Y-m-d');
                            $preciototal=0;
                            $idusuario = consultaValor($conexion, "SELECT Id_usuario FROM Usuarios where Nombre = '$nomnrecli' AND Telefono = '$telefonocli'");
                            $repartidor = consultaValor($conexion, "SELECT Id_repartidor FROM Repartidor where Disponibilidad = 1");

                            //Se insertan los datos correspondientes en actualizar Payments.
                            insertarPayments($idusuario, $sumaCompra, $conexion);
                            //se actualiza el stock //
                            actualizarStock2($conexion, $carroCompra);
                            //ahora toca actualizar el tema de la orden(pedido). Para eso, hay que crear una nueva orden.
                            $nuevaorden = generarNuevaOrden($conexion); //la función coge el último número y le suma +1. Se parte del 10425.
                          insertarDatosOrders($nuevaorden,$repartidor, $paymentDate,$idusuario,$saldo,$ubicacion,$conexion);
                            //Se insertan: insertarDatosOrders ($orderNumber,$orderDate,$requiredDate,$customerNumber,$base);
                            $sumaCompra=0; //variable en la que se irán haciendo las sumas.
                            //También tienen que aparecer reflejadas las cantidades. Es decir, del array, tengo que acceder a cada una de las cantidades y hacer la suma por cantidades de cada producto.
                            foreach ($carroCompra as $codigoProducto => $cantidadProducto) {
                                $precioProducto = consultaValor($conexion, "SELECT Precio FROM platos where Id_plato = '$codigoProducto'"); //Se devuelve el precio de cada producto
                                $precioConCantidades = $precioProducto * $cantidadProducto; //en cada pasada, se multiplica ese precio por la cantidad introducida.
                                $sumaCompra+=$precioConCantidades; //se va acumulando el precio total en la variable $sumacompra.
                            }

                            $orderLine = 1; //Entiendo que es el número de líneas del carrito de la compra. Si hay tres artículos diferentes, salen tres líneas para un número de orden generado en cada compra.

                            // Ahora incluiremos los datos de la compra en la tabla orderDetails, producto por producto.


                            //Una vez se haga la compra, se debería reiniciar el carrito.
                            $_SESSION['CARROCOMPRA'] = array();
                            $carroCompra = $_SESSION['CARROCOMPRA'];

                          //--------------
                        }//FIN else
                     else{
                        echo "<br>No se puede realizar la compra, no tienes saldo suficiente";
                      }
                      if (isset($_POST["pago"])) { //Si se pulsa pago, se visualiza la tabla.

echo "Compra correcta";
}
            }//FIN IF COMPRAR


        ?>

    <p><a href="pe_inicio.php">Volver al menu de usuario</a></p>
</BODY>
</HTML>
