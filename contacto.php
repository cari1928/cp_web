<?php
  include('cp_web.class.php');

  $templates = $web->templateEngine();
  $templates->assign('titulo', 'Contacto');
  $templates->display('contacto.html');
?>
