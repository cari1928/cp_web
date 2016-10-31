<?php
  include('../cp_web.class.php');

  $templates = $web->templateEngine(); // 2016-09-27_SMARTY_INICIOS
  $templates->setTemplateDir("../templates/admin");
  $web = new Roles;
  $web->conexion();
  $web->checarAcceso();

  //Operaciones SQL
  $accion = null; //2016-09-29
  $id_rol = null; //2016-09-29

  if(isset($_GET['accion']) ){ //2016-09-29
    //Validar que id_rol sea numérico
    $accion = $_GET['accion'];
    if(isset($_GET['id_rol']))
        $id_rol = $_GET['id_rol'];

    switch ($accion) {
      case 'alta': //insertar nuevo estado
          $web->setTabla("rol"); //2016-10-11
          $web->insert($_POST); //2016-10-11
        break;

      case 'nuevo': //mostrar
        $templates->display('roles_form.html');
        break;

      case 'ver':
        break;

      case 'editar': //2016-10-04
        $rol = $web->getRol($id_rol); //2016-10-04
        $templates->assign('id_rol', $id_rol); //2016-10-04
        $templates->assign('rol', $rol[0]); //2016-10-06
        $templates->display('roles_form.html'); //2016-10-04
        break;

      case 'guardar': //2016-10-06
          // $web->updateEstado($_POST['id_rol'], $_POST);
          $web->setTabla("rol");
          $web->update($_POST, $_POST['id_rol'],array('id_rol'=>$_POST['id_rol']));
        break;

      case 'eliminar':
          $web->deleteRol($id_rol);
        break;
    }
  }
  
  $roles = $web->getAll("select * from rol order by rol"); //Modificado el 2016-09-29, getAllEstados -> getAll
  $templates->assign('titulo', 'Rol'); // 2016-09-27_SMARTY_INICIOS
  $templates->assign('roles', $roles); // 2016-09-27_SMARTY_INICIOS
  $templates->display('roles.html'); // 2016-09-27_SMARTY_INICIOS
?>
