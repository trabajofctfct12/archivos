<?php
  require_once ("../funcionesComunes/funcionesComunes.php");
  $conexion = abrirConexion();

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
    <div class="text">CAFETERÍA SANTA MARTA<img src="../img/cafesinfondo.png" alt="cafe" class="cafe"></div>
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
  <h2 style="text-align:center;">GENERAR NUEVA CONTRASEÑA A USUARIO EXISTENTE</h2>
  <div class="usuariologin4">
  <form action="cambiar_contraseña.php" method="POST">
      <label>Nombre: </label>
      <input type="text" name="Nombre" required/><br/><br>
      <label>Apellidos: </label>
      <input type="text" name="Apellidos" required/><br/><br>
      <label>Codigo postal: </label>
      <input type="text" name="Codigopostal" required/><br/><br>
      <label>Email: </label>
      <input type="text" name="Email" required/><br/><br>
      <label>Nueva contraseña: </label>
      <input type="text" name="Contraseña" required/><br/><br>
      <input class="inputbutton" type="submit" name="crear" value="GENERAR NUEVA CONTRASEÑA"/>
  </form>
  <br>
        <a href="crear_cuenta">Crear cuenta</a>
        <a href="../pe_login.php">Iniciar Sesión</a>
        </div>
</body>
</html>

<?php
if($_POST){
function consultaValor($conexion, $consulta){
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $valor=$resultado->fetchColumn(); //Si no se especifica nada, devuelve la primera columna de la primera fila.
    return $valor;
} // fin consultarValor

//recogida y limpieza de valores introducidos por el usuario.
$Nombre = test_input($_POST['Nombre']);
$Apellidos = test_input($_POST['Apellidos']);
$Codigopostal = test_input($_POST['Codigopostal']);
$Email = test_input($_POST['Email']);
$Contraseña = test_input($_POST['Contraseña']);

//Ahora hay que establecer las funciones para cada uno de los botones:
if (isset($_POST['crear'])) {
$usuario= consultaValor($conexion, "SELECT Nombre FROM Usuarios WHERE Nombre='$Nombre' AND Apellidos='$Apellidos' AND Codigo_postal='$Codigopostal' AND Email='$Email'");
if ($usuario!='') {
$sqlConsulta = "UPDATE Usuarios SET Contrasena='$Contraseña' WHERE Nombre='$Nombre' AND Apellidos='$Apellidos' AND Codigo_postal='$Codigopostal' AND Email='$Email'";
try {
$resultado = $conexion-> prepare($sqlConsulta); // Se prepara.
$resultado->execute(); //Se ejecuta.
echo "<div class='opciones'> Hemos reseteado la contraseña de ".$Nombre. " ". $Apellidos. " a "." <strong>".$Contraseña."</strong></div>";

//echo "Datos insertados en la tabla de pagos  <br>";
}catch(PDOException $e){
echo "Los datos introducidos no coinciden con ningún usuario  <br>", $e-> getMessage();
}
}else {
echo "<div class='opciones'>Los datos introducidos no coincidden con ningún usuario </div>";

}
}
}
?>
