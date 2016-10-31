<?php
  include('../cp_web.class.php');
  
  $templates = $web->templateEngine(); // 2016-09-27_SMARTY_INICIOS
  $templates->setTemplateDir("../templates/admin");
  $web = new UsuarioRol;
  $web->conexion();
  $web->checarAcceso();

  //Operaciones SQL
  $accion = null; //2016-09-29
  $id_usuario = null; //2016-09-29
  $id_rol = null;

  if(isset($_GET['accion']) ){ //2016-09-29
    //Validar que id_usuario sea numérico
    $accion = $_GET['accion'];
    if(isset($_GET['id_usuario']) && isset($_GET['id_rol']))
        $id_usuario = $_GET['id_usuario'];
        $id_rol = $_GET['id_rol'];

    switch ($accion) {
      case 'alta': //insertar nuevo usuario
          $web->setTabla("usuario_rol"); //2016-10-11
          $web->insert($_POST); //2016-10-11
        break;

      case 'nuevo': //mostrar
        $templates->display('usuarios_roles_form.html');
        break;

      case 'ver':
        break;

      case 'editar': //2016-10-04
        $usuario = $web->getsUsuarioRol($id_usuario, $id_rol); //2016-10-04
        $templates->assign('id_usuario', $id_usuario); //2016-10-04
        $templates->assign('id_rol', $id_rol); //2016-10-04
        $templates->assign('usuario', $usuario[0]); //2016-10-06
        // $templates->assign('rol', $usuario[1]); //2016-10-06
        $templates->display('usuarios_roles_form.html'); //2016-10-04
        break;

      case 'guardar': //2016-10-06
          // $web->updatesUsuarioRol($_POST['id_usuario'], $_POST);
          $web->setTabla("usuario");
          $web->update($_POST, $_POST['id_usuario'],array('id_usuario'=>$_POST['id_usuario'], 'id_rol'=>$_POST['id_rol']));
        break;

      case 'eliminar':
          $web->deletesUsuarioRol($id_usuario, $id_rol);
        break;
    }
  } else{
    //Muestra de contenido
    $usuarios = $web->getAll("select * from usuario_rol order by id_usuario"); //Modificado el 2016-09-29, getAllUsuarioRol -> getAll
    $templates->assign('titulo', 'Usuarios y Roles'); // 2016-09-27_SMARTY_INICIOS
    $templates->assign('usuarios', $usuarios); // 2016-09-27_SMARTY_INICIOS
    $templates->display('usuarios.html'); // 2016-09-27_SMARTY_INICIOS
  }
?>
