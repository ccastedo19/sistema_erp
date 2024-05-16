<?php

class Integracion{

    public function guardarIntegracion() {
        include_once '../conexion/bd_directa.php';
        
        $id_caja = $_POST['id_caja'];
        $id_credito = $_POST['id_credito'];
        $id_debito = $_POST['id_debito'];
        $id_compra = $_POST['id_compra'];
        $id_venta = $_POST['id_venta'];
        $id_it = $_POST['id_it'];
        $id_it_pago = $_POST['id_it_pago'];
        $id_empresa  = $_POST['id_empresa'];
        $estado = 1; // El nuevo insert siempre lleva 1
        $activacion = $_POST['activacion'];
    
        // Respuesta
        $response = array();
        $response['succes'] = false;
    
        // Cambiar el estado a 0 en todos los registros de la empresa
        $sql_update = "UPDATE integraciones SET estado = 0 WHERE id_empresa_integracion = '$id_empresa' ";
        $resultado_update = mysqli_query($conexion, $sql_update);
        if ($resultado_update) {
            $response['succes'] = $activacion;
        }else{
            $response['succes'] = "Error: " . $conexion->error;
        }
    
        // Insertar el nuevo registro
        $sql_insert = "INSERT INTO integraciones VALUES (null, '$id_caja', '$id_credito', '$id_debito', '$id_compra', '$id_venta', '$id_it', '$id_it_pago', '$estado', '$activacion', '$id_empresa')";
        $resultado_insert = mysqli_query($conexion, $sql_insert);
    
        if ($resultado_insert) {
            $response['succes'] = $activacion;
        }else{
            $response['succes'] = "Error: " . $conexion->error;
        }

        die(json_encode($response));

    }
    


}







?>