<?php
  // 2016-09-27_SMARTY_INICIOS
  define('PATH', '/var/www/html/cp_web/');

  // Archivo de configuración de CPweb
  define('DB_IP', '172.20.108.47'); //se debe modificar cada que se acceda a internet
  define('DB_NAME', 'cp_web');
  define('DB_USER', 'conta');
  define('DB_PASS', '1234');
  define('DB_ENGINE', 'pgsql'); //2016-10-17 cambiado a postgres
  // define('DB_ENGINE', 'mysql');

  /*
    2016-09-27_SMARTY_INICIOS
    Constantes del motor de plantillas (importante la última diagonal)
    se relaciona la cte con una dirección
    se ocupa en cp_web.class.php->templateEngine()
  */
  define('TEMPLATE',    PATH.'templates/');
  define('TEMPLATE_C',  PATH.'templates_c/');
  define('CACHE',       PATH.'cache/');
  define('CONFIGS',     PATH.'configs/');
?>
