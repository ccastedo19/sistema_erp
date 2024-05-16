<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <script defer src="../js/autor.js" ></script>

    <!--LIBRERIA PARA JQERY PARA VALIDAR EN AJAX FORMULARIO-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--TOASTER-->
    <link href="../css/toastr.min.css" rel="stylesheet">
    <!--my styles-->
    <link href="../css/myStyle.css" rel="stylesheet">
    <!-- Incluir Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
</head>

<body id="page-top">





<?php
    //llegada de datos
    $db = mysqli_connect("localhost","root","","erp");

    if(isset($_GET['enviar'])){
        $busqueda = $_GET['busqueda'];
        $id_empresa = $_GET['id_empresa'];

        if (isset($_GET['busqueda']))
        {
            $qry = "SELECT * FROM empresas WHERE id_empresa = $id_empresa";
            $run = $db -> query($qry);
            $num_rows = 0;
            if($run -> num_rows > 0 ){
                while($row = $run -> fetch_assoc()){
                    $nombre_empresa=$row['nombre_empresa'];
                    $id_empresa= $row['id_empresa'];
                }
            }  

        }
    }else{

        $id_empresa = $_GET['id'];
        $qry = "SELECT * FROM empresas WHERE id_empresa = $id_empresa";
        $run = $db -> query($qry);
        $num_rows = 0;
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                $nombre_empresa=$row['nombre_empresa'];
            }
        } 

    }

    //llegada de datos EmpresaMoneda
    $qry = "SELECT *  FROM empresa_monedas where id_empresa_m = $id_empresa";
    $run = $db -> query($qry);
    $num_rows = 0;
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                $moneda_principalID = $row['id_moneda_principal'];
            }
        } 
    //llegada de datos de moneda
    $qry = "SELECT *  FROM monedas";
    $run = $db -> query($qry);
    $num_rows = 0;
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                if($row['id_moneda'] == $moneda_principalID){
                    $moneda_principal = $row['nombre_moneda'];
                }
            }
        }

   
?>
<?php
    //include('../../erpApi/conexion/bd.php'); //abrimos la conexion

    //$sqlCliente = ("SELECT * FROM empresa_monedas WHERE id_empresa_m = $id_empresa AND id_moneda_alternativa IS NOT NULL");
    //$queryEmpresaMoneda = mysqli_query($con, $sqlCliente);
    //$cantidad     = mysqli_num_rows($queryEmpresaMoneda);

    //$articulos_x_pagina = 3;

    //contar articulos de la bd
    //$total_articulos_db = $cantidad; //la cantidad viene de 'mysqli_num_rows'
    //$paginas = $total_articulos_db/3;
    //$paginas = ceil($paginas); //redondear paginas
    //echo "<script type='text/javascript'>
    //            console.log('Numero de pagina:'.$paginas)';
    //        </script>"; 
            
?>
<?php
    if(!$_GET){
        header("Location:detalleComprobantes.php?id=$id_empresa");
    }    
?>
<!--estilos titulo-->
<style>
    .contenedorTituloImg{
        height: 10rem;
        display: flex;
        align-items: center;
        justify-content: center
    }
    .navLibro{
        width: 60px;
        height: 60px;
        align-items: center;
        display: flex;
        justify-content: center;
    }
    .navLibro2{
        width: 30px;
        align-items: center;
    }
    .tituloInicio{
        font-size:20px;
        font-family:Arial, Helvetica, sans-serif;
        color:white;
        text-align: center;
        align-items: center;
        display: flex;
        justify-content: center;
        
    }
    .tituloNav{
        height: 70px;
        background-color:#E34724 ;
        align-items: center;
        display: flex;
        justify-content: center;
    }
    .imagenPortada{
        text-align: center;
        margin-bottom:15px;   
    }
    
    

