<?php
  require_once ("funcionesComunes/funcionesComunes.php");
  $conexion = abrirConexion();
  if($_POST){ //Cuando se completan los datos, se viene aquí.
      $usuario= test_input($_POST['usuario']);
      $password= test_input($_POST['password']);
      //Consulta: ¿Hay algún cliente con el usuario y la contraseña introducidas? Si es que sí, entonces entra en el if, si no dice que son incorrectos.
      $query=$conexion->prepare("SELECT Nombre, Telefono FROM Usuarios WHERE Nombre= :usuario AND Telefono = :password");
      $query->bindParam(":usuario", $usuario); //Esto es simplemente una asociación de variables. Hasta que no se ejecuta, no se hace.
      $query->bindParam(":password", $password); //Se asocia el password introducido por el usuario a :password.
      $query->execute();
      $usuarioLogin=$query->fetch(PDO::FETCH_ASSOC); //Crea un array indexado: $usuarioLogin[Nombre] = daría el usuario solicitado en la consulta.

      if ($usuarioLogin){
          session_start();
          $_SESSION['Nombre'] = $usuarioLogin["Nombre"];
          $_SESSION['usuarioContraseña'] = $usuarioLogin["Telefono"];
          header("location:./php/pe_inicio.php"); //La función header() se puede utilizar para redirigir automáticamente a otra página, enviando como argumento la cadena Location:
      }else{
          echo "Usuario o password incorrecto";
      }
  }
 ?>
<html>
<head>
  <meta charset="utf-8">
  <title>Cafetería Santa Marta</title>
  <!-- imagen de la pestaña -->
  <link rel="icon" href="img/icon.jpg">
  <!-- fuentes -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
              <link rel="stylesheet" href="css/pe_login.css">


    </head>
    <body>
      <h1>Cafetería Santa Marta</h1>
    <br>
      <div class="menulateral">
        <a href="index.php">Inicio</a>
      <!-- <a href="#">Reservas</a> -->
      <a href="pe_menudia.php">Menú del día</a>
      <a href="pe_nuestrolocal">Nuestro local</a>
      <a href="#">Contacto</a>
      <a href="#">Dónde estamos</a>
      <!-- <a href="#">Reparto a domicilio</a> -->
    </div>
    <div class="opciones">
        <form action="pe_login.php" method="POST">

            <label>USUARIO: </label>
            <input type="text" name="usuario" required/><br/><br>

            <label>CONTRASEÑA: </label>
            <input type="password" name="password" required/><br/><br>

            <input type="submit" value="LOGIN"/>

        </form>
        </div>
    </body>
</html>
