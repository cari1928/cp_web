<?php
  //Creado 2016-10-18
  include('cp_web.class.php');

  $templates = $web->templateEngine();
  $web = new Usuarios;
  $web->conexion();

  if(isset($_GET['accion']) ) { //Validar que id_usuario sea numérico
    $web->setTabla("usuario");
    $_POST['contrasena'] = md5($_POST['contrasena']); //encriptación
    $web->insert($_POST);
  }

  $templates->display('usuarios_form.html');
?>
