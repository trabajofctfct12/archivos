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

        <form action="crear_cuenta.php" method="POST">

            <label>Nombre: </label>
            <input type="text" name="Nombre" required/><br/><br>

            <label>Apellidos: </label>
            <input type="text" name="Apellidos" required/><br/><br>
            <label>Ciudad: </label>
            <input type="text" name="Ciudad" required/><br/><br>
            <label>Pais: </label>
            <input type="text" name="Pais" required/><br/><br>
            <label>Codigo postal: </label>
            <input type="text" name="Codigopostal" required/><br/><br>
            <label>Telefono: </label>
            <input type="text" name="Telefono" required/><br/><br>
            <label>Email: </label>
            <input type="text" name="Email" required/><br/><br>
            <label>Saldo: </label>
            <input type="text" name="Saldo" required/><br/><br>

            <input type="submit" name="crear" value="Crear usuario"/>


        </form>
        </div>
            <div class="opciones">
                          <a href="../pe_login.php">Iniciar Sesión</a>
                                      <a href="cambiar_contraseña">Cambiar contraseña</a>
            </div>
    </body>
</html>

<?php
if($_POST){

    //recogida y limpieza de valores introducidos por el usuario.
    $Nombre = test_input($_POST['Nombre']);
    $Apellidos = test_input($_POST['Apellidos']);
    $Ciudad = test_input($_POST['Ciudad']);
    $Pais = test_input($_POST['Pais']);
    $Codigopostal = test_input($_POST['Codigopostal']);
    $Telefono = test_input($_POST['Telefono']);
    $Email = test_input($_POST['Email']);
    $Saldo = test_input($_POST['Saldo']);

    //Ahora hay que establecer las funciones para cada uno de los botones:
    if (isset($_POST['crear'])) {
      $sqlConsulta = "INSERT INTO Usuarios (`Tipo_usuario`,`Nombre`, `Apellidos`, `Ciudad`, `Pais`, `Codigo_postal`, `Telefono`, `Email`, `Saldo`) VALUES ('Cliente', '$Nombre', '$Apellidos', '$Ciudad', '$Pais', '$Codigopostal', '$Telefono', '$Email', '$Saldo')";
    	 try {
    		$resultado = $conexion-> prepare($sqlConsulta); // Se prepara.
    		$resultado->execute(); //Se ejecuta.
    		//echo "Datos insertados en la tabla de pagos  <br>";
    	}catch(PDOException $e){
    		 echo "No hay saldo suficiente  <br>", $e-> getMessage();
    	 }

    }
  }


?>
