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
      header("location:php/pe_inicio.php");
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
          header("location:./php/pe_inicio.php"); //La función header() se puede utilizar para redirigir automáticamente a otra página, enviando como argumento la cadena Location:
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
  <!-- esencial para que funcione -->
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <!-- esencial para que funcione -->
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script type='text/javascript' src='js/menu.js'></script>
  <!-- scripts fotos de la carta -->
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script>
		!window.jQuery && document.write('<script src="js/jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript" src="js/js.js"></script>
	<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
 	<link rel="stylesheet" href="css/estiloimagenes.css" />
  <!-- scripts fotos de la carta -->
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
        <li id="mostrar"><a href="menudeldia/menudeldia1.html">MENÚ DEL DÍA <img src="img/menudeldia.png" alt="menudeldia" class="menudeldia">
        </a></li>
        <li><a href="nuestrolocal.php">NUESTRO LOCAL <img src="img/local1.png" alt="local" class="local"></a></li>
        <li><a href="contacto.php">CONTACTO <img src="img/contacto.png" alt="contacto" class="contacto"></a></li>
        <li><a href="preguntas.php">PREGUNTAS <img src="img/pregunta.png" alt="preguntas frecuentes" class="pregunta"></a></li>
      </ul>
    </nav>
  </div>
  <div style="text-align: center;" class="textoblanco">
    <h2 style="color: white;">CARTA</h2>
</div>
<center>
  <div id="content">
  	<p class="parrafoimagenes">
  		Primeros<br />
  		<a rel="example_group" href="./img/platos/carbonara.jpg" title="Titulo aqui"><img alt="" src="./example/9_s.jpg" /></a>
  		<a rel="example_group" href="./example/10_b.jpg" title=""><img alt="" src="./example/10_s.jpg" /></a>
  		<a rel="example_group" href="./example/11_b.jpg" title=""><img alt="" src="./example/11_s.jpg" /></a>
  		<a rel="example_group" href="./example/9_b.jpg" title="Titulo aqui"><img alt="" src="./example/9_s.jpg" /></a>
  		<a rel="example_group" href="./example/10_b.jpg" title=""><img alt="" src="./example/10_s.jpg" /></a>
  		<a rel="example_group" href="./example/11_b.jpg" title=""><img alt="" src="./example/11_s.jpg" /></a>
  		<a rel="example_group" href="./example/11_b.jpg" title=""><img alt="" src="./example/11_s.jpg" /></a>
  		<a rel="example_group" href="./example/12_b.jpg" title=""><img class="last" alt="" src="./example/12_s.jpg" /></a>
  	</p>
  	<p class="parrafoimagenes">
  		Segundos<br />
  		<a rel="example_group" href="./example/9_b.jpg" title="Titulo aqui"><img alt="" src="./example/9_s.jpg" /></a>
  		<a rel="example_group" href="./example/10_b.jpg" title=""><img alt="" src="./example/10_s.jpg" /></a>
  		<a rel="example_group" href="./example/11_b.jpg" title=""><img alt="" src="./example/11_s.jpg" /></a>
  		<a rel="example_group" href="./example/9_b.jpg" title="Titulo aqui"><img alt="" src="./example/9_s.jpg" /></a>
  		<a rel="example_group" href="./example/10_b.jpg" title=""><img alt="" src="./example/10_s.jpg" /></a>
  		<a rel="example_group" href="./example/11_b.jpg" title=""><img alt="" src="./example/11_s.jpg" /></a>
  		<a rel="example_group" href="./example/11_b.jpg" title=""><img alt="" src="./example/11_s.jpg" /></a>
  		<a rel="example_group" href="./example/12_b.jpg" title=""><img class="last" alt="" src="./example/12_s.jpg" /></a>
  	</p>
  	Postres<br />
  	<a rel="example_group" href="./example/9_b.jpg" title="Titulo aqui"><img alt="" src="./example/9_s.jpg" /></a>
  	<a rel="example_group" href="./example/10_b.jpg" title=""><img alt="" src="./example/10_s.jpg" /></a>
  	<a rel="example_group" href="./example/11_b.jpg" title=""><img alt="" src="./example/11_s.jpg" /></a>
  	<a rel="example_group" href="./example/9_b.jpg" title="Titulo aqui"><img alt="" src="./example/9_s.jpg" /></a>
  	<a rel="example_group" href="./example/10_b.jpg" title=""><img alt="" src="./example/10_s.jpg" /></a>
  	<a rel="example_group" href="./example/11_b.jpg" title=""><img alt="" src="./example/11_s.jpg" /></a>
  	<a rel="example_group" href="./example/11_b.jpg" title=""><img alt="" src="./example/11_s.jpg" /></a>
  	<a rel="example_group" href="./example/12_b.jpg" title=""><img class="last" alt="" src="./example/12_s.jpg" /></a>
  </p>


  </div>


</center>
  </body>
</html>
