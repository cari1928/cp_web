<?php
  include('../cp_web.class.php');
  $templates = $web->templateEngine();
  $templates->setTemplateDir("../templates/admin");
  $web->checarAcceso('Login');
  $email = "";
  if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
  }

  // print_r($_SESSION);

  $templates->assign('titulo', 'Login');
  $templates->assign('email', $email);
  $templates->display('index.html');
?>
