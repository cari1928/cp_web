<?php
  include('../cp_web.class.php');

  $templates = $web->templateEngine(); 
  $templates->setTemplateDir("../templates/cliente");
  $web->conexion();
  $web->checarAcceso('Cliente');

  if(!isset($_GET['accion']) ){
    die('no existe accion');
  }
    
  $accion = $_GET['accion'];
  switch ($accion) {
			
    case 'nuevo':
			/*
			$detalle_cotizacion = array();
      $detalle_cotizacion[0]['id_servicio'] = 5;
			$detalle_cotizacion[0]['cantidad'] = 5;
			$detalle_cotizacion[1]['id_servicio'] = 7;
			$detalle_cotizacion[1]['cantidad'] = 7;
			*/
			
			if(isset($_POST['id_servicio'])) {
				$id_servicio = $_POST['id_servicio'];
				$cantidad = $_POST['cantidad'];
				$detalle_cotizacion = $_SESSION['cotizacion'];
								
				if(existeArray($detalle_cotizacion, $id_servicio)) {
				  array_push($detalle_cotizacion, array(
						'id_servicio'=>$id_servicio,
						'cantidad'=>$cantidad
					));
				}				
			}
      
      $_SESSION['cotizacion'] = $detalle_cotizacion;      
			echo "Agregado con éxito";
      break;
      
    default: //imprime cotización
      $cmb_servicios = $web->showList('select id_servicio, servicio from servicio');
			$cotizacion = "";
			
      if(isset($_SESSION['cotizacion'])) {
				$cotizaciones = $_SESSION['cotizacion'];
        $cotizacion = array();
				$cotizacion = acomodaArray($cotizaciones, $web);
      }
			
			$templates->assign('cmb_servicios', $cmb_servicios);
			$templates->assign('cotizacion', $cotizacion);
			$templates->display('cotizacion.html');  
      break;
  }

//--------------------------------------------------------------------------------------
	function acomodaArray($array, $web) {
		$tmp = array();
		for($i = 0; $i< count($array); $i++) {
			$sql = "select servicio from servicio where id_servicio=".$array[$i]['id_servicio'];
			$datos = $web->fetchAll($sql);

			if(isset($datos[0])) {
				$tmp[$i]['id_servicio'] = $datos[0]['servicio'];
				$tmp[$i]['cantidad'] = $array[$i]['cantidad'];
			}
		}
		return $tmp;
	}
//--------------------------------------------------------------------------------------
	function existeArray($array, $elemento) {
		$tmp = array();
		$flag = true; //se va a insertar
		$cont = 0;
		
		while($cont < count($array) && $flag) {
			if($array[$cont]['id_servicio'] == $elemento) {
				$flag = false; //no se va a insertar
			}
			++$cont;
		}
		return $flag;
	}
?>
