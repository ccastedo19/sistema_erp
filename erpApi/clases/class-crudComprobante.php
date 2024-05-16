<?php
class Comprobante{

    public function guardarComprobante() {
        //tabla comprobantes 
        //variables recibidas
        $serie = $_POST['serie'];
        $tipo_comprobante = $_POST['tipo_comprobante'];
        $estado = $_POST['estado'];
        $tc = $_POST['tc'];
        $id_moneda = $_POST['id_moneda']; //nombre de la moneda que usamos en el comprobante 
        $glosa_principal = $_POST['glosa_principal'];
        $id_empresa_comprobante = $_POST['id_empresa_comprobante']; //id de la empresa

        $fecha_comprobante = $_POST['fecha_comprobante'];
        $fecha_comprobante = date("Y-m-d", strtotime(str_replace('/', '-', $fecha_comprobante))); //poner formato de fecha de acuerdo a la base de datos
        //variables manuales
        $id_usuario_comprobante = 1;

        //tabla detalle_comprobante
        $detalles = $_POST['detalles']; //array ej: {id_cuenta: '475', debe: '100', haber: '0', glosa: 'texto glosa'}

        //conte de errores
        $errorComprobante = '';
        $errorDetalle = '';

        //array de la respuesta
        $response = array();
        $response['succes'] = "";
        
        //validaciones para la tabla comprobantes:

        //validar que fecha_comprobante pertenezca a un periodo abierto
        include_once '../conexion/bd_directa.php';

        // Consultar los periodos abiertos para la empresa en cuestión
        $query_periodos = "SELECT p.fecha_inicio_periodo, p.fecha_fin_periodo
                        FROM periodos p
                        JOIN gestiones g ON p.id_gestion_periodo = g.id_gestion
                        WHERE g.id_empresa_gestion = '$id_empresa_comprobante' AND p.estado_periodo = 1";

        $resultado_periodos = mysqli_query($conexion, $query_periodos);
        $periodos_abiertos = mysqli_fetch_all($resultado_periodos, MYSQLI_ASSOC);

        $fecha_comprobante_valida = false;

        foreach ($periodos_abiertos as $periodo) {
            $fecha_inicio_periodo = strtotime($periodo['fecha_inicio_periodo']);
            $fecha_fin_periodo = strtotime($periodo['fecha_fin_periodo']);
            $fecha_comprobante_timestamp = strtotime($fecha_comprobante);

            if ($fecha_comprobante_timestamp >= $fecha_inicio_periodo && $fecha_comprobante_timestamp <= $fecha_fin_periodo) {
                $fecha_comprobante_valida = true;
                break;
            }
        }

        if (!$fecha_comprobante_valida) {
            // La fecha del comprobante no es válida, puedes mostrar un mensaje de error o realizar alguna acción.
            //echo 'La fecha del comprobante no pertenece a ningun periodo.';
            $errorComprobante = 'errorFecha'; //error de fecha

        }else{
            //echo 'fecha correcta procede a seguir con la otras validaciones';
            // Validar que solo puede haber un tipo_comprobante = 'Apertura' en la gestion que se encuentra el periodo (saber esto por la fecha)
            if ($tipo_comprobante == 'Apertura') {
                // Obtener la gestión a la que pertenece el periodo
                $query_gestion = "SELECT g.id_gestion
                                FROM gestiones g
                                JOIN periodos p ON p.id_gestion_periodo = g.id_gestion
                                WHERE g.id_empresa_gestion = '$id_empresa_comprobante' AND p.estado_periodo = 1
                                AND '$fecha_comprobante' BETWEEN p.fecha_inicio_periodo AND p.fecha_fin_periodo";
                
                $resultado_gestion = mysqli_query($conexion, $query_gestion);
                $gestion = mysqli_fetch_assoc($resultado_gestion);
                $id_gestion = $gestion['id_gestion'];

                // Verificar si ya existe un comprobante de tipo "Apertura" en la gestión
                $query_comprobante_apertura = "SELECT c.id_comprobante
                            FROM comprobantes c
                            JOIN periodos p ON p.id_gestion_periodo = '$id_gestion'
                            WHERE c.tipo_comprobante = 'Apertura' AND c.estado = 1 AND c.id_empresa_comprobante = '$id_empresa_comprobante'
                            AND c.fecha_comprobante BETWEEN p.fecha_inicio_periodo AND p.fecha_fin_periodo";
                
                $resultado_comprobante_apertura = mysqli_query($conexion, $query_comprobante_apertura);
                $comprobante_apertura = mysqli_fetch_assoc($resultado_comprobante_apertura);

                if ($comprobante_apertura) {
                    // Ya existe un comprobante de tipo "Apertura" en la gestión, puedes mostrar un mensaje de error o realizar alguna acción.
                    //echo('----Ya existe un comprobante de tipo "Apertura" en la gestión.');
                    $errorComprobante = 'errorApertura';  //errorApertura
                    
                }
            }
            
        }

        //validaciones con la tabla detalle_comprobantes
        $detalles = $_POST['detalles']; //array ej: {id_cuenta: '475', debe: '100', haber: '0', glosa: 'texto glosa'}
        //primera validacion no se puede grabar un comprobante sin almenos dos detalles dentro del array, osea minimo 2 tiene que haber
        if (count($detalles) < 2) {
            // El array detalles no contiene al menos dos elementos, puedes mostrar un mensaje de error o realizar alguna acción.
            //echo('----El comprobante debe contener al menos dos detalles.');
            $errorDetalle = "detalleCero";
        }else{
            // Validar que la suma de todos los "Debe" sea igual a la suma de todos los "Haber"
            $suma_debe = 0;
            $suma_haber = 0;

            foreach ($detalles as $detalle) {
                $suma_debe += $detalle['debe'];
                $suma_haber += $detalle['haber'];
            }

            if ($suma_debe != $suma_haber) {
                // La suma de todos los "Debe" no es igual a la suma de todos los "Haber", puedes mostrar un mensaje de error o realizar alguna acción.
                //echo('----La suma de todos los "Debe" debe ser igual a la suma de todos los "Haber".');
                $errorDetalle = 'errorSuma';
            }else{
                //echo('---- todo bien sumado');
            }
        }    
        
        //validar Errores:
        if($errorComprobante == 'errorFecha' && $errorDetalle == ''){
            //error fecha sin periodo abierto
            $response['succes'] = 'errorFecha';
            die(json_encode($response));
            exit;
        }else if($errorComprobante == 'errorApertura' && $errorDetalle == ''){
            //error Apertura dos veces
            $response['succes'] = 'errorApertura';
            die(json_encode($response));
            exit;
        }else if($errorComprobante == '' && $errorDetalle == 'detalleCero'){
            //error el detalle tiene que contener almenos dos cuentas detalles
            $response['succes'] = 'errorDetalleCero';
            die(json_encode($response));
            exit;
        }else if($errorComprobante == '' && $errorDetalle == 'errorSuma'){
            //error el detalle tiene debe ser igual a lasuma de los haber
            $response['succes'] = 'errorSuma';
            die(json_encode($response));
            exit;
        }else if($errorComprobante == 'errorFecha' && $errorDetalle == 'detalleCero'){
            //error de fecha sin periodo y error de menos de dos cuentas detalles
            $response['succes'] = 'errorFecha&errorDetalleCero';
            die(json_encode($response));
            exit;
        }else if($errorComprobante == 'errorApertura' && $errorDetalle == 'detalleCero'){
            //error de tipo de comprobaten apertura 2 veces y error de menos de dos cuentas detalles
            $response['succes'] = 'errorApertura&errorDetalleCero';
            die(json_encode($response));
            exit;
        }else if($errorComprobante == 'errorFecha' && $errorDetalle == 'errorSuma'){
            //error de fecha sin periodo y error de suma en el haber y debe
            $response['succes'] = 'errorFecha&errorSuma';
            die(json_encode($response));
            exit;
        }else if($errorComprobante == 'errorApertura' && $errorDetalle == 'errorSuma'){
            //error de doble apertura y error de suma en el haber y debe
            $response['succes'] ='errorApertura&errorSuma';
            die(json_encode($response));
            exit;
        }
        else if ($errorComprobante == '' && $errorDetalle == ''){
            //guardar en la base de datos
            $qry = "INSERT INTO comprobantes (serie,glosa_principal,fecha_comprobante,tc,estado,tipo_comprobante,id_empresa_comprobante,id_usuario_comprobante,id_moneda) values('$serie','$glosa_principal','$fecha_comprobante','$tc','$estado','$tipo_comprobante','$id_empresa_comprobante','$id_usuario_comprobante','$id_moneda')";
            $resultado = $conexion->query($qry);
            if($resultado){
                
            }

            //guardar detalle...
            $ultimo_id_comprobante = mysqli_insert_id($conexion);//id_comprobante
            $id_usuario_comprobante = 1; //temporal

            // Obtener la información de la empresa y monedas
            $empresa_monedas = mysqli_query($conexion, "SELECT * FROM empresa_monedas WHERE id_empresa_m='$id_empresa_comprobante' AND activo = 1");
            $empresa = mysqli_fetch_assoc($empresa_monedas);
            $numero = 1; // Inicializar el contador de detalles
            $allDetailsSaved = true;

            foreach ($detalles as $detalle) {
                $id_cuenta = $detalle['id_cuenta'];
                $debe = $detalle['debe'];
                $haber = $detalle['haber'];
                $glosa = $detalle['glosa'];
            
                if ($id_moneda == $empresa['id_moneda_principal']) {
                    $monto_debe = $debe;
                    $monto_haber = $haber;
                    // Conversión de moneda principal a alternativa
                    $monto_debe_alt = $debe / $tc;
                    $monto_haber_alt = $haber / $tc;
                } else {
                    $monto_debe_alt = $debe;
                    $monto_haber_alt = $haber;
                    // Conversión de moneda alternativa a principal
                    $monto_debe = $debe * $tc;
                    $monto_haber = $haber * $tc;
                }
                $insert_detalle = "INSERT INTO detalle_comprobantes (numero, glosa_secundaria,monto_debe,monto_haber,monto_debe_alt,monto_haber_alt,id_usuario_comprobante,id_comprobante,id_cuenta) values('$numero','$glosa','$monto_debe','$monto_haber','$monto_debe_alt','$monto_haber_alt','$id_usuario_comprobante','$ultimo_id_comprobante','$id_cuenta')";
                $result = mysqli_query($conexion, $insert_detalle);
                if ($result) {
                    //echo 'se guardo el detalle';
                }
            
                $numero++; // Incrementar el contador de detalles
            }
            if ($allDetailsSaved) {
                $response['succes'] = $ultimo_id_comprobante; //esto para enviarme a la pagina de vista previa del comprobante
            } else {
                $response['succes'] = 'error';
            }
            
            die(json_encode($response));
        
        
        }

    }

