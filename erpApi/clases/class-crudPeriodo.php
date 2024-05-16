<?php

class Periodo{

    public function guardarPeriodo(){
        include '../conexion/bd.php';
        //datos traidos de POST
        $nombre_periodo = $_POST['nombre_periodo'];
        $fecha_inicio_periodo = $_POST['fecha_inicio_periodo'];
        $fecha_fin_periodo = $_POST['fecha_fin_periodo'];
        $estado_periodo = $_POST['estado_periodo'];
        $id_usuario_periodo = $_POST['id_usuario_periodo'];
        $id_gestion_periodo = $_POST['id_gestion_periodo'];

        // Convertir fecha_inicio y fecha_fin al formato "año-mes-día"
        $fecha_inicio_periodo = date("Y-m-d", strtotime(str_replace('/', '-', $fecha_inicio_periodo)));
        $fecha_fin_periodo = date("Y-m-d", strtotime(str_replace('/', '-', $fecha_fin_periodo)));

        //mandar en formato json respuesta
        $error['succes'] = '';
        
        // No pueden Existir 2 periodos con el mismo nombre para la misma gestion
        $sqlNombre = "SELECT * FROM periodos WHERE id_gestion_periodo = $id_gestion_periodo AND nombre_periodo = '$nombre_periodo'";
        $queryGestion = mysqli_query($con, $sqlNombre);
        $nombreRepetido = mysqli_num_rows($queryGestion) > 0;
        
        if($nombreRepetido > 0){
            $error['succes'] = 'errorNombre';
            die(json_encode($error));
            exit;
        }
        else{
            //Validar que fecha inicio debe ser menor a fecha fin
            $fechaInicioP = strtotime($fecha_inicio_periodo); //declarar variables para hacer uso
            $fechaFinP = strtotime($fecha_fin_periodo);

            //validar fechas iguales
            if ($fechaInicioP == $fechaFinP){
                $error['succes'] = 'errrorFechaIgual';
                die(json_encode($error));
                exit;
            }

            if ($fechaInicioP >= $fechaFinP) {
                // If fecha_inicio_periodo is greater than or equal to fecha_fin_periodo, show an error message and exit the script
                $error['succes'] = 'errorFechaMenor';
                die(json_encode($error));
                exit;
            }else{
                // Las fechas tienen que estar dentro del rango de fechas de la gestion a la que pertenece
                //revisamos las fechas de nuestra gestión aprovechando el id de la gestion obtenida en $id_gestion_periodo
                $sqlFecha = "SELECT * FROM gestiones WHERE id_gestion = $id_gestion_periodo"; //consultamos a la bd de gestiones para sacar la fecha incio y fecha fin
                $queryFecha = mysqli_query($con,$sqlFecha);
                $cantidad     = mysqli_num_rows($queryFecha);

                if ($queryFecha -> num_rows > 0){
                    while ($dataFecha = mysqli_fetch_array($queryFecha)) {
                        $fecha_incio_gestion = $dataFecha['fecha_inicio'];
                        $fecha_fin_gestion = $dataFecha['fecha_fin'];
                    }
                    //$fecha_inicio_periodo y $fecha_fin_periodo tiene que estar dentro del rango de fecha_inicio_gestion y fecha_fin_gestion

                    // Las fechas tienen que estar dentro del rango de fechas de la gestión a la que pertenece
                    $fechaInicioG = strtotime($fecha_incio_gestion);
                    $fechaFinG = strtotime($fecha_fin_gestion);

                    if ($fechaInicioP < $fechaInicioG || $fechaFinP > $fechaFinG) {
                        // Si las fechas del periodo están fuera del rango de fechas de la gestión, mostramos un mensaje de error y salimos del script
                        $error['succes'] = 'errorFechaGestion';
                        die(json_encode($error));
                        exit;
                    }
                    else {
                        // Validar solapamiento de Periodos. Las fechas no se deben superponer entre periodos
                        $sqlSolapamiento = "SELECT * FROM periodos WHERE id_gestion_periodo = $id_gestion_periodo AND ((fecha_inicio_periodo <= '$fecha_inicio_periodo' AND fecha_fin_periodo >= '$fecha_inicio_periodo') OR (fecha_inicio_periodo <= '$fecha_fin_periodo' AND fecha_fin_periodo >= '$fecha_fin_periodo'))";
                        $querySolapamiento = mysqli_query($con, $sqlSolapamiento);
                        $numSolapamiento = mysqli_num_rows($querySolapamiento);

                        if ($numSolapamiento > 0) {
                            // Si hay periodos que se solapan con el nuevo periodo, mostramos un mensaje de error y salimos del script
                            $error['succes'] = 'errorFechaPeriodo';
                            die(json_encode($error));
                            exit;
                        }
                        else {
                            // Si no hay solapamiento de periodos, podemos guardar el nuevo periodo en la base de datos
                            $sqlGuardar = "INSERT INTO periodos (nombre_periodo, fecha_inicio_periodo, fecha_fin_periodo, estado_periodo, id_usuario_periodo, id_gestion_periodo) VALUES ('$nombre_periodo', '$fecha_inicio_periodo', '$fecha_fin_periodo', '$estado_periodo', '$id_usuario_periodo', '$id_gestion_periodo')";
                            $queryGuardar = mysqli_query($con, $sqlGuardar);
                            
                            if ($queryGuardar) {
                                $error['succes'] = 'Guardado';
                                die(json_encode($error));
                            }
                            else {
                                echo "Error al guardar el periodo: " . mysqli_error($con);
                            }
                        }

                    }

                }
            }
        }
    }


