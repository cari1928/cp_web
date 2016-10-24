<?php
  include('cp_web.class.php'); //acceso a sus métodos
  $templates = $web->templateEngine(); //motor de plantillas listo

  $templates->assign('titulo', 'Página Principal');
  $templates->display('index.html');
?>
