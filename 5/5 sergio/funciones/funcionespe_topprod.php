<?php
  function ComprobarVentas($cliente,$inicio,$fin,$conn) {//Le pasamos una fecha de inicio y de fin y consultamos que cantidad de cada producto se ha vendido entre esas dos fechas
    try {
      $con = 0;
      $ventas = array();

      $stmt = $conn->prepare("SELECT products.productName,orderdetails.quantityOrdered FROM products,orderdetails,orders
        WHERE products.productCode = orderdetails.productCode AND orders.orderNumber = orderdetails.orderNumber
        AND orders.customerNumber = '$cliente' AND orders.status = 'shipped' AND orders.orderDate >= '$inicio'  AND orders.orderDate <= '$fin'");
      $stmt->execute();

      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);//Guardo los resultados
        foreach($stmt->fetchAll() as $row) {
          $ventas[$con] = $row["productName"];
          $con++;
          $ventas[$con] = $row["quantityOrdered"];
          $con++;
       }
       return $ventas;
    }
    catch(PDOException $e) {
        echo "Error: ".$e->getMessage();
    }
  }
 ?>
