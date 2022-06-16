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
      <center style="color:white;"><h2>REPARTO A DOMICILIO</h2></center>
      <div class="usuariologin3">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <img src="../img/carrito.png" alt="carrito" class="local"> CARRITO <img src="../img/dinero.png" alt="dinero" class="local">
      <?php
      echo "<center> <table border='2'>";
      echo "<thead> <tr> <th colspan='3'> CARRO DE LA COMPRA </th> </tr> </thead>
      <tbody>
      <tr> <th> Nombre del producto </th> <th> Cantidad </th> </tr>";
      foreach ($carroCompra as $codigoProducto => $cantidadProducto) {
          $nombreProducto = consultaValor($conexion, "SELECT Nombre FROM platos where Id_plato = '$codigoProducto'");
          echo   "<tr>
                      <td>".$nombreProducto."</td>
                      <td>".$cantidadProducto."</td>
                  </tr>";
      }
      echo "</tbody></table></center>";
      echo "<br>";
      $cantidadplatos=0;
      foreach ($_SESSION['CARROCOMPRA'] as $key) {
      $cantidadplatos=$cantidadplatos+$key;
      }
      //calculo dependiendo de la cantidad de productos para saber el precio
      $totalplatos=0;
      $totalplatos=$cantidadplatos/4;
      $preciototal=$totalplatos*15;
      echo "El precio total es de $preciototal €</br>";
       ?>
       <input type="submit" value="Pedir otro menú" name="pedirotromenu">
       <input type="submit" value="Vaciar cesta" name="vaciar">
    </form>
       <?php
            //Ahora hay que establecer las funciones para cada uno de los botones:
            if (isset($_POST['vaciar'])) {//Si se pulsa el botón vaciar. Se vuelve a los orígenes.
                    $carroCompra = array();
                    $_SESSION['CARROCOMPRA'] = $carroCompra;
            } //fin if vaciar
            if (isset($_POST['pedirotromenu'])) {//Si se pulsa el botón vaciar. Se vuelve a los orígenes.
              header("location: ./pe_altapedmenu1.php");
            } //fin if vaciar
    ?>
            <br>
            <label> Ubicación donde enviar el pedido: </label>
            <input type="text" name="ubicacion">
            <br><br>
            <input type="submit" name="comprar" value="Comprobar Pago">
            <br>

    <?php
        if (isset($_POST['comprar'])) {
          echo "stringAAAAAAA";
          //Si se pulsa el botón de comprar:
          $miObj = new RedsysAPI;
          $ubicacion = test_input($_POST['ubicacion']);
          //pedidos_online
          $numPedido = consultaValor($conexion, "SELECT MAX(Id_pedido) FROM Enviodomicilio");
          $fuc="999008881";
          $terminal="1";
          $moneda="978";
          $trans="0";
          $url="";
          $urlOK="http://localhost/FCT/5/5%20sergio/php/pe_altaped.php";
          $urlOKKO="http://localhost/FCT/5/5%20sergio/php/pe_altaped.php";
          $id=1000000000000000000000000+$numPedido;
          $amount=$preciototal;
          $nombrecomercio="Cafeteria Santa Marta";

          // Se Rellenan los campos
          $miObj->setParameter("DS_MERCHANT_AMOUNT",$amount);  //obligatorio
          $miObj->setParameter("DS_MERCHANT_ORDER",$id);  //obligatorio
          $miObj->setParameter("DS_MERCHANT_MERCHANTCODE",$fuc); //obligatorio
          $miObj->setParameter("DS_MERCHANT_CURRENCY",$moneda); //obligatorio
          $miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE",$trans); //obligatorio
          $miObj->setParameter("DS_MERCHANT_TERMINAL",$terminal);  //obligatorio
          $miObj->setParameter("DS_MERCHANT_MERCHANTURL",$url); //opcional
          $miObj->setParameter("DS_MERCHANT_URLOK",$urlOK);  //opcional
          $miObj->setParameter("DS_MERCHANT_URLKO",$urlOKKO); //opcional
          $miObj->setParameter("DS_MERCHANT_MERCHANTNAME",$nombrecomercio); //opcional

          //Datos de configuración
          $version="HMAC_SHA256_V1";
          $kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';//Clave recuperada de CANALES
          // Se generan los parámetros de la petición
          $request = "";
          $params = $miObj->createMerchantParameters();
          $signature = $miObj->createMerchantSignature($kc);

          //-------------------
          $nombrecli= $_SESSION['Nombre'];
          $contracli =  $_SESSION['usuarioContraseña'];
          $saldo = consultaValor($conexion, "SELECT Saldo FROM Usuarios where Nombre = '$nombrecli' AND Contrasena = '$contracli'");
          echo "</br>Su saldo actual es de ".(intval($saldo)-intval($sumaCompra))."€";
          $repartidor = consultaValor($conexion, "SELECT Id_repartidor FROM Repartidor where Disponibilidad = 1");

                      if($saldo>=$sumaCompra){
                      //$repartidor!=''
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
                        $idusuario = consultaValor($conexion, "SELECT Id_usuario FROM Usuarios where Nombre = '$nombrecli' AND Contrasena = '$contracli'");
                        $repartidor = consultaValor($conexion, "SELECT Id_repartidor FROM Repartidor where Disponibilidad = 1");

                        //Se le resta el sueldo al usuario
                        insertarPayments($idusuario, $sumaCompra, $conexion);
                        //Se le resta la cantidad al almacen
                        actualizarStock2($conexion, $carroCompra);

                        $nuevaorden = generarNuevaOrden($conexion); //la función coge el último número y le suma +1. Se parte del 10425.
                        //Se insertan los datos a la tabla envio a domicilio
                        insertarDatosOrders($nuevaorden,$repartidor, $paymentDate,$idusuario,$saldo,$ubicacion,$conexion);

                        //Añadir la linea de pedido a domicilio
                        $idlineaped=generarNuevaOrden2($conexion);
                        foreach ($carroCompra as $codigoProducto => $cantidadProducto) {
                            $nombreProducto = consultaValor($conexion, "SELECT Nombre FROM platos where Id_plato = '$codigoProducto'");
                            $precio = consultaValor($conexion, "SELECT Precio FROM platos where Id_plato = '$codigoProducto'"); //se extrae el nombre del producto en base a la id.
                            insertatpedidodomicilio($idlineaped,$nuevaorden, $codigoProducto, $idusuario,$precio ,$cantidadProducto ,$conexion);
                        }

                        //Seleccionar un repartidor


                        $sumaCompra=0; //variable en la que se irán haciendo las sumas.
                        //También tienen que aparecer reflejadas las cantidades. Es decir, del array, tengo que acceder a cada una de las cantidades y hacer la suma por cantidades de cada producto.
                        foreach ($carroCompra as $codigoProducto => $cantidadProducto) {
                            $precioProducto = consultaValor($conexion, "SELECT Precio FROM platos where Id_plato = '$codigoProducto'"); //Se devuelve el precio de cada producto
                            $precioConCantidades = $precioProducto * $cantidadProducto; //en cada pasada, se multiplica ese precio por la cantidad introducida.
                            $sumaCompra+=$precioConCantidades; //se va acumulando el precio total en la variable $sumacompra.
                        }

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
</div>
</BODY>
</HTML>
