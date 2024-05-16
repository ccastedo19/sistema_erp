<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../clases/class-crudNota.php");
//Recibir peticiones de la empresa
switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        $db = mysqli_connect("localhost","root","","erp");

        $_POST =json_decode(file_get_contents('php://input'),true);
        $nota = new Nota($_POST["nro_nota"],$_POST['descripcion'],$_POST['fecha'],$_POST['id_empresa'],$_POST['lote']);
        $nota->guardarNota();
        

    break;

    case 'PUT':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $nota = new Nota($_POST["id_nota"]);
        $nota->editarNota();

    break;
    

    
        



}





?>