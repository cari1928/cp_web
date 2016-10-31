<?php
  include('../cp_web.class.php');
  $templates = $web->templateEngine();
  $templates->setTemplateDir("../templates/admin");

  $email = "";
  if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
  }

  $templates->assign('titulo', 'Login');
  $templates->assign('email', $email);
  $templates->display('index.html');
?>
