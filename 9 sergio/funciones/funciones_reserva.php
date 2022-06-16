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

function crearreserva($idusuario,$mesa,$telf,$email,$fechatotal,$conexion){

  //SELECT SACANDO EL MAXIMO DE Id_reserva
  $stmt1 = $conexion->prepare("SELECT MAX(Id_reserva) as 'maximareserva' from reservaenlocal");
  $stmt1->execute(); //ejecuta la select
  $stmt1->setFetchMode(PDO::FETCH_ASSOC);
  foreach($stmt1->fetchAll() as $row) {
    $maximareserva=$row['maximareserva'];
 }
 if (is_null($maximareserva)) {
   $maximareserva=1;
 }
 $funciona=0;
 $maximareserva=$maximareserva+1;
  try {
   $stmt3 = $conexion->prepare("INSERT INTO reservaenlocal (Id_usuario,Id_reserva,Id_mesa,Telefono,Email,Fechainicio) VALUES ('$idusuario','$maximareserva','$mesa','$telf','$email','$fechatotal')");
   $stmt3->execute(); //ejecuta la select
   $stmt3->setFetchMode(PDO::FETCH_ASSOC);
   $funciona=1;
   // echo "</br></br>Reserva realizada para ".$fechatotal;
  }catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    $funciona=0;
  }
  return $funciona;
  }



 ?>
