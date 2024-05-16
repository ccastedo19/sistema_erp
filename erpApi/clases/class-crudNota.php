<?php
class Nota{

    public function guardarNota(){
        include_once '../conexion/bd_directa.php';

        $nro_nota = $_POST['nro_nota'];
        $descripcion = $_POST['descripcion'];
        $fecha = $_POST['fecha'];
        $id_empresa = $_POST['id_empresa'];
        $tipo_nota = "Compra";
        $estado_nota = 1;
        $id_usuario = 1;

        $lote = $_POST['lote'];

        $response = array();
        $response['succes'] = false;

        $activacion = 0;

        //OBTENER EL TOTAL
        $total_subtotal = 0; // inicializar la suma de los subtotales
        foreach($lote as $item) {
            $total_subtotal += $item['subtotal']; // sumar el subtotal de este item al total
        }


        //verificamos si la integración esta activa----------------------
        $consulta = "SELECT COUNT(*) AS total_empresas FROM integraciones WHERE id_empresa_integracion = $id_empresa";//verificamos la cantidad de id_empresa en integracion
        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
            $fila = mysqli_fetch_assoc($resultado);
            $cantidad_empresa = $fila['total_empresas'];
            if($cantidad_empresa > 0){
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

                //------------------------------------------------------------------------------------------------------
                
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
                        $glosa = "Compra de mercaderias";
                        $tipo_comprobante = "Egreso";
                        $estado = 1;
                        $id_usuario = 1;

                        $sqlInsert = "INSERT INTO comprobantes values(null,'$serie','$glosa','$fecha','$tc','$estado','$tipo_comprobante','$id_empresa','$id_usuario','$id_moneda_principal')";
                        $resultadoInsert = mysqli_query($conexion,$sqlInsert);
                        $ultimo_id_comprobante = mysqli_insert_id($conexion);
                        if($resultadoInsert){
                            //consultamos los id_cuenta y nombre_cuenta de la integracion
                            $sqlCuenta = "SELECT caja,credito_fiscal,compra FROM integraciones WHERE id_empresa_integracion = '$id_empresa' AND estado = 1";

                            $run = $conexion -> query($sqlCuenta);
                            $num_rows = 0;
                            if($run -> num_rows > 0 ){
                                while($row = $run -> fetch_assoc()){
                                    $id_caja = $row['caja'];
                                    $id_credito_fiscal = $row['credito_fiscal'];
                                    $id_compra = $row['compra'];
                                }
                            } 
                        //insertamos en detalle comprobante
                        $monto_credito_fiscal = $total_subtotal * 0.13;
                        $sql1 = "INSERT INTO detalle_comprobantes values(null,1,'$glosa','$monto_credito_fiscal',0,0,0,'$id_usuario','$ultimo_id_comprobante','$id_credito_fiscal')";
                        $resultadoSql1 = mysqli_query($conexion,$sql1);
                        
                        $monto_compras = $total_subtotal - $monto_credito_fiscal;
                        $sql2 = "INSERT INTO detalle_comprobantes values(null,2,'$glosa','$monto_compras',0,0,0,'$id_usuario','$ultimo_id_comprobante','$id_compra')";
                        $resultadoSql2 = mysqli_query($conexion,$sql2);

                        $monto_caja = $total_subtotal;
                        $sql3 = "INSERT INTO detalle_comprobantes values(null,3,'$glosa',0,'$monto_caja',0,0,'$id_usuario','$ultimo_id_comprobante','$id_caja')";
                        $resultadoSql3 = mysqli_query($conexion,$sql3);

                        }

                    } 

                }    

            }else{
                //abandonar integraciones
            }

        } else {
            echo "Error en la consulta.";
        }


    

        //------------------------------------------------------------------------------------------------------

        //insertamos
        if($activacion == 1){
            $sqlNota = "INSERT INTO notas(nro_nota,fecha_nota,descripcion,total_nota,tipo_nota,estado_nota,id_empresa_nota,id_usuario_nota,id_comprobante_nota) VALUES('$nro_nota','$fecha','$descripcion','$total_subtotal','$tipo_nota','$estado_nota','$id_empresa','$id_usuario','$ultimo_id_comprobante')";
        }else{
            $sqlNota = "INSERT INTO notas(nro_nota,fecha_nota,descripcion,total_nota,tipo_nota,estado_nota,id_empresa_nota,id_usuario_nota,id_comprobante_nota) VALUES('$nro_nota','$fecha','$descripcion','$total_subtotal','$tipo_nota','$estado_nota','$id_empresa','$id_usuario',null)";
        }
        
        $resultado = mysqli_query($conexion,$sqlNota);
        if($resultado){
            //realizar el registro del lote (array)
            $fecha_ingreso = $fecha;
            $estado_lote = 1;
            $id_nota = mysqli_insert_id($conexion);
            
            foreach($lote as $item) {
                // Obtener el id_articulo actual
                $id_articulo_lote_actual = $item['id_articulo'];

                // Consulta para obtener el último nro_lote de este artículo
                $query = "SELECT MAX(nro_lote) AS ultimo_lote FROM lotes WHERE id_articulo_lote = $id_articulo_lote_actual";

                // Ejecutar la consulta
                $result = mysqli_query($conexion, $query);

                // Obtener el resultado
                $fila = mysqli_fetch_assoc($result);

                // Si el resultado es NULL, entonces es la primera vez que este artículo está siendo loteado
                // por lo tanto, establecer nro_lote a 1, de lo contrario, incrementar el último nro_lote en 1
                $nro_lote = $fila['ultimo_lote'] === NULL ? 1 : $fila['ultimo_lote'] + 1;

                $fechaVenc = empty($item['fechaVenc']) ? "NULL" : $item['fechaVenc']; // si la fecha está vacía, insertar NULL
                $sql = "INSERT INTO lotes (nro_lote, fecha_ingreso, fecha_vencimiento, cantidad_lote, precio_compra, stock, estado_lote, id_articulo_lote, id_nota_lote) VALUES 
                        ('$nro_lote', '$fecha_ingreso', '$fechaVenc', ".$item['cantidad'].", ".$item['precio'].", ".$item['cantidad']." , '$estado_lote', ".$item['id_articulo'].",'$id_nota')";
            
                $resultado2 = mysqli_query($conexion,$sql);
                if($resultado2){
                    $response ['succes'] = $id_nota;
                }else{
                    echo 'Error al insertar datos en lotes: ' . mysqli_error($conexion);
                }

                $id_articulo_actual = $item['id_articulo'];
                $cantidad_actual = $item['cantidad'];
                //consultar articulo
                $sqlConsulta = "SELECT cantidad FROM articulos WHERE id_articulo = $id_articulo_actual";
                $run = $conexion -> query($sqlConsulta);
                $num_rows = 0;
                if($run -> num_rows > 0 ){
                    while($row = $run -> fetch_assoc()){
                        $cantidadArticulo = $row['cantidad'];
                    }
                } 
                $nuevaCantidadArticulo = $cantidadArticulo + $cantidad_actual;

                $sqlArticulo = "UPDATE articulos SET cantidad = $nuevaCantidadArticulo WHERE id_articulo = $id_articulo_actual";
                $resultado3 = mysqli_query($conexion,$sqlArticulo);
                if($resultado3){
                    $response ['succes'] = $id_nota;
                }else{
                    echo 'Error al insertar datos en articulos: ' . mysqli_error($conexion);
                }
            }
            

        }else{
            echo 'Error al insertar datos en nota: ' . mysqli_error($conexion);
        }

        


        die(json_encode($response));

    }

    public function editarNota(){
        include_once '../conexion/bd_directa.php';

        $id_nota = $_POST['id_nota'];
        $response = array();
        $response['succes'] = false;

        //la nota de compra no se podra anular si uno de sus lotes ya fue vendido
        $sqlConsultaLotes = "SELECT id_lote FROM lotes WHERE id_nota_lote = '$id_nota'";//consultamos los lotes de la nota de compra
        $run = $conexion -> query($sqlConsultaLotes);
        $num_rows = 0;
        $contVenta = 0;
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                $id_lote = $row['id_lote'];
                //verificar id_lote que este en la tabla detalles
                $sql = "SELECT COUNT(*) AS count
                FROM lotes 
                INNER JOIN detalles ON lotes.id_lote = detalles.id_lote_detalle WHERE lotes.id_lote = '$id_lote'";
                $resultado = $conexion->query($sql);
                $row = $resultado->fetch_assoc();
                if($row['count'] > 0) {
                    //el lote esta en la tabla detalles
                    $contVenta = $contVenta + 1;
                } else {
                    //el lote no esta en la tabla detalles
                }
            }
        }
        if($contVenta >= 1){
            $response['succes'] = "errorLoteVendido";
            die(json_encode($response));
            exit();
        }
        

        //----------------------------------------------------------------------------

        //consultar los lotes para verificar si stock y cantidad son iguales
        $sqlLote = "SELECT cantidad_lote, stock FROM lotes WHERE id_nota_lote = $id_nota AND estado_lote = 1";
        $cont = 0;
        $run = $conexion -> query($sqlLote);
            $num_rows = 0;
            if($run -> num_rows > 0 ){
                while($row = $run -> fetch_assoc()){
                    $cantidad_lote = $row['cantidad_lote'];
                    $stock = $row['stock'];
                    if($cantidad_lote !== $stock){
                        if($cantidad_lote == 0 && $stock == 0){

                        }else{
                            $cont = $cont + 1; 
                        }
                        
                    }
                }
            } 
        if($cont >= 1){
            $response['succes'] = "errorLote";
        }else{
            // Primero, obtén todos los lotes relacionados con la nota
            $sqlLote2 = "SELECT cantidad_lote, id_articulo_lote FROM lotes WHERE id_nota_lote = $id_nota";
            $resultLote2 = $conexion->query($sqlLote2);

            // Para cada lote...
            while($lote = $resultLote2->fetch_assoc()) {
                // Obtén la información actual del artículo
                $sqlArticulo = "SELECT id_articulo, cantidad FROM articulos WHERE id_articulo = " . $lote['id_articulo_lote'];
                $resultArticulo = $conexion->query($sqlArticulo);
                $articulo = $resultArticulo->fetch_assoc();

                // Resta la cantidad del lote a la cantidad del artículo
                $nuevaCantidadArticulo = $articulo['cantidad'] - $lote['cantidad_lote'];

                // Actualiza la cantidad del artículo
                $sqlUpdateArticulo = "UPDATE articulos SET cantidad = $nuevaCantidadArticulo WHERE id_articulo = " . $articulo['id_articulo'];
                $resultadoArticulo = mysqli_query($conexion, $sqlUpdateArticulo);

                if(!$resultadoArticulo){
                    $response['succes'] = "errorCantidadArticulo";
                    die(json_encode($response));
                    exit();
                }
            }


            //Actualiza el estado de lote:
            $sqlUpdate = "UPDATE lotes SET estado_lote = 0 WHERE id_nota_lote = $id_nota";
            $resultado = mysqli_query($conexion, $sqlUpdate);
            if($resultado){
                $response['succes'] = true;
            } else{
                $response['succes'] = false;
            }

            // Actualiza el estado de la nota
            $sql = "UPDATE notas SET estado_nota = 0 WHERE id_nota = $id_nota";
            $resultado = mysqli_query($conexion, $sql);
            if($resultado){
                $response['succes'] = true;
            } else{
                $response['succes'] = false;
            }

            //si la nota contiene id_comprobante de parte de las integraciones se anula el comprobante relacionado
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
        }


        die(json_encode($response));

    }



}



?>