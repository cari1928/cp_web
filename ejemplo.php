<?php
//2016-09-27_SMARTY_INICIOS

require_once('lib/smarty/Smarty.class.php');
$smarty = new Smarty();

$frutas = array('Manzana', 'Kiwi', 'Melón', 'Jitomate', 'Aguacate');
$smarty->assign('titulo', 'Arreglo de frutas');
$smarty->assign('frutas', $frutas);

// $smarty->assign('name','Ned'); //para crear etiquetas a usar

$smarty->display('ejemplo.html'); //para mostrar la plantilla que se encuentra en templates
?>
