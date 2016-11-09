<?php
  include('../cp_web.class.php');

  $templates = $web->templateEngine();
  $templates->setTemplateDir("../templates/admin");
  $web->conexion();
  $web->checarAcceso('login');

  if(isset($_GET['action'])) {
    switch ($_GET['action']) {
      case 'guardar':
          $web->setTabla('usuario');
          $_POST['id_usuario'] = $_SESSION['id_usuario'];
          $web->update($_POST, null, array('id_usuario'=>$_SESSION['id_usuario']));
        break;
    }
  }
  $usuario = $web->getAll(
  "select * from usuario where id_usuario='".$_SESSION['id_usuario']."'");
  $templates->assign('usuario', $usuario[0]);
  $templates->display('perfil.html');



  
?>
