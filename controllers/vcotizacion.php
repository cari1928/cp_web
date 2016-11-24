<?php

class vCotizacion extends CPweb
{
//----------------------------------------------------------------------------------------------------------
  // function getAll() { //2016-09-29 getAllClientes -> getAll
  //regresa arreglo indexado, números y títulos
  public function getAll($query)
  {
    //2016-10-04
    $clientes = array();
    foreach ($this->conn->query($query) as $fila) {
      array_push($clientes, $fila);
    }
    return $clientes;
  }
//----------------------------------------------------------------------------------------------------------
  //regresa arreglo asociativo, solo títulos
  public function fetchAll($query)
  {
    //2016-09-29 fetchAllClientes -> fetchAll
    $statement = $this->conn->Prepare($query);
    $statement->Execute();
    $clientes = $statement->FetchAll(PDO::FETCH_ASSOC);
    return $clientes;
  }
}
