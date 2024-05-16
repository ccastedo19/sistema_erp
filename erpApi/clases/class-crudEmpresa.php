<?php

class Empresa{



    public function guardarEmpresa(){
        $db = mysqli_connect("localhost","root","","erp");

        $nombre_empresa=$_POST['nombre_empresa'];
        $nit=$_POST['nit'];
        $sigla=$_POST['sigla'];
        $telefono=$_POST['telefono'];
        $correo=$_POST['correo'];
        $direccion=$_POST['direccion'];
        $nivel=$_POST['nivel'];
        $estado=$_POST['estado'];
        $id_usuario_empresa=$_POST['id_usuario_empresa'];

        //variables en mayuscula (3)
        $nombre_empresaM = strtoupper($nombre_empresa);
        $nitM = strtoupper($nit);
        $siglaM = strtoupper($sigla);

        //validaciones
        $qry = "SELECT * FROM empresas";
        $run = $db -> query($qry);
        $num_rows = 0;

        $contNombre = 0;
        $contNit = 0;
        $contSigla = 0;

        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                //string originals
                $idSql = $row['id_empresa'];
                $nombre_empresaSql = $row['nombre_empresa'];
                $nitSql = $row['nit'];
                $siglaSql = $row['sigla'];
                //string en mayuscula
                $nombre_empresaSqlM = strtoupper($nombre_empresaSql);
                $nitSqlM = strtoupper($nitSql);
                $siglaSqlM = strtoupper($siglaSql);

                if ($nombre_empresaSqlM == $nombre_empresaM){
                    $contNombre = $contNombre + 1; 
                }
                if ($nitSqlM == $nitM){
                    $contNit = $contNit+1;
                }
                if ($siglaSqlM == $siglaM){
                    $contSigla = $contSigla + 1;
                }

            }
        }

        $response = array();
        $response['succes'] = '';

        if($contNombre >= 1 && $contNit == 0 && $contSigla == 0){
            $response['succes'] = "nombre";
        }
        else if($contNombre == 0 && $contNit >= 1 && $contSigla == 0){
            $response['succes'] = "nit";
        }
        else if($contNombre == 0 && $contNit == 0 && $contSigla >= 1){
            $response['succes'] = "sigla";
        }
        //doble
        else if($contNombre >= 1 && $contNit >= 1 && $contSigla == 0){
            $response['succes'] = "nombre&nit";
        }
        else if($contNombre >= 1 && $contNit == 0 && $contSigla >= 1){
            $response['succes'] = "nombre&sigla";
        }
        else if($contNombre == 0 && $contNit >= 1 && $contSigla >= 1){
            $response['succes'] = "nit&sigla";
        }
        //los tres
        else if($contNombre >= 1 && $contNit >= 1 && $contSigla >= 1){
            $response['succes'] = "nombre&nit&sigla";
        }

        if ($contNombre == 0 && $contSigla == 0 && $contNit == 0){
            $qry = "INSERT INTO empresas values (null,'$nombre_empresa','$nit','$sigla','$telefono','$correo','$direccion','$nivel','$estado','$id_usuario_empresa')";
            if(mysqli_query($db, $qry)){}

            //registro de la tabla empresa_monedas

            // Establece la zona horaria de Bolivia
            date_default_timezone_set('America/La_Paz');

            //registros puestos:
            //cambio = null
            $activo = 1;
            $fecha_registro = date('Y-m-d H:i:s');
            $id_empresa_m = mysqli_insert_id($db); //id de la empresa recien insertada
            $id_moneda_principal = $_POST['id_moneda_principal'];
            //id_moneda_alternativa = null 
            $id_usuario_moneda = 1; //por ahora
            $qry2 = "INSERT INTO empresa_monedas values(null, null, '$activo','$fecha_registro','$id_empresa_m','$id_moneda_principal',null,'$id_usuario_moneda')";
            if(mysqli_query($db, $qry2)){

            }
            else{
                echo "error al guardar moneda";
            }
            

            //registro de cuenta
            $tipo_cuenta = "Global";
            $nivel_nuevo = 1;
            $id_usuario = 1; //cosa temporal
            if ($nivel == 3){
                $codigo = '1.0.0';
                $nombre_cuenta = "Activo";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}            
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '2.0.0';
                $nombre_cuenta = "Pasivo";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //---------------------------------------------------------------------------------------------------------ss---------------------------------
                $codigo = '3.0.0';
                $nombre_cuenta = "Patrimonio";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '4.0.0';
                $nombre_cuenta = "Ingresos";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '5.0.0';
                $nombre_cuenta = "Egresos";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '5.1.0';
                $nombre_cuenta = "Costos";
                $nivel_nuevo = 2;
                $ultimo_id_cuenta = mysqli_insert_id($db);
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m','$ultimo_id_cuenta')";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '5.2.0';
                $nombre_cuenta = "Gastos";
                $nivel_nuevo = 2;
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m','$ultimo_id_cuenta')";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
            
            }else if($nivel == 4){
                $codigo = '1.0.0.0';
                $nombre_cuenta = "Activo";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '2.0.0.0';
                $nombre_cuenta = "Pasivo";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '3.0.0.0';
                $nombre_cuenta = "Patrimonio";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '4.0.0.0';
                $nombre_cuenta = "Ingresos";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '5.0.0.0';
                $nombre_cuenta = "Egresos";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '5.1.0.0';
                $nombre_cuenta = "Costos";
                $nivel_nuevo = 2;
                $ultimo_id_cuenta = mysqli_insert_id($db);
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m','$ultimo_id_cuenta')";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '5.2.0.0';
                $nombre_cuenta = "Gastos";
                $nivel_nuevo = 2;
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m','$ultimo_id_cuenta')";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
            }else if($nivel == 5){
                $codigo = '1.0.0.0.0';
                $nombre_cuenta = "Activo";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '2.0.0.0.0';
                $nombre_cuenta = "Pasivo";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '3.0.0.0.0';
                $nombre_cuenta = "Patrimonio";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '4.0.0.0.0';
                $nombre_cuenta = "Ingresos";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '5.0.0.0.0';
                $nombre_cuenta = "Egresos";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '5.1.0.0.0';
                $nombre_cuenta = "Costos";
                $nivel_nuevo = 2;
                $ultimo_id_cuenta = mysqli_insert_id($db);
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m','$ultimo_id_cuenta')";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '5.2.0.0.0';
                $nombre_cuenta = "Gastos";
                $nivel_nuevo = 2;
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m','$ultimo_id_cuenta')";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
            }else if($nivel == 6){
                $codigo = '1.0.0.0.0.0';
                $nombre_cuenta = "Activo";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '2.0.0.0.0.0';
                $nombre_cuenta = "Pasivo";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '3.0.0.0.0.0';
                $nombre_cuenta = "Patrimonio";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '4.0.0.0.0.0';
                $nombre_cuenta = "Ingresos";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '5.0.0.0.0.0';
                $nombre_cuenta = "Egresos";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '5.1.0.0.0.0';
                $nombre_cuenta = "Costos";
                $nivel_nuevo = 2;
                $ultimo_id_cuenta = mysqli_insert_id($db);
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m','$ultimo_id_cuenta')";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '5.2.0.0.0.0';
                $nombre_cuenta = "Gastos";
                $nivel_nuevo = 2;
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m','$ultimo_id_cuenta')";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
            }else if($nivel == 7){
                $codigo = '1.0.0.0.0.0.0';
                $nombre_cuenta = "Activo";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '2.0.0.0.0.0.0';
                $nombre_cuenta = "Pasivo";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '3.0.0.0.0.0.0';
                $nombre_cuenta = "Patrimonio";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '4.0.0.0.0.0.0';
                $nombre_cuenta = "Ingresos";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '5.0.0.0.0.0.0';
                $nombre_cuenta = "Egresos";
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m ',null)";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '5.1.0.0.0.0.0';
                $nombre_cuenta = "Costos";
                $nivel_nuevo = 2;
                $ultimo_id_cuenta = mysqli_insert_id($db);
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m','$ultimo_id_cuenta')";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
                $codigo = '5.2.0.0.0.0.0';
                $nombre_cuenta = "Gastos";
                $nivel_nuevo = 2;
                $qryCuenta = "INSERT INTO cuentas values(null,'$codigo','$nombre_cuenta','$tipo_cuenta','$nivel_nuevo','$id_usuario','$id_empresa_m','$ultimo_id_cuenta')";
                if(mysqli_query($db, $qryCuenta)){}
                //------------------------------------------------------------------------------------------------------------------------------------------
            }
            $response['succes'] = "guardado";


        }

        
        die(json_encode($response));    

        
            

    }

    

    public static function eliminarEmpresa($indice){
        $db = mysqli_connect("localhost","root","","erp");
        $resultado = array();
        $resultado['succes'] = '';
        $estadoInactivo = 0;
        $qry = ("UPDATE empresas 
            SET 
            estado  ='" .$estadoInactivo. "'
    
            WHERE id_empresa='" .$indice. "'
            "); 
        if(mysqli_query($db, $qry)){
            $resultado['succes'] = true;      
        }
        else{
            $resultado['succes'] = false;
        }
        die(json_encode($resultado));

    }

    public function editarEmpresa() {
        $conexion = mysqli_connect("localhost", "root", "", "erp");
        //datos principales
        $id_empresa = $_POST['id_empresa'];
        $nombre_empresa = $_POST['nombre_empresa'];
        $nit = $_POST['nit'];
        $sigla = $_POST['sigla'];
        //datos secundarios
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $direccion = $_POST['direccion'];
        $nivel = $_POST['nivel'];
        // datos no usados
        $estado = $_POST['estado'];
        $id_usuario_empresa = $_POST['id_usuario_empresa'];

        $errores = array();
        $validar['succes'] ='';

        //Dato principales en minuscula
        $nombre_empresaM = strtolower($nombre_empresa);
        $siglaM = strtolower($sigla);
        //Datos secundarios en minuscula
        $correoM = strtolower($correo);
        $direccionM = strtolower($direccion);
        //Valida datos del mismo id
        $query = "SELECT * FROM empresas WHERE id_empresa = $id_empresa";
        $run = $conexion -> query($query);
        $num_rows = 0;
        while($row = $run -> fetch_assoc()){ //obtenemos los datos principales Originales
            //datos principales
            $nombre_empresaO = strtolower($row['nombre_empresa']);
            $nitO = strtolower($row['nit']);
            $siglaO = strtolower($row['sigla']);
            //Dato secundarios
            $telefonoO = strtolower($row['telefono']);
            $correoO = strtolower($row['correo']);
            $direccionO = strtolower($row['direccion']);
            $nivelO = strtolower($row['nivel']);

        }
        //si los datos son los mismos de nombre,nit, sigla validar normals
        if($nombre_empresaO == $nombre_empresaM && $nitO == $nit && $siglaO == $siglaM){
            if($nombre_empresaO == $nombre_empresaM && $nitO == $nit && $siglaO == $siglaM && $telefonoO == $telefono && $correoO == $correoM && $direccionO == $direccionM && $nivelO == $nivel){
                //echo "<script type='text/javascript'>
                //    console.log('Todos los datos son iguales');
                //</script>";
                $validar['succes'] ='igual';
                die(json_encode($validar));
                exit;
            }else{
                $query = "UPDATE empresas SET nombre_empresa='$nombre_empresa', nit='$nit', sigla='$sigla', telefono='$telefono', correo='$correo', direccion='$direccion', nivel='$nivel', estado='$estado', id_usuario_empresa='$id_usuario_empresa' WHERE id_empresa=$id_empresa";
                $resultado = mysqli_query($conexion, $query);

                if ($resultado) {
                    // Si la consulta se realizó correctamente, muestra un mensaje de éxito
                    //echo "<script type='text/javascript'>
                    //    console.log('La empresa se actualizó!!');
                    //</script>";
                    $validar['succes'] ='guardado';
                    die(json_encode($validar));
                } else {
                    // Si hubo un error al actualizar la empresa, muestra un mensaje de error
                    //echo "<script type='text/javascript'>
                    //    console.log('Error, hubo un error al actualizar :c');
                    //</script>";
                    
                }
                exit;

            }
            
        }
        //si nombre es diferente y nit y sigla son los mismo de la original
        else if ($nombre_empresaO !== $nombre_empresaM && $nitO == $nit && $siglaO == $siglaM){
            //validamos si nombre no se encuentra repetido en la base de datos y que no sea igual al del mismo id_empresa
            $query = "SELECT COUNT(*) as total FROM empresas WHERE nombre_empresa = '$nombre_empresa' AND id_empresa != $id_empresa";
            $resultado = mysqli_query($conexion, $query);
            $num_filas = mysqli_fetch_assoc($resultado)['total'];
            if ($num_filas == 0) {
                // El nombre no está repetido, se puede actualizar la empresa
                $query = "UPDATE empresas SET nombre_empresa='$nombre_empresa', nit='$nit', sigla='$sigla', telefono='$telefono', correo='$correo', direccion='$direccion', nivel='$nivel', estado='$estado', id_usuario_empresa='$id_usuario_empresa' WHERE id_empresa=$id_empresa";
                $resultado = mysqli_query($conexion, $query);

                if ($resultado) {
                    // Si la consulta se realizó correctamente, muestra un mensaje de éxito
                    //echo "<script type='text/javascript'>
                    //    console.log('La empresa se actualizó!!');
                    //</script>";
                    $validar['succes'] ='guardado';
                    die(json_encode($validar));
                } else {
                    // Si hubo un error al actualizar la empresa, muestra un mensaje de error
                    //echo "<script type='text/javascript'>
                    //    console.log('Error, hubo un error al actualizar :c');
                    //</script>";
                }
                exit;
            } else {
                // El nombre está repetido, se muestra un mensaje de error
                //echo "<script type='text/javascript'>
                //    console.log('Error, el nombre de la empresa ya está en uso :c');
                //</script>";
                $validar['succes'] ='error';
                die(json_encode($validar));
                exit;
            }
            
        }else if ($nombre_empresaO == $nombre_empresaM && $nitO !== $nit && $siglaO == $siglaM){
            //validamos si nit no se encuentra repetido en la base de datos y que no sea igual al del mismo id_empresa
            $query = "SELECT COUNT(*) as total FROM empresas WHERE nit = '$nit' AND id_empresa != $id_empresa";
            $resultado = mysqli_query($conexion, $query);
            $num_filas = mysqli_fetch_assoc($resultado)['total'];
            if ($num_filas == 0) {
                // El nit no está repetido, se puede actualizar la empresa
                $query = "UPDATE empresas SET nombre_empresa='$nombre_empresa', nit='$nit', sigla='$sigla', telefono='$telefono', correo='$correo', direccion='$direccion', nivel='$nivel', estado='$estado', id_usuario_empresa='$id_usuario_empresa' WHERE id_empresa=$id_empresa";
                $resultado = mysqli_query($conexion, $query);

                if ($resultado) {
                    // Si la consulta se realizó correctamente, muestra un mensaje de éxito
                    //echo "<script type='text/javascript'>
                    //    console.log('La empresa se actualizó!!');
                    //</script>";
                    $validar['succes'] ='guardado';
                    die(json_encode($validar));
                } else {
                    // Si hubo un error al actualizar la empresa, muestra un mensaje de error
                    //echo "<script type='text/javascript'>
                    //    console.log('Error, hubo un error al actualizar :c');
                    //</script>";
                    
                }
                exit;
            } else {
                // El nit está repetido, se muestra un mensaje de error
                //echo "<script type='text/javascript'>
                //    console.log('Error, el nit de la empresa ya está en uso :c');
                //</script>";
                $validar['succes'] ='error';
                die(json_encode($validar));
                exit;
            }
                    
        }else if ($nombre_empresaO == $nombre_empresaM && $nitO == $nit && $siglaO !== $siglaM){
            //validamos si sigla no se encuentra repetido en la base de datos y que no sea igual al del mismo id_empresa
            $query = "SELECT COUNT(*) as total FROM empresas WHERE sigla = '$sigla' AND id_empresa != $id_empresa";
            $resultado = mysqli_query($conexion, $query);
            $num_filas = mysqli_fetch_assoc($resultado)['total'];
            if ($num_filas == 0) {
                // La sigla no está repetida, se puede actualizar la empresa
                $query = "UPDATE empresas SET nombre_empresa='$nombre_empresa', nit='$nit', sigla='$sigla', telefono='$telefono', correo='$correo', direccion='$direccion', nivel='$nivel', estado='$estado', id_usuario_empresa='$id_usuario_empresa' WHERE id_empresa=$id_empresa";
                $resultado = mysqli_query($conexion, $query);
                if ($resultado) {
                    // Si la consulta se realizó correctamente, muestra un mensaje de éxito
                    //echo "<script type='text/javascript'>
                    //    console.log('La empresa se actualizó!!');
                    //</script>";
                    $validar['succes'] ='guardado';
                    die(json_encode($validar));
                } else {
                    // Si hubo un error al actualizar la empresa, muestra un mensaje de error
                    //echo "<script type='text/javascript'>
                    //    console.log('Error, hubo un error al actualizar :c');
                    //</script>";
                }
                exit;    
            }else {
                // La sigla está repetida, se muestra un mensaje de error
                //echo "<script type='text/javascript'>
                //    console.log('Error, la sigla ya está en uso :c');
                //</script>";
                $validar['succes'] ='error';
                die(json_encode($validar));
                exit;
            }

        }else if ($nombre_empresaO !== $nombre_empresaM && $nitO == $nit && $siglaO !== $siglaM){
            //validamos si nombre y sigla no se encuentra repetido en la base de datos y que no sea igual al del mismo id_empresa
            $query = "SELECT * FROM empresas WHERE 
                (nombre_empresa = '$nombre_empresa' AND id_empresa != $id_empresa) OR 
                (sigla = '$sigla' AND id_empresa != $id_empresa)";
            $run = $conexion->query($query);
            $num_rows = mysqli_num_rows($run);

            if ($num_rows > 0) {
                // Si hay resultados, significa que ya existe una empresa con el mismo nombre o sigla.
                // Agregar aquí el código a ejecutar en caso de error.
                //echo "<script type='text/javascript'>
                //        console.log('Empresa con el mismo nombre y sigla');
                //    </script>";
                $validar['succes'] ='error';
                die(json_encode($validar));
                exit;
            } else {
                // Si no hay resultados, podemos actualizar los datos de la empresa.
                // Agregar aquí el código a ejecutar en caso de éxito.
                $query = "UPDATE empresas SET nombre_empresa='$nombre_empresa', nit='$nit', sigla='$sigla', telefono='$telefono', correo='$correo', direccion='$direccion', nivel='$nivel', estado='$estado', id_usuario_empresa='$id_usuario_empresa' WHERE id_empresa=$id_empresa";
                $resultado = mysqli_query($conexion, $query);
                if ($resultado) {
                    // Si la consulta se realizó correctamente, muestra un mensaje de éxito
                    //echo "<script type='text/javascript'>
                    //    console.log('La empresa se actualizó!!');
                    //</script>";
                    $validar['succes'] ='guardado';
                    die(json_encode($validar));
                } else {
                    // Si hubo un error al actualizar la empresa, muestra un mensaje de error
                    //echo "<script type='text/javascript'>
                    //    console.log('Error, hubo un error al actualizar :c');
                    //</script>";
                    
                }
                exit;
            }

        }else if ($nombre_empresaO !== $nombre_empresaM && $nitO !== $nit && $siglaO == $siglaM){
           //validamos si nombre y nit no se encuentra repetido en la base de datos y que no sea igual al del mismo id_empresa
           //completa codigo chatGpt 
           $query = "SELECT * FROM empresas WHERE 
                (nombre_empresa = '$nombre_empresa' AND id_empresa != $id_empresa) OR 
                (nit = '$nit' AND id_empresa != $id_empresa)";
            $run = $conexion->query($query);
            $num_rows = mysqli_num_rows($run);

            if ($num_rows > 0) {
                // Si hay resultados, significa que ya existe una empresa con el mismo nombre o nit.
                // Agregar aquí el código a ejecutar en caso de error.
                //echo "<script type='text/javascript'>
                //        console.log('Empresa con el mismo nombre y nit');
                //    </script>";
                $validar['succes'] ='error';
                die(json_encode($validar));
                exit;
            } else {
                // Si no hay resultados, podemos actualizar los datos de la empresa.
                // Agregar aquí el código a ejecutar en caso de éxito.
                $query = "UPDATE empresas SET nombre_empresa='$nombre_empresa', nit='$nit', sigla='$sigla', telefono='$telefono', correo='$correo', direccion='$direccion', nivel='$nivel', estado='$estado', id_usuario_empresa='$id_usuario_empresa' WHERE id_empresa=$id_empresa";
                $resultado = mysqli_query($conexion, $query);
                if ($resultado) {
                    // Si la consulta se realizó correctamente, muestra un mensaje de éxito
                    //echo "<script type='text/javascript'>
                    //    console.log('La empresa se actualizó!!');
                    //</script>";
                    $validar['succes'] ='guardado';
                    die(json_encode($validar));
                } else {
                    // Si hubo un error al actualizar la empresa, muestra un mensaje de error
                    //echo "<script type='text/javascript'>
                    //    console.log('Error, hubo un error al actualizar :c');
                    //</script>";
                }
                exit;
            }
        }else if ($nombre_empresaO == $nombre_empresaM && $nitO !== $nit && $siglaO !== $siglaM){
            //validamos si nit y sigla no se encuentra repetido en la base de datos y que no sea igual al del mismo id_empresa
            //completa codigo chatGpt 
            $query = "SELECT * FROM empresas WHERE 
                (nit = '$nit' AND id_empresa != $id_empresa) OR 
                (sigla = '$sigla' AND id_empresa != $id_empresa)";
            $run = $conexion->query($query);
            $num_rows = mysqli_num_rows($run);

            if ($num_rows > 0) {
                // Si hay resultados, significa que ya existe una empresa con el mismo NIT o sigla.
                // Agregar aquí el código a ejecutar en caso de error.
                //echo "<script type='text/javascript'>
                //        console.log('Empresa con el mismo NIT o sigla');
                //    </script>";
                $validar['succes'] ='error';
                die(json_encode($validar));
                exit;

            } else {
                // Si no hay resultados, podemos actualizar los datos de la empresa.
                // Agregar aquí el código a ejecutar en caso de éxito.
                $query = "UPDATE empresas SET nombre_empresa='$nombre_empresa', nit='$nit', sigla='$sigla', telefono='$telefono', correo='$correo', direccion='$direccion', nivel='$nivel', estado='$estado', id_usuario_empresa='$id_usuario_empresa' WHERE id_empresa=$id_empresa";
                $resultado = mysqli_query($conexion, $query);
                if ($resultado) {
                    // Si la consulta se realizó correctamente, muestra un mensaje de éxito
                    //echo "<script type='text/javascript'>
                    //    console.log('La empresa se actualizó!!');
                    //</script>";
                    $validar['succes'] ='guardado';
                    die(json_encode($validar));
                } else {
                    // Si hubo un error al actualizar la empresa, muestra un mensaje de error
                    //echo "<script type='text/javascript'>
                    //    console.log('Error, hubo un error al actualizar :c');
                    //</script>";
                }
                exit;
            }
        }else if ($nombre_empresaO !== $nombre_empresaM && $nitO !== $nit && $siglaO !== $siglaM){
            //validamos si nombre,nit y sigla no se encuentra repetido en la base de datos y que no sea igual a los datos del mismo id_empresa
            //completa codigo chatGpt 
            // Consulta para verificar si ya existe una empresa con el mismo nombre, NIT o sigla
            $query = "SELECT * FROM empresas WHERE (nombre_empresa = '$nombre_empresa' OR nit = '$nit' OR sigla = '$sigla') AND id_empresa != $id_empresa";
            $result = mysqli_query($conexion, $query);

            // Verificar si la consulta devolvió algún resultado
            if(mysqli_num_rows($result) > 0) {
                // Si ya existe una empresa con el mismo nombre, NIT o sigla, mostrar mensaje de error y detener la ejecución
                //echo "<script type='text/javascript'>
                //        console.log('Error: Ya existe una empresa con el mismo nombre, NIT o sigla');
                //    </script>";
                $validar['succes'] ='error';
                die(json_encode($validar));
                exit;
            }

            // Si no hay empresas con el mismo nombre, NIT o sigla, se pueden actualizar los datos de la empresa
            $query = "UPDATE empresas SET nombre_empresa='$nombre_empresa', nit='$nit', sigla='$sigla', telefono='$telefono', correo='$correo', direccion='$direccion', nivel='$nivel', estado='$estado', id_usuario_empresa='$id_usuario_empresa' WHERE id_empresa=$id_empresa";
            $resultado = mysqli_query($conexion, $query);

            if ($resultado) {
                // Si la consulta se realizó correctamente, muestra un mensaje de éxito
                //echo "<script type='text/javascript'>
                //        console.log('La empresa se actualizó!!');
                //    </script>";
                $validar['succes'] ='guardado';
                die(json_encode($validar));
            } else {
                // Si hubo un error al actualizar la empresa, muestra un mensaje de error
                //echo "<script type='text/javascript'>
                //        console.log('Error, hubo un error al actualizar :c');
                //    </script>";
            }
            exit;
            
        }

        
    }
}


?>