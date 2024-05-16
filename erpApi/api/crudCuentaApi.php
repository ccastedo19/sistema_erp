<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../clases/class-crudCuenta.php");
//Recibir peticiones de la empresa
switch($_SERVER['REQUEST_METHOD']){
    case 'POST':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $cuenta = new Cuenta($_POST["nombre_cuenta"],$_POST["id_cuenta_padre"],$_POST['id_empresa_cuenta']);
        $cuenta->guardarCuenta();
        

    break;

    case 'DELETE':
        Cuenta::eliminarCuenta($_GET['id_cuenta']);
    break;

    case 'PUT':
        $_POST =json_decode(file_get_contents('php://input'),true);
        $cuenta = new Cuenta($_POST["id_cuenta"],$_POST["nombre_cuenta"],$_POST['id_empresa_cuenta']);
        $cuenta->editarCuenta();

    break;
    


}





?>