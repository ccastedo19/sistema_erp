<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../clases/class-crudCategoria.php");
//Recibir peticiones de la empresa
switch($_SERVER['REQUEST_METHOD']){
    case 'POST':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $cuenta = new Categoria($_POST["nombre_categoria"],$_POST['descripcion_categoria'] ,$_POST["id_categoria_padre"],$_POST['id_empresa_categoria']);
        $cuenta->guardarCategoria();
        

    break;

    case 'DELETE':
        Categoria::eliminarCategoria($_GET['id_categoria']);
    break;

    case 'PUT':
        $_POST =json_decode(file_get_contents('php://input'),true);
        $cuenta = new Categoria($_POST["id_categoria"],$_POST["nombre_categoria"],$_POST['descripcion_categoria'],$_POST['id_empresa_categoria']);
        $cuenta->editarCategoria();

    break;
    


}





?>