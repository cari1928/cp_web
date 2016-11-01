<?php
/*
  Clase     cp_web
  Autor:    Carolina
  Version:  0.1
  Fecha:    2016-09-22
*/

session_start(); //iniciamos la sesion 2016-10-20

include('configs/configuration.php');
require_once('lib/smarty/Smarty.class.php'); // 2016-09-27_SMARTY_INICIOS

class CPweb {
  /****************************************************************************
    CLASS VARIABLES
  ****************************************************************************/
  var $cliente = null;
  var $conn = null;
  var $tabla = null;

  /****************************************************************************
    DATABASE CONNECTION  METHODS
  ****************************************************************************/
  function conexion() {
    $this->conn = new PDO (DB_ENGINE.':host='.DB_IP.';dbname='.DB_NAME, DB_USER, DB_PASS);
  }

  /****************************************************************************
    METHOD TO GET AN INDEXED ARRAY WITH THE INFORMATION OF A QUERY
    @param   String $query QUERY SQL
  ****************************************************************************/
  function getAll($query) {
    $datos = array();
    foreach($this->conn->query($query) as $fila) {
      array_push($datos, $fila);
    }
    return $datos;
  }

  /****************************************************************************
    METHOD TO GET AN ASSOCIATIVE ARRAY WITH THE INFORMATION OF A QUERY
    @param   String $query QUERY SQL
  ****************************************************************************/
  function fetchAll($query){
    $statement = $this->conn->Prepare($query);
    $statement->Execute();
    $datos = $statement->FetchAll(PDO::FETCH_ASSOC);
    return $datos;
  }

  /****************************************************************************
    METHOD INITIALIZE SMARTY TEMPLATES
  ****************************************************************************/
  // 2016-09-27_SMARTY_INICIOS
  function templateEngine() {
    $smarty = new Smarty(); //instancia la variable smarty
    $smarty->setTemplateDir(TEMPLATE);
    $smarty->setCompileDir(TEMPLATE_C);
    $smarty->setConfigDir(CONFIGS);
    $smarty->setCacheDir(CACHE);
    return $smarty;
  }

  /****************************************************************************
    METHOD TO GET HTML CODE OF A DROPDOWN LIST
    @param   String $query QUERY SQL
    @param   int $selected ELEMNT TO SELECT
  ****************************************************************************/
  //2016-10-04, regresa un arreglo asociativo, es para hacer combo
  function showList($query, $selected=null){
    $datos = $this->getAll($query);
    $nombDatos = array_keys($datos[0]);
    $template = $this->templateEngine();
    $template->assign('selected', $selected); //2016-10-06
    $template->assign('datos', $datos);
    $template->assign('nombDatos', $nombDatos);
    //fecth: procesa la plantilla, el resultado lo guarda en una variable
    return $template->fetch('select.component.html'); //Esto es hermoso T-T
  }

  /****************************************************************************
    METHOD TO STABLISH THE MANIPULATED TABLE
    @param   array $tabla CONTAINS THE COLUMNS OF GET OR POST TABLE
  ****************************************************************************/
  //2016-10-10
  function setTabla($tabla){ //Método para asignar la tabla
    $this->tabla = $tabla;
  }

  /****************************************************************************
    METHOD TO GET THE NAME OF THE TABLE
  ****************************************************************************/
  //2016-10-10
  function getTabla(){
    return $this->tabla;
  }

  /****************************************************************************
    GENERIC METHOD TO UPDATE ANY TABLE
    @param   array  $datos      CONTAINS THE COLUMNS OF GET OR POST
    @param   String $id         INDICATES PRIMARY KEY
    @param   array  $condition  ELEMENTS OF WHERE CONDITION
  ****************************************************************************/
  //2016-10-10
  function update($datos, $id, $condition=null){
    $nombresColumnas = $this->getNombresColumnas($datos); //2016-10-11
    $columnas = $this->getColumnas($datos, 'update'); //2016-10-11

    $where = "";
    if(!empty($condition)){
      $where = " where ";
      $nombresColumnasWhere = array_keys($condition); //2016-10-11
      for ($i=0; $i < sizeof($nombresColumnasWhere); $i++) {
        $where.= $nombresColumnasWhere[$i]; //2016-10-11
        $where.= '=:'.$nombresColumnasWhere[$i]; //2016-10-11
        if($i != sizeof($nombresColumnasWhere) - 1)
            $where.= ' and ';
      }
    }

    $sql = "update ".$this->getTabla()." set ".$columnas.$where;
    $stmt = $this->conn->prepare($sql);
    for ($i=0; $i < sizeof($nombresColumnas); $i++) //2016-10-11
      $stmt->bindParam(':'.$nombresColumnas[$i], $datos[$nombresColumnas[$i]]); //2016-10-11
    $stmt->execute();
  }

