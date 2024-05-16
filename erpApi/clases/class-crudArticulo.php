<?php
class Articulo{

    public function guardarArticulo(){
        include_once '../conexion/bd_directa.php';
        //datos llegada
        $nombre_articulo = $_POST['nombre_articulo'];
        $descripcion_articulo = $_POST['descripcion_articulo'];
        $precio_venta = $_POST['precio_venta'];
        $id_empresa = $_POST['id_empresa_articulo'];
        $estado_articulo = 1;
        $cantidad = 0;
        $id_usuario = 1;
        //dato para doble Art Cat
        $id_categorias = $_POST['id_categorias'];
        $totalCat = count($id_categorias);

        //respuesta
        $response = array();
        $response['succes'] = false;

        // Verificar si el nombre del artículo ya existe en la base de datos para la misma empresa
        $consulta = "SELECT COUNT(*) AS total FROM articulos WHERE nombre_articulo = '$nombre_articulo' AND id_empresa_articulo = '$id_empresa'";
        $resultado = mysqli_query($conexion, $consulta);
        $fila = mysqli_fetch_assoc($resultado);
        $total = $fila['total'];

        if($total > 0){
            $response['succes'] = false;
        } else {
            $response['succes'] = true;
            $sql = "INSERT INTO articulos (nombre_articulo, descripcion_articulo, cantidad, precio_venta,estado_articulo, id_empresa_articulo, id_usuario_articulo) values('$nombre_articulo', '$descripcion_articulo','$cantidad','$precio_venta','$estado_articulo','$id_empresa','$id_usuario')";
            if(mysqli_query($conexion, $sql)){
                $response['succes'] = true;
            }else{
                $response['succes'] = false;
            }
        }
        //rescatamos el id del articulo
        $ultimo_id_articulo = mysqli_insert_id($conexion);

        if ($response['succes'] == true){
            for ($i = 0; $i < $totalCat; $i++) {
                $idCategoria = $id_categorias[$i];
                $sqlC = "INSERT INTO articulo_categorias (id_articulo_ca, id_categoria_ca) values ('$ultimo_id_articulo','$idCategoria')";
                if(mysqli_query($conexion, $sqlC)){
                    $response['succes'] = true;
                }else{
                    $response['succes'] = false;
                }
            }
        }

        die(json_encode($response));

        
    }


    public function eliminarArticulo(){
        include_once '../conexion/bd_directa.php';
        $id_articulo = $_POST['id_articulo'];
        $response=array();
        $response['succes'] = false;

        //verificar si articulo tiene lotes
        $sql = "SELECT COUNT(*) as total FROM lotes WHERE id_articulo_lote = '$id_articulo'";
        $result = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_assoc($result);
        $total = $row['total'];
        if ($total > 0) {
            //El artículo con id $id_articulo se encuentra en la tabla lotes
            $response['succes'] = "errorLote";
            die(json_encode($response));
            exit();
        } else {
            //El artículo con id $id_articulo no se encuentra en la tabla lotes
        }
        //---------------------------------------------------------------------------------------
        //eliminar primero las categorias del articulo
        $sqlEliminar = "DELETE FROM articulo_categorias WHERE id_articulo_ca = '$id_articulo'";
        $resultado = mysqli_query($conexion, $sqlEliminar);
        if($resultado){
            //procedemos a eliminar de la tabla articulos
            $sqlArticulo = "DELETE FROM articulos WHERE id_articulo = '$id_articulo'";
            $resultado = mysqli_query($conexion,$sqlArticulo);
            if($resultado){
                $response['succes'] = true;
            }else{
                $response['succes'] = false;
            }
        }else{
            $response['succes'] = false;
        }

        die(json_encode($response));

    }


    public function editarArticulo()
    {
        include_once '../conexion/bd_directa.php';

        // Traída de datos
        $id_articulo = $_POST['id_articulo'];
        $nombre_articulo = $_POST['nombre_articulo'];
        $descripcion_articulo = $_POST['descripcion_articulo'];
        $precio_venta = $_POST['precio_venta'];
        $id_empresa = $_POST['id_empresa_articulo'];
        $id_categorias = $_POST['id_categorias'];//array

        // Respuesta
        $response = array();
        $response['succes'] = false;

        // Verificar si el nombre del artículo ya existe en la base de datos para el mismo id_articulo
        $consulta = "SELECT COUNT(*) AS total FROM articulos WHERE nombre_articulo = '$nombre_articulo' AND id_articulo != '$id_articulo'";
        $resultado = mysqli_query($conexion, $consulta);
        $fila = mysqli_fetch_assoc($resultado);
        $total = $fila['total'];

        if ($total > 0) {
            $response['succes'] = false;
        } else {
            $response['succes'] = true;
            $sql = "UPDATE articulos SET nombre_articulo = '$nombre_articulo', descripcion_articulo = '$descripcion_articulo', precio_venta = '$precio_venta' WHERE id_articulo = '$id_articulo' AND id_empresa_articulo = '$id_empresa'";
            if (mysqli_query($conexion, $sql)) {
                $response['succes'] = true;
            }

            //eliminamos todas las categorias del articulo:
            $sql = "DELETE FROM articulo_categorias WHERE id_articulo_ca = $id_articulo";
            if (mysqli_query($conexion, $sql)) {
                $response['succes'] = true;
            } else {
                $response['succes'] = false;
            }

            // Insertar las nuevas categorías del artículo
            foreach ($id_categorias as $id_categoria) {
                $sql = "INSERT INTO articulo_categorias (id_articulo_ca, id_categoria_ca) VALUES ($id_articulo, $id_categoria)";
                if (!mysqli_query($conexion, $sql)) {
                    $response['succes'] = false;
                    break;
                }
            }

        }

        die(json_encode($response));
    }



}




?>