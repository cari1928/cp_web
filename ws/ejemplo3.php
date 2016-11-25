<?php
  include('../cp_web.class.php');

  $templates = $web->templateEngine();
  $web = new Servicios;
  $web->conexion();

  $cadenaJSON = '
  [
    {
    "id_servicio": 4,
    "servicio": "Abogado",
    "precio": "15.90"
    },
    {
    "id_servicio": 1,
    "servicio": "Cotabilidad 1",
    "precio": "12.90"
    },
    {
    "id_servicio": 3,
    "servicio": "Brujeria del SAT",
    "precio": "13.90"
    },
    {
    "id_servicio": 5,
    "servicio": "Cotabilidad 2",
    "precio": "10.90"
    },
    {
    "id_servicio": 6,
    "servicio": "Brujeria del SAT 2",
    "precio": "20.90"
    }
  ] 
';

  //Muestra de contenido
  // $combo = $web->showList("select id_servicio, servicio from servicio order by servicio"); 
  // echo $combo;

  $servicios = $web->getAll("select * from servicio order by servicio");

  $servExterno = json_decode($cadenaJSON);
  $newServicio = array();
  echo "<pre>";
  // print_r($servicios);
  // print_r($servExterno);

  foreach ($servExterno as $etiqueta => $servicio) {
    // echo $etiqueta;
    // print_r($servicio);

    $tmp = array('id_servicion'=>$servicio->id_servicio,
                  'servicio'=>$servicio->servicio,
                  'precio'=>$servicio->precio);

    array_push($servicios, $tmp);
  }
  print_r($servicios); //ya se tienen todos los datos

  //hacer el combo estilo select.component ver código de showList para imitarlo pero aplicarlo a este código 
  //mostrar el combo con un echo

?>
