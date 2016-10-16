<?php

  class Clientes extends CPweb {
//----------------------------------------------------------------------------------------------------------
    // function getAll() { //2016-09-29 getAllClientes -> getAll
    //regresa arreglo indexado, números y títulos
    function getAll($query) { //2016-10-04
      $clientes = array();
      foreach($this->conn->query($query) as $fila) {
        array_push($clientes, $fila);
      }
      return $clientes;
    }
//----------------------------------------------------------------------------------------------------------
    //regresa arreglo asociativo, solo títulos
    function fetchAll($query){ //2016-09-29 fetchAllClientes -> fetchAll
      $statement = $this->conn->Prepare($query);
      $statement->Execute();
      $clientes = $statement->FetchAll(PDO::FETCH_ASSOC);
      return $clientes;
    }
//----------------------------------------------------------------------------------------------------------
    function getCliente($idCliente){
      $clientes = array();
      if(is_numeric($idCliente)){
        $statement = $this->conn->Prepare('select * from cliente where id_cliente='.$idCliente);
        $statement->Execute();
        $clientes =  $statement->FetchAll(PDO::FETCH_ASSOC);
      }
      return $clientes;
    }
//----------------------------------------------------------------------------------------------------------
    function updateCliente($id_cliente, $datos){
      print_r($datos);
      die($id_cliente);
      $sql = "UPDATE cliente SET id_cliente= :id_cliente, razon_social= :razon_social, rfc= :rfc,
                domicilio= :domicilio, email= :email, telefono= :telefono, id_tipo= :id_tipo
              WHERE id_cliente = :id_cliente";
      $stmt = $this->conn->Prepare($sql);
      $stmt->bindParam(':id_cliente',   $id_cliente,             PDO::PARAM_INT);
      $stmt->bindParam(':razon_social', $datos['razon_social'],  PDO::PARAM_STR);
      $stmt->bindParam(':rfc',          $datos['rfc'],           PDO::PARAM_STR);
      $stmt->bindParam(':domicilio',    $datos['domicilio'],     PDO::PARAM_STR);
      $stmt->bindParam(':email',        $datos['email'],         PDO::PARAM_STR);
      $stmt->bindParam(':telefono',     $datos['telefono'],      PDO::PARAM_STR);
      $stmt->bindParam(':id_tipo',      $datos['id_tipo'],       PDO::PARAM_INT);
      $stmt->Execute();
    }
//----------------------------------------------------------------------------------------------------------
    function insertCliente($id_cliente, $datos){ //AÚN NO ESTÁ
      print_r($datos);
      die($id_cliente);
      $sql = "INSERT INTO cliente SET id_cliente= :id_cliente, razon_social= :razon_social, rfc= :rfc,
                domicilio= :domicilio, email= :email, telefono= :telefono, id_tipo= :id_tipo
              WHERE id_cliente = :id_cliente";
      $stmt = $this->conn->Prepare($sql);
      $stmt->bindParam(':id_cliente',   $id_cliente,             PDO::PARAM_INT);
      $stmt->bindParam(':razon_social', $datos['razon_social'],  PDO::PARAM_STR);
      $stmt->bindParam(':rfc',          $datos['rfc'],           PDO::PARAM_STR);
      $stmt->bindParam(':domicilio',    $datos['domicilio'],     PDO::PARAM_STR);
      $stmt->bindParam(':email',        $datos['email'],         PDO::PARAM_STR);
      $stmt->bindParam(':telefono',     $datos['telefono'],      PDO::PARAM_STR);
      $stmt->bindParam(':id_tipo',      $datos['id_tipo'],       PDO::PARAM_INT);
      $stmt->Execute();
    }
//----------------------------------------------------------------------------------------------------------
    function deleteCliente($id_cliente){ //2016-09-29
      // $count = $this->conn->exec("DELETE FROM cliente WHERE id_cliente=".$id_cliente);
      //Esto previene inyección SQL!!!
      $sql = "DELETE FROM cliente WHERE id_cliente= :id_cliente";
      $stmt = $this->conn->Prepare($sql);
      $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
      $stmt->execute();
    }
  }
  //----------------------------------------------------------------------------------------------------------

?>
