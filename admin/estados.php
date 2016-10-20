<?php
  include('../cp_web.class.php');
  $smarty = new Smarty(); // 2016-09-27_SMARTY_INICIOS
  $templates = $web->templateEngine(); // 2016-09-27_SMARTY_INICIOS
  $web = new Estados;
  $web->conexion();

  $web->checarAcceso();

  //Operaciones SQL
  $accion = null; //2016-09-29
  $id_estado = null; //2016-09-29

  if(isset($_GET['accion']) ){ //2016-09-29
    //Validar que id_estado sea numérico
    $accion = $_GET['accion'];
    if(isset($_GET['id_estado']))
        $id_estado = $_GET['id_estado'];

    switch ($accion) {
      case 'alta': //insertar nuevo estado
          $web->setTabla("estado"); //2016-10-11
          $web->insert($_POST); //2016-10-11
        break;

      case 'nuevo': //mostrar
        $templates->display('estados_form.html');
        break;

      case 'ver':
        break;

      case 'editar': //2016-10-04
        $estado = $web->getEstado($id_estado); //2016-10-04
        $templates->assign('id_estado', $id_estado); //2016-10-04
        $templates->assign('estado', $estado[0]); //2016-10-06
        $templates->display('estados_form.html'); //2016-10-04
        break;

      case 'guardar': //2016-10-06
          // $web->updateEstado($_POST['id_estado'], $_POST);
          $web->setTabla("estado");
          $web->update($_POST, $_POST['id_estado'],array('id_estado'=>$_POST['id_estado']));
        break;

      case 'eliminar':
          $web->deleteEstado($id_estado);
        break;
    }
  } else{
    //Muestra de contenido
    $estados = $web->getAll("select * from estado order by estado"); //Modificado el 2016-09-29, getAllEstados -> getAll
    $templates->assign('titulo', 'Estados'); // 2016-09-27_SMARTY_INICIOS
    $templates->assign('estados', $estados); // 2016-09-27_SMARTY_INICIOS
    $templates->display('estados.html'); // 2016-09-27_SMARTY_INICIOS
  }
?>
