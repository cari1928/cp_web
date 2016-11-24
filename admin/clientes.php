<?php
include '../cp_web.class.php';

$templates = $web->templateEngine(); // 2016-09-27_SMARTY_INICIOS
$templates->setTemplateDir("../templates/admin");
$web = new Clientes;
$web->conexion();
$web->checarAcceso('Contador');

//Operaciones SQL
$accion     = null; //2016-09-29
$id_cliente = null; //2016-09-29
if (isset($_GET['accion'])) {
    //2016-09-29
    //Validar que id_cliente sea numérico
    $accion = $_GET['accion'];
    if (isset($_GET['id_cliente'])) {
        $id_cliente = $_GET['id_cliente'];

        switch ($accion) {
            case 'alta': //insertar nuevo cliente
                // $razon_social =  $_POST['razon_social'];
                // $rfc =          $_POST['rfc'];
                // $domicilio =    $_POST['domicilio'];
                // $email =        $_POST['email'];
                // $telefono =     $_POST['telefono'];
                // $id_tipo =      $_POST['id_tipo'];
                //
                // $sql = "insert into cliente(razon_social, rfc, domicilio, email, telefono, id_tipo)
                // values('".$razon_social."', '".$rfc."', '".$domicilio."', '".$email."', '".$telefono."', ".$id_tipo.");";
                // $web->conn->Exec($sql);

                $web->setTabla("cliente"); //2016-10-11
                $web->insert($_POST); //2016-10-11
                break;

            case 'nuevo': //mostrar
                $combo         = $web->showList("select * from tipo"); //para hacer combos T-T
                $combo_estados = $web->showList("select * from estado"); //2016-10-11
                $templates->assign('combo', $combo); //2016-10-04 esto es hermoso T-T
                $templates->assign('combo_estados', $combo_estados); //2016-10-11
                $templates->display('clientes_form.html');
                die();
                break;

            case 'ver':
                break;

            case 'editar': //2016-10-04
                $cliente       = $web->getCliente($id_cliente); //2016-10-04
                $combo         = $web->showList("select * from tipo", $cliente[0]['id_tipo']); //2016-10-04 //para hacer combos T-T
                $combo_estados = $web->showList("select * from estado"); //2016-10-11
                $templates->assign('id_cliente', $id_cliente); //2016-10-04
                $templates->assign('cliente', $cliente[0]); //2016-10-06
                $templates->assign('combo', $combo); //2016-10-04 esto es hermoso T-T
                $templates->assign('combo_estados', $combo_estados); //2016-10-11
                $templates->display('clientes_form.html'); //2016-10-04
                die();
                break;

            case 'guardar': //2016-10-06
                // $web->updateCliente($_POST['id_cliente'], $_POST);
                $web->setTabla("cliente");
                $web->update($_POST, $_POST['id_cliente'], array('id_cliente' => $_POST['id_cliente']));
                break;

            case 'eliminar':
                $web->deleteCliente($id_cliente);
                break;
        }
    }

//Muestra de contenido
    $clientes = $web->getAll("select id_cliente, razon_social, rfc, domicilio, email, telefono, tipo from cliente inner join tipo on cliente.id_tipo = tipo.id_tipo"); //Modificado el 2016-09-29, getAllClientes -> getAll
    $templates->assign('titulo', 'Clientes'); // 2016-09-27_SMARTY_INICIOS
    $templates->assign('clientes', $clientes); // 2016-09-27_SMARTY_INICIOS
    $templates->display('clientes.html'); // 2016-09-27_SMARTY_INICIOS
