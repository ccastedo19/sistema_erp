<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../clases/class-login.php");
//Recibir peticiones del usuario
switch($_SERVER['REQUEST_METHOD']){

    case 'POST':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $login = new Login($_POST["usuario"],$_POST['contrasena']);
        $login->loguear();
        
    break;    
        
    case 'PUT':
        $_POST =json_decode(file_get_contents('php://input'),true);
        $login = new Login($_POST["id_usuario"],$_POST['contrasena']);
        $login->encriptar();

    break;

}

?>