<?php

class Categoria{

    public function guardarCategoria(){
        include_once '../conexion/bd_directa.php';
        //datos traidos de POST
        $nombre_categoria = $_POST['nombre_categoria'];
        $id_categoria_padre = $_POST['id_categoria_padre'];
        $descripcion_categoria = $_POST['descripcion_categoria'];
        $id_empresa_categoria = $_POST['id_empresa_categoria']; //id_empresa
        $id_usuario_categoria = 1;
        
        //respuesta
        $response = array();
        $response['succes'] = false;
    
        // Convertir nombre_categoria a minúsculas para asegurar que la comparación no sea sensible a mayúsculas y minúsculas
        $nombre_categoria_lower = strtolower($nombre_categoria);
    
        // Consulta para verificar si el nombre_categoria ya existe en la misma empresa
        $sqlCheck = "SELECT * FROM categorias WHERE LOWER(nombre_categoria) = '$nombre_categoria_lower' AND id_empresa_categoria = $id_empresa_categoria";
        $queryCheck = mysqli_query($conexion, $sqlCheck);

        if(mysqli_num_rows($queryCheck) > 0){
            // Si el resultado es mayor que 0, significa que ya existe un nombre_categoria en la misma empresa
            $response['succes'] = false;
        }else{
            if($id_categoria_padre == 0){
                $sqlInsert = "INSERT INTO categorias (nombre_categoria,descripcion_categoria ,id_categoria_padre, id_usuario_categoria, id_empresa_categoria) VALUES ('$nombre_categoria','$descripcion_categoria', NULL,'$id_usuario_categoria', '$id_empresa_categoria')";
                if(mysqli_query($conexion, $sqlInsert)){
                    $response['succes'] = true;
                }else{
                    $response['succes'] = false;
                }
            }else{
                $sqlInsert = "INSERT INTO categorias (nombre_categoria,descripcion_categoria ,id_categoria_padre, id_usuario_categoria, id_empresa_categoria) VALUES ('$nombre_categoria','$descripcion_categoria', '$id_categoria_padre', '$id_usuario_categoria', '$id_empresa_categoria')";
                if(mysqli_query($conexion, $sqlInsert)){
                    $response['succes'] = true;
                }else{
                    $response['succes'] = false;
                }
            }


            
        }
        die(json_encode($response));
    }
    
    public static function eliminarCategoria($indice){
        include_once '../conexion/bd_directa.php';
        $response = array();
        $response['succes'] = false;

        $cont1 = 0;
        $cont2 = 0;
        //validar que exista en la bd de la empresa
        $qry = "SELECT * FROM categorias WHERE id_categoria = $indice";
        $run = $conexion -> query($qry);
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                $nombre_categoria = $row['nombre_categoria'];
                $id_empresa_categoria = $row['id_empresa_categoria'];
            }
        }
    
        // Verificar si el id_categoria se usa en la tabla 'articulos'
        $qryArticulos = "SELECT COUNT(*) as count FROM articulo_categorias WHERE id_categoria_ca = $indice";
        $resultArticulos = mysqli_query($conexion, $qryArticulos);
        if ($resultArticulos) {
            $rowArticulos = mysqli_fetch_assoc($resultArticulos);
            if ($rowArticulos['count'] > 0) {
                $cont1 = $cont1 + 1;
            }
        }
    
        //validar que no se este usando su id en otro elemento de la tabla de id_categoria_padre(relacion con id_categoria) o que no tenga relacion 
        $qry = "SELECT COUNT(*) as count FROM categorias WHERE id_categoria_padre = $indice";
        $result = mysqli_query($conexion, $qry);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row['count'] > 0) {
                $cantidad = $row['count'];
                // El ID de cuenta se está utilizando en otros elementos de la tabla de id_categoria_padre, por lo que no se puede eliminar
                $cont2 = $cont2 + 1;   
            }
        }   
        
        if ($cont1 == 0 && $cont2 == 0){
            $qry = "DELETE FROM categorias WHERE id_categoria = $indice";
            $result = mysqli_query($conexion, $qry);
            $response['succes'] = true;
            die(json_encode($response));
            exit();

        }else if($cont1 > 0 && $cont2 == 0){
            $response['succes'] = "idRelacion";
            die(json_encode($response));
            exit();
        }else if($cont1 == 0 && $cont2 > 0){
            $response['succes'] = "conHijo";
            die(json_encode($response));
            exit();
        }else if($cont1 > 0 && $cont2 > 0){
            $response['succes'] = "conHijo&Relacion";
            die(json_encode($response));
            exit();
        }



    }
    

    public function editarCategoria(){
        include_once '../conexion/bd_directa.php';
        //datos traidos de POST
        $id_categoria = $_POST['id_categoria'];
        $nombre_categoria = $_POST['nombre_categoria'];
        $descripcion_categoria = $_POST['descripcion_categoria'];
        $id_empresa_categoria = $_POST['id_empresa_categoria']; //id_empresa
        
        //respuesta
        $response = array();
        $response['succes'] = false;

        //consulta datos
        $sql = "SELECT nombre_categoria, descripcion_categoria FROM categorias WHERE id_categoria = '$id_categoria'";
        $run = $conexion -> query($sql);
        $num_rows = 0;
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                $nombre_categoriaR = $row['nombre_categoria'];
                $descripcion_categoriaR = $row['descripcion_categoria'];
            }
        } 
        //verficar si los datos son los mismos
        if($nombre_categoriaR == $nombre_categoria && $descripcion_categoria == $descripcion_categoriaR){
            $response['succes'] = "igual";
            die(json_encode($response));
            exit();
        }
    
        // Convertir nombre_categoria a minúsculas para asegurar que la comparación no sea sensible a mayúsculas y minúsculas
        $nombre_categoria_lower = strtolower($nombre_categoria);
    
        // Consulta para verificar si el nombre_categoria ya existe en la misma empresa
        $sqlCheck = "SELECT * FROM categorias WHERE LOWER(nombre_categoria) = '$nombre_categoria_lower' AND id_empresa_categoria = $id_empresa_categoria";
        $queryCheck = mysqli_query($conexion, $sqlCheck);

        if(mysqli_num_rows($queryCheck) > 0){
            // Si el resultado es mayor que 0, significa que ya existe un nombre_categoria en la misma empresa
            $response['succes'] = false;
        }else{
            $sqlUpdate = "UPDATE categorias SET nombre_categoria = '$nombre_categoria', descripcion_categoria = '$descripcion_categoria' WHERE id_categoria = $id_categoria";
            if(mysqli_query($conexion, $sqlUpdate)){
                $response['succes'] = true;
            }else{
                $response['succes'] = false;
                die(json_encode('error al actualizar en sql SQL'));
            }
        }
            
        die(json_encode($response));

    }




}



?>