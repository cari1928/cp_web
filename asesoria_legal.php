<?php
  include('cp_web.class.php');

  $templates = $web->templateEngine();
  $templates->assign('titulo', 'Asesoría Legal');
  $templates->display('asesoria_legal.html');
?>
