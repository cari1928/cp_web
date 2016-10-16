<?php
  class Tipos extends CPweb {
//-------------------------------------------------------------------------------------------------
    function getTipo($id_tipo){
      $tipos = array();
      if(is_numeric($id_tipo)){
        $statement = $this->conn->Prepare('select * from tipo where id_tipo='.$id_tipo);
        $statement->Execute();
        $tipos =  $statement->FetchAll(PDO::FETCH_ASSOC);
      }
      return $tipos;
    }
//----------------------------------------------------------------------------------------------------------
    function deleteTipo($id_tipo){ //2016-09-29
      // $count = $this->conn->exec("DELETE FROM cliente WHERE id_tipo=".$id_tipo);
      //Esto previene inyección SQL!!!
      $sql = "DELETE FROM tipo WHERE id_tipo= :id_tipo";
      $stmt = $this->conn->Prepare($sql);
      $stmt->bindParam(':id_tipo', $id_tipo, PDO::PARAM_INT);
      $stmt->execute();
    }
  }
?>
