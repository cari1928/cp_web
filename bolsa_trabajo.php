<?php
  include('cp_web.class.php');

  $templates = $web->templateEngine();
  $templates->assign('titulo', 'Bolsa de Trabajo');
  $templates->display('bolsa_trabajo.html');
?>
