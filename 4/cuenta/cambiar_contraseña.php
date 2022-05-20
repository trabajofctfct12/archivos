<?php
  require_once ("../funcionesComunes/funcionesComunes.php");
  $conexion = abrirConexion(); //Se establece la conexión.

  ?>
<html>
<head>
  <meta charset="utf-8">
  <title>Cafetería Santa Marta</title>
  <!-- imagen de la pestaña -->
  <link rel="icon" href="../img/icon.jpg">
  <!-- fuentes -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
              <link rel="stylesheet" href="../css/pe_login.css">


    </head>
    <body>
      <br>
      <h1>Cafetería Santa Marta</h1>
    <br>
      <div class="menulateral">
        <a href="../index.php">Inicio</a>
      <!-- <a href="#">Reservas</a> -->
      <a href="../pe_menudia.php">Menú del día</a>
      <a href="../pe_nuestrolocal">Nuestro local</a>
      <a href="#">Contacto</a>
      <a href="#">Dónde estamos</a>
      <!-- <a href="#">Reparto a domicilio</a> -->
    </div>
    <div class="opciones">
      <br>      <br>

        <form action="cambiar_contraseña.php" method="POST">

            <label>Nombre: </label>
            <input type="text" name="Nombre" required/><br/><br>
            <label>Apellidos: </label>
            <input type="text" name="Apellidos" required/><br/><br>
            <label>Codigo postal: </label>
            <input type="text" name="Codigopostal" required/><br/><br>
            <label>Email: </label>
            <input type="text" name="Email" required/><br/><br>

            <input type="submit" name="crear" value="Generar nueva contraseña"/>


        </form>
        </div>
            <div class="opciones">
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

    //Ahora hay que establecer las funciones para cada uno de los botones:
    if (isset($_POST['crear'])) {
      $Telefono = consultaValor($conexion, "SELECT Telefono FROM Usuarios WHERE Nombre='$Nombre' AND Apellidos='$Apellidos' AND Codigo_postal='$Codigopostal' AND Email='$Email'");
echo "<div class='opciones'> Hemos reseteado la contraseña de ".$Nombre. " ". $Apellidos. " a tu número de teléfono "." <strong>".$Telefono."</strong></div>";
    }
  }


?>
