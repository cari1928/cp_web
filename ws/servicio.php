<?php
  include('../cp_web.class.php');

  $templates = $web->templateEngine();
  $web = new Servicios;
  $web->conexion();

  //Muestra de contenido
  $servicios = $web->getAll("select * from servicio order by servicio");
  // print_r($servicios);

  $servicios = json_encode($servicios, JSON_PRETTY_PRINT);
  header("Content-Type: application/json");
  echo $servicios;

?>
