<?php
  include('cp_web.class.php');

  $templates = $web->templateEngine();
  $templates->assign('titulo', 'Nóminas');
  $templates->display('nomina.html');
?>
