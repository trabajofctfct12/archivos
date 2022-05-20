<?php
function consultaPedidos($conn,$customer_number){
    try {
        $stmt = $conn->prepare("SELECT orders.orderNumber, orderDate, orders.status, orderLineNumber, productName, quantityOrdered, priceEach FROM orders, orderdetails, products
        WHERE orders.orderNumber = orderdetails.orderNumber AND
        orderdetails.productCode = products.productCode
        AND orders.customerNumber='$customer_number'
        ORDER BY orderLineNumber ASC");
        $stmt->execute(); //ejecuta la select
        if ($stmt->rowCount() > 0) {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            echo "<table border=1>";
            echo "<tr><th>orderNumber</th><th>orderDate</th><th>status</th><th>orderLineNumber</th><th>productName</th><th>quantityOrdered</th><th>priceEach</th></tr>";
            foreach($stmt->fetchAll() as $row) {
                echo "<tr>";
                echo "<td>".$row["orderNumber"]."</td><td>".$row["orderDate"]."</td><td>".$row["status"]."</td><td>".$row["orderLineNumber"]."</td><td>".$row["productName"]."</td><td>".$row["quantityOrdered"]."</td><td>".$row["priceEach"]."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else{
            echo "No se encontró ningun pedido.";
        }

    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
