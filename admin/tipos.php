<?php
  include('../cp_web.class.php');

  $templates = $web->templateEngine(); // 2016-09-27_SMARTY_INICIOS
  $templates->setTemplateDir("../templates/admin");
  $web = new Tipos;
  $web->conexion();
  $web->checarAcceso();

  //Operaciones SQL
  $accion = null; //2016-09-29
  $id_tipo = null; //2016-09-29

  if(isset($_GET['accion']) ){ //2016-09-29
    //Validar que id_tipo sea numérico
    $accion = $_GET['accion'];
    if(isset($_GET['id_tipo']))
        $id_tipo = $_GET['id_tipo'];

    switch ($accion) {
      case 'alta': //insertar nuevo tipo
          $web->setTabla("tipo"); //2016-10-11
          $web->insert($_POST); //2016-10-11
        break;

      case 'nuevo': //mostrar
        $templates->display('tipos_form.html');
        break;

      case 'ver':
        break;

      case 'editar': //2016-10-04
        $tipo = $web->getTipo($id_tipo); //2016-10-04
        $templates->assign('id_tipo', $id_tipo); //2016-10-04
        $templates->assign('tipo', $tipo[0]); //2016-10-06
        $templates->display('tipos_form.html'); //2016-10-04
        break;

      case 'guardar': //2016-10-06
          // $web->updateTipo($_POST['id_tipo'], $_POST);
          $web->setTabla("tipo");
          $web->update($_POST, $_POST['id_tipo'],array('id_tipo'=>$_POST['id_tipo']));
        break;

      case 'eliminar':
          $web->deleteTipo($id_tipo);
        break;
    }
  }
  
  //Muestra de contenido
    $tipos = $web->getAll("select * from tipo order by tipo"); //Modificado el 2016-09-29, getAllTipos -> getAll
    $templates->assign('titulo', 'Tipos'); // 2016-09-27_SMARTY_INICIOS
    $templates->assign('tipos', $tipos); // 2016-09-27_SMARTY_INICIOS
    $templates->display('tipos.html'); // 2016-09-27_SMARTY_INICIOS
?>
