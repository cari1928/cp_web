<?php
  //Creado 2016-10-18
  include('../cp_web.class.php');

  $templates = $web->templateEngine();
  $templates->setTemplateDir("../templates/admin");
  $web = new Usuarios;
  $web->conexion();
  $web->checarAcceso('Administrador');

  //Operaciones SQL
  $accion = null;
  $id_usuario = null;

  $flag = 1; //si muestra el formulario final

  if(isset($_GET['accion']) ){
    //Validar que id_usuario sea numérico
    $accion = $_GET['accion'];
    if(isset($_GET['id_usuario']))
        $id_usuario = $_GET['id_usuario'];

    switch ($accion) {
      case 'alta': //insertar nuevo usuario
          $web->setTabla("usuario");
          $_POST['contrasena'] = md5($_POST['contrasena']); //encriptación
          $web->insert($_POST);
        break;

      case 'nuevo': //mostrar
        $templates->display('usuarios_form.html');
        $flag = 0; //no muestra form final
        break;

      case 'ver':
        break;

      case 'editar':
        $usuario = $web->getUsuario($id_usuario);
        $templates->assign('id_usuario', $id_usuario);
        $templates->assign('usuario', $usuario[0]);
        $templates->display('usuarios_form.html');
        $flag = 0;
        break;

      case 'guardar':

          if(empty($_POST['contrasena'])){
            unset($_POST['contrasena']); //destruye campo de POST
          } else{
            $_POST['contrasena'] = md5($_POST['contrasena']); //encriptcaión de la nueva contraseña
          }

          $web->setTabla("usuario");
          $web->update($_POST, $_POST['id_usuario'],array('id_usuario'=>$_POST['id_usuario']));
        break;

      case 'eliminar':
          $web->deleteUsuario($id_usuario);
        break;
    }
  }

  if($flag == 1){
    $usuarios = $web->getAll("select * from usuario order by usuario"); //Modificado el 2016-09-29, getAllUsuarios -> getAll
    $templates->assign('titulo', 'Usuarios');
    $templates->assign('usuarios', $usuarios);
    $templates->display('usuarios.html');
  }

?>
