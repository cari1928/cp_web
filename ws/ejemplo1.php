<?php 

$cadenaJSON = '
{
"responsable":
    {
    "Nombre" : "Juan",
    "Edad": 28,
    "Aficiones": ["Música", "Cine", "Tenis"],
    "Residencia": "Madrid"
    },
"empleados":
    [
        {
        "Nombre" : "Elena",
        "Edad": 26,
        "Aficiones": ["Música", "Cine"],
        "Residencia": "Madrid"
        },
        {
        "Nombre" : "Luis",
        "Edad": 31,
        "Aficiones": ["Teatro", "Cine", "Fútbol"],
        "Residencia": "Madrid"
        }
    ]
}    
';

//json para php
// json_encode(trabajador)
// json_decode(json)

$empleados = json_decode($cadenaJSON);
// echo "<pre>";
// print_r($empleados);

$cont = 0;
$edadProm = 0;
$empleadoAficion = array();

echo "<pre>";   
foreach ($empleados as $etiqueta=>$trabajador) {
    // print_r($trabajador);    
    // echo "<br>Etiqueta : ".$etiqueta."<br>";
    switch ($etiqueta) {
        case 'responsable':
            // print_r($trabajador);
            ++$cont;  
            $edadProm += $trabajador->Edad;
            if(in_array("Fútbol", $trabajador->Aficiones)) {
                array_push($empleadoAficion, $trabajador->Nombre);
            }
        break;

        case 'empleados':
            foreach ($trabajador as $empleado) {
                // print_r($empleado);
                ++$cont;
                $edadProm += $empleado->Edad;
                if(in_array("Fútbol", $empleado->Aficiones)) {
                    array_push($empleadoAficion, $empleado->Nombre);
                }   
            }
        break;
    }
}
echo "Número de Empleados: ".$cont;
echo "<br>Edad: ".($edadProm/$cont);
echo "<br>Les gusta el Fútbol: <br>";
print_r($empleadoAficion);

?>