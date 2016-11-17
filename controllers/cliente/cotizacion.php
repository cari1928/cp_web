<?php
  class Cotizacion extends CPweb {
//-----------------------------------------------------------------------------------------------
    function getEstado($id_estado){
      $estados = array();
      if(is_numeric($id_estado)){
        $statement = $this->conn->Prepare('select * from estado where id_estado='.$id_estado);
        $statement->Execute();
        $estados =  $statement->FetchAll(PDO::FETCH_ASSOC);
      }
      return $estados;
    }
//-----------------------------------------------------------------------------------------------
    function deleteEstado($id_estado){ //2016-09-29
      // $count = $this->conn->exec("DELETE FROM cliente WHERE id_estado=".$id_estado);
      //Esto previene inyección SQL!!!
      $sql = "DELETE FROM estado WHERE id_estado= :id_estado";
      $stmt = $this->conn->Prepare($sql);
      $stmt->bindParam(':id_estado', $id_estado, PDO::PARAM_INT);
      $stmt->execute();
    }
  }
?>
