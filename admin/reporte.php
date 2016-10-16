<?php
  include('../cp_web.class.php');
  $web = new CPweb;
  $web->conexion();
  $templates = $web->templateEngine(); // 2016-09-27_SMARTY_INICIOS

  $reporte1 = $web->getQuery2HTML("
    select razon_social as Razón Social, estado as Estado, tipo as Tipo
      from cliente join estado on cliente.id_estado = estado.id_estado
                   join tipo on cliente.id_tipo = tipo.id_tipo");

  $templates->assign('reporte1', $reporte1); // 2016-09-27_SMARTY_INICIOS
  $templates->display('reporte.html'); // 2016-09-27_SMARTY_INICIOS
?>
