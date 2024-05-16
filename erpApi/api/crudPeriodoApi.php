<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../clases/class-crudPeriodo.php");
//Recibir peticiones de la empresa
switch($_SERVER['REQUEST_METHOD']){
    case 'POST':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $periodo = new Periodo($_POST["nombre_periodo"],$_POST["fecha_inicio_periodo"],$_POST['fecha_fin_periodo'],$_POST['estado_periodo'],$_POST['id_usuario_periodo'],$_POST['id_gestion_periodo']);
        $periodo->guardarPeriodo();
        

    break;

    case 'DELETE':

        Periodo::eliminarPeriodo($_GET['id_periodo']);
        
    break;

    case 'PUT':
        $_POST =json_decode(file_get_contents('php://input'),true);
        $periodo = new Periodo($_POST["id_periodo"],$_POST["nombre_periodo"],$_POST["fecha_inicio_periodo"],$_POST['fecha_fin_periodo'],$_POST['estado_periodo'],$_POST['id_usuario_periodo'],$_POST['id_gestion_periodo']);
        $periodo->editarPeriodo();

    break;
    

 
        



}





?>