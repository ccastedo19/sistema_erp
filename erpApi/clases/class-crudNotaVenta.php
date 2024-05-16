<?php
class Nota{

    public function guardarNotaVenta(){
        include_once '../conexion/bd_directa.php';

        $nro_nota = $_POST['nro_nota'];
        $descripcion = $_POST['descripcion'];
        $fecha = $_POST['fecha'];
        $id_empresa = $_POST['id_empresa'];
        $tipo_nota = "Venta";
        $estado_nota = 1;
        $id_usuario = 1;

        $detalles = $_POST['detalles']; //array

        $response = array();
        $response['succes'] = false;

        $activacion = 0;

        $total_subtotal = 0; // inicializar la suma de los subtotales
        foreach($detalles as $item) {
            $total_subtotal += $item['subtotal']; // sumar el subtotal de este item al total
        }

        //---------------------------------------------------------------------------------------------------------

        //consultamos la cantidad de integraciones en id_empresa antes de inicializar caso por si no tiene ninguna integracion o si tiene y no esta disponible
        $consulta = "SELECT COUNT(*) AS total_empresas FROM integraciones WHERE id_empresa_integracion = $id_empresa";
        $resultado = mysqli_query($conexion, $consulta);
        // Obtener el resultado
        if ($resultado) {
            $fila = mysqli_fetch_assoc($resultado);
            $cantidad_empresa = $fila['total_empresas'];
            if($cantidad_empresa > 0){
                //verificamos si la integración esta activa----------------------
                $sql = "SELECT * FROM integraciones WHERE id_empresa_integracion = '$id_empresa' ORDER BY id_integracion DESC LIMIT 1";
                $resultado = mysqli_query($conexion, $sql);
                if ($resultado) {
                    $ultimo_registro = mysqli_fetch_assoc($resultado);
                    $activacion = $ultimo_registro['activacion'];
                    //verificar si esta activa la integracion
                    if($activacion == 1){
                        //ahora verificamos que la fecha ingresada este dentro de un periodo
                        $sqlPerido = "SELECT p.id_periodo, p.fecha_inicio_periodo, p.fecha_fin_periodo
                                FROM periodos AS p
                                INNER JOIN gestiones AS g ON g.id_gestion = p.id_gestion_periodo
                                WHERE g.id_empresa_gestion = '$id_empresa' AND 
                                '$fecha' BETWEEN p.fecha_inicio_periodo AND p.fecha_fin_periodo AND
                                p.estado_periodo = 1
                            ";
                        $resultadoPeriodo = mysqli_query($conexion, $sqlPerido);

                        if (mysqli_num_rows($resultadoPeriodo) > 0) {
                            //La fecha pertenece a un periodo de la empresa sigue el proceso normal
                        } else {
                            $response['succes'] = "errorPeriodo";
                            die(json_encode($response));
                            exit();
                        }
                    }
                } else {
                    $response['succes'] = "Error: " . mysqli_error($conexion);
                    die(json_encode($response));
                    exit();
                }

            }
        } else {
            echo "Error en la consulta.";
        }

        
        //------------------------------------------------------------------------------------------------------

        
        //realizar comprobante si las integraciones estan activas
        
        if($activacion == 1){
            //verificar si ya hay regitros en la base de datos
            $sqlCantidad = "SELECT COUNT(*) as cantidadComprobante FROM comprobantes WHERE id_empresa_comprobante = '$id_empresa'";
            $resultadoCantidad = mysqli_query($conexion, $sqlCantidad);

            if ($resultadoCantidad) {
                $fila = mysqli_fetch_assoc($resultadoCantidad);
                $cantidadComprobante = $fila['cantidadComprobante'];
                if($cantidadComprobante >= 1){
                    //si hay uno o mas comprobantes en la base de datos incrementamos
                    $sqlSerie = "SELECT * FROM comprobantes WHERE id_empresa_comprobante = '$id_empresa' ORDER BY id_comprobante DESC LIMIT 1";
                    $resultadoSerie = mysqli_query($conexion, $sqlSerie);
                    if ($resultadoSerie) {
                        $ultimo_serie = mysqli_fetch_assoc($resultadoSerie);
                        $serieBD = $ultimo_serie['serie'];
                        $serie = $serieBD + 1;
                    }   
                }else if($cantidadComprobante == 0){
                    //sino la serie seria 1
                    $serie = 1;
                }
                //consultar empresaMoneda para obtener el tipo de cambio y la moneda prinicipal
                $qry = "SELECT * FROM empresa_monedas WHERE id_empresa_m = '$id_empresa' AND activo = 1";
                $run = $conexion -> query($qry);
                $num_rows = 0;
                if($run -> num_rows > 0 ){
                    while($row = $run -> fetch_assoc()){
                        $tc = $row['cambio'];
                        $id_moneda_principal = $row['id_moneda_principal'];
                    }
                } 
                //procedemos a insertar datos a la tabla comprobantes
                $glosa = "Venta de mercaderias";
                $tipo_comprobante = "Ingreso";
                $estado = 1;
                $id_usuario = 1;

                $sqlInsert = "INSERT INTO comprobantes values(null,'$serie','$glosa','$fecha','$tc','$estado','$tipo_comprobante','$id_empresa','$id_usuario','$id_moneda_principal')";
                $resultadoInsert = mysqli_query($conexion,$sqlInsert);
                $ultimo_id_comprobante = mysqli_insert_id($conexion);
                if($resultadoInsert){
                    //consultamos los id_cuenta y nombre_cuenta de la integracion
                    $sqlCuenta = "SELECT caja,debito_fiscal,venta,it,it_pago FROM integraciones WHERE id_empresa_integracion = '$id_empresa' AND estado = 1";

                    $run = $conexion -> query($sqlCuenta);
                    $num_rows = 0;
                    if($run -> num_rows > 0 ){
                        while($row = $run -> fetch_assoc()){
                            $id_caja = $row['caja'];
                            $id_debito_fiscal = $row['debito_fiscal'];
                            $id_venta = $row['venta'];
                            $id_it = $row['it'];
                            $id_it_pago = $row['it_pago'];
                        }
                    } 
                //insertamos en detalle comprobante
                $monto_caja = $total_subtotal;
                $sql1 = "INSERT INTO detalle_comprobantes values(null,1,'$glosa','$monto_caja',0,0,0,'$id_usuario','$ultimo_id_comprobante','$id_caja')";
                $resultadoSql1 = mysqli_query($conexion,$sql1);

                $monto_it = $total_subtotal * 0.3;
                $sql2 = "INSERT INTO detalle_comprobantes values(null,2,'$glosa','$monto_it',0,0,0,'$id_usuario','$ultimo_id_comprobante','$id_it')";
                $resultadoSql2 = mysqli_query($conexion,$sql2);

                $monto_debito_fiscal = $total_subtotal * 0.13;
                $sql3 = "INSERT INTO detalle_comprobantes values(null,3,'$glosa',0,'$monto_debito_fiscal',0,0,'$id_usuario','$ultimo_id_comprobante','$id_debito_fiscal')";
                $resultadoSql3 = mysqli_query($conexion,$sql3);
                
                $monto_venta = $monto_caja - $monto_debito_fiscal;
                $sql4 = "INSERT INTO detalle_comprobantes values(null,3,'$glosa',0,'$monto_venta',0,0,'$id_usuario','$ultimo_id_comprobante','$id_venta')";
                $resultadoSql4 = mysqli_query($conexion,$sql4);

                $monto_it_pago = $total_subtotal * 0.3;
                $sql5 = "INSERT INTO detalle_comprobantes values(null,3,'$glosa',0,'$monto_it_pago',0,0,'$id_usuario','$ultimo_id_comprobante','$id_it_pago')";
                $resultadoSql5 = mysqli_query($conexion,$sql5);

                }

            } 

        }


        //---------------------------------------------------------------------------------------------------------
        //restar en stock(lotes)
        foreach ($detalles as $detalle) {
            // Extraer los valores del detalle
            $articulo = $detalle['idArticulo'];
            $nroLote = $detalle['nroLote']; //id_lote
            $cantidad = $detalle['cantidad'];
            $precio = $detalle['precio'];
        
            $sqlArticulo1 = "SELECT id_lote, stock FROM lotes WHERE id_lote = $nroLote";
            $run = $conexion -> query($sqlArticulo1);
            $num_rows = 0;
            if($run -> num_rows > 0 ){
                while($row = $run -> fetch_assoc()){
                    $stockBD = $row['stock'];
                    $id_lote = $row['id_lote'];
                }
            } 
            $nuevoStock = $stockBD - $cantidad;
            $sqlArticulo1 = "UPDATE lotes SET stock = $nuevoStock WHERE id_lote = $id_lote";
            $resultado = mysqli_query($conexion,$sqlArticulo1);
            if($resultado){
                // Si el stock es 0, actualizar el estado del lote a 2
                if ($nuevoStock == 0) {
                    $sqlUpdateEstadoLote = "UPDATE lotes SET estado_lote = 2 WHERE id_lote = $id_lote";
                    $resultadoEstadoLote = mysqli_query($conexion, $sqlUpdateEstadoLote);
                    if(!$resultadoEstadoLote){
                        $response['succes'] = "errorEstadoLote";
                        die(json_encode($response));
                        exit();
                    }
                }
            }else{
                $response['succes'] = "errorCantidadLote";
                die(json_encode($response));
                exit();
            }
        }
        

        //restar en cantidad(articulos)
        foreach ($detalles as $detalle) {
            // Extraer los valores del detalle
            $articulo = $detalle['idArticulo'];
            $nroLote = $detalle['nroLote'];
            $cantidad = $detalle['cantidad'];
            $precio = $detalle['precio'];

            $sqlArticulo1 = "SELECT cantidad FROM articulos WHERE id_articulo = $articulo";
            $run = $conexion -> query($sqlArticulo1);
            $num_rows = 0;
            if($run -> num_rows > 0 ){
                while($row = $run -> fetch_assoc()){
                    $cantidadBD = $row['cantidad'];
                }
            } 
            $nuevaCantidad = $cantidadBD - $cantidad;
            $sqlArticulo2 = "UPDATE articulos SET cantidad = $nuevaCantidad WHERE id_articulo = $articulo";
            $resultado = mysqli_query($conexion,$sqlArticulo2);
            if($resultado){
                //todo bien
            }else{
                $response['succes'] = "errorCantidadArticulo";
                die(json_encode($response));
                exit();
            }
        }

        //insertamos
        if($activacion == 1){
            $sqlNota = "INSERT INTO notas(nro_nota,fecha_nota,descripcion,total_nota,tipo_nota,estado_nota,id_empresa_nota,id_usuario_nota,id_comprobante_nota) VALUES('$nro_nota','$fecha','$descripcion','$total_subtotal','$tipo_nota','$estado_nota','$id_empresa','$id_usuario','$ultimo_id_comprobante')";
        }else{
            $sqlNota = "INSERT INTO notas(nro_nota,fecha_nota,descripcion,total_nota,tipo_nota,estado_nota,id_empresa_nota,id_usuario_nota,id_comprobante_nota) VALUES('$nro_nota','$fecha','$descripcion','$total_subtotal','$tipo_nota','$estado_nota','$id_empresa','$id_usuario',null)";
        }
        

        $resultado = mysqli_query($conexion,$sqlNota);
        $id_nota = mysqli_insert_id($conexion);
        if ($resultado) {
            // Recorrer cada detalle y insertarlo en la base de datos
            foreach ($detalles as $detalle) {
                // Extraer los valores del detalle
                $articulo = $detalle['idArticulo'];
                $nroLote = $detalle['nroLote'];
                $cantidad = $detalle['cantidad'];
                $precio = $detalle['precio'];

                
        
                // Preparar la sentencia SQL
                $sql = "INSERT INTO detalles (id_nota_detalle, id_articulo_detalle, id_lote_detalle, cantidad, precio_venta) 
                        VALUES ($id_nota, $articulo, '$nroLote', $cantidad, $precio)";
        
                // Ejecutar la sentencia
                if (mysqli_query($conexion, $sql)) {
                    $response['succes'] = $id_nota;
                } else {
                    echo 'Error al insertar detalle: ' . mysqli_error($conexion);
                    exit;
                }
            }
        
        } else {
            echo 'Error al insertar datos en nota: ' . mysqli_error($conexion);
        }
        
        die(json_encode($response));


    }

public function editarNotaVenta(){
    include_once '../conexion/bd_directa.php';

    $id_nota = $_POST['id_nota']; //unico variable de llegada
    $response = array();
    $response['succes'] = false;

    // Consultar cantidad de detalles
    $sqlDetalle = "SELECT id_articulo_detalle, cantidad, id_lote_detalle FROM detalles WHERE id_nota_detalle = $id_nota";
    $resultDetalle = $conexion->query($sqlDetalle);

    // Por cada detalle...
    while($detalle = $resultDetalle->fetch_assoc()) {
        // Obtener los valores actuales de los lotes y los articulos
        $sqlArticulo = "SELECT id_articulo, cantidad FROM articulos WHERE id_articulo = " . $detalle['id_articulo_detalle'];
        $resultArticulo = $conexion->query($sqlArticulo);
        $articulo = $resultArticulo->fetch_assoc();

    

        $sqlLote = "SELECT id_lote, stock FROM lotes WHERE id_articulo_lote = " . $detalle['id_articulo_detalle'] . " AND id_lote = " . $detalle['id_lote_detalle'];
        $resultLote = $conexion->query($sqlLote);
        $lote = $resultLote->fetch_assoc();

        // Calcular los nuevos valores
        $nuevoStockLote = $lote['stock'] + $detalle['cantidad'];
        $nuevaCantidadArticulo = $articulo['cantidad'] + $detalle['cantidad'];

        // Actualizar los lotes y los articulos
        $sqlUpdateArticulo = "UPDATE articulos SET cantidad = $nuevaCantidadArticulo WHERE id_articulo = " . $articulo['id_articulo'];
        $resultadoArticulo = mysqli_query($conexion, $sqlUpdateArticulo);

        if(!$resultadoArticulo){
            $response['succes'] = "errorCantidadArticulo";
            die(json_encode($response));
            exit();
        }

        $sqlUpdateLote = "UPDATE lotes SET stock = $nuevoStockLote WHERE id_lote = " . $lote['id_lote'];
        $resultadoLote = mysqli_query($conexion, $sqlUpdateLote);

        if(!$resultadoLote){
            $response['succes'] = "errorCantidadLote";
            die(json_encode($response));
            exit();
        }
    }

    //consultar si la nota de venta tiene id_comprobante para anularlar tambien
    $sqlConsulta = "SELECT id_comprobante_nota FROM notas WHERE id_nota = '$id_nota'";
        $run = $conexion -> query($sqlConsulta);
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                $id_comprobante = $row['id_comprobante_nota'];
            }
        }  
        if($id_comprobante > 0){
            //que si tiene un id_comprobante en la nota
            //anulamos 
            $sql = "UPDATE comprobantes SET estado = 0 WHERE id_comprobante = '$id_comprobante'";
            $resultado = mysqli_query($conexion,$sql);
            if($resultado){
                $response['succes'] = true;
            }else{
                $response['succes'] = false;
            }
        }
    //------------------------------------------------------------------------------


    // Actualizar el estado de la nota
    $sql = "UPDATE notas SET estado_nota = 0 WHERE id_nota = $id_nota";
    $resultado = mysqli_query($conexion,$sql);

    if($resultado){
        $response['succes'] = true;
    }else{
        $response['succes'] = false;
    }

    die(json_encode($response));
}
    

}


?>