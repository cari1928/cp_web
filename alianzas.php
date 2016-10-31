<?php
  include('cp_web.class.php');

  $templates = $web->templateEngine();
  $templates->assign('titulo', 'Alianzas');
  $templates->display('alianzas.html');
?>
