<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../clases/class-crudGestion.php");
//Recibir peticiones de la empresa
switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        $db = mysqli_connect("localhost","root","","erp");

        $_POST =json_decode(file_get_contents('php://input'),true);
        $gestion = new Gestion($_POST["nombre_gestion"],$_POST["fecha_inicio"],$_POST["fecha_fin"],$_POST["estado_gestion"],$_POST["id_empresa_gestion"],$_POST["id_usuario_gestion"]);
        $gestion->guardarGestion();
        

    break;

    case 'DELETE':

        Gestion::eliminarGestion($_GET['id_gestion']);
        
    break;

    case 'PUT':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $gestion = new Gestion($_POST["id_gestion"],$_POST["nombre_gestion"],$_POST["fecha_inicio"],$_POST["fecha_fin"],$_POST["estado_gestion"],$_POST["id_empresa_gestion"],$_POST["id_usuario_gestion"]);
        $gestion->editarGestion();

    break;
    
    case 'PATCH':
        $_POST =json_decode(file_get_contents('php://input'),true);


    break;    

    
        



}





?>