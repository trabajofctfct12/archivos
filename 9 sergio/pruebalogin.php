<?php
    session_start();
    require_once ("funcionesComunes/funcionesComunes.php");
    $conexion = abrirConexion(); //Se establece la conexión.
    //1.- Se mira si hay o no una sesión abierta.
    if (!isset($_SESSION["Nombre"])) {//Si no hay sesión iniciada no nos permite acceder la programa y nos saca un mensaje de error
      //Cerrar sesion
      session_unset();
      session_destroy();

    } else {
      header("location:php/inicio.php");

    }

  if($_POST){ //Cuando se completan los datos, se viene aquí.
      $usuario= test_input($_POST['usuario']);
      $password= test_input($_POST['password']);
      //Consulta: ¿Hay algún cliente con el usuario y la contraseña introducidas? Si es que sí, entonces entra en el if, si no dice que son incorrectos.
      $query=$conexion->prepare("SELECT Nombre, Contrasena FROM Usuarios WHERE Nombre= :usuario AND Contrasena = :password");
      $query->bindParam(":usuario", $usuario); //Esto es simplemente una asociación de variables. Hasta que no se ejecuta, no se hace.
      $query->bindParam(":password", $password); //Se asocia el password introducido por el usuario a :password.
      $query->execute();
      $usuarioLogin=$query->fetch(PDO::FETCH_ASSOC); //Crea un array indexado: $usuarioLogin[Nombre] = daría el usuario solicitado en la consulta.

      if ($usuarioLogin){
          session_start();
          $_SESSION['Nombre'] = $usuarioLogin["Nombre"];
          $_SESSION['usuarioContraseña'] = $usuarioLogin["Contrasena"];
          header("location:./php/inicio.php"); //La función header() se puede utilizar para redirigir automáticamente a otra página, enviando como argumento la cadena Location:
      }else{
        ?>
        <script type="text/javascript">
          alert("Usuario o password incorrecto");
        </script>

          <?php
      }
  }
 ?>


 <!DOCTYPE html>
 <html lang="es" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Cafetería</title>
    </head>
    <link rel="stylesheet" href="css/menu.css">
    <link rel="icon" href="img/cafe.png">
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script type='text/javascript' src='js/menu.js'></script>
    <script type='text/javascript' src='js/botonlogin.js'></script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Roboto+Condensed:wght@700&display=swap');
    </style>

    <body class="body2">
      <!-- no se expande -->
    <div class="text">CAFETERÍA SANTA MARTA<img src="img/cafesinfondo.png" alt="cafe" class="cafe"></div>
  <div class="menu-tab">
    <div id="one"></div>
    <div id="two"></div>
    <div id="three"></div>
  </div>
  <div class="menu-hide">
    <nav>
      <ul>
        <li><a href="pe_login.php">MI CUENTA <img src="img/cuenta.png" alt="micuenta" class="micuenta"></a></li>
        <li id="mostrar"><a href="menudeldia/menudeldia1.php">MENÚ DEL DÍA <img src="img/menudeldia.png" alt="menudeldia" class="menudeldia">
        </a></li>
        <li><a href="carta.php">CARTA <img src="img/carta.png" alt="carta" class="carta"></a></li>
        <li><a href="nuestrolocal.php">NUESTRO LOCAL <img src="img/local1.png" alt="local" class="local"></a></li>
        <li><a href="contacto.php">CONTACTO <img src="img/contacto.png" alt="contacto" class="contacto"></a></li>
        <li><a href="preguntas.php">PREGUNTAS <img src="img/pregunta.png" alt="preguntas frecuentes" class="pregunta"></a></li>
        <li>
        <a target="_blank" href="https://www.instagram.com/cafeteriasantamarta/">INSTAGRAM<img src="img/instagram.png" alt="instagram" class="instagram"></a>
        </li>
      </ul>
    </nav>
  </div>
  <div class="usuariologin">
    <form action="pe_login.php" method="POST">

        <label>USUARIO: </label>
        <input type="text" name="usuario" required/><br/><br>

        <label>CONTRASEÑA: </label>
        <input type="password" name="password" required/><br/><br>

        <input type="submit" value="LOGIN"/>


    </form>
    </div>
        <div class="opciones">
                      <a href="cuenta/crear_cuenta.php">Crear cuenta</a>
                                  <a href="cuenta/cambiar_contraseña">Cambiar contraseña</a>
        </div>
  </body>
</html>
