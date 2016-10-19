<?php
  class Privilegios extends CPweb {
//-------------------------------------------------------------------------------------------------
    function getPrivilegio($id_privilegio){
      $privilegios = array();
      if(is_numeric($id_privilegio)){
        $statement = $this->conn->Prepare('select * from privilegio where id_privilegio='.$id_privilegio);
        $statement->Execute();
        $privilegios =  $statement->FetchAll(PDO::FETCH_ASSOC);
      }
      return $privilegios;
    }
//----------------------------------------------------------------------------------------------------------
    function deletePrivilegio($id_privilegio){ //2016-09-29
      // $count = $this->conn->exec("DELETE FROM cliente WHERE id_privilegio=".$id_privilegio);
      //Esto previene inyección SQL!!!
      $sql = "DELETE FROM privilegio WHERE id_privilegio= :id_privilegio";
      $stmt = $this->conn->Prepare($sql);
      $stmt->bindParam(':id_privilegio', $id_privilegio, PDO::PARAM_INT);
      $stmt->execute();
    }
  }
?>
