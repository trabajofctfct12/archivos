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
    <title>Preguntas</title>
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
    <body class="body4">
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
  <div style="text-align: center;" class="textoblanco">
    <h2 style="color: white;">PREGUNTAS FRECUENTES</h2><br>
</div>
<center>
  <div class="preguntas">
    <h2>1-PREGUNTAS MÁS FRECUENTES SOBRE NUESTRO CAFÉ</h2>
    <p style="color:white;">¿Qué variedad de café se sirve en Cafetería Santa Marta®?</p>
    En Santa Marta se sirve café de la más alta calidad. La especie arábica supone un 60% de la producción mundial, crece mejor a altitudes elevadas, a partir de los 1200 m. de altitud. En estas altitudes las temperaturas
    son más bajas por la noche y más cálidas por el día lo que ayuda a mejorar el crecimiento del cafeto.
    Por otro lado, la especie arábica tiene un menor rendimiento y son plantas menos resistentes a las enfermedades del café. Por lo general, con este tipo de café conseguimos sabores más refinados y elegantes.<br>
    <p style="color:white;">¿Qué tipos de tostado trabajamos en Santa Marta®?</p>
    Una vez que el café verde llega a una planta de tostado de Santa Marta®, sus características de sabor inherentes no se pueden mejorar, pero se pueden arruinar fácilmente. Cada café requerirá una cantidad de tiempo y
    temperatura ligeramente diferente durante el proceso de tostado para crear una taza de café que está en su máximo punto de aroma, acidez, cuerpo y sabor.
    <br><br>Los tres tipos de tostado que puedes encontrar en cada una de nuestras tiendas son:<br><br>
    - Tostado suave: Los cafés de tostado suave tienen un cuerpo más ligero y un sabor más suave. Aunque los sabores pueden ser más delicados en comparación con los cafés de tostado medio o tostado intenso que siguen siendo
     complejos con matices muy diferentes.
<br>
    - Tostado medio: Los cafés de tostado medio tienen una acidez suave, un cuerpo equilibrado y una gran riqueza en el sabor. Con el tostado se desarrolla más complejidad en el sabor y cafés más balanceados.
<br>
    - Tostado intenso: Nuestros cafés de tostado intenso tienden a presentar un cuerpo más completo y sabores potentes y audaces.

  <h2>  2- PREGUNTAS FRECUENTES SOBRE LA CARTA</h2>
  <p style="color:white;">  Información nutricional de nuestros productos</p>
    Si deseas obtener más información sobre los productos de nuestra tienda, se encuentran todos los contenidos en nuestro apartado de Menú de día además de los alérgenos de cada plato.
<br><br>
    En Cafeteria Santa Marta servimos un amplio abanico de comidas deliciosas, y esta información te ayudará a estar seguro de que lo que elijas respete el estilo de vida que deseas llevar.
<br><br>
    No dejes de avisarnos si necesitas más ayuda. Si tienes dudas o comentarios sobre esta carta, ponte en contacto con nuestro equipo de atención al cliente enviándonos un email a <a href="atencionalcliente@cafeteriasantamarta.es"
     class="enlace1">atencionalcliente@cafeteriasantamarta.es</a>
<br><br>
    El usuario es informado de que, realizando la petición oportuna a la dirección de correo electrónico, acepta el tratamiento de sus datos personales para la gestión de la petición.

  </div>
</center>
  </body>
</html>
