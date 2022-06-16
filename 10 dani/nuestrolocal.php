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
    <title>Local</title>
  </head>
  <link rel="stylesheet" href="css/menu.css">
  <link rel="icon" href="img/cafe.png">
  <!-- esencial para que funcione -->
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <!-- esencial para que funcione -->
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script type='text/javascript' src='js/menu.js'></script>
  <style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Roboto+Condensed:wght@700&display=swap');
  </style>
    <body class="body2">
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
  <center><h2 style="color: white;">MAPA DE DONDE NOS ENCONTRAMOS</h2></center>
  <div style="float:left;width: 790px; height: 600px;margin-left: 150px;padding-left: 30px;padding-top: 20px;margin-right: 20px; padding-bottom: 10px;border-radius: 5px; border: black 5px groove; color:black;
  background-image: url('./img/marmol3.jpg');" class="textoblanco">
    Nuestra cafeteria se encuentra en la calle Jeddah, 29601 en Marbella, Málaga.<br>
    Aunque su entrada está en la calle Galveston, como se muestra en la imagen podemos ver como en la entrada
    tenemos unas preciosas palmeras.
    <iframe src="https://www.google.com/maps/embed?pb=!3m2!1ses!2ses!4v1654846158766!5m2!1ses!2ses!6m8!1m7!1sQUfIi0xy05mo7ceZs7Ipyw!2m2!1d36.5145470653611!2d-4.880906971333172!3f42.6813151949504!4f-17.79950823472302!5f0.7820865974627469"
     width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
<div style="float:left; background-image: url('./img/marmol4.jpg'); padding:15px; border-radius: 5px; border: black 5px groove; color:black; width: 720px; height: 600px;" class="">
  En la misma calle podremos aparacar aunque dependerá del tráfico. <br>
  Parkings cercanos: <br>
  <ol style="list-style-type:lower-greek;list-style-image: url('./img/parkinglogo.png')">
    <li>  Avenida Doctor Maíz Viñals, 25, 29601</li>
    <li>  Plaza Santo Cristo, 9, 29601 </li>
    <li>  Calle Valentuñana, 11, 7, 29601 </li>
    <li>  Calle los Olivos, 3, 29601 </li>
  </ol>
  <img style="height:320px;width:450px;" src="./img/parkings.jpg" alt="parkingscercanos">
</div>
<div style="clear:both;color:white; font-size:50px; text-align:center;"class="">
Te esperamos!</div>
</body>
</html>
