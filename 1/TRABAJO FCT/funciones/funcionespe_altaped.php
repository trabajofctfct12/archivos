<?php
//EJERCICIO2
function desplegableProductos ($base){
//  $sqlConsulta = ("SELECT productName, productCode from platos where quantityInStock > 0");
$sqlConsulta = ("SELECT Nombre, Platos.Id_plato from Platos, Almacen where Platos.Id_plato=Almacen.Id_plato and Cantidad>0");

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

function insertarPayments ($customNumber, $checkNumber, $paymentDate, $amount, $base) {
	$sqlConsulta = "INSERT INTO payments values ('$customNumber', '$checkNumber', '$paymentDate', '$amount')";
	 try {
		$resultado = $base-> prepare($sqlConsulta); // Se prepara.
		$resultado->execute(); //Se ejecuta.
		//echo "Datos insertados en la tabla de pagos  <br>";
	}catch(PDOException $e){
		 echo "No se han podido insertar los pagos en la tabla  <br>", $e-> getMessage();
	 }
}//fin insertarPayments

function actualizarStock2 ($base, $carroCompra) { //Lo único que si hay dos almacenas resta el id del producto a los dos, no a uno de ellos.
    //Insercion en la tabla almacena de los registros:
	/*A qué almacen se lo quito? */
foreach ($carroCompra as $idProducto => $cantidad){
	$sqlConsulta = "UPDATE products SET quantityInStock = quantityInStock - '$cantidad' WHERE productCode = '$idProducto'";
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
		$sqlConsulta = ("SELECT max(orderNumber) FROM orders"); //los números de pedido (orders) van hasta el 10425, de uno en uno, por lo que hay que recuperar el número y añadirle uno.
		$resultado = $base->prepare($sqlConsulta);
        $resultado->execute();
        $valor=$resultado->fetchColumn(); //Si no se especifica nada, devuelve la primera columna de la primera fila. En este caso, un select con un único dato, devuelve la primera vez 10425.
        $valor+=1;
        return $valor;
}//fin generar orden.

function insertarDatosOrders ($orderNumber,$orderDate,$requiredDate,$customerNumber,$base) {
	$sqlConsulta = "INSERT INTO orders values ('$orderNumber', '$orderDate', '$requiredDate', null, 'Shipped', null, '$customerNumber')";
	 try {
		$resultado = $base-> prepare($sqlConsulta); // Se prepara.
		$resultado->execute(); //Se ejecuta.
		//echo "Datos insertados en la tabla de pagos  <br>";
	}catch(PDOException $e){
		 echo "No se han podido insertar los pagos en la tabla  <br>", $e-> getMessage();
	 }
}// fin confirmarCompra


?>
