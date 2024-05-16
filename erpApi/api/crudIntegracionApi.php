<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../clases/class-crudIntegracion.php");
//Recibir peticiones de la empresa
switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        $db = mysqli_connect("localhost","root","","erp");

        $_POST =json_decode(file_get_contents('php://input'),true);
        $integracion = new Integracion($_POST["id_caja"],$_POST["id_credito"],$_POST["id_debito"],$_POST["id_compra"],$_POST["id_venta"],$_POST["id_it"],$_POST["id_it_pago"],$_POST['id_empresa'], $_POST['activacion']);
        $integracion->guardarIntegracion();
        

    break;  

    
        



}





?>