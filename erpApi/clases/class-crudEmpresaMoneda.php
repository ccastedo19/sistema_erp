<?php

class EmpresaMoneda{


    public function guardarEmpresaMoneda(){
        //conexion
        include_once '../conexion/bd_directa.php';
        //metodo post
        $cambio = $_POST['cambio'];
        $id_moneda_principal = $_POST['id_moneda_principal'];
        $id_moneda_alternativa = $_POST['id_moneda_alternativa'];
        $id_empresa_m = $_POST["id_empresa_m"];
        //variables directas
        $activo = 1;
        $id_usuario_moneda = 1;

        // Establece la zona horaria de Bolivia
        date_default_timezone_set('America/La_Paz');

        //respuesta
        $response = array();
        $response['succes'] = "";

        //cambiar formato de fecha
        $fecha_registro = date('Y-m-d H:i:s');
    
        //validar que el cambio ingresado no sea el mismo que el ultimo ingresado a la bd
        $ultimoCambioQuery = "SELECT cambio FROM empresa_monedas WHERE id_empresa_m = $id_empresa_m ORDER BY id_empresa_moneda DESC LIMIT 1";
        $resultado = mysqli_query($conexion, $ultimoCambioQuery);
        $row = mysqli_fetch_assoc($resultado);
        $ultimoCambio = $row['cambio'];
    
        if($cambio == $ultimoCambio) {
            $response['succes'] = "cambio";
            die(json_encode($response));
            
        }else{
            // Actualizamos el atributo 'activo' que sea igual a 0 en los demas registros de monedaEmpresa de la misma empresa antes de guardar
            $actualizarActivoQuery = "UPDATE empresa_monedas SET activo = 0 WHERE id_empresa_m = $id_empresa_m";
            mysqli_query($conexion, $actualizarActivoQuery);

            // Insertar los datos en la tabla empresa_monedas
            $query = "INSERT INTO empresa_monedas (fecha_registro, cambio, id_moneda_principal, id_moneda_alternativa, id_empresa_m, activo, id_usuario_moneda) VALUES ('$fecha_registro', '$cambio', '$id_moneda_principal', '$id_moneda_alternativa', '$id_empresa_m', '$activo', '$id_usuario_moneda')";

            $resultado = mysqli_query($conexion, $query);

            if($resultado) {
                $response['succes'] = "guardado";
            }

            die(json_encode($response));
        }

    }

}

?>