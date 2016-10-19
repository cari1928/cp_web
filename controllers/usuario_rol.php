<?php
  class UsuarioRol extends CPweb {
//-------------------------------------------------------------------------------------------------
    function getUsuarioRol($id_usuario, $id_rol){
      $estados = array();
      if(is_numeric($id_usuario) && is_numeric($id_rol)){
        $statement = $this->conn->Prepare('select * from usuario_rol where id_usuario='.$id_usuario.' and id_rol='.$id_rol);
        $statement->Execute();
        $estados =  $statement->FetchAll(PDO::FETCH_ASSOC);
      }
      return $estados;
    }
//----------------------------------------------------------------------------------------------------------
    function deleteUsuarioRol($id_usuario, $id_rol){ //2016-09-29
      // $count = $this->conn->exec("DELETE FROM cliente WHERE id_estado=".$id_estado);
      //Esto previene inyección SQL!!!
      $sql = "DELETE FROM usuario_rol WHERE id_usuario= :id_usuario and id_rol= :id_rol";
      $stmt = $this->conn->Prepare($sql);
      $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
      $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
      $stmt->execute();
    }
  }
?>
