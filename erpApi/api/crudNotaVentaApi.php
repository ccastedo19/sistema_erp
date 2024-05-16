<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../clases/class-crudNotaVenta.php");
//Recibir peticiones de la empresa
switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        $db = mysqli_connect("localhost","root","","erp");

        $_POST =json_decode(file_get_contents('php://input'),true);
        $nota = new Nota($_POST["nro_nota"],$_POST['descripcion'],$_POST['fecha'],$_POST['id_empresa'],$_POST['detalles']);
        $nota->guardarNotaVenta();
        

    break;

    case 'PUT':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $nota = new Nota($_POST["id_nota"]);
        $nota->editarNotaVenta();

    break;
    

    
        



}





?>