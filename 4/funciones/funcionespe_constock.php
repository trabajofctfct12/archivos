<?php
function revisarParametros($producto){
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $producto = test_input($_POST["producto"]);

  }
}

function mostrarStockLine($producto,$conn){
  echo "</br>";
  try {
    $cont=0;
    $arrayNombreStock=array();
    $stmt = $conn->prepare("SELECT productName,quantityInStock FROM products WHERE productLine='$producto' ORDER BY quantityInStock DESC");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach($stmt->fetchAll() as $row) {

      $arrayNombreStock[$cont]=$row["productName"];
      $cont++;
      $arrayNombreStock[$cont]=$row["quantityInStock"];
      $cont++;
    }
  }
  catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  return $arrayNombreStock;
}



?>
