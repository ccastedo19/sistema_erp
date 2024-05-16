<?php
class Cuenta{


    public function guardarCuenta(){
        // Conexión
        include_once '../conexion/bd_directa.php';
        
        // Recibir los datos principales
        $nombre_cuenta = $_POST['nombre_cuenta'];
        $id_empresa_cuenta = $_POST['id_empresa_cuenta'];
        $id_cuenta_padre = $_POST['id_cuenta_padre'];
        //globales
        $id_usuario_cuenta = 1;
        $tipo_cuenta = "Global";
        // envio de variable
        $response = array();
        $response['succes'] = false;

        //sacar variables de empresa
        $qry = "SELECT * FROM empresas WHERE id_empresa = $id_empresa_cuenta";
        $run = $conexion -> query($qry);
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                $nivel_empresa = $row['nivel'];
            }
        }
        // Verificar si el nombre de la cuenta ya existe en la misma empresa
        $consulta = "SELECT * FROM cuentas WHERE BINARY nombre_cuenta = '$nombre_cuenta' AND id_empresa_cuenta = $id_empresa_cuenta";
        $resultado = $conexion->query($consulta);
        if ($resultado->num_rows > 0) {
            //echo "<script type='text/javascript'>
            //console.log('error mismo nombre');
            //</script>";
            $response['succes'] = false;
            die(json_encode($response));
            exit();
        }else{
                //si la empresa es de nivel 7
                if($nivel_empresa == 7){
                    //si el id_padre es igual a 0
                    if ($id_cuenta_padre == 0) {
                        // Obtener la cuenta de nivel 1 con el código más alto
                        $consulta = "SELECT codigo FROM cuentas WHERE nivel = 1 AND id_empresa_cuenta = $id_empresa_cuenta ORDER BY codigo DESC LIMIT 1";
                        $resultado = $conexion->query($consulta);
            
                        if ($resultado->num_rows > 0) {
                            $fila = $resultado->fetch_assoc();
                            $codigo_cuenta_nivel_1 = $fila['codigo'];
                            $partes_codigo_cuenta_nivel_1 = explode('.', $codigo_cuenta_nivel_1);
                            $partes_codigo_cuenta_nivel_1[0] = $partes_codigo_cuenta_nivel_1[0] + 1;
                        } else {
                            $partes_codigo_cuenta_nivel_1 = array(1);
                        }
            
                        // Rellenar las partes restantes del código con 0
                        for ($i = 1; $i < 7; $i++) {
                            $partes_codigo_cuenta_nivel_1[$i] = 0;
                        }
                        $codigo_nueva_cuenta = implode('.', $partes_codigo_cuenta_nivel_1);
                        $nivel_nueva_cuenta = 1;
            
                        // Insertar la nueva cuenta
                        $consulta = "INSERT INTO cuentas (codigo, nombre_cuenta, nivel, id_empresa_cuenta, id_cuenta_padre, id_usuario_cuenta, tipo_cuenta) VALUES ('$codigo_nueva_cuenta', '$nombre_cuenta', '$nivel_nueva_cuenta', '$id_empresa_cuenta', NULL, '$id_usuario_cuenta', '$tipo_cuenta')";
                        $resultado = $conexion->query($consulta);
            
                        // Verificar si la consulta se ejecutó correctamente
                        if ($resultado) {
                            $response['succes'] = true;
                            die(json_encode($response));
                        } else {
                        }
            
                    }else{
                        // Obtener información de la cuenta padre
                        $consulta = "SELECT * FROM cuentas WHERE id_cuenta = $id_cuenta_padre";
                        $resultado = $conexion->query($consulta);

                        if ($resultado->num_rows > 0) {
                            $fila = $resultado->fetch_assoc();
                            $codigo_cuenta_padre = $fila['codigo'];
                            $nivel_cuenta_padre = $fila['nivel'];

                            // Obtener el último hijo de la cuenta padre
                            $consulta_hijos = "SELECT codigo FROM cuentas WHERE id_cuenta_padre = $id_cuenta_padre ORDER BY codigo DESC LIMIT 1";
                            $resultado_hijos = $conexion->query($consulta_hijos);

                            if ($resultado_hijos->num_rows > 0) {
                                $fila_hijos = $resultado_hijos->fetch_assoc();
                                $codigo_ultimo_hijo = $fila_hijos['codigo'];
                                $partes_codigo_ultimo_hijo = explode('.', $codigo_ultimo_hijo);
                                $partes_codigo_ultimo_hijo[$nivel_cuenta_padre]++;
                            } else {
                                $partes_codigo_ultimo_hijo = explode('.', $codigo_cuenta_padre);
                                $partes_codigo_ultimo_hijo[$nivel_cuenta_padre]++;
                            }

                            // Rellenar las partes restantes del código con 0
                            for ($i = $nivel_cuenta_padre + 1; $i < 7; $i++) {
                                $partes_codigo_ultimo_hijo[$i] = 0;
                            }

                            $codigo_nueva_cuenta = implode('.', $partes_codigo_ultimo_hijo);
                            $nivel_nueva_cuenta = $nivel_cuenta_padre + 1;

                            // Verificar si el último nivel del código de la cuenta padre es cero
                            if ($partes_codigo_ultimo_hijo[6] > 0) {
                                // Si es cero, se está usando el último nivel y la cuenta es "Detalle"
                                $tipo_cuenta = "Detalle";
                            }           

                            // Insertar la nueva cuenta
                            $consulta = "INSERT INTO cuentas (codigo, nombre_cuenta, nivel, id_empresa_cuenta, id_cuenta_padre, id_usuario_cuenta, tipo_cuenta) VALUES ('$codigo_nueva_cuenta', '$nombre_cuenta', '$nivel_nueva_cuenta', '$id_empresa_cuenta', '$id_cuenta_padre', '$id_usuario_cuenta', '$tipo_cuenta')";
                            $resultado = $conexion->query($consulta);

                            // Verificar si la consulta se ejecutó correctamente
                            if ($resultado) {
                                
                                $response['succes'] = true;
                                die(json_encode($response));
                            } else {
                                //no se ejecuto correctamente
                            }
                        }else{

                        }

                }

            }else if($nivel_empresa == 6){
                if($id_cuenta_padre == 0){
                    //si la cuenta padre es 0 se guarda como nulo
                    // Obtener la cuenta de nivel 1 con el código más alto
                    $consulta = "SELECT codigo FROM cuentas WHERE nivel = 1 AND id_empresa_cuenta = $id_empresa_cuenta ORDER BY codigo DESC LIMIT 1";
                    $resultado = $conexion->query($consulta);
        
                    if ($resultado->num_rows > 0) {
                        $fila = $resultado->fetch_assoc();
                        $codigo_cuenta_nivel_1 = $fila['codigo'];
                        $partes_codigo_cuenta_nivel_1 = explode('.', $codigo_cuenta_nivel_1);
                        $partes_codigo_cuenta_nivel_1[0] = $partes_codigo_cuenta_nivel_1[0] + 1;
                    } else {
                        $partes_codigo_cuenta_nivel_1 = array(1);
                    }
        
                    // Rellenar las partes restantes del código con 0
                    for ($i = 1; $i < 6; $i++) {
                        $partes_codigo_cuenta_nivel_1[$i] = 0;
                    }
                    $codigo_nueva_cuenta = implode('.', $partes_codigo_cuenta_nivel_1);
                    $nivel_nueva_cuenta = 1;
        
                    // Insertar la nueva cuenta
                    $consulta = "INSERT INTO cuentas (codigo, nombre_cuenta, nivel, id_empresa_cuenta, id_cuenta_padre, id_usuario_cuenta, tipo_cuenta) VALUES ('$codigo_nueva_cuenta', '$nombre_cuenta', '$nivel_nueva_cuenta', '$id_empresa_cuenta', NULL, '$id_usuario_cuenta', '$tipo_cuenta')";
                    $resultado = $conexion->query($consulta);
        
                    // Verificar si la consulta se ejecutó correctamente
                    if ($resultado) {
                        $response['succes'] = true;
                        die(json_encode($response));
                    } else {
                    }

                }
                else{
                    // Obtener información de la cuenta padre
                    $consulta = "SELECT * FROM cuentas WHERE id_cuenta = $id_cuenta_padre";
                    $resultado = $conexion->query($consulta);

                    if ($resultado->num_rows > 0) {
                        $fila = $resultado->fetch_assoc();
                        $codigo_cuenta_padre = $fila['codigo'];
                        $nivel_cuenta_padre = $fila['nivel'];

                        // Obtener el último hijo de la cuenta padre
                        $consulta_hijos = "SELECT codigo FROM cuentas WHERE id_cuenta_padre = $id_cuenta_padre ORDER BY codigo DESC LIMIT 1";
                        $resultado_hijos = $conexion->query($consulta_hijos);

                        if ($resultado_hijos->num_rows > 0) {
                            $fila_hijos = $resultado_hijos->fetch_assoc();
                            $codigo_ultimo_hijo = $fila_hijos['codigo'];
                            $partes_codigo_ultimo_hijo = explode('.', $codigo_ultimo_hijo);
                            $partes_codigo_ultimo_hijo[$nivel_cuenta_padre]++;
                        } else {
                            $partes_codigo_ultimo_hijo = explode('.', $codigo_cuenta_padre);
                            $partes_codigo_ultimo_hijo[$nivel_cuenta_padre]++;
                        }

                        // Rellenar las partes restantes del código con 0
                        for ($i = $nivel_cuenta_padre + 1; $i < 6; $i++) {
                            $partes_codigo_ultimo_hijo[$i] = 0;
                        }

                        $codigo_nueva_cuenta = implode('.', $partes_codigo_ultimo_hijo);
                        $nivel_nueva_cuenta = $nivel_cuenta_padre + 1;

                         // Verificar si el último nivel del código de la cuenta padre es cero
                        if ($partes_codigo_ultimo_hijo[5] > 0) {
                            // Si es cero, se está usando el último nivel y la cuenta es "Detalle"
                            $tipo_cuenta = "Detalle";
                        }       
              
                        // Insertar la nueva cuenta
                        $consulta = "INSERT INTO cuentas (codigo, nombre_cuenta, nivel, id_empresa_cuenta, id_cuenta_padre, id_usuario_cuenta, tipo_cuenta) VALUES ('$codigo_nueva_cuenta', '$nombre_cuenta', '$nivel_nueva_cuenta', '$id_empresa_cuenta', '$id_cuenta_padre', '$id_usuario_cuenta', '$tipo_cuenta')";
                        $resultado = $conexion->query($consulta);

                        // Verificar si la consulta se ejecutó correctamente
                        if ($resultado) {
                            $response['succes'] = true;
                            die(json_encode($response));
                        } else {
                        }
                    }else {
                        
                    }

                }
                
            }else if($nivel_empresa == 5){
                if($id_cuenta_padre == 0){
                    //si la cuenta padre es 0 se guarda como nulo
                    // Obtener la cuenta de nivel 1 con el código más alto
                    $consulta = "SELECT codigo FROM cuentas WHERE nivel = 1 AND id_empresa_cuenta = $id_empresa_cuenta ORDER BY codigo DESC LIMIT 1";
                    $resultado = $conexion->query($consulta);
        
                    if ($resultado->num_rows > 0) {
                        $fila = $resultado->fetch_assoc();
                        $codigo_cuenta_nivel_1 = $fila['codigo']; 
                        $partes_codigo_cuenta_nivel_1 = explode('.', $codigo_cuenta_nivel_1);
                        $partes_codigo_cuenta_nivel_1[0] = $partes_codigo_cuenta_nivel_1[0] + 1;
                    } else {
                        $partes_codigo_cuenta_nivel_1 = array(1);
                    }
        
                    // Rellenar las partes restantes del código con 0
                    for ($i = 1; $i < 5; $i++) {
                        $partes_codigo_cuenta_nivel_1[$i] = 0;
                    }
                    $codigo_nueva_cuenta = implode('.', $partes_codigo_cuenta_nivel_1);
                    $nivel_nueva_cuenta = 1;
        
                    // Insertar la nueva cuenta
                    $consulta = "INSERT INTO cuentas (codigo, nombre_cuenta, nivel, id_empresa_cuenta, id_cuenta_padre, id_usuario_cuenta, tipo_cuenta) VALUES ('$codigo_nueva_cuenta', '$nombre_cuenta', '$nivel_nueva_cuenta', '$id_empresa_cuenta', NULL, '$id_usuario_cuenta', '$tipo_cuenta')";
                    $resultado = $conexion->query($consulta);
        
                    // Verificar si la consulta se ejecutó correctamente
                    if ($resultado) {
                        $response['succes'] = true;
                        die(json_encode($response));
                    } else {
                    }

                }
                else{
                    // Obtener información de la cuenta padre
                    $consulta = "SELECT * FROM cuentas WHERE id_cuenta = $id_cuenta_padre";
                    $resultado = $conexion->query($consulta);

                    if ($resultado->num_rows > 0) {
                        $fila = $resultado->fetch_assoc();
                        $codigo_cuenta_padre = $fila['codigo'];
                        $nivel_cuenta_padre = $fila['nivel'];

                        // Obtener el último hijo de la cuenta padre
                        $consulta_hijos = "SELECT codigo FROM cuentas WHERE id_cuenta_padre = $id_cuenta_padre ORDER BY codigo DESC LIMIT 1";
                        $resultado_hijos = $conexion->query($consulta_hijos);

                        if ($resultado_hijos->num_rows > 0) {
                            $fila_hijos = $resultado_hijos->fetch_assoc();
                            $codigo_ultimo_hijo = $fila_hijos['codigo'];
                            $partes_codigo_ultimo_hijo = explode('.', $codigo_ultimo_hijo);
                            $partes_codigo_ultimo_hijo[$nivel_cuenta_padre]++;
                        } else {
                            $partes_codigo_ultimo_hijo = explode('.', $codigo_cuenta_padre);
                            $partes_codigo_ultimo_hijo[$nivel_cuenta_padre]++;
                        }

                        // Rellenar las partes restantes del código con 0
                        for ($i = $nivel_cuenta_padre + 1; $i < 5; $i++) {
                            $partes_codigo_ultimo_hijo[$i] = 0;
                        }

                        $codigo_nueva_cuenta = implode('.', $partes_codigo_ultimo_hijo);
                        $nivel_nueva_cuenta = $nivel_cuenta_padre + 1;

                         // Verificar si el último nivel del código de la cuenta padre es cero
                        if ($partes_codigo_ultimo_hijo[4] > 0) {
                            // Si es cero, se está usando el último nivel y la cuenta es "Detalle"
                            $tipo_cuenta = "Detalle";
                        }       

                        // Insertar la nueva cuenta
                        $consulta = "INSERT INTO cuentas (codigo, nombre_cuenta, nivel, id_empresa_cuenta, id_cuenta_padre, id_usuario_cuenta, tipo_cuenta) VALUES ('$codigo_nueva_cuenta', '$nombre_cuenta', '$nivel_nueva_cuenta', '$id_empresa_cuenta', '$id_cuenta_padre', '$id_usuario_cuenta', '$tipo_cuenta')";
                        $resultado = $conexion->query($consulta);

                        // Verificar si la consulta se ejecutó correctamente
                        if ($resultado) {
                            $response['succes'] = true;
                            die(json_encode($response));
                        } else {
                        }
                    }else {

                    }

                }
                
            }else if($nivel_empresa == 4){
                if($id_cuenta_padre == 0){
                    //si la cuenta padre es 0 se guarda como nulo
                    // Obtener la cuenta de nivel 1 con el código más alto
                    $consulta = "SELECT codigo FROM cuentas WHERE nivel = 1 AND id_empresa_cuenta = $id_empresa_cuenta ORDER BY codigo DESC LIMIT 1";
                    $resultado = $conexion->query($consulta);
        
                    if ($resultado->num_rows > 0) {
                        $fila = $resultado->fetch_assoc();
                        $codigo_cuenta_nivel_1 = $fila['codigo'];
                        $partes_codigo_cuenta_nivel_1 = explode('.', $codigo_cuenta_nivel_1);
                        $partes_codigo_cuenta_nivel_1[0] = $partes_codigo_cuenta_nivel_1[0] + 1;
                    } else {
                        $partes_codigo_cuenta_nivel_1 = array(1);
                    }
        
                    // Rellenar las partes restantes del código con 0
                    for ($i = 1; $i < 4; $i++) {
                        $partes_codigo_cuenta_nivel_1[$i] = 0;
                    }
                    $codigo_nueva_cuenta = implode('.', $partes_codigo_cuenta_nivel_1);
                    $nivel_nueva_cuenta = 1;
        
                    // Insertar la nueva cuenta
                    $consulta = "INSERT INTO cuentas (codigo, nombre_cuenta, nivel, id_empresa_cuenta, id_cuenta_padre, id_usuario_cuenta, tipo_cuenta) VALUES ('$codigo_nueva_cuenta', '$nombre_cuenta', '$nivel_nueva_cuenta', '$id_empresa_cuenta', NULL, '$id_usuario_cuenta', '$tipo_cuenta')";
                    $resultado = $conexion->query($consulta);
        
                    // Verificar si la consulta se ejecutó correctamente
                    if ($resultado) {
                        $response['succes'] = true;
                        die(json_encode($response));
                    } else {
                    }

                }
                else{
                    // Obtener información de la cuenta padre
                    $consulta = "SELECT * FROM cuentas WHERE id_cuenta = $id_cuenta_padre";
                    $resultado = $conexion->query($consulta);

                    if ($resultado->num_rows > 0) {
                        $fila = $resultado->fetch_assoc();
                        $codigo_cuenta_padre = $fila['codigo'];
                        $nivel_cuenta_padre = $fila['nivel'];

                        // Obtener el último hijo de la cuenta padre
                        $consulta_hijos = "SELECT codigo FROM cuentas WHERE id_cuenta_padre = $id_cuenta_padre ORDER BY codigo DESC LIMIT 1";
                        $resultado_hijos = $conexion->query($consulta_hijos);

                        if ($resultado_hijos->num_rows > 0) {
                            $fila_hijos = $resultado_hijos->fetch_assoc();
                            $codigo_ultimo_hijo = $fila_hijos['codigo'];
                            $partes_codigo_ultimo_hijo = explode('.', $codigo_ultimo_hijo);
                            $partes_codigo_ultimo_hijo[$nivel_cuenta_padre]++;
                        } else {
                            $partes_codigo_ultimo_hijo = explode('.', $codigo_cuenta_padre);
                            $partes_codigo_ultimo_hijo[$nivel_cuenta_padre]++;
                        }

                        // Rellenar las partes restantes del código con 0
                        for ($i = $nivel_cuenta_padre + 1; $i < 4; $i++) {
                            $partes_codigo_ultimo_hijo[$i] = 0;
                        }

                        $codigo_nueva_cuenta = implode('.', $partes_codigo_ultimo_hijo);
                        $nivel_nueva_cuenta = $nivel_cuenta_padre + 1;

                         // Verificar si el último nivel del código de la cuenta padre es cero
                        if ($partes_codigo_ultimo_hijo[3] > 0) {
                            // Si es cero, se está usando el último nivel y la cuenta es "Detalle"
                            $tipo_cuenta = "Detalle";
                        }       

                        // Insertar la nueva cuenta
                        $consulta = "INSERT INTO cuentas (codigo, nombre_cuenta, nivel, id_empresa_cuenta, id_cuenta_padre, id_usuario_cuenta, tipo_cuenta) VALUES ('$codigo_nueva_cuenta', '$nombre_cuenta', '$nivel_nueva_cuenta', '$id_empresa_cuenta', '$id_cuenta_padre', '$id_usuario_cuenta', '$tipo_cuenta')";
                        $resultado = $conexion->query($consulta);

                        // Verificar si la consulta se ejecutó correctamente
                        if ($resultado) {
                            $response['succes'] = true;
                            die(json_encode($response));
                        } else {
                        }
                    }else {

                    }

                }
                
            }else if($nivel_empresa == 3){
                if($id_cuenta_padre == 0){
                    //si la cuenta padre es 0 se guarda como nulo
                    // Obtener la cuenta de nivel 1 con el código más alto
                    $consulta = "SELECT codigo FROM cuentas WHERE nivel = 1 AND id_empresa_cuenta = $id_empresa_cuenta ORDER BY codigo DESC LIMIT 1";
                    $resultado = $conexion->query($consulta);
        
                    if ($resultado->num_rows > 0) {
                        $fila = $resultado->fetch_assoc();
                        $codigo_cuenta_nivel_1 = $fila['codigo'];
                        $partes_codigo_cuenta_nivel_1 = explode('.', $codigo_cuenta_nivel_1);
                        $partes_codigo_cuenta_nivel_1[0] = $partes_codigo_cuenta_nivel_1[0] + 1;
                    } else {
                        $partes_codigo_cuenta_nivel_1 = array(1);
                    }
        
                    // Rellenar las partes restantes del código con 0
                    for ($i = 1; $i < 3; $i++) {
                        $partes_codigo_cuenta_nivel_1[$i] = 0;
                    }
                    $codigo_nueva_cuenta = implode('.', $partes_codigo_cuenta_nivel_1);
                    $nivel_nueva_cuenta = 1;
        
                    // Insertar la nueva cuenta
                    $consulta = "INSERT INTO cuentas (codigo, nombre_cuenta, nivel, id_empresa_cuenta, id_cuenta_padre, id_usuario_cuenta, tipo_cuenta) VALUES ('$codigo_nueva_cuenta', '$nombre_cuenta', '$nivel_nueva_cuenta', '$id_empresa_cuenta', NULL, '$id_usuario_cuenta', '$tipo_cuenta')";
                    $resultado = $conexion->query($consulta);
        
                    // Verificar si la consulta se ejecutó correctamente
                    if ($resultado) {
                        $response['succes'] = true;
                        die(json_encode($response));
                    } else {
                    }

                }
                else{
                    // Obtener información de la cuenta padre
                    $consulta = "SELECT * FROM cuentas WHERE id_cuenta = $id_cuenta_padre";
                    $resultado = $conexion->query($consulta);

                    if ($resultado->num_rows > 0) {
                        $fila = $resultado->fetch_assoc();
                        $codigo_cuenta_padre = $fila['codigo'];
                        $nivel_cuenta_padre = $fila['nivel'];

                        // Obtener el último hijo de la cuenta padre
                        $consulta_hijos = "SELECT codigo FROM cuentas WHERE id_cuenta_padre = $id_cuenta_padre ORDER BY codigo DESC LIMIT 1";
                        $resultado_hijos = $conexion->query($consulta_hijos);

                        if ($resultado_hijos->num_rows > 0) {
                            $fila_hijos = $resultado_hijos->fetch_assoc();
                            $codigo_ultimo_hijo = $fila_hijos['codigo'];
                            $partes_codigo_ultimo_hijo = explode('.', $codigo_ultimo_hijo);
                            $partes_codigo_ultimo_hijo[$nivel_cuenta_padre]++;
                        } else {
                            $partes_codigo_ultimo_hijo = explode('.', $codigo_cuenta_padre);
                            $partes_codigo_ultimo_hijo[$nivel_cuenta_padre]++;
                        }

                        // Rellenar las partes restantes del código con 0
                        for ($i = $nivel_cuenta_padre + 1; $i < 3; $i++) {
                            $partes_codigo_ultimo_hijo[$i] = 0;
                        }

                        $codigo_nueva_cuenta = implode('.', $partes_codigo_ultimo_hijo);
                        $nivel_nueva_cuenta = $nivel_cuenta_padre + 1;

                         // Verificar si el último nivel del código de la cuenta padre es cero
                        if ($partes_codigo_ultimo_hijo[2] > 0) {
                            // Si es cero, se está usando el último nivel y la cuenta es "Detalle"
                            $tipo_cuenta = "Detalle";
                        }       
                        // Insertar la nueva cuenta
                        $consulta = "INSERT INTO cuentas (codigo, nombre_cuenta, nivel, id_empresa_cuenta, id_cuenta_padre, id_usuario_cuenta, tipo_cuenta) VALUES ('$codigo_nueva_cuenta', '$nombre_cuenta', '$nivel_nueva_cuenta', '$id_empresa_cuenta', '$id_cuenta_padre', '$id_usuario_cuenta', '$tipo_cuenta')";
                        $resultado = $conexion->query($consulta);

                        // Verificar si la consulta se ejecutó correctamente
                        if ($resultado) {
                            $response['succes'] = true;
                            die(json_encode($response));
                        } else {
                        }
                    }else {

                    }

                }
                
            }          
        }
    }

    public static function eliminarCuenta($indice){
        include_once '../conexion/bd_directa.php';

        $response = array();
        $response['succes'] = false;
        //validar que alj1exista en la bd de la empresa
        $qry = "SELECT * FROM cuentas WHERE id_cuenta = $indice";
        $run = $conexion -> query($qry);
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                $nombre_cuenta = $row['nombre_cuenta'];
                $id_empresa_cuenta = $row['id_empresa_cuenta'];
            }
        }

        //validar que no se este usando si id en otro elemento de la tabla de id_cuenta_padre(relacion con id_cuenta) o que no tenga relacion 
        $qry = "SELECT COUNT(*) as count FROM cuentas WHERE id_cuenta_padre = $indice";
        $result = mysqli_query($conexion, $qry);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row['count'] > 0) {
                $cantidad = $row['count'];
                // El ID de cuenta se está utilizando en otros elementos de la tabla de id_cuenta_padre, por lo que no se puede eliminar
                $response['succes'] = false;
                die(json_encode($response));
                
            }
            else{
                //si no tiene ninguna relacion con ningun elemento de la tabla que se elimine normal
                $qry = "DELETE FROM cuentas WHERE id_cuenta = $indice";
                $result = mysqli_query($conexion, $qry);
                $response['succes'] = true;
                die(json_encode($response));
                
            }
        }        
    }

    public function editarCuenta(){
        include_once '../conexion/bd_directa.php';
    
        $response = array();
        $response['succes'] = false;
        
        //incluir datos del post
        $id_cuenta = $_POST['id_cuenta'];
        $nombre_cuenta = $_POST['nombre_cuenta'];
        $id_empresa_cuenta = $_POST['id_empresa_cuenta'];//id de la empresa

        //validar si el nombre_cuenta es el mismo nombre_cuenta guardado en el id_cuenta
        $sql = "SELECT nombre_cuenta FROM cuentas WHERE id_cuenta = $id_cuenta";
        $resultado = $conexion->query($sql);
        $nombre_cuenta_guardado = $resultado->fetch_array()[0];

        if ($nombre_cuenta === $nombre_cuenta_guardado) {
            $response['succes'] = 'errorIgual';
            die(json_encode($response));
            exit;
        } 

        
    
        //validar que el nombre de la cuenta no se repita dentro de la misma empresa, si no se repite editar datos
        $sql = "SELECT COUNT(*) FROM cuentas WHERE nombre_cuenta = '$nombre_cuenta' AND id_empresa_cuenta = '$id_empresa_cuenta' AND id_cuenta != '$id_cuenta'";
        $resultado = $conexion->query($sql);
        $existe_cuenta = $resultado->fetch_array()[0];

        if ($existe_cuenta > 0) {
            $response['succes'] = 'errorDatoRepetido';
            die(json_encode($response));
        } else {
            $query = "UPDATE cuentas SET nombre_cuenta = '$nombre_cuenta' WHERE id_cuenta = $id_cuenta";
            
            if(mysqli_query($conexion, $query)){
                $response['succes'] = 'guardado';
                die(json_encode($response));
            } else {
                // Error al actualizar la cuenta
            }            
        }
    }
    

}

?>