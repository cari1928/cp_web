<?php
  include('cp_web.class.php');

  $templates = $web->templateEngine();
  $templates->assign('titulo', 'Planeación Financiera');
  $templates->display('planeacion_financiera.html');
?>
