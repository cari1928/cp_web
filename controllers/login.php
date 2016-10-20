<?php
  //2016-10-20
  class Login extends CPweb {

    function newLogin($email, $contrasena){
      $contrasena = md5($contrasena);
      $sql = "select * from usuario where email='".$email."' and contrasena='".$contrasena."'";
      $data = $this->fetchAll($sql);

      if(isset($data[0])){
        unset($data[0]['contrasena']); //se destruye la contraseña
        $_SESSION['email'] = $data[0]['email'];
        $_SESSION['id_usuario'] = $data[0]['id_usuario'];
        $_SESSION['validado'] = true;
        header("Location: ../admin/index.php");
      }
      else{
        $this->logout();
      }
    }

//------------------------------------------------------------------------------
    function logout(){
      session_destroy(); //se destruye la sesion
    }
  }

?>
