<?php 

include('../cp_web.class.php');

$templates = $web->templateEngine();
$web = new Servicios;
$web->conexion();

$cadenaJSON = '
[
    {
        "id_servicio": 11,
        "servicio": "Contador del Demonio",
        "precio": "10.00"
    },
    {
        "id_servicio": 12,
        "servicio": "Contador Diabólico",
        "precio": "11.00"
    }
]
';

$servicios = json_decode($cadenaJSON);
echo "<pre>";
// print_r($servicios);

foreach ($servicios as $servicio) {
    print_r($servicio);
    $id_servicio = $servicio->id_servicio;
    $servicio = $servicio->servicio;
    // $precio = $servicio->precio;

    $sql = "insert into servicio values($id_servicio, '$servicio')";
    // echo $sql;
    $statement = $web->conn->Prepare($sql);
    $statement->Execute();
}

?>