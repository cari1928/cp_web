<?php
include '../cp_web.class.php';

$templates = $web->templateEngine();
$templates->setTemplateDir("../templates/admin");
$web = new vCotizacion;
$web->conexion();
$web->checarAcceso('Contador');

$accion        = null;
$id_cotizacion = null;

if (isset($_GET['accion'])) {
  $accion = $_GET['accion'];

  switch ($accion) {

    case "imprimir":
      $id_cotizacion = $_GET['id_cotizacion'];

      $cotizaciones = $web->fetchAll("select id_cotizacion, razon_social, fecha, count(id_servicio) as total_servicio, sum(subtotal) as total from v_cotizacion where id_cotizacion=" . $id_cotizacion . " grup by 1,2,3");

      $detalle = $web->fetchAll("select id_servicio, servicio, cantidad, precio, subtotal from v_cotizacion where id_cotizacion = " . $id_cotizacion);

      $templates->assign('cotizaciones', $cotizaciones);
      $reporte = $templates->fetch('cotizaciones_pdf.html');

      require_once PATH . '/lib/html2pdf/vendor/autoload.php';
      $html2pdf = new HTML2PDF('P', 'A4', 'fr');
      $html2pdf->setDefaultFont('Arial');
      $html2pdf->writeHTML($reporte, null);
      $html2pdf->Output('cotizacion.pdf');

      // echo $reporte;
      die();
      break;

  }
}

// $sql = "select id_cotizacion, razon_social, fecha, count(id_servicio) as total_servicio, count(precio) as total from v_cotizacion group by id_cotizacion, razon_social, fecha, id_servicio, precio, cantidad, servicio";
// echo $sql;

// $sql = "select id_cliente, razon_social, rfc, domicilio, email, from cliente inner join tipo on cliente.id_tipo = tipo.id_tipo";

// $v_cotizacion = $web->getAll($sql);

// echo "<pre>";
// print_r($v_cotizacion);
// echo "</pre>";
// die();

// $templates->assign('titulo', 'Cotización');
// $templates->assign('v_cotizacion', $v_cotizacion);
// $templates->display('v_cotizacion.html');
//
$v_cotizacion = $web->fetchAll("select * from v_cotizacion");
var_dump($v_cotizacion);

die();
$templates->assign('titulo', 'Clientes');
$templates->assign('v_cotizacion', $v_cotizacion);
$templates->display('v_cotizacion.html');