</style>

    <!-- Page Wrapper -->
    <div id="wrapper" class="sidebar-toggled">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion toggled" id="accordionSidebar">

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center tituloNav" href="#">
                <div class="sidebar-brand-icon rotate-n-15" >
                    <img class="navLibro" src="../img/logo.png">
                    
                </div>
                <div class="sidebar-brand-text mx-3">DISEÑO DE SOLUCION</div>
                
            </a>   
            
            

            
            <!-- Divider -->
            
            <hr class="sidebar-divider my-0">
            
    

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="inicio.php?id=<?php echo $id_empresa;?>">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
                
            </li>
            
            


            <hr class="sidebar-divider my-0">
    

            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-chart-bar"></i>
                    <span>Contabilidad</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-dark py-2 collapse-inner rounded" >
                        
                        <a style="color:white;" class="collapse-item" href="planCuentas.php?id=<?php echo $id_empresa ?>"><i style="margin-right:10px;" class="fas fa-calculator"></i><span>Plan de Cuentas</span></a>
                        <a style="color:white;" class="collapse-item" href="comprobantes.php?id=<?php echo $id_empresa ?>&paginas=1"><i style="margin-right:10px;" class="fas fa-clipboard-check"></i><span>Comprobante</span></a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item ">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Configuración</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-dark py-2 collapse-inner rounded">
                    <a style="color:white;" class="collapse-item" href="gestiones.php?id=<?php echo $id_empresa;?>&paginas=1"><i style="margin-right:10px;" class="fas fa-calendar-alt"></i><span>Gestión</span></a>
                    <a style="color:white;" class="collapse-item" href="empresaMonedas.php?id=<?php echo $id_empresa;?>&paginas=1"><i style="margin-right:10px;" class="fas fa-dollar-sign"></i><span>Moneda</span></a>
                    <a style="color:white;" class="collapse-item" href="integraciones.php?id=<?php echo $id_empresa;?>"><i style="margin-right:10px;" class="fas fa-cog"></i><span>Integraciones</span></a>    
                </div>
                </div>
            </li>

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-dolly"></i>
                    <span>Inventario</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-dark py-2 collapse-inner rounded">
                        <a style="color:white;" class="collapse-item" href="categoria.php?id=<?php echo $id_empresa ?>"><i style="margin-right:10px;" class="fas fa-bookmark"></i><span>Categoría</span></a>
                        <a style="color:white;" class="collapse-item" href="articulo.php?id=<?php echo $id_empresa;?>&paginas=1"><i style="margin-right:10px;" class="fas fa-folder-open"></i><span>Articulos</span></a>
                        <a style="color:white;" class="collapse-item" href="notaCompra.php?id=<?php echo $id_empresa;?>&paginas=1"><i style="margin-right:10px;" class="fas fa-clipboard-check"></i><span>Nota de Compra</span></a>
                        <a style="color:white;" class="collapse-item" href="notaVenta.php?id=<?php echo $id_empresa;?>&paginas=1"><i style="margin-right:10px;" class="fas fa-comment-dollar"></i><span>Nota de Venta</span></a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider my-0">
            
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport"
                    aria-expanded="true" aria-controls="collapseReport">
                    <i class="fa fa-book"></i>
                    <span>Reportes</span>
                </a>
                <div id="collapseReport" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-dark py-2 collapse-inner rounded">
                        <a style="color:white;" class="collapse-item" href="balance.php?id=<?php echo $id_empresa?>"><i style="margin-right:10px;" class="fa fa-balance-scale"></i><span>Balance Inicial</span></a>
                        <a style="color:white;" class="collapse-item" href="libro_diario.php?id=<?php echo $id_empresa; ?>"><i style="margin-right:10px;" class="fas fa-book-open"></i><span>Libro Diario</span></a>
                        <a style="color:white;" class="collapse-item" href="libro_mayor.php?id=<?php echo $id_empresa; ?>"><i style="margin-right:10px;" class="fas fa-book-reader"></i><span>Libro Mayor</span></a>
                        <a style="color:white;" class="collapse-item" href="suma_saldos.php?id=<?php echo $id_empresa; ?>"><i style="margin-right:10px;" class="fas fa-chart-line"></i><span>Suma y Saldos</span></a>
                        <a style="color:white;" class="collapse-item" href="estadoResultado.php?id=<?php echo $id_empresa; ?>"><i style="margin-right:10px;" class="fas fa-tasks"></i><span>Estado de Resultados</span></a>
                        <a style="color:white;" class="collapse-item" href="articulo_stock.php?id=<?php echo $id_empresa; ?>"><i style="margin-right:10px;" class="fas fa-folder-plus"></i><span>Articulos Stock</span></a>
                    </div>
                </div>
            </li>

            <div style="margin-top: 2rem;" class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-dark topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <style>
                        .btnEliminar{
                            text-decoration:none;
                        }
                        .empresaActual{
                            display:flex;
                            flex-direction:row;
                            margin-right:10px;
                        }
                    </style>
                
                    
                    

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="empresaActual">
                            <h2 style="color:#fff; margin-top:15px; margin-right:10px;">Empresa:</h2>
                            <input style="height:50px;margin-top:10px;padding-left:10px;" value="<?php echo $nombre_empresa ?>" readonly>
                        </div>

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-white-600 small">Administrador</span>
                                <img class="img-profile rounded-circle"
                                    src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown" style="background-color:#5a5c69;">
                                <a class="dropdown-item" style="color:white;" href="empresas.php">
                                    <i class="fas fa-door-open fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Empresas
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" style="color:white;" href="../index.php" >
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Salir
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!--Buscar-->
                

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="crudAutor">
                    <style>
                        .añadir{
                            margin-bottom:10px;
                            margin-right:25px;
                        }
                        .arribaTbl{
                            display:flex;
                            flex-direction:row;
                            justify-content:space-between;
                            margin-top:2.5rem;
                        }
                        .buscar{
                            display:flex;
                            flex-direction:row;
                            gap:7.5px;
                        }
                        .buscador{
                            width:250px;
                        }
                        .btnBuscar{
                            height:38px;
                        }
                        
                        .anadir{
                            margin-right:30px;
                            
                        }
                        .buscarOcultar{
                            display:none;
                        }
                        .btnVolver{
                            display:none;
                            
                            
                        }
                        
                        


                        .txtTitulo{
                            font-family: Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
                        }
                        .FotoAutor{
                            width:40px;
                            height:40px;
                            margin-top:7px;
                            
                        }
                        .txtDichoAutor{
                            /*background-color:yellow;*/
                            width:80rem;
                            margin-top:18px;
                            margin-left:10px;
                            font-family:cursive;
                        }
                        
                        .tablaArriba , .tablaAbajo{
                            display:flex;
                            flex-direction:row;
                            gap:21.3rem;
                        }
                        

                        .ImagenAutor{
                            display:flex;
                            flex-direction:row;
                            
                        }
                        .inputMoneda{
                            width:11rem;
                        }
                        .btnPrincipales{
                            display:flex;
                            flex-direction:row;
                            justify-content:flex-end;
                        }
                        .btnP {
                            width: 20px;
                            height: 20px;
                            filter: invert(1);
                        }
                        .formTabla{
                            display:flex;
                            flex-direction:column;
                            justify-content: space-around;
                        }
                        .formPrincipal{
                            display:flex;
                            flex-direction:column-reverse;
                        }
                        .tablaGlosa{
                            margin-left:12.5rem;
                            position:relative;
                            top:30px;
                        }
                        .formGlosa{
                            gap:5px;
                        }
                    </style>
                    
                    <!-- Page Heading -->

                    <div class="ImagenAutor">
                        <div>
                            <img class="FotoAutor"src="../img/detalleComprobante.png">
                        </div>
                        <div>
                            <h2 style="font-size:25px; margin-top:1rem;" class="txtDichoAutor">Detalles para el nuevo comprobante</h2>
                        </div>
                        
                    </div>

                    
                    
                    

                    <!--Very importan!-->
                <?php
                    include_once '../../erpApi/conexion/bd_directa.php';
                    $query = "SELECT serie FROM comprobantes WHERE id_empresa_comprobante = $id_empresa ORDER BY serie DESC LIMIT 1";
                    $result = mysqli_query($conexion, $query);
                    $row = mysqli_fetch_assoc($result);
                    if (mysqli_num_rows($result) > 0) {
                        $serie = $row['serie'] + 1;
                    } else {
                        $serie = 1;
                    }
                    
                    //fecha_actual
                    date_default_timezone_set('America/La_Paz');
                    $fecha_actual = date("Y-m-d");
                    //moneda
                    
                ?>

                <div class="card shadow mb-4" >
                    <div class="card-header py-3">
                    <?php

                        $query = "SELECT COUNT(*) as count FROM cuentas WHERE id_empresa_cuenta = $id_empresa AND tipo_cuenta = 'Detalle'";

                        $result = mysqli_query($conexion, $query);
                        $row = mysqli_fetch_assoc($result);
                        $count = $row['count'];

                        $disabledButton = "";
                        if ($count <= 1) {
                            $disabledButton = "disabled";
                        }

                    ?>
                    <form class="formPrincipal" method="POST" id="formularioAdd">
                        
                        <div class="formTabla">
                            <div class="tablaArriba">

                                <div class="formSerie">
                                    <label for="validationCustom01" class="col-form-label">Serie</label> <!--comprobantes-->
                                    <input type="number" class="form-control inputMoneda no-arrow" id="serie" name="serie" value="<?php echo $serie ?>" required readonly <?php echo $disabledButton; ?>>
                                </div>
                                <div  class="formFecha">
                                    <label for="validationCustom01" class="col-form-label">Fecha</label><!--comprobantes-->
                                    <input type="date" class="form-control inputMoneda no-arrow" id="fecha_comprobante" name="fecha_comprobante" value="<?php echo $fecha_actual?>" required <?php echo $disabledButton; ?> >
                                </div>
                                <div  class="formTipoComprobante">
                                    <label for="validationCustom01" class="col-form-label">Tipo de Comprobante</label><!--comprobantes-->
                                    <select style="width:11rem;" class="form-control" id="tipo_comprobante" name="tipo_comprobante" <?php echo $disabledButton; ?> > 
                                        <option value= "Ingreso">Ingreso</option> 
                                        <option value= "Egreso">Egreso</option>
                                        <option value= "Traspaso">Traspaso</option>
                                        <option value= "Apertura">Apertura</option>
                                        <option value= "Ajuste">Ajuste</option>
                                    </select>  
                                </div>
                                <div  class="formEstado">
                                    <label for="validationCustom01" class="col-form-label">Estado</label><!--comprobantes-->
                                    <select style="width:11rem;" class="form-control" id="estado_comprobante" name="estado_comprobante" disabled <?php echo $disabledButton; ?>>
                                        <option value='1'>Abierto</option>
                                        <option value='0'>Anulado</option>
                                    </select>
                                </div>  

                            </div>

                            <div style="margin-top:20px;" class="tablaAbajo">
                                <div  class="formTC">
                                    <label for="validationCustom01" class="col-form-label">TC</label><!--comprobantes-->
                                    <?php
                                        $query = "
                                            SELECT
                                            empresa_monedas.cambio
                                            FROM
                                            empresa_monedas
                                            INNER JOIN empresas ON empresa_monedas.id_empresa_m = empresas.id_empresa
                                            WHERE
                                            empresas.id_empresa = ? AND
                                            empresa_monedas.activo = 1;
                                        ";
                                        
                                        $stmt = mysqli_prepare($conexion, $query);
                                        
                                        if (!$stmt) {
                                            echo "Error al preparar la consulta: " . mysqli_error($conexion);
                                            exit();
                                        }
                                        
                                        mysqli_stmt_bind_param($stmt, "i", $id_empresa);
                                        
                                        if (!mysqli_stmt_execute($stmt)) {
                                            echo "Error al ejecutar la consulta: " . mysqli_stmt_error($stmt);
                                            exit();
                                        }
                                        
                                        $result = mysqli_stmt_get_result($stmt);
                                        
                                        if (mysqli_num_rows($result) == 0) {
                                            echo "No se encontraron resultados";
                                            exit();
                                        }
                                        
                                        $row = mysqli_fetch_assoc($result);
                                        ?>
                                        <input type="number" class="form-control inputMoneda no-arrow" name="tc" step="any" min="0.01" value="<?php echo $row['cambio']; ?>" pattern="^([1-9]\d*(\.\d+)?|0\.\d*[1-9]\d*)$" title="Por favor, ingrese un número mayor a 0" id="tc" required <?php echo $disabledButton; ?>>

                
                                </div>
                                <div class="formMoneda">
                                    <label for="validationCustom01" class="col-form-label">Moneda</label>
                                    <?php
                                    include_once '../../erpApi/conexion/bd_directa.php';
                                    $query = "
                                        SELECT
                                            monedas_principal.id_moneda AS id_moneda_principal,
                                            monedas_principal.nombre_moneda AS nombre_moneda_principal,
                                            monedas_principal.abreviatura AS abreviatura_principal,
                                            monedas_alternativa.id_moneda AS id_moneda_alternativa,
                                            monedas_alternativa.nombre_moneda AS nombre_moneda_alternativa,
                                            monedas_alternativa.abreviatura AS abreviatura_alternativa
                                        FROM
                                            empresa_monedas
                                            INNER JOIN monedas AS monedas_principal ON empresa_monedas.id_moneda_principal = monedas_principal.id_moneda
                                            LEFT JOIN monedas AS monedas_alternativa ON empresa_monedas.id_moneda_alternativa = monedas_alternativa.id_moneda
                                            INNER JOIN empresas ON empresa_monedas.id_empresa_m = empresas.id_empresa
                                        WHERE
                                            empresas.id_empresa = ? AND empresa_monedas.activo = 1;
                                        ";

                                    $stmt = mysqli_prepare($conexion, $query);

                                    if (!$stmt) {
                                        echo "Error al preparar la consulta: " . mysqli_error($conexion);
                                        exit();
                                    }

                                    mysqli_stmt_bind_param($stmt, "i", $id_empresa);

                                    if (!mysqli_stmt_execute($stmt)) {
                                        echo "Error al ejecutar la consulta: " . mysqli_stmt_error($stmt);
                                        exit();
                                    }

                                    $result = mysqli_stmt_get_result($stmt);

                                    if (mysqli_num_rows($result) == 0) {
                                        echo "No se encontraron resultados";
                                        exit();
                                    }
                                    ?>

                                    <select style="width:11rem;" class="form-control" name="id_moneda" id="id_moneda" <?php echo $disabledButton; ?>>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $row['id_moneda_principal'] . '">' . $row['nombre_moneda_principal'] . ' (' . $row['abreviatura_principal'] . ')</option>';

                                        if (!is_null($row['id_moneda_alternativa']) && $row['id_moneda_alternativa'] != "") {
                                            echo '<option value="' . $row['id_moneda_alternativa'] . '">' . $row['nombre_moneda_alternativa'] . ' (' . $row['abreviatura_alternativa'] . ')</option>';
                                        }
                                    }

                                    echo '</select>';

                                    // ...
                                    ?>
                                </div>
                                <div class="formGlosa"><!--comprobantes-->
                                    <label for="validationCustom01" class="col-form-label">Glosa</label>
                                    <input style="width:33rem;" type="text" class="form-control inputMoneda" id="glosa_principal" name="glosa_principal" <?php echo $disabledButton; ?>>
                                </div>
                            </div>

                        </div>
                        <div class="btnPrincipales" > 
                            <div style="margin-right:96.5rem;" class="VovlerC left">
                                    <a class="btn btn-info" href="comprobantes.php?id=<?php echo $id_empresa?>&paginas=1" title="Volver">Volver</a>                                
                            </div>    
                            <div class="anadirC">
                                <button style="position:relative;left:25px;"  title="Guardar" type="submit" class="btn btn-success añadir" id="guardarBtn">Guardar</button>                                
                            </div>
                                
                            <div style="display:none;" class="LimpiarC">
                                    <button style="background-color:#000;position:relative;left:20px;"  title="Anular" type="button" id="anularBtn" class="btn btn-dark añadir">Anular</button>                                
                            </div>
                            
                        </div>

                        
                    </form>


                    <hr style="margin-top:3rem;">
                    <div class="arribaTbl">
                        
                        <!--<form action="" method="GET">
                            <div class="buscar">
                                <input style="border-color:#858796; margin-bottom:15px;"  type="text" class="form-control buscador"  required  name="busqueda" placeholder="Buscar...">
                                <input type="hidden" name="id_empresa" value="<?php //echo $id_empresa; ?>">
                                <button type="submit" name="enviar" class="btn btnBuscar" style="background-color:#3598D9; color:white; border:none;">Buscar</button>
                            </div>
                        </form>-->
                        
                    </div>
                    
                    
                    <!--MODAL PARA AÑADIR-->

                    <style>
                        
                        /* Estilos para quitar las flechas del input de tipo number */
                        .no-arrow::-webkit-outer-spin-button,
                        .no-arrow::-webkit-inner-spin-button {
                            -webkit-appearance: none;
                            margin: 0;
                        }
                        .no-arrow {
                            -moz-appearance: textfield;
                        }
                    </style>


                

                    
                    <style>
                        th, td{
                            text-align:center;
                            border: 1px solid #D0D1C8;
                        }
                        td{
                            background-color:#F1EDED;
                        }
                    </style>
                    <button style="float:right;position:relative;bottom:25px;" class="btn btn-success" data-toggle="modal" data-target="#addModal" id="addDetalleBtn">Añadir Detalle</button>

                    <!--Modal añadir-->
                    <div class="modal fade" id="addModal">
                        <div class="modal-dialog">
                            <div class="modal-content" style="width: 80rem;position:relative; right:20rem;top:8rem;">
                            <form id="addForm">
                                <div class="modal-header" style="background-color:#1cc88a">
                                    <h4 class="modal-title" style="color:#fff;">Añadir Detalle</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="form-control">Cuenta</label><!--detalle_comprobantes(plan de cuentas)-->
                                            <?php
                                                include_once '../../erpApi/conexion/bd_directa.php';
                                                $query = "SELECT cuentas.id_cuenta, cuentas.codigo, cuentas.nombre_cuenta
                                                FROM cuentas
                                                INNER JOIN empresas ON cuentas.id_empresa_cuenta = empresas.id_empresa
                                                WHERE empresas.id_empresa = '$id_empresa' AND cuentas.tipo_cuenta = 'Detalle'";
    
                                                $result = mysqli_query($conexion, $query);
    
                                                if (!$result) {
                                                    echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
                                                    exit();
                                                }
                                                
                                                $disabled = "";
                                                if (mysqli_num_rows($result) == 0) {
                                                    echo "No se encontraron resultados";
                                                    $disabled = "disabled";
                                                }
                                                $disabledButton = "";
                                                if (mysqli_num_rows($result) <= 1) {
                                                    $disabledButton = "disabled";
                                                }
                                    
                                                $option_html = "";
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $option_html .= '<option value="' . $row['id_cuenta'] . '">' . $row['codigo'] . ' - ' . $row['nombre_cuenta'] . '</option>';
                                                }
                                                ?>
                                                <select class="form-control" name="cuentas" id="cuentas" <?php echo $disabled; ?>>
                                                    <?php echo $option_html; ?>
                                                </select>
                                        </div>
                                        <div class="form-group col">
                                            <label for="form-control">Glosa</label><!--detalle_comprobantes(misma que la glosa de )-->
                                            <input type="text" class="form-control" id="add_glosa" name="add_glosa">
                                        </div>
                                        <div class="form-group col">
                                            <label for="form-control">Debe</label>
                                            <input  type="number" class="form-control no-arrow" id="add_debe" name="add_debe" style="text-align:right;" value='0'>
                                        </div>
                                        <div class="form-group col">
                                            <label for="form-control">Haber</label>
                                            <input type="number" class="form-control no-arrow" id="add_haber" name="add_haber" style="text-align:right;" value='0'>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="cerrarMD">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                    <div class="acciones">
                                        <button type="submit" class="btn btn-success" id="btn-submit">Guardar</button>           
                                    </div>    
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>

                    
                    <script>
                       
                        // Obtén una referencia a los elementos input
                        const glosaInput = document.getElementById('glosa_principal');
                        const addGlosaInput = document.getElementById('add_glosa');

                        // Agrega un evento de escucha al primer input
                        glosaInput.addEventListener('input', function () {
                            // Actualiza el valor del segundo input con el valor del primero
                            addGlosaInput.value = glosaInput.value;
                        });
                        $(document).ready(function () {
                            // Inicializa Select2 en el elemento select
                            $('#cuentas').select2();
                        });
                    </script>
                    

                    <!-- Modal editar -->
                    <div class="modal fade" id="editModal">
                        <div class="modal-dialog">
                            <div class="modal-content" style="width: 80rem;position:relative; right:20rem;top:8rem;">
                                <form id="editForm">
                                    <div class="modal-header" style="background-color:#f6c23e">
                                        <h4 class="modal-title" style="color:#fff;">Editar Cuenta</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col">
                                                <label for="form-control">Cuenta</label>
                                                <!-- El código PHP para generar el select de cuentas se mantiene igual -->
                                                <select class="form-control" name="edit_cuentas" id="edit_cuentas" <?php echo $disabled; ?> disabled>
                                                    <?php echo $option_html; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col">
                                                <label for="form-control">Glosa</label>
                                                <input type="text" class="form-control" id="edit_glosa" name="edit_glosa">
                                            </div>
                                            <div class="form-group col">
                                                <label for="form-control">Debe</label>
                                                <input type="text" class="form-control" id="edit_debe" name="edit_debe" value='0' style="text-align:right;">
                                            </div>
                                            <div class="form-group col">
                                                <label for="form-control">Haber</label>
                                                <input type="text" class="form-control" id="edit_haber" name="edit_haber" value='0' style="text-align:right;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-warning" id="btn-edit">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <style>
                            .table-scroll{
                                position:relative;
                                bottom:15px;
                                width:108rem;
                                height:300px;
                                overflow-y: auto; /* habilita el scroll vertical */
                                display: block; /* establece el contenedor como un bloque para permitir el desplazamiento */
                            }
                            .table-scroll thead th {
                                position: sticky;
                                top: 0;
                                z-index: 100;
                                background-color:#5a5c69; /* Asegura que el fondo del encabezado sea opaco y no se vea el texto debajo */
                                color:#fff;
                                box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4); /* Añade sombra al encabezado */
                            }
                            .table-scroll tfoot td {
                                position: sticky;
                                bottom: 0;
                                z-index: 100;
                                background-color:#F8F5F5; /* Asegura que el fondo del pie de tabla sea opaco y no se vea el texto debajo */
                                color:#212529;
                                box-shadow: 0 -2px 2px -1px rgba(0, 0, 0, 0.4); /* Añade sombra al pie de tabla */
                            }
                    </style>
                    <div class="table-scroll">
                        <table class="table" id="tablaDetalles">
                            <thead style="background-color:#5a5c69; color:#fff;">
                                <tr>
                                    <th scope="col">Cuenta</th>
                                    <th scope="col">Glosa</th>
                                    <th scope="col">Debe</th>
                                    <th scope="col">Haber</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyDetalles">
                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <strong>Total Debe:</strong>
                                    <span id="totalDebe">0</span>
                                </td>
                                <td>
                                    <strong>Total Haber:</strong>
                                    <span id="totalHaber">0</span>
                                </td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    
                    <script>
                        let detalles = []; //array donde se guardan los datos traidos del formulario 
                        let currentIndex = -1; //para funcion de editar

                        function eliminarFila(button) {
                            let tbody = document.getElementById('tbodyDetalles');
                            let tr = button.parentElement.parentElement;
                            let id_cuenta = tr.querySelector('td').dataset.idCuenta; // Obtiene el id_cuenta del elemento a eliminar

                            let index = detalles.findIndex(detalle => detalle.id_cuenta === id_cuenta); // Encuentra el índice en el array detalles

                            Swal.fire({
                                title: 'Eliminar Registro',
                                text: "Está seguro que desea eliminar el registro?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, seguro',
                                cancelButtonText: 'Cancelar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    detalles.splice(index, 1); // Elimina el elemento del array detalles
                                    tbody.removeChild(tr); // Elimina la fila de la tabla

                                    console.log('despues de eliminar: ', detalles);

                                    // Actualiza los totales
                                    checkTableRecords();
                                }
                            });
                        }

                        function resetearFORM(){
                            document.getElementById('add_debe').value = '0';
                            document.getElementById('add_haber').value = '0';
                        }

                        function checkTableRecords() {
                            let noRecordsMessage = document.getElementById('noRecordsMessage');
                            let totalDebe = 0;
                            let totalHaber = 0;

                            for (let i = 0; i < detalles.length; i++) {
                                totalDebe += parseInt(detalles[i].debe);
                                totalHaber += parseInt(detalles[i].haber);
                            }

                            document.getElementById('totalDebe').textContent = totalDebe;
                            document.getElementById('totalHaber').textContent = totalHaber;

                            if (detalles.length === 0) {
                                if (!noRecordsMessage) {
                                let newRow = tbodyDetalles.insertRow(-1);
                                newRow.id = 'noRecordsMessage';
                                newRow.className = 'text-center';
                                newRow.innerHTML = '<td style="color:black;" colspan="5">No hay registros</td>';
                                } else {
                                noRecordsMessage.style.display = '';
                                }
                            } else {
                                if (noRecordsMessage) {
                                noRecordsMessage.style.display = 'none';
                                }
                            }
                        }
                        function validacion(texto){
                            Command: toastr["error"](texto)
                                toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                        }
                        
                        //añadir elemento al array
                        document.getElementById('addForm').addEventListener('submit', function (event) {
                            event.preventDefault();
                            

                            let id_cuenta = document.getElementById('cuentas').value;
                            let cuenta_text = document.getElementById('cuentas').options[document.getElementById('cuentas').selectedIndex].text;
                            let debe = document.getElementById('add_debe').value;
                            let haber = document.getElementById('add_haber').value;
                            let glosa = document.getElementById('add_glosa').value;
                            // Validaciones
                            let contValidaciones = 0;
                            if (detalles.map(d => d.id_cuenta).includes(id_cuenta)) {
                                texto = "La cuenta ya se encuentra registrada";
                                validacion(texto);
                                contValidaciones += 1
                            }
                            if(debe < 0 || haber < 0){
                                texto = "No puede haber numero negativo";
                                validacion(texto);
                                contValidaciones += 1
                            }
                            if(debe > 0 && haber > 0){
                                texto = "No puede haber un monto en el Debe y el Haber, solo en uno";
                                validacion(texto);
                                contValidaciones += 1
                            }
                            if(debe == 0 && haber == 0){
                                texto = "Coloque un monto en el Debe o Haber";
                                validacion(texto);
                                contValidaciones += 1
                            }
                            if(debe > 0 && haber == ""){
                                //el espacio vacio se valida con cero
                                haber = 0;
                            }
                            if(debe == "" && haber > 0){
                                //el espacio vacio se valida con cero
                                debe = 0;
                            }

                            if(contValidaciones > 0){
                                return
                            }else{
                                Command: toastr["success"]("Se registró el detalle")
                                toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                                }
                                resetearFORM();
                            }

                            //------------------------------------------------------------------

                            let tbodyDetalles = document.getElementById('tbodyDetalles');
                            let newRow = tbodyDetalles.insertRow(-1);

                            newRow.innerHTML = `
                            <td style="color:#858796" data-id-cuenta="${id_cuenta}">${cuenta_text}</td>
                            <td style="color:#858796">${glosa}</td>
                            <td style="color:#858796;text-align:right;">${debe}</td>
                            <td style="color:#858796;text-align:right;">${haber}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="eliminarFila(this)"><i class="fas fa fa-trash" aria-hidden="true"></i></button>
                                <button class="btn btn-warning btn-sm" onclick="editarFila(this)"><i class="fas fa fa-edit" aria-hidden="true"></i></button>
                            </td>
                            `;


                            detalles.push({
                                id_cuenta: id_cuenta,
                                debe: debe,
                                haber: haber,
                                glosa: glosa
                            });

                            console.log(detalles);
                            //$('#addModal').modal('hide');

                            checkTableRecords();
                        });
                        

                        checkTableRecords();
                    </script>
                    <script>
                        function editarFila(button) {
                            let tr = button.parentElement.parentElement;
                            let id_cuenta = tr.querySelector('td').dataset.idCuenta;
                            let glosa = tr.children[1].textContent;
                            let debe = tr.children[2].textContent;
                            let haber = tr.children[3].textContent;

                            // Encuentra el índice en el array detalles
                            currentIndex = detalles.findIndex(detalle => detalle.id_cuenta === id_cuenta);

                            // Muestra el modal de edición
                            $('#editModal').modal('show');

                            let selectCuentas = document.getElementById('edit_cuentas');
                            let targetOption = selectCuentas.querySelector(`option[value="${id_cuenta}"]`);
                            selectCuentas.value = targetOption.value;

                            document.getElementById('edit_glosa').value = glosa;
                            document.getElementById('edit_debe').value = debe;
                            document.getElementById('edit_haber').value = haber;
                        }

                        document.getElementById('editForm').addEventListener('submit', function (event) {
                            event.preventDefault();
                            let contValidaciones = 0;
                            let debe = parseFloat(document.getElementById('edit_debe').value);
                            let haber = parseFloat(document.getElementById('edit_haber').value);

                            debe = isNaN(debe) ? 0 : debe;
                            haber = isNaN(haber) ? 0 : haber;

                            if (debe > 0 && haber > 0) {
                                let texto = "No puede haber un monto en el Debe y el Haber, solo en uno";
                                validacion(texto);
                                contValidaciones += 1;
                            }
                            if (debe == 0 && haber == 0) {
                                let texto = "Coloque un monto en el Debe o Haber";
                                validacion(texto);
                                contValidaciones += 1;
                            }

                            if (contValidaciones > 0) {
                                return;
                            }

                            let originalIdCuenta = detalles[currentIndex].id_cuenta;
                            let tr = document.querySelector(`td[data-id-cuenta="${originalIdCuenta}"]`).parentElement;

                            detalles[currentIndex].id_cuenta = document.getElementById('edit_cuentas').value;
                            detalles[currentIndex].glosa = document.getElementById('edit_glosa').value;
                            detalles[currentIndex].debe = debe; // actualizar con la variable debe
                            detalles[currentIndex].haber = haber; // actualizar con la variable haber

                            tr.querySelector('td').dataset.idCuenta = detalles[currentIndex].id_cuenta;
                            tr.children[1].textContent = detalles[currentIndex].glosa;
                            tr.children[2].textContent = detalles[currentIndex].debe;
                            tr.children[3].textContent = detalles[currentIndex].haber;

                            $('#editModal').modal('hide');

                            document.getElementById('editForm').reset();

                            checkTableRecords();
                        });

                    </script>
                    <!--recibir los datos para guardarlos-->
                    <script>
                        function handleSubmit(event) {
                            event.preventDefault();

                            const serie = document.getElementById('serie').value;
                            const fecha_comprobante = document.getElementById('fecha_comprobante').value;
                            const tipo_comprobante = document.getElementById('tipo_comprobante').value;
                            const estado_comprobante = document.getElementById('estado_comprobante').value;
                            const tc = document.getElementById('tc').value;
                            const id_moneda = document.getElementById('id_moneda').value;
                            const glosa_principal = document.getElementById('glosa_principal').value;
                            const id_empresa = <?php echo $id_empresa ?>;

                            console.log('Serie:', serie);
                            console.log('Fecha:', fecha_comprobante);
                            console.log('Tipo de Comprobante:', tipo_comprobante);
                            console.log('Estado:', estado_comprobante);
                            console.log('TC:', tc);
                            console.log('id_moneda:', id_moneda);
                            console.log('Glosa:', glosa_principal);
                            console.log('id_empresa:', id_empresa);
                            console.log('detalles_actuales:',detalles)

                            guardarComprobante(serie,fecha_comprobante,estado_comprobante,tipo_comprobante,tc,id_moneda,glosa_principal,id_empresa,detalles,event)
                        }

                        document.addEventListener('DOMContentLoaded', function() {
                            const form = document.getElementById('formularioAdd');
                            form.addEventListener('submit', handleSubmit);
                        });
                    </script>

                    <script src="../js/jquery.min.js"></script>
                    <script src="../js/popper.min.js"></script>


                    </div>
                    
                    
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            </div>
    </div>
            <!-- Footer -->
            <br>
            <footer class="sticky-footer bg-dark">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span style="color:white">Copyright &copy; Cesar Castedo</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <style>
        .modal-dialog{
            margin-top:5rem;
        }
    </style>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div style="background-color:#3598D9; color:#ffff;" class="modal-header">
                    <h5  class="modal-title" id="exampleModalLabel">Administrador</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div style="font-size:25px;" class="modal-body">Desea cerrar sesión?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a style="background-color:#3598D9; border:none; width:100px;" class="btn btn-primary" href="../index.php">Sí, Cerrar</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        //botones desabilitados si hay menos de 2 cuentas "Detalle"
        $(document).ready(function () {
        <?php if ($disabledButton == "disabled") : ?>
            $('#addDetalleBtn').prop('disabled', true);
            $('#anularBtn').prop('disabled', true);
            $('#guardarBtn').prop('disabled', true);
            Swal.fire({
            title: '<strong>Tomar en cuenta.</strong>',
            icon: 'info',
           html:
                'No hay cuentas Detalle suficientes para realizar comprobante. ' +
                '' +
               '',
            showCloseButton: true,
            focusConfirm: false,
        
            confirmButtonText:
                'OK',

            })

        <?php endif; ?>
        
    });
    </script>

    <!--Responsive-->
    
    <style>
        @media only screen and (max-width: 600px) {
        body {
            background-color: lightblue;
        }
        }
    </style>

   
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>

    <!-- Axios js-->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!--controlador-->
    <script src="../js/controlador.js"></script>
    <!--sweetalert2-->
    <script src="../js/sweetalert2.all.min.js"></script>
    <!--Validar Formularios-->
    <script src="../js/validarFormulario.js"></script>
    <!--Toaster-->
    <script src="../js/toastr.min.js"></script>
    
    <!-- Incluir Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    
</body>

</html>