  /****************************************************************************
    GENERIC METHOD TO INSERT ANY TABLE
    @param   array  $datos      CONTAINS THE COLUMNS OF GET OR POST
  ****************************************************************************/    //2016-10-11
    function insert($datos){
      $nombresColumnas = $this->getNombresColumnas($datos);
      $columnas[0] = $this->getColumnas($datos, 'insert');
      $columnas[1] = ":".str_replace(',', ',:', $columnas[0]);

      $sql = "insert into ".$this->getTabla()." (".$columnas[0].") values(".$columnas[1].")";

      $stmt = $this->conn->prepare($sql);
      for ($i=0; $i < sizeof($nombresColumnas); $i++) {
        $stmt->bindParam(':'.$nombresColumnas[$i], $datos[$nombresColumnas[$i]]);
      }
      $stmt->execute();
    }

  /****************************************************************************
    RETURNS THE COLUMNS INGRESED SEPARATED WITH COMMAS OR ,=:
    @param   array    $datos  CONTAINS THE COLUMNS OF THE TABLE
    @param   String   $accion INDICATES THE DML OPERATION: INSERT OR UPDATE
  ****************************************************************************/
    //2016-10-11
    function getColumnas($datos, $accion=null){
      $nombresColumnas = $this->getNombresColumnas($datos);
      $columnas = "";
      for ($i=0; $i < sizeof($nombresColumnas); $i++) {
        $columnas.= $nombresColumnas[$i];

        if($accion == 'update') //si es por update se separa por =:
            $columnas.= '=:'.$nombresColumnas[$i];

        if($i != sizeof($nombresColumnas) - 1)
            $columnas.= ','; //separa por comas
      }
      return $columnas;
    }

  /****************************************************************************
    GENERIC METHOD TO UPDATE ANY TABLE
    @param   array  $datos      CONTAINS THE COLUMNS OF GET OR POST
  ****************************************************************************/
    //2016-10-11 //regresa los campos separados por comas y por :=
    function getNombresColumnas($datos){
      return array_keys($datos);
    }

/****************************************************************************
    METHOD THAT RETURNS A QUERY IN HTML SINTAX
    @param   String  $query      CONTAINS THE SQL QUERY
  ****************************************************************************/
    //2016-10-13
    function getQuery2HTML($query){
      $datos = $this->getAll($query);
      $campos = $this->getNombresColumnas($datos[0]);
      $template = $this->templateEngine();
      $template->assign('datos', $datos);
      $template->assign('campos', $campos);
      return $template->fetch('query2html2.component.html'); //Esto es hermoso T-T
    }

//------------------------------------------------------------------------------
    function checarAcceso($rol=null){
      $data = $_SESSION;
      if(isset($data['validado'])){
        if($data['validado']){

          //CHECAR ESTO!!!!
          $roles = $_SESSION['roles'];
          echo "<pre>";
          var_dump($roles);
          echo $rol;
          for ($i=0; $i < count($roles); $i++) {
            if(in_array($rol, $roles )) {
              die('Existe');
            } else {
              die('No existe');
              header('Location: ../login.php');
            }
          }

          // for ($i=0; $i < count($roles); $i++) {
          //   if($roles[0]['rol'] != $rol) {
          //     header('Location: ../login.php');
          //   }
          // }

        }else{
          header('Location: login.php');
        }
      }else{
        header('Location: login.php');
      }
    }

} //END OF THE CLASS
//-----------------------------------------------------------------------------------------------

//Incluimos todos los controladores - //2016-09-29 se agregó foreach
  // foreach (glob("controllers/*.php") as $nombre_fichero) {
  //     include($nombre_fichero);
  // }
 include('controllers/clientes.php'); ////2016-09-29 En lo que se arregla el foreach de arriba
 include('controllers/estados.php');
 include('controllers/tipos.php');
 include('controllers/roles.php');
 include('controllers/privilegios.php');
 include('controllers/usuarios.php');
 include('controllers/usuario_rol.php');
 include('controllers/login.php');

$web = new CPweb;
$web->conexion();
$template = $web->templateEngine(); //2016-09-27_SMARTY_INICIOS
?>
