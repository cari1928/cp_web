<?php
  include('cp_web.class.php');

  $templates = $web->templateEngine();
  $templates->assign('titulo', 'Quiénes Somos');
  $templates->display('quienes_somos.html');
?>
