<?php
  include('../cp_web.class.php');

  $templates = $web->templateEngine(); 
  $templates->setTemplateDir("../templates/cliente");
  //$web = new Cotizacion();
  $web->conexion();
  $web->checarAcceso('Cliente');

  if(!isset($_GET['accion']) ){
    die('no existe accion');
  }

 
    
  $accion = $_GET['accion'];
  switch ($accion) {
    case 'nuevo':
      $detalle_cotizacion = $_SESSION['cotizacion'];
          
      if(isset($_POST['id_servicio'])) {
        $id_servicio = $_POST['id_servicio'];
        $cantidad = $_POST['cantidad'];

        //inserta pero si ya existe no insertar

        $tmp = $_SESSION['cotizacion'];
        print_r($tmp);
        
        $flag = true;
        for($i=0; $i< count($tmp); $i++) {
          if($tmp[$i]['id_servicio'] == $id_servicio) {
            //no se inserta
            $flag = false;
            break;
          } else {
            $flag = true;
          }
        }
        
        if($flag) { //se inserta
          $detalle_cotizacion = $tmp;
          $detalle_cotizacion = array_push($detalle_cotizacion, array('id_servicio'=>$id_servicio, 'cantidad'=>$cantidad));
        }
        
        //die(print_r($detalle_cotizacion));
      }        
      
      $_SESSION['cotizacion'] = $detalle_cotizacion;  
      print_r($_SESSION['cotizacion']);
      
      break;
      
    default: //imprime cotización
      $cmb_servicios = $web->showList('select id_servicio, servicio from servicio');
      
      $tmp = array();
      $cotizaciones = $_SESSION['cotizacion'];
      if(isset($_SESSION['cotizacion'])) {
        echo "existe";
        for($i = 0; $i< count($_SESSION['cotizacion']); $i++) {
          $sql = "select servicio from servicio where id_servicio=".$cotizaciones[$i]['id_servicio'];
          $datos = $web->fetchAll($sql);
          print_r($datos);
          
          if(isset($datos[0])) {
            $tmp[$i]['id_servicio'] = $datos[0]['servicio'];
            $tmp[$i]['cantidad'] = $cotizaciones[$i]['cantidad'];
          }
        }
        
        print_r($tmp);
        $templates->assign('cmb_servicios', $cmb_servicios);
        $templates->assign('cotizacion', $tmp);
        $templates->display('cotizacion.html');  
      }
      break;

  }
?>
