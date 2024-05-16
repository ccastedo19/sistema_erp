<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../clases/class-crudEmpresaMoneda.php");
//Recibir peticiones de la empresa
switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        $db = mysqli_connect("localhost","root","","erp");

        $_POST =json_decode(file_get_contents('php://input'),true);
        $empresaMoneda = new EmpresaMoneda($_POST["cambio"],$_POST["id_empresa_m"],$_POST["id_moneda_principal"],$_POST["id_moneda_alternativa"]);
        $empresaMoneda->guardarEmpresaMoneda();

    break;


}
