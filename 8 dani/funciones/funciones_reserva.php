<?php
function sacaridusuario($usuario,$conexion){
  try {
   $stmt = $conexion->prepare("SELECT Id_Usuario from usuarios where Nombre='$usuario'");
   $stmt->execute(); //ejecuta la select
   $stmt->setFetchMode(PDO::FETCH_ASSOC);
   foreach($stmt->fetchAll() as $row) {
     $idusario=$row['Id_Usuario'];
  }
}catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
  return $idusario;
}

function crearreserva($idusuario,$mesa,$telf,$email,$fechaentera,$conexion){

//SELECT SACANDO EL MAXIMO DE Id_reserva
//COMPROBAR SI ESTE USUARIO TIENE RESERVAS YA EN ESAS HORAS
  try {
   $stmt = $conexion->prepare("INSERT INTO Reservaenlocal (Id_usuario,Id_reserva,Id_mesa,Telefono,Email,Fechainicio,Fechafin) VALUES (Id_usuario,Id_reserva,Id_mesa,Telefono,Email,Fechainicio,Fechafin)");
   $stmt->execute(); //ejecuta la select
   $stmt->setFetchMode(PDO::FETCH_ASSOC);
   foreach($stmt->fetchAll() as $row) {
     $idusario=$row['Id_Usuario'];
  }
  }catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  return $idusario;
  }

}

 ?>
