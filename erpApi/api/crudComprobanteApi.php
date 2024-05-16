<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../clases/class-crudComprobante.php");
//Recibir peticiones de la empresa
switch($_SERVER['REQUEST_METHOD']){
    case 'POST':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $comprobante = new Comprobante($_POST["serie"],$_POST["fecha_comprobante"],$_POST['estado'],$_POST['tipo_comprobante'],$_POST['tc'],$_POST['id_moneda'],$_POST['glosa_principal'],$_POST['id_empresa_comprobante'],
        $_POST['detalles']);//variable array para la tabla detalle_comprobante
        $comprobante->guardarComprobante();
        

    break;

    case 'PUT':
        $_POST =json_decode(file_get_contents('php://input'),true);
        $comprobante = new Comprobante($_POST['id_comprobante']);
        $comprobante->editarComprobante();

    break;
    

        
}





?>