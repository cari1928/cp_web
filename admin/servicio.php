<?php
  include('../cp_web.class.php');

  $templates = $web->templateEngine();
  $templates->setTemplateDir("../templates/admin");
  $web = new Servicios;
  $web->conexion();
  $web->checarAcceso('Contador');

  //Operaciones SQL
  $accion = null;
  $id_servicio = null;
  if(isset($_GET['accion']) ){
    $accion = $_GET['accion'];
    if(isset($_GET['id_servicio']))
        $id_servicio = $_GET['id_servicio'];

    switch ($accion) {
      case 'alta': //insertar nuevo servicio
          $web->setTabla("servicio");
          $web->insert($_POST);
        break;

      case 'nuevo': //mostrar
        //$combo = $web->showList("select * from servicio"); //para hacer combos T-T
        //$combo_estados = $web->showList("select * from estado");
        //$templates->assign('combo', $combo);  //esto es hermoso T-T
        //$templates->assign('combo_estados', $combo_estados);
        $templates->display('servicio_form.html');
        die();
        break;

      case 'ver':
        break;

      case 'editar':
        $servicio = $web->getservicio($id_servicio);
        //$combo = $web->showList("select * from servicio", $servicio[0]['id_servicio']); //para hacer combos T-T
        //$combo_estados = $web->showList("select * from estado");
        $templates->assign('id_servicio', $id_servicio);
        $templates->assign('servicio', $servicio[0]);
        //$templates->assign('combo', $combo);  //esto es hermoso T-T
        //$templates->assign('combo_estados', $combo_estados);
        $templates->display('servicio_form.html');
        die();
        break;

      case 'guardar':
          $web->setTabla("servicio");
          $web->update($_POST, $_POST['id_servicio'],array('id_servicio'=>$_POST['id_servicio']));
        break;

      case 'eliminar':
          $web->deleteservicio($id_servicio);
        break;
    }
  }

  //Muestra de contenido
  $servicios = $web->getAll("select * from servicio");
  $templates->assign('titulo', 'servicios');
  $templates->assign('servicios', $servicios);
  $templates->display('servicio.html');
?>
