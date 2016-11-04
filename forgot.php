<?php
  include('cp_web.class.php');
  $templates = $web->templateEngine();
  // $web = new Login; //para el mail
  $action = null;

  if(isset($_GET['action'])) {
    $action = $_GET['action'];
  }

  switch ($action) {
    case 'validar':
        $email = $_POST['email'];

        // se validará si la variable correo cumple con la expr regular de un email
        $sql = "select id_usuario from usuario where email='".$email."'";
        $resultado = $web->fetchAll($sql);
        if(isset($resultado[0])) {
          $cadena1 = md5(rand(1, 1000000000));
          $cadena2 = md5(md5(sha1($resultado[0]['id_usuario'].$email.rand(1, 999999))).rand(1, 1000000000).$cadena1);
          $cadena = $cadena1.$cadena2;

          $datos['clave'] = $cadena;
          $datos['fecha_clave'] = date ( 'Y-m-j' , strtotime ( '+2 day' , strtotime ( date('Y-m-j') ) ) );
          $datos['id_usuario'] = $resultado[0]['id_usuario'];

          $web->setTabla('usuario');
          //CHECAR ESTA PARTE!!! NO ACTUALIZA
          $web->update($datos, null, array('id_usuario'=>$resultado[0]['id_usuario']));

          $templates->assign('confirmacion', 'Se ha enviado un correo electrónico con un vínculo para que recupere su contraseña, tiene 2 días para realizar el cambio');

          echo $cadena;
          //Aquí se enviará el email
          $web->forgotpassword($email, $cadena);

        } else {
          //Agregar mensaje bootstrap!!!!
          $templates->assign('msg', "No existe el correo electrónico");
        }
      break;

    case 'recuperar':
        $clave = "*";
        if(isset($_GET['clave'])) {
          $clave = $_GET['clave'];
        }

        $fecha = date('Y-m-j');
        $despues = date ( 'Y-m-j' , strtotime ( '+2 day' , strtotime ( $fecha ) ) );
        $sql = "select id_usuario from usuario where clave='".$clave."' and fecha_clave <= '".$despues."'";
        $resultado = $web->fetchAll($sql);

        if(isset($resultado[0])) {
          $templates->assign('clave', $clave); //para no perder la variable
          $templates->display('forgot_recuperar.html');
          die();

        } else {
          $templates->assign('msg', 'Clave no válida o Vínculo expirado');
        }
      break;
  }
  $templates->display('forgot.html');
?>
