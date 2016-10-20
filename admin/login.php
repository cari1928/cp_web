<?php
  include('../cp_web.class.php');
  $smarty = new Smarty();
  $templates = $web->templateEngine();
  $web = new Login;
  $web->conexion();

  $accion = null;
  if(isset($_GET['accion']) )
    $accion = $_GET['accion'];

    switch ($accion) {
      case 'login':
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];
        $web->newLogin($email, $contrasena);
        break;

      case 'logout':
        $web->logout();
        break;
      default:
    }

  $templates->assign('titulo', 'Login');
  $templates->display('login_form.html');
?>
