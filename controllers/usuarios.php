<?php
  class Usuarios extends CPweb {
//-------------------------------------------------------------------------------------------------
    function getUsuario($id_usuario){
      $usuarios = array();
      if(is_numeric($id_usuario)){
        $statement = $this->conn->Prepare('select * from usuario where id_usuario='.$id_usuario);
        $statement->Execute();
        $usuarios =  $statement->FetchAll(PDO::FETCH_ASSOC);
      }
      return $usuarios;
    }
//----------------------------------------------------------------------------------------------------------
    function deleteUsuario($id_usuario){ //2016-09-29
      // $count = $this->conn->exec("DELETE FROM cliente WHERE id_usuario=".$id_usuario);
      //Esto previene inyección SQL!!!
      $sql = "DELETE FROM usuario WHERE id_usuario= :id_usuario";
      $stmt = $this->conn->Prepare($sql);
      $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
      $stmt->execute();
    }
  }
?>
