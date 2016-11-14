<?php
  class servicios extends CPweb {
//-----------------------------------------------------------------------------------
    function getservicio($id_servicio){
      $servicios = array();
      if(is_numeric($id_servicio)){
        $statement = $this->conn->Prepare('select * from servicio where id_servicio='.$id_servicio);
        $statement->Execute();
        $servicios =  $statement->FetchAll(PDO::FETCH_ASSOC);
      }
      return $servicios;
    }
//------------------------------------------------------------------------------------
    function deleteservicio($id_servicio){
      $sql = "DELETE FROM servicio WHERE id_servicio= :id_servicio";
      $stmt = $this->conn->Prepare($sql);
      $stmt->bindParam(':id_servicio', $id_servicio, PDO::PARAM_INT);
      $stmt->execute();
    }
  }
?>
