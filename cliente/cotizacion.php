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
			
		case 'terminar':
			if(isset($_SESSION['cotizacion'])) {
				$cotizaciones = $_SESSION['cotizacion'];					
				//$id_cliente = $_POST['id_cliente']; //se debe validar el valor seleccionado del combo, futuro
				$id_cliente = 1;
				
				/*
				$sql = "insert into cotizacion(id_cliente, fecha) 
				values(".$id_cliente.", now())";
				$web->conn->Exec($sql);
				*/
				
				/*
				$sql = "insert into cotizacion(id_cliente, fecha) values(:id_cliente, :fecha)";
				$fecha = date('Y-m-j');
				$stmt = $web->conn->prepare($sql);
				$stmt->bindParam(':id_cliente', $id_cliente);
				$stmt->bindParam(':fecha', $fecha);
				*/
				
				$fecha = date('Y-m-j');
				$stmt = $web->conn->prepare("INSERT INTO cotizacion (id_cliente, fecha) VALUES(?,?)"); 
 
				$web->conn->beginTransaction(); 
				$stmt->execute(array($id_cliente, $fecha)); 
				$web->conn->commit(); 
				//var_dump($web->conn->lastInsertId());
				
				$sql = "select * from cotizacion where id_cliente=".$id_cliente." 
					order by id_cotizacion DESC";
				$datos = $web->fetchAll($sql);
				//var_dump($datos);
				
				$id_cotizacion = $datos[0]['id_cotizacion'];
				$web->conn->beginTransaction(); 
				for($i=0; $i < count($cotizaciones); $i++) {
					$id_servicio = $cotizaciones[$i]['id_servicio'];
					$cantidad = $cotizaciones[$i]['cantidad'];
					
					$sql = "insert into cotizacion_detalle
						values(".$id_cotizacion.", ".$id_servicio.",".$cantidad.")";
					$web->conn->Exec($sql);	
				
				}
				$web->conn->commit(); 
				unset($_SESSION['cotizacion']);
				header("Location: index.php");
      }
			
			//insertar en cotizacion
			//obtener id_cliente
			//obtener id_cotizacion
			//insertar en cotizacion_detalle, son varios		
			
			break;
      
    default: //imprime cotización
      $cmb_servicios = $web->showList('select id_servicio, servicio from servicio');
			$cotizacion = "";
			
			$sql = "select id_cliente, razon_social from cliente where id_usuario='".$_SESSION['id_usuario']."'";
			$cmb_clientes=$web->showList($sql);
			
      if(isset($_SESSION['cotizacion'])) {
				$cotizaciones = $_SESSION['cotizacion'];
        $cotizacion = array();
				$cotizacion = acomodaArray($cotizaciones, $web);	
				$templates->assign('cotizacion', $cotizacion);
      }
			
			$templates->assign('cmb_servicios', $cmb_servicios);
			$templates->assign('cmb_clientes', $cmb_clientes);
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
