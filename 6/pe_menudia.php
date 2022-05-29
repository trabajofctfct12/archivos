<?php     session_start(); ?>
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
        <a href="pe_login.php">Mi cuenta</a>
      <!-- <a href="#">Reservas</a> -->
      <a href="index.php">Inicio</a>
      <a href="pe_nuestrolocal.php">Nuestro local</a>
      <a href="#">Contacto</a>
      <a href="#">Dónde estamos</a>
      <!-- <a href="#">Reparto a domicilio</a> -->
    </div>
    <div class="opciones">
<?php
$fecha = date('d');

if (intval($fecha)%2==0) {
 echo "par (foto)";
}else {
  echo "impar (foto)";
}

 ?>
        </div>
    </body>
</html>
