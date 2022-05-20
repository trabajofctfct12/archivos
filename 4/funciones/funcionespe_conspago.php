<?php
  function verPagos($cliente,$inicio,$fin,$conn) {//Le pasamos una fecha de inicio y de fin y vemos cuantos veces ha realizado pagos entre las mismas
    try {
      $con = 0;
      $pagos = array();

      $stmt = $conn->prepare("SELECT count(checkNumber) as numeroPagos, sum(amount) as totalPagos FROM payments
                              WHERE customerNumber = '$cliente' AND paymentDate >= '$inicio'  AND paymentDate <= '$fin'");
      $stmt->execute();

      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);//Guardo los resultados
        foreach($stmt->fetchAll() as $row) {
          $pagos[$con] = $row["numeroPagos"];
          $con++;
          $pagos[$con] = $row["totalPagos"];
       }
       return $pagos;
    }
    catch(PDOException $e) {
        echo "Error: ".$e->getMessage();
    }
  }

  function verHistoricoPagos($cliente,$conn) {//Consultamos todos los pagos que ha hecho un cliente y devolvemos un array con los resultados
    try {
      $con = 0;
      $pagos = array();

      $stmt = $conn->prepare("SELECT checkNumber,paymentDate,amount FROM payments WHERE customerNumber = '$cliente'");
      $stmt->execute();

      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);//Guardo los resultados
        foreach($stmt->fetchAll() as $row) {
          $pagos[$con] = $row["checkNumber"];
          $con++;
          $pagos[$con] = $row["paymentDate"];
          $con++;
          $pagos[$con] = $row["amount"];
          $con++;
       }
       return $pagos;
    }
    catch(PDOException $e) {
        echo "Error: ".$e->getMessage();
    }
  }
 ?>
