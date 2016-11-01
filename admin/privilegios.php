<?php
  include('../cp_web.class.php');

  $templates = $web->templateEngine(); // 2016-09-27_SMARTY_INICIOS
  $templates->setTemplateDir("../templates/admin");
  $web = new Privilegios;
  $web->conexion();
  $web->checarAcceso('Administrador');

  //Operaciones SQL
  $accion = null; //2016-09-29
  $id_privilegio = null; //2016-09-29

  if(isset($_GET['accion']) ){ //2016-09-29
    //Validar que id_privilegio sea numérico
    $accion = $_GET['accion'];
    if(isset($_GET['id_privilegio']))
        $id_privilegio = $_GET['id_privilegio'];

    switch ($accion) {
      case 'alta': //insertar nuevo privilegio
          $web->setTabla("privilegio"); //2016-10-11
          $web->insert($_POST); //2016-10-11
        break;

      case 'nuevo': //mostrar
        $templates->display('privilegios_form.html');
        die();
        break;

      case 'ver':
        break;

      case 'editar': //2016-10-04
        $privilegio = $web->getPrivilegio($id_privilegio); //2016-10-04
        $templates->assign('id_privilegio', $id_privilegio); //2016-10-04
        $templates->assign('privilegio', $privilegio[0]); //2016-10-06
        $templates->display('privilegios_form.html'); //2016-10-04
        break;

      case 'guardar': //2016-10-06
          // $web->updatePrivilegio($_POST['id_privilegio'], $_POST);
          $web->setTabla("privilegio");
          $web->update($_POST, $_POST['id_privilegio'],array('id_privilegio'=>$_POST['id_privilegio']));
        break;

      case 'eliminar':
          $web->deletePrivilegio($id_privilegio);
        break;
    }
  } else{
    //Muestra de contenido
    $privilegios = $web->getAll("select * from privilegio order by privilegio"); //Modificado el 2016-09-29, getAllPrivilegios -> getAll
    $templates->assign('titulo', 'Privilegios'); // 2016-09-27_SMARTY_INICIOS
    $templates->assign('privilegios', $privilegios); // 2016-09-27_SMARTY_INICIOS
    $templates->display('privilegios.html'); // 2016-09-27_SMARTY_INICIOS
  }
?>
