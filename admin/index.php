<?php
  include('../cp_web.class.php');
  $smarty = new Smarty();
  $templates = $web->templateEngine();

  $email = "";
  if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
  }

  $templates->assign('titulo', 'Login');
  $templates->assign('email', $email);
  $templates->display('index.html');
?>
