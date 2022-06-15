<?php
//EJERCICIO2
function desplegableProductos ($base){
//  $sqlConsulta = ("SELECT productName, productCode from platos where quantityInStock > 0");
$sqlConsulta = ("SELECT Platos.Nombre, Platos.Id_plato, Platos.precio from Platos, Almacen where Platos.Id_plato=Almacen.Id_plato and Stockplato>0 and Platos.numerodemenu=11");
      try{
        $resultado=$base->prepare($sqlConsulta);
        $resultado->execute();
    }catch(PDOException $e){
        echo "No se ha ejecutado el select <br>",$e->getMessage();
    }
  //Devuelvo los resultados
  return $resultado;
  cerrarConexion($base);
}

function desplegableProductos2 ($base){
//  $sqlConsulta = ("SELECT productName, productCode from platos where quantityInStock > 0");
$sqlConsulta = ("SELECT Platos.Nombre, Platos.Id_plato from Platos, Almacen where Platos.Id_plato=Almacen.Id_plato and Stockplato>0 and Platos.numerodemenu=12");
      try{
        $resultado=$base->prepare($sqlConsulta);
        $resultado->execute();
    }catch(PDOException $e){
        echo "No se ha ejecutado el select <br>",$e->getMessage();
    }
  //Devuelvo los resultados
  return $resultado;
  cerrarConexion($base);
}

function desplegableProductos3 ($base){
//  $sqlConsulta = ("SELECT productName, productCode from platos where quantityInStock > 0");
$sqlConsulta = ("SELECT Platos.Nombre, Platos.Id_plato from Platos, Almacen where Platos.Id_plato=Almacen.Id_plato and Stockplato>0 and Platos.numerodemenu=13");
      try{
        $resultado=$base->prepare($sqlConsulta);
        $resultado->execute();
    }catch(PDOException $e){
        echo "No se ha ejecutado el select <br>",$e->getMessage();
    }
  //Devuelvo los resultados
  return $resultado;
  cerrarConexion($base);
}

function desplegableProductos4 ($base){
//  $sqlConsulta = ("SELECT productName, productCode from platos where quantityInStock > 0");
$sqlConsulta = ("SELECT Platos.Nombre, Platos.Id_plato from Platos, Almacen where Platos.Id_plato=Almacen.Id_plato and Stockplato>0 and Platos.numerodemenu=14");
      try{
        $resultado=$base->prepare($sqlConsulta);
        $resultado->execute();
    }catch(PDOException $e){
        echo "No se ha ejecutado el select <br>",$e->getMessage();
    }
  //Devuelvo los resultados
  return $resultado;
  cerrarConexion($base);
}

function consultaValor($base, $consulta){
        $resultado = $base->prepare($consulta);
        $resultado->execute();
        $valor=$resultado->fetchColumn(); //Si no se especifica nada, devuelve la primera columna de la primera fila.
        return $valor;
} // fin consultarValor

function consultar ($base, $consulta){ //base para cualquier consulta que se reciba por parámetro.
        $resultado = $base->prepare($consulta); //se prepara la consulta
        $resultado->execute(); //se ejecuta
        $registro=$resultado->fetchAll(PDO::FETCH_ASSOC); //se guardan los resultados de la consulta
        return $registro; //se retorna el registro.
    } // fin consultar.

function insertarPayments ($idusuario,$pago, $base) {
	$sqlConsulta = "UPDATE Usuarios SET Saldo= Saldo-$pago WHERE Id_usuario=$idusuario";
	 try {
		$resultado = $base-> prepare($sqlConsulta); // Se prepara.
		$resultado->execute(); //Se ejecuta.
		//echo "Datos insertados en la tabla de pagos  <br>";
	}catch(PDOException $e){
		 echo "No hay saldo suficiente  <br>", $e-> getMessage();
	 }
}//fin insertarPayments

