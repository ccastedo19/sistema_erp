<?php

header("Content-Type: application/json/"); //recibir en formato json los "echo"
include_once("../clases/class-crudArticulo.php");
//Recibir peticiones de la empresa
switch($_SERVER['REQUEST_METHOD']){
    case 'POST':

        $_POST =json_decode(file_get_contents('php://input'),true);
        $articulo = new Articulo($_POST["nombre_articulo"],$_POST['descripcion_articulo'] ,$_POST["precio_venta"],$_POST['id_empresa_articulo'],$_POST['id_categorias']);
        $articulo->guardarArticulo();
        

    break;

    case 'DELETE':
        $_POST =json_decode(file_get_contents('php://input'),true);
        $articulo = new Articulo($_POST["id_articulo"]);
        $articulo->eliminarArticulo();
    break;

    case 'PUT':
        $_POST =json_decode(file_get_contents('php://input'),true);
        $articulo = new Articulo($_POST["id_articulo"],$_POST["nombre_articulo"],$_POST['precio_venta'],$_POST['descripcion_articulo'],$_POST['id_empresa_articulo'],$_POST['id_categorias']);
        $articulo->editarArticulo();

    break;
    


}





?>