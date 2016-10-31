<?php
  include('cp_web.class.php');

  $templates = $web->templateEngine();
  $templates->assign('titulo', 'Auditorías');
  $templates->display('auditoria.html');
?>
