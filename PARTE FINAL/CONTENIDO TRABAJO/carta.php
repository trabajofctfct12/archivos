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
    <title>Carta</title>
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
    <h2 style="color: white;">CARTA</h2>
</div>
<center>
  <div id="content">
  	<p class="parrafoimagenes">
  		PLATOS PRINCIPALES <br>
  		<a rel="example_group" href="./img/platos/carbonara.jpg" title="Espaguetis a la carbonara - 8.47€ "><img alt="" src="./img/platos/carbonara2.jpg" /></a>
      <a rel="example_group" href="./img/platos/berenjenas.jpg" title="Berenjenas rellenas - 9.68€"><img alt="" src="./img/platos/berenjenas2.jpg" /></a>
      <a rel="example_group" href="./img/platos/bocadillolomo.jpeg" title="Bocadillo de lomo con patatas - 9.68€"><img alt="" src="./img/platos/bocadillolomo2.jpeg" /></a>
      <a rel="example_group" href="./img/platos/calamares.jpg" title="Calamares a la romana - 18.15€"><img alt="" src="./img/platos/calamares2.jpg" /></a>
      <a rel="example_group" href="./img/platos/canelones.jpg" title="Canelones con tomate - 10.89€"><img alt="" src="./img/platos/canelones2.jpg" /></a>
      <a rel="example_group" href="./img/platos/chuletas-de-cordero-al-horno.jpg" title=" Chuletas de cordero - 14.52€"><img alt="" src="./img/platos/chuletas-de-cordero-al-horno2.jpg" /></a>
      <a rel="example_group" href="./img/platos/costillasbarbacoa.jpg" title="Costillas a la barbacoa - 18.15€"><img alt="" src="./img/platos/costillasbarbacoa2.jpg" /></a>
  </p>
  <p class="parrafoimagenes">
      <a rel="example_group" href="./img/platos/tortilla.jpg" title="Tortilla de patatas española - 12.1€ "><img alt="" src="./img/platos/tortilla2.jpg" /></a>
      <a rel="example_group" href="./img/platos/verdurasplancha.jpg" title="Verduras a la plancha - 7.26€ "><img alt="" src="./img/platos/verdurasplancha2.jpg" /></a>
      <a rel="example_group" href="./img/platos/croquetas.jpg" title="Croquetas de jamón - 12.1€ "><img alt="" src="./img/platos/croquetas2.jpg" /></a>
      <a rel="example_group" href="./img/platos/ensaladaprimavera.jpg" title="Ensalada de Primavera - 6.05€ "><img alt="" src="./img/platos/ensaladaprimavera2.jpg" /></a>
      <a rel="example_group" href="./img/platos/ensaladillarusa.jpg" title="Ensaladilla rusa - 7.26€ "><img alt="" src="./img/platos/ensaladillarusa2.jpg" /></a>
      <a rel="example_group" href="./img/platos/entrecot.jpg" title="Entrecot con patatas - 18.15€ "><img alt="" src="./img/platos/entrecot2.jpg" /></a>
      <a rel="example_group" href="./img/platos/escalopes.jpg" title="Escalope de pollo - 9.68€ "><img alt="" src="./img/platos/escalopes2.jpg" /></a>
      </p>
      <p class="parrafoimagenes">
      <a rel="example_group" href="./img/platos/fetucchini.jpg" title="Fetucchini al pesto - 9.68€ "><img alt="" src="./img/platos/fetucchini2.jpg" /></a>
      <a rel="example_group" href="./img/platos/sandwichvegano.jpg" title="Sandwich vegano - 7.26€ "><img alt="" src="./img/platos/sandwichvegano2.jpg" /></a>
    <a rel="example_group" href="./img/platos/friturapescado.jpg" title="Fritura de pescado - 18.15€ "><img alt="" src="./img/platos/friturapescado2.jpg" /></a>
    <a rel="example_group" href="./img/platos/gnocchi.jpg" title="Gnocchi a la Sorrentina - 18.15€ "><img alt="" src="./img/platos/gnocchi2.jpg" /></a>
    <a rel="example_group" href="./img/platos/lasañavegetariana.jpg" title="Lasaña Vegetariana - 12.1€ "><img alt="" src="./img/platos/lasañavegetariana2.jpg" /></a>
    <a rel="example_group" href="./img/platos/mixto.jpg" title="Sandwich mixto - 6.05€ "><img alt="" src="./img/platos/mixto2.jpg" /></a>
    <a rel="example_group" href="./img/platos/pizzacalabresa.jpg" title="Pizza Calabresa - 14.52€ "><img alt="" src="./img/platos/pizzacalabresa2.jpg" /></a>
      </p>
    <!-- <a rel="example_group" href="./img/platos/pizzaprosciutto.jpg" title="Pizza Prosciutto - 13.31€ "><img alt="" src="./img/platos/pizzaprosciutto2.jpg" /></a>
    <a rel="example_group" href="./img/platos/salmorejo.jpg" title="Salmorejo - 13.31€ "><img alt="" src="./img/platos/salmorejo2.jpg" /></a> -->
  </p>

  POSTRES<br />
  <!-- <a rel="example_group" href="./img/platos/cafes.jpeg" title=" Café solo, con leche, cortado, americano ... desde 4€ "><img alt="" src="./img/platos/cafes2.jpeg" /></a> -->
  <a rel="example_group" href="./img/platos/chocolate.jpg" title="Helado de chocolate - 4.84€"><img alt="" src="./img/platos/chocolate2.jpg" /></a>
  <a rel="example_group" href="./img/platos/flandehuevo.jpg" title="Flan de huevo - 4.84€ "><img alt="" src="./img/platos/flandehuevo2.jpg" /></a>
  <a rel="example_group" href="./img/platos/fresa.jpg" title="Helado de fresa - 4.84€ "><img alt="" src="./img/platos/fresa2.jpg" /></a>
  <a rel="example_group" href="./img/platos/natillas.jpg" title="Natillas - 4.84€ "><img alt="" src="./img/platos/natillas2.jpg" /></a>
  <a rel="example_group" href="./img/platos/tartadequeso.jpg" title="Tarta de queso - 10.89€ "><img alt="" src="./img/platos/tartadequeso2.jpg" /></a>
  <a rel="example_group" href="./img/platos/tiramisu.jpg" title="Tarta de Tiramisú - 8.47€ "><img alt="" src="./img/platos/tiramisu2.jpg" /></a>
  <a rel="example_group" href="./img/platos/vainilla.jpg" title="Tarrina vainilla - 4.84€ "><img alt="" src="./img/platos/vainilla2.jpg" /></a>
</p>

  </div>


</center>
  </body>
</html>