    public function editarComprobante(){
        include_once '../conexion/bd_directa.php';
        $id_comprobante = $_POST['id_comprobante'];
        $response = array();
        $response['succes'] = false;

        //verificar si comprobante tiene relacion con integraciones
        $sql = "SELECT COUNT(*) AS count
        FROM comprobantes 
        INNER JOIN notas ON comprobantes.id_comprobante = notas.id_comprobante_nota WHERE comprobantes.id_comprobante = '$id_comprobante'";
        
        $resultado = $conexion->query($sql);
        $row = $resultado->fetch_assoc();
        
        if($row['count'] > 0) {
            //El id_comprobante de la tabla comprobantes está presente en la tabla notas
            $response['succes'] = "errorIntegracion";
            die(json_encode($response));
            exit;

        } else {
            //El id_comprobante de la tabla comprobantes no está presente en la tabla notas
        }
        

        //-------------------------------------------------------------------- -                                                                                                                                    
        
        $qry = "UPDATE comprobantes SET estado = 0 WHERE id_comprobante = '$id_comprobante'";//actualizamos el estado

        if(mysqli_query($conexion, $qry)){
            $response['succes'] = true;
            die(json_encode($response));
            exit;
            //se edito correctamente
        } else {
            //error al editar
        }
    }
}









?>