function actualizarStock2 ($base, $carroCompra) { //Lo único que si hay dos almacenas resta el id del producto a los dos, no a uno de ellos.
    //Insercion en la tabla almacena de los registros:
	/*A qué almacen se lo quito? */
foreach ($carroCompra as $idProducto => $cantidad){
	$sqlConsulta = "UPDATE Almacen SET Stockplato = Stockplato - '$cantidad' WHERE Id_plato = '$idProducto'";
	 try {
		$resultado = $base-> prepare($sqlConsulta); // Se prepara.
		$resultado->execute(); //Se ejecuta.
		//echo "Actualización STOCK correcta  <br>";
	}catch(PDOException $e){
		 echo "No se ha podido actualizar el stock de la compra", $e-> getMessage();
	 }
}// fin foreach
}// fin actualizarStock2

function generarNuevaOrden ($base) {
		$sqlConsulta = ("SELECT max(Id_pedido) FROM Enviodomicilio;"); //los números de pedido (orders) van hasta el 10425, de uno en uno, por lo que hay que recuperar el número y añadirle uno.
		$resultado = $base->prepare($sqlConsulta);
        $resultado->execute();
        $valor=$resultado->fetchColumn(); //Si no se especifica nada, devuelve la primera columna de la primera fila. En este caso, un select con un único dato, devuelve la primera vez 10425.
        $valor+=1;
        return $valor;
}//fin generar orden.
function generarNuevaOrden2 ($base) {
		$sqlConsulta = ("SELECT max(Id_lineapedido) FROM Lineapedidodomicilio;"); //los números de pedido (orders) van hasta el 10425, de uno en uno, por lo que hay que recuperar el número y añadirle uno.
		$resultado = $base->prepare($sqlConsulta);
        $resultado->execute();
        $valor=$resultado->fetchColumn(); //Si no se especifica nada, devuelve la primera columna de la primera fila. En este caso, un select con un único dato, devuelve la primera vez 10425.
        $valor+=1;
        return $valor;
}//fin generar orden.

function insertarDatosOrders ($orderNumber,$idrepartidor,$orderDate,$customerNumber,$precio,$ubicacion,$base) {
	$sqlConsulta = "INSERT INTO Enviodomicilio values ('$orderNumber','$idrepartidor','$customerNumber', '$orderDate', '$precio', '$ubicacion')";
	 try {
		$resultado = $base-> prepare($sqlConsulta); // Se prepara.
		$resultado->execute(); //Se ejecuta.
		//echo "Datos insertados en la tabla de pagos  <br>";
	}catch(PDOException $e){
		 echo "No se han podido insertar los pagos en la tabla  <br>", $e-> getMessage();
	 }
}// fin confirmarCompra

function insertatpedidodomicilio ($idlineaped,$idpedido,$idplato,$id_usuario,$precio,$cantidad,$base) {
	$sqlConsulta = "INSERT INTO Lineapedidodomicilio values ('$idlineaped','$idpedido','$idplato','$id_usuario','$precio', '$cantidad')";
	 try {
		$resultado = $base-> prepare($sqlConsulta); // Se prepara.
		$resultado->execute(); //Se ejecuta.
	}catch(PDOException $e){
		 echo "No se han podido insertar los datos del envio a domicilio en la tabla  <br>", $e-> getMessage();
	 }
}// fin confirmarCompra

function cambiarrepartidor ($repartidor,$base) {


	$sqlConsulta = "UPDATE Repartidor SET Disponibilidad=0 WHERE Id_repartidor='$repartidor'";
	 try {
		$resultado = $base-> prepare($sqlConsulta); // Se prepara.
		$resultado->execute(); //Se ejecuta.
		//echo "Datos insertados en la tabla de pagos  <br>";
	}catch(PDOException $e){
		 echo "No se han podido cambiar la disponibilidad del repartidor  <br>", $e-> getMessage();
	 }
}// fin confirmarCompra


?>