     public static function eliminarPeriodo($indice){
        include_once '../conexion/bd_directa.php';
 
        $qry = "DELETE FROM periodos WHERE id_periodo = $indice";
        mysqli_query($conexion,$qry);
    

    }
    

    public function editarPeriodo(){
        include '../conexion/bd_directa.php';
        
        $error = array();
        $error['succes'] = '';
        //datos traidos de POST
        $id_periodo = $_POST['id_periodo'];
        $nombre_periodo = $_POST['nombre_periodo'];
        $fecha_inicio_periodo = $_POST['fecha_inicio_periodo'];
        $fecha_fin_periodo = $_POST['fecha_fin_periodo'];
        $estado_periodo = $_POST['estado_periodo'];
        $id_usuario_periodo = $_POST['id_usuario_periodo'];
        $id_gestion_periodo = $_POST['id_gestion_periodo']; // id de la gestion
    
        // Convertir fecha_inicio y fecha_fin al formato "año-mes-día"
        $fecha_inicio_periodo = date("Y-m-d", strtotime(str_replace('/', '-', $fecha_inicio_periodo)));
        $fecha_fin_periodo = date("Y-m-d", strtotime(str_replace('/', '-', $fecha_fin_periodo)));
    
        //no puede existir dos periodos con el mismo nombre a excepcion que se ingrese el nombre del periodo original
        $sql = "SELECT COUNT(*) AS count FROM periodos WHERE nombre_periodo = '$nombre_periodo' AND id_periodo <> '$id_periodo' AND id_gestion_periodo = '$id_gestion_periodo'";
        $result = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];

        //validar que los 3 datos ingresados son los mismo
        // Obtener los valores almacenados en la base de datos para el periodo con el id_periodo correspondiente
        $sql = "SELECT nombre_periodo, fecha_inicio_periodo, fecha_fin_periodo FROM periodos WHERE id_periodo = $id_periodo";
        $resultado = mysqli_query($conexion, $sql);
        $periodo = mysqli_fetch_assoc($resultado);
        $nombre_periodo_bd = $periodo['nombre_periodo'];
        $fecha_inicio_periodo_bd = $periodo['fecha_inicio_periodo'];
        $fecha_fin_periodo_bd = $periodo['fecha_fin_periodo'];

