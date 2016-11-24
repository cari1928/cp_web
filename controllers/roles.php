<?php
  class Roles extends CPweb {
//-------------------------------------------------------------------------------------------------
    function getRol($id_rol){
      $roles = array();
      if(is_numeric($id_rol)){
        $statement = $this->conn->Prepare('select * from rol where id_rol='.$id_rol);
        $statement->Execute();
        $roles =  $statement->FetchAll(PDO::FETCH_ASSOC);
      }
      return $roles;
    }
//----------------------------------------------------------------------------------------------------------
    function deleteRol($id_rol){ //2016-09-29
      // $count = $this->conn->exec("DELETE FROM cliente WHERE id_rol=".$id_rol);
      //Esto previene inyección SQL!!!
      $sql = "DELETE FROM rol WHERE id_rol= :id_rol";
      $stmt = $this->conn->Prepare($sql);
      $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
      $stmt->execute();
    }
  }

?>
