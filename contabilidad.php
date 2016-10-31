<?php
  include('cp_web.class.php');

  $templates = $web->templateEngine();
  $templates->assign('titulo', 'Contabilidad');
  $templates->display('contabilidad.html');
?>