        // Validar que los valores del formulario son los mismos que los valores almacenados en la base de datos
        if ($nombre_periodo == $nombre_periodo_bd && $fecha_inicio_periodo == $fecha_inicio_periodo_bd && $fecha_fin_periodo == $fecha_fin_periodo_bd) {
            $error['succes'] = 'errorDatosIgual';
            die(json_encode($error));
            exit;
        } else {
            //avanzar
        }

        
        if ($count > 0) {
            //nombre existente en la bd
            $error['succes'] = 'errorNombre';
            die(json_encode($error));
            exit;
        }

        //validar fechas iguales
        if ($fecha_inicio_periodo == $fecha_fin_periodo){
            $error['succes'] = 'errorFechaIgual';
            die(json_encode($error));
            exit;
        }

        //validar si la fecha inicial es mayor
        if($fecha_inicio_periodo > $fecha_fin_periodo){
            $error['succes'] = 'errorFechaMayor';
            die(json_encode($error));
            exit;
        }

        //---validar que las fechas esten dentro de la misma gestion
        // Obtener las fechas de inicio y fin de la gestión correspondiente
        $sql = "SELECT fecha_inicio, fecha_fin FROM gestiones WHERE id_gestion = $id_gestion_periodo";
        $resultado = mysqli_query($conexion, $sql);
        $gestion = mysqli_fetch_assoc($resultado);
        $fecha_inicio_gestion = $gestion['fecha_inicio'];
        $fecha_fin_gestion = $gestion['fecha_fin'];

        // Validar que las fechas del periodo están dentro del rango de fechas de la gestión
        if ($fecha_inicio_periodo >= $fecha_inicio_gestion && $fecha_fin_periodo <= $fecha_fin_gestion) {
        // Las fechas del periodo están dentro del rango de fechas de la gestión
        // Realizar las acciones necesarias

        } else {
            $error['succes'] = 'errorFechaGestion';
            die(json_encode($error));
            exit;
        }

        // verificar si hay solapamiento de fechas con otros periodos de la misma gestión
        // Validar solapamientos de fechas de periodos de la misma gestión
        $sql = "SELECT COUNT(*) AS count FROM periodos WHERE id_gestion_periodo = '$id_gestion_periodo' AND (fecha_inicio_periodo BETWEEN '$fecha_inicio_periodo' AND '$fecha_fin_periodo' OR fecha_fin_periodo BETWEEN '$fecha_inicio_periodo' AND '$fecha_fin_periodo' OR ('$fecha_inicio_periodo' BETWEEN fecha_inicio_periodo AND fecha_fin_periodo AND '$fecha_fin_periodo' BETWEEN fecha_inicio_periodo AND fecha_fin_periodo)) AND id_periodo <> '$id_periodo'";
        $result = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];

        if ($count > 0) {
            $error['succes'] = 'errorFechaSolapamiento';
            die(json_encode($error));
            exit;
            // Las fechas de este periodo se solapan con las fechas de uno o más periodos de la misma gestión
            // Mostrar un mensaje de error o realizar las acciones necesarias
        } else {
            // Las fechas de este periodo no se solapan con las fechas de ningún otro periodo de la misma gestión
            // Realizar las acciones necesarias
        }

        //si pasa todas las validacione actualizamos
        $query = "UPDATE periodos SET fecha_inicio_periodo = '$fecha_inicio_periodo', fecha_fin_periodo = '$fecha_fin_periodo', nombre_periodo = '$nombre_periodo' WHERE id_periodo = $id_periodo";

        if(mysqli_query($conexion, $query)){
            $resul['succes'] = 'guardado';
            die(json_encode($resul));
            exit;
            //$resul['message'] = "La gestión se ha editado correctamente";
        } else {
            //$resul['message'] = "Ha ocurrido un error al editar la gestión";
        }

        


        


    }


}



?>