<?php  

class Gestion {

    public function guardarGestion() {
        
        include '../conexion/bd.php';
        
        $fecha_inicio = $_POST["fecha_inicio"];
        $fecha_fin = $_POST["fecha_fin"];
        $nombre_gestion = $_POST["nombre_gestion"];
        $id_usuario_gestion = $_POST["id_usuario_gestion"];//resultado 1
        $id_empresa_gestion = $_POST["id_empresa_gestion"];
        $estado_gestion = $_POST["estado_gestion"]; //resultado 1
        //validacion para el front end
        $errores = array();
        $errores['succes'] ='';
        
        // Convertir fecha_inicio y fecha_fin al formato "año-mes-día"
        $fecha_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $fecha_inicio)));
        $fecha_fin = date("Y-m-d", strtotime(str_replace('/', '-', $fecha_fin)));

        //COMPROBAR SI LAS FECHAS SON IGUALES
        if (strtotime($fecha_inicio) == strtotime($fecha_fin)) {
            $errores['succes'] = 'errorFechasIguales';
            die(json_encode($errores));
            exit;
        }
        
        // Comprobar que la fecha de inicio sea menor que la fecha de fin
        if (strtotime($fecha_inicio) >= strtotime($fecha_fin)) {
            //echo "<script type='text/javascript'>
            //            console.log('La fecha de inicio debe ser anterior a la fecha de fin')';
            //        </script>";
        }else{
            // Validar que no existan dos gestiones con el mismo nombre para la misma empresa
            $sqlCliente = "SELECT * FROM gestiones WHERE id_empresa_gestion = $id_empresa_gestion AND nombre_gestion = '$nombre_gestion'";
            $queryGestion = mysqli_query($con, $sqlCliente);
            $nombreRepetido = mysqli_num_rows($queryGestion) > 0;
        
            if (!$nombreRepetido) {
                // Validar solapamiento de gestiones. Las fechas no se deben superponer entre gestiones
                $sqlSolapamiento = "SELECT * FROM gestiones WHERE id_empresa_gestion = $id_empresa_gestion AND (
                    (fecha_inicio <= '$fecha_inicio' AND fecha_fin >= '$fecha_inicio') OR
                    (fecha_inicio <= '$fecha_fin' AND fecha_fin >= '$fecha_fin') OR
                    (fecha_inicio >= '$fecha_inicio' AND fecha_fin <= '$fecha_fin')
                )";
                $querySolapamiento = mysqli_query($con, $sqlSolapamiento);
                $solapamiento = mysqli_num_rows($querySolapamiento) > 0;
        
                if (!$solapamiento) {

                    //gestion activa o inactiva
                    $sqlEstado = "SELECT COUNT(*) AS count_estado_gestion FROM gestiones WHERE id_empresa_gestion = $id_empresa_gestion AND estado_gestion = 1";
                    $resultado = mysqli_query($con, $sqlEstado);
                    $count_estado_gestion = mysqli_fetch_assoc($resultado)["count_estado_gestion"];

                    // Guardar la gestión
                    $sqlGuardar = "INSERT INTO gestiones (fecha_inicio, fecha_fin, nombre_gestion, estado_gestion, id_usuario_gestion, id_empresa_gestion) VALUES ('$fecha_inicio', '$fecha_fin', '$nombre_gestion', '$estado_gestion', $id_usuario_gestion, $id_empresa_gestion)";
                    $queryGuardar = mysqli_query($con, $sqlGuardar);
        
                    if ($queryGuardar) {
                        $errores['succes'] = 'guardado';
                        //echo "<script type='text/javascript'>
                        //    console.log('Gestion se guardo correctamente')';
                        //</script>";
                    } else {
                        //echo "<script type='text/javascript'>
                        //    console.log('ERROR al guardar la gestion')';
                        //</script>";
                    }
                } else {
                    $errores['succes'] = 'errorGestion'; //error por superponer con otra gestion
                    //echo "<script type='text/javascript'>
                    //        console.log('Error la gestion se superpone con otra existente')';
                    //    </script>";
                }
            } else {
                $errores['succes'] = 'errorNombre'; //error por nombre existente
                //echo "<script type='text/javascript'>
                //            console.log('Ya existe el mismo nombre de gestion')';
                //        </script>";
            }
            //comprobacion si la fecha inicio es mayor a la fecha fin
            
            die(json_encode($errores));

        }
        if ($errores['succes'] != 'guardado' && $errores['succes'] != 'errorGestion' && $errores['succes'] != 'errorNombre' ){
            $errores['succes'] = 'errorFecha';
            die(json_encode($errores));

            
        }

        
    
        
    }


    public static function eliminarGestion($indice){
        include_once '../conexion/bd_directa.php';
    
        //hacer consulta a base de datos de la tabla periodos y verificar que no exista ningun periodo creado con ese id_gestion
            
        $query = "SELECT * FROM periodos WHERE id_gestion_periodo = $indice";
        $resultado = mysqli_query($conexion, $query);
    
        $resul = array();
        $resul['succes'] = '';

        //Verificar si la consulta SQL se ejecutó correctamente
        if($resultado === false){

            return;
        }
    
        //Verificar si no existes ningún periodo asociado a la gestión
        if(mysqli_num_rows($resultado) == 0){
            //No hay ningún periodo asociado a la gestión, proceder a eliminar la gestión
            $query_eliminar = "DELETE FROM gestiones WHERE id_gestion = '".$indice."' ";
            mysqli_query($conexion, $query_eliminar);
            $resul['succes'] = true;
            die(json_encode($resul));
            exit;

        }else{
            //echo "Error, no se puede eliminar la gestión porque existen períodos dentro de ella";
            $resul['succes'] = false;
            die(json_encode($resul));
            exit;
        }
    }

    function editarGestion(){
        include_once '../conexion/bd_directa.php';
    
        $id_gestion = $_POST["id_gestion"];
        $fecha_inicio = $_POST["fecha_inicio"];
        $fecha_fin = $_POST["fecha_fin"];
        $nombre_gestion = $_POST["nombre_gestion"];
        $id_usuario_gestion = $_POST["id_usuario_gestion"];
        $id_empresa_gestion = $_POST["id_empresa_gestion"]; //id_empresa de la gestion
        $estado_gestion = $_POST["estado_gestion"];

        // Convertir fecha_inicio y fecha_fin al formato "año-mes-día"
        $fecha_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $fecha_inicio)));
        $fecha_fin = date("Y-m-d", strtotime(str_replace('/', '-', $fecha_fin)));

       

        $resul = array();
        $resul['succes'] = '';

        //verificar que los datos ingresados son los mismos originalmente (fecha_inicio,fecha_fin,nombre_gestion)
        $sql = "SELECT * FROM gestiones WHERE id_gestion = $id_gestion";
        $query = mysqli_query($conexion, $sql);
        $gestion = mysqli_fetch_assoc($query);
        if ($fecha_inicio == $gestion['fecha_inicio'] && $fecha_fin == $gestion['fecha_fin'] && $nombre_gestion == $gestion['nombre_gestion']) {
            $resul['succes'] = 'errorIgual';
            die(json_encode($resul));
            exit();
        }

        // consulta SQL para verificar si ya existe una gestión con el mismo nombre en la base de datos
        $sql = "SELECT id_gestion FROM gestiones WHERE nombre_gestion = '$nombre_gestion' AND id_empresa_gestion = '$id_empresa_gestion'";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $id_gestion_encontrada = $fila["id_gestion"];
        
            // si el id de la gestión encontrada coincide con el id enviado por el formulario
            if ($id_gestion_encontrada == $id_gestion) {
                //que siga pasando a las otras validaciones 
            } else {
                $resul['succes'] = 'errorNombre';
                die(json_encode($resul));
                exit();
            }
        }
        
        //verificacion de fechas----------------------------------------------------------------------------------

        // Verificar si hay periodos asociados a la gestión
        $query = "SELECT * FROM periodos WHERE id_gestion_periodo = $id_gestion";
        $resultado = mysqli_query($conexion, $query);
        if(mysqli_num_rows($resultado) > 0){
            //Hay periodos asociados a la gestión, no se puede editar
            //verificamos si las fechas son las mismas a las originales en caso de querer cambiar solo el nombre
            $query = "SELECT fecha_inicio, fecha_fin FROM gestiones WHERE id_gestion = '$id_gestion'";
            $result = mysqli_query($conexion, $query);
            $row = mysqli_fetch_assoc($result);
            if ($row['fecha_inicio'] == $fecha_inicio && $row['fecha_fin'] == $fecha_fin) {
                // Las fechas son iguales, solo guardamos el nombre
                $query = "UPDATE gestiones SET fecha_inicio = '$fecha_inicio', fecha_fin = '$fecha_fin', nombre_gestion = '$nombre_gestion' WHERE id_gestion = $id_gestion";

                if(mysqli_query($conexion, $query)){
                    $resul['succes'] = 'guardado';
                    //$resul['message'] = "La gestión se ha editado correctamente";
                } else {
                    //$resul['message'] = "Ha ocurrido un error al editar la gestión";
                }
            }else{
                //error no se puede modificar fechas de periodos asociados a la gestion
                $resul['succes'] = 'errorPeriodoAsociado';
                die(json_encode($resul));
                exit();
            }

            
        }

        // Verificar que fecha_inicio sea menor a fecha_fin
        if(strtotime($fecha_inicio) >= strtotime($fecha_fin)){
            // La fecha de inicio no es menor a la fecha de fin
            $resul['succes'] = 'errorFechaMenor';
            die(json_encode($resul));
            exit;
        }

        // Verificar si hay solapamiento con otras gestiones de la misma empresa
        $query = "SELECT * FROM gestiones WHERE id_empresa_gestion = $id_empresa_gestion AND id_gestion != $id_gestion AND fecha_inicio <= '$fecha_fin' AND fecha_fin >= '$fecha_inicio'";
        $resultado = mysqli_query($conexion, $query);

        if(mysqli_num_rows($resultado) > 0){
            // Hay solapamiento con otras gestiones de la misma empresa, no se puede editar
            $resul['succes'] = 'errorSolapamiento';
            die(json_encode($resul));
            exit;
        }

        // No hay periodos asociados ni solapamiento con otras gestiones de la misma empresa, se puede editar
        $query = "UPDATE gestiones SET fecha_inicio = '$fecha_inicio', fecha_fin = '$fecha_fin', nombre_gestion = '$nombre_gestion' WHERE id_gestion = $id_gestion";


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
