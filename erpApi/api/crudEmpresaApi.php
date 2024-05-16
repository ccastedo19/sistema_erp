<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../clases/class-crudEmpresa.php");
//Recibir peticiones de la empresa
switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        $db = mysqli_connect("localhost","root","","erp");

        $_POST =json_decode(file_get_contents('php://input'),true);
        $empresa = new Empresa($_POST["nombre_empresa"],$_POST["sigla"],$_POST["nit"],$_POST["correo"],$_POST["telefono"],$_POST["direccion"],$_POST["nivel"],$_POST["estado"],$_POST["id_usuario_empresa"],$_POST['id_moneda_principal']);
        $empresa->guardarEmpresa();
        //$resultado['mensaje']="Guardar empresa, informacion: ".json_encode($_POST);
        //echo json_encode($resultado);


    break;

    case 'DELETE':
        
        Empresa::eliminarEmpresa($_GET['id_empresa']);

    break;

    case 'PUT':
        $db = mysqli_connect("localhost","root","","erp");
        
        $_POST =json_decode(file_get_contents('php://input'),true);
        $empresa = new Empresa($_POST["id_empresa"],$_POST["nombre_empresa"],$_POST["nit"],$_POST["sigla"],$_POST["telefono"],$_POST["correo"],$_POST["direccion"],$_POST["nivel"],$_POST["estado"],$_POST["id_usuario_empresa"]);
        $empresa->editarEmpresa();
        //$resultado['mensaje']="actualizar empresa, informacion: ".json_encode($_POST);
        //echo json_encode($resultado);

    break;
    
    case 'GET':
        function conexion(){
            return mysqli_connect('localhost','root','','erp');
        }        
        $conexion = conexion();
        $sql = "SELECT * FROM empresas";
        $resultado = mysqli_query($conexion,$sql);
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);

        if(!empty($datos)){
            echo json_encode($datos);
        }else{
            echo json_encode([]);
        } 

        
    break;      
        



}





?>