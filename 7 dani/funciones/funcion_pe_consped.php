<?php
function consultaPedidos1($conn,$nombre,$contra){
    try {
     $stmt = $conn->prepare("SELECT Platos.Nombre,LineaPedidolocal.Precio, LineaPedidolocal.Cantidad
       from LineaPedidolocal,Usuarios,Platos
       where Usuarios.Id_usuario=LineaPedidolocal.Id_usuario
       and LineaPedidolocal.Id_plato = Platos.Id_plato
       and Usuarios.Nombre='$nombre'
       and Usuarios.Contrasena='$contra'");

        $stmt->execute(); //ejecuta la select
        if ($stmt->rowCount() > 0) {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            echo "<table border=1>";
            echo "<tr><th>Plato</th><th> Precio </th><th> Cantidad </th><th> Cantidad total </th></tr>";
            foreach($stmt->fetchAll() as $row) {
                echo "<tr>";
                echo "<td>".$row["Nombre"]."</td><td>".$row["Cantidad"]."€</td><td>".$row["Precio"]."</td><td>".$row["Precio"]*$row["Cantidad"]."€</td>";
                echo "</tr>";
            }
            echo "</table>";
        }else{
            echo "No se encontró ningun pedido en el local.";
        }

    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
function consultaPedidos2($conn,$nombre,$contra){
    try {
     $stmt = $conn->prepare("SELECT Platos.Nombre,LineaReservaenlocal.Precio, LineaReservaenlocal.Cantidad
       from LineaReservaenlocal,Usuarios,Platos
       where Usuarios.Id_usuario=LineaReservaenlocal.Id_usuario
       and LineaReservaenlocal.Id_plato = Platos.Id_plato
       and Usuarios.Nombre='$nombre'
       and Usuarios.Contrasena='$contra'");

        $stmt->execute(); //ejecuta la select
        if ($stmt->rowCount() > 0) {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            echo "<table border=1>";
            echo "<tr><th>Plato</th><th> Precio </th><th> Cantidad </th><th> Cantidad total </th></tr>";
            foreach($stmt->fetchAll() as $row) {
                echo "<tr>";
                echo "<td>".$row["Nombre"]."</td><td>".$row["Precio"]."€</td><td>".$row["Cantidad"]."</td><td>".$row["Precio"]*$row["Cantidad"]."€</td>";
                echo "</tr>";
            }
            echo "</table>";
        }else{
            echo "No se encontró ningun pedido al reservar en el local.";
        }

    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
function consultaPedidos3($conn,$nombre,$contra){
    try {
     $stmt = $conn->prepare("SELECT Platos.Nombre,Lineapedidodomicilio.Precio, Lineapedidodomicilio.Cantidad
       from lineapedidodomicilio,Usuarios,Platos
       where Usuarios.Id_usuario=Lineapedidodomicilio.Id_usuario
       and Lineapedidodomicilio.Id_plato = Platos.Id_plato
       and Usuarios.Nombre='$nombre'
       and Usuarios.Contrasena='$contra'");

        $stmt->execute(); //ejecuta la select
        if ($stmt->rowCount() > 0) {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            echo "<table border=1>";
            echo "<tr><th>Plato</th><th> Precio </th><th> Cantidad </th><th> Cantidad total </th></tr>";
            foreach($stmt->fetchAll() as $row) {
                echo "<tr>";
                echo "<td>".$row["Nombre"]."</td><td>".$row["Precio"]."€</td><td>".$row["Cantidad"]."</td><td>".$row["Precio"]*$row["Cantidad"]."€</td>";
                echo "</tr>";
            }
            echo "</table>";
        }else{
            echo "No se encontró ningun pedido a domicilio.";
        }

    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
