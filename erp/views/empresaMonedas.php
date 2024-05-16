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
    include('../../erpApi/conexion/bd.php'); //abrimos la conexion

    $sqlCliente = ("SELECT * FROM empresa_monedas WHERE id_empresa_m = $id_empresa AND id_moneda_alternativa IS NOT NULL");
    $queryEmpresaMoneda = mysqli_query($con, $sqlCliente);
    $cantidad     = mysqli_num_rows($queryEmpresaMoneda);

    $articulos_x_pagina = 3;

    //contar articulos de la bd
    $total_articulos_db = $cantidad; //la cantidad viene de 'mysqli_num_rows'
    $paginas = $total_articulos_db/3;
    $paginas = ceil($paginas); //redondear paginas
    echo "<script type='text/javascript'>
                console.log('Numero de pagina:'.$paginas)';
            </script>"; 
            
?>
<?php
    if(!$_GET){
        header("Location:empresaMonedas.php?id=$id_empresa&paginas=1");
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
    

            <li class="nav-item">
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
            <li class="nav-item active">
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
                            margin-top:38px;
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
                            width:120px;
                            height:120px;
                            margin-top:15px;
                            
                        }
                        .txtDichoAutor{
                            /*background-color:yellow;*/
                            width:80rem;
                            margin-top:18px;
                            margin-left:10px;
                            font-family:cursive;
                        }
                        .formPrincipal{
                            display:flex;
                            flex-direction:row;
                            font-size:17.5px;
                            justify-content: space-around;
                            
                            
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
                            flex-direction:row;
                            gap:33rem;
                        }
                    </style>
                    
                    <!-- Page Heading -->

                    <div class="ImagenAutor">
                        <div>
                            <img class="FotoAutor"src="../img/monedas.png">
                        </div>
                        <div>
                            <h2 style="font-size:47px; margin-top:4rem;" class="txtDichoAutor">Monedas de la Empresa <?php echo $nombre_empresa ?></h2>
                        </div>
                        
                    </div>

                    
                    
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <!--<h1 style="margin-left:10px; margin-top:5px; font-family:cursive" class="h3 mb-0 text-gray-800">Empresas</h1>-->
                        
                    </div>

                    <!--Very importan!-->

                <div class="card shadow mb-4" >
                    <div class="card-header py-3">

                    
                    <form class="formPrincipal" method="POST" onsubmit="guardarEmpresaMoneda(event)" id="formularioAdd">
                        
                        <div class="formTabla">
                            <div class="formMonedaPrincipal">
                                <?php
                                include('../../erpApi/conexion/bd_directa.php'); //abrimos la conexion

                                $id_moneda_principal = null;
                                $id_moneda_alternativa = null;

                                $query_empresa_monedas = "SELECT id_moneda_principal, id_moneda_alternativa FROM empresa_monedas WHERE id_empresa_m = $id_empresa";
                                $resultado_empresa_monedas = mysqli_query($conexion, $query_empresa_monedas);

                                if ($fila = mysqli_fetch_assoc($resultado_empresa_monedas)) {
                                    $id_moneda_principal = $fila['id_moneda_principal'];
                                    $id_moneda_alternativa = $fila['id_moneda_alternativa'];
                                }

                                // Consulta para obtener las monedas de la tabla 'monedas'
                                $query = "SELECT id_moneda, nombre_moneda, abreviatura FROM monedas";
                                $resultado = mysqli_query($conexion, $query);
                                ?>
                                <label for="validationCustom01" class="col-form-label">Moneda Principal</label>
                                <select class="form-control" name="id_moneda_principal" id="id_moneda_principal" disabled>
                                    <?php
                                    // Recorre los resultados y genera las opciones del elemento <select>
                                    while ($row = mysqli_fetch_assoc($resultado)) {
                                        echo '<option value="' . $row['id_moneda'] . '"' . ($row['id_moneda'] == $id_moneda_principal ? ' selected' : '') . '>' . $row['nombre_moneda'] . ' ' . $row['abreviatura'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="formMonedaAlternativa">
                                <?php
                                //abrimos la conexion
                                include('../../erpApi/conexion/bd_directa.php');

                                // Obtener la moneda alternativa de la empresa
                                $query_moneda_alternativa = "SELECT id_moneda_alternativa FROM empresa_monedas WHERE id_empresa_m = $id_empresa AND activo = 1";
                                $resultado_moneda_alternativa = mysqli_query($conexion, $query_moneda_alternativa);
                                $id_moneda_alternativa = null;

                                if ($fila = mysqli_fetch_assoc($resultado_moneda_alternativa)) {
                                    $id_moneda_alternativa = $fila['id_moneda_alternativa'];
                                }

                                
                                // Verificar si existe algún comprobante con $id_empresa
                                $query_comprobantes = "SELECT COUNT(*) AS count FROM comprobantes WHERE id_empresa_comprobante = $id_empresa";
                                $resultado_comprobantes = mysqli_query($conexion, $query_comprobantes);
                                $comprobante_existente = false;
                                
                                if ($fila = mysqli_fetch_assoc($resultado_comprobantes)) {
                                    if ($fila['count'] > 0) {
                                        $comprobante_existente = true;
                                    }
                                }
                                
                                // Si hay comprobantes existentes, verificar si se está usando la moneda alternativa
                                $moneda_alternativa_usada = false;
                                
                                if ($comprobante_existente) {
                                    $query_moneda_usada = "SELECT COUNT(*) AS count FROM empresa_monedas em INNER JOIN comprobantes c ON em.id_empresa_m = c.id_empresa_comprobante WHERE em.id_empresa_m = $id_empresa AND em.id_moneda_alternativa = c.id_moneda AND em.activo = 1";
                                    $resultado_moneda_usada = mysqli_query($conexion, $query_moneda_usada);
                                    
                                    if ($fila = mysqli_fetch_assoc($resultado_moneda_usada)) {
                                        if ($fila['count'] > 0) {
                                            $moneda_alternativa_usada = true;
                                        }
                                    }
                                }
                                
                                // Consulta para obtener las monedas de la tabla 'monedas'
                                $query = "SELECT id_moneda, nombre_moneda, abreviatura FROM monedas";
                                $resultado = mysqli_query($conexion, $query);
                                ?>
                                <label for="validationCustom01" class="col-form-label">Moneda Alternativa</label>
                                <select class="form-control" name="id_moneda_alternativa" id="id_moneda_alternativa" <?php echo $moneda_alternativa_usada ? 'disabled' : ''; ?>>
                                    <?php
                                    // Recorre los resultados y genera las opciones del elemento <select>
                                    while ($row = mysqli_fetch_assoc($resultado)) {
                                        // Omite la opción que coincide con la moneda principal
                                        if ($row['id_moneda'] == $id_moneda_principal) {
                                            continue;
                                        }
                                        
                                        echo '<option value="' . $row['id_moneda'] . '"' . ($row['id_moneda'] == $id_moneda_alternativa ? ' selected' : '') . '>' . $row['nombre_moneda'] . ' ' . $row['abreviatura'] . '</option>';
                                    }

                                    ?>
                                </select>
                            </div>

                            <div class="formCambio">
                                <label for="validationCustom01" class="col-form-label">Cambio</label>
                                <?php
                                    include('../../erpApi/conexion/bd_directa.php'); //abrimos la conexion
                                    $qry = "SELECT cambio from empresa_monedas WHERE id_empresa_m = $id_empresa ORDER BY id_empresa_moneda DESC LIMIT 1";
                                    $run = $conexion -> query($qry);
                                    $num_rows = 0;
                                    if($run -> num_rows > 0 ){
                                        while($row = $run -> fetch_assoc()){
                                            $cambioActual = $row['cambio'];
                                        }
                                    } 
                                ?>
                                <input type="number" class="form-control inputMoneda no-arrow" id="cambio" name="cambio" step="any" min=1 value="<?php echo $cambioActual ?>" required>
                            </div>

                            <div style="display:none;" class="formIdEmpresa">
                                <label for="validationCustom01" class="col-form-label">Id_empresa</label>
                                <input type="number" class="form-control inputMoneda no-arrow" id="id_empresa_m" name="id_empresa_m" value="<?php echo $id_empresa ?>" readonly required>
                            </div>
                            
                        </div>
                        <div class="btnPrincipales" >         
                            <div style="display:none;" class="LimpiarMoneda">
                                    <button style="position:relative; left:35px;" title="Limpiar" type="button" class="btn btn-warning añadir"><img class="btnP" src="../img/casetLimpiar.png"></button>                                
                            </div>
                            <div class="anadirMoneda">
                                <button style="position:relative; left:25px;" title="Guardar" type="submit" class="btn btn-success añadir" id="Btnguardar">Guardar</button>                                
                            </div>
                        </div>

                        
                    </form>


                    <hr style="margin-top:3rem;">
                    <div class="arribaTbl">
                        
                        <form style="display:none;" action="" method="GET">
                            <div class="buscar">
                                <input style="border-color:#858796; margin-bottom:15px;"  type="text" class="form-control buscador"  required  name="busqueda" placeholder="Buscar...">
                                <input type="hidden" name="id_empresa" value="<?php echo $id_empresa; ?>">
                                <button type="submit" name="enviar" class="btn btnBuscar" style="background-color:#3598D9; color:white; border:none;">Buscar</button>
                            </div>
                        </form>
                        
                        
                        
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


                    <?php
                        include '../../erpApi/conexion/bd.php';
                        $conexion = mysqli_connect("localhost","root","","erp");
                        $where="";
                        
                        if(isset($_GET['enviar'])){
                          $busqueda = $_GET['busqueda'];
                        
                          if (isset($_GET['busqueda']))
                          {
                            $where = "WHERE ((em.fecha_registro LIKE '%".$busqueda."%') OR (mp.nombre_moneda LIKE '%".$busqueda."%') OR (ma.nombre_moneda LIKE '%".$busqueda."%')) AND em.id_empresa_m = $id_empresa AND em.id_moneda_alternativa IS NOT NULL";

                            //consulta
                            $sqlCliente = "SELECT em.*, mp.nombre_moneda AS nombre_moneda_principal, ma.nombre_moneda AS nombre_moneda_alternativa
                            FROM empresa_monedas AS em
                            LEFT JOIN monedas AS mp ON em.id_moneda_principal = mp.id_moneda
                            LEFT JOIN monedas AS ma ON em.id_moneda_alternativa = ma.id_moneda
                            $where";

                            $queryEmpresaMoneda = mysqli_query($con, $sqlCliente);
                            if (!$queryEmpresaMoneda) {
                                echo "Error en la consulta: " . mysqli_error($con);
                            }
                                
                            
                            $queryEmpresaMoneda = mysqli_query($con, $sqlCliente);
                            $cantidad     = mysqli_num_rows($queryEmpresaMoneda);?>
                                    <style>
                                        .paginacion{
                                            display:none;
                                        }
                                        .btnVolver{
                                            width:72.5px;
                                            display: unset;
                                            text-decoration: none;
                                            
                                        }
                                        
                                        .TxTVolver{
                                            width: 7.5px;
                                        }
                                        .mostrando{
                                            display:none; 
                                        }
                                        
                                    </style>

                                <?php    
                                }
                                else{
                                    echo '<script type="text/JavaScript"> 
                                    console.log("No se logró entrar a la busqueda");
                                    </script>';
                                }
                                if($_GET['busqueda'] == ''){
                                    header('Location:empresaMonedas.php?paginas=1');
                                }

                            }else{
                                $iniciar = ($_GET['paginas']-1) * $articulos_x_pagina;
                                //echo $iniciar;
                                //consulta
                                $sqlCliente   = ("SELECT em.*, mp.nombre_moneda AS nombre_moneda_principal, ma.nombre_moneda AS nombre_moneda_alternativa
                                FROM empresa_monedas AS em
                                LEFT JOIN monedas AS mp ON em.id_moneda_principal = mp.id_moneda
                                LEFT JOIN monedas AS ma ON em.id_moneda_alternativa = ma.id_moneda
                                WHERE em.id_empresa_m = $id_empresa AND em.id_moneda_alternativa IS NOT NULL
                                ORDER BY em.id_empresa_moneda DESC
                                LIMIT $iniciar, 3                                
                                ");
                                $queryEmpresaMoneda = mysqli_query($con, $sqlCliente);
                                $cantidad     = mysqli_num_rows($queryEmpresaMoneda);

                            }
                    
                        
                    ?>

                    
                    <style>
                        th, td{
                            text-align:center;
                            border: 1px solid #D0D1C8;
                        }
                        td{
                            background-color:#F1EDED;
                        }
                    </style>
                    
                    <table class="table" >
                        
                    <thead style="background-color:#5a5c69; color:#fff;">
                        <tr>
                            <th scope="col">Fecha y Hora</th>
                            <th scope="col">Moneda Principal</th>
                            <th scope="col">Moneda Alternativa</th>
                            <th scope="col">Cambio</th>
                            <th scope="col">Activo</th>
                        </tr>

                        <?php
                            if ($queryEmpresaMoneda -> num_rows > 0){
                                while ($dataEmpresaMoneda = mysqli_fetch_array($queryEmpresaMoneda)) {  
                        ?>
                    </thead>
                    <tbody>
                        <tr>
                            
                            <td style="width:10rem;"><?php echo date('d/m/Y H:i:s', strtotime($dataEmpresaMoneda['fecha_registro'])); ?></td>
                            <td style="width:18rem;"><?php echo $dataEmpresaMoneda['nombre_moneda_principal']; ?></td>
                            <td style="width:18rem;"><?php echo $dataEmpresaMoneda['nombre_moneda_alternativa']; ?></td>

                            <td style="width:18rem;"><?php echo $dataEmpresaMoneda['cambio']; ?></td>
                            
                            <td style="width:15rem;">
                                
                                <?php
                                if($dataEmpresaMoneda['activo'] == 1){ ?>
                                    <button style="background-color:#1DBC26;border-color:#1DBC26;width:6rem;font-family:Inherit;cursor: default;color: #fff;outline: none;" type="button" class="btn btn-success">ABIERTO</button>
                                <?php
                                }else if($dataEmpresaMoneda['activo'] == 0){ ?>
                                    <button style="background-color:#0F0F0F;border-color:#0F0F0F; width:7rem;font-family:Inherit" type="button" class="btn btn-dark">CERRADO</button>
                                <?php
                                }
                                ?>
                            </td>

                            
                            
                            

                        </tr>



                        
                    </tbody>
                        <?php
                            }
                                }else{

                                    ?>
                                    <tr class="text-center">
                                    <td style="color:black;" colspan="16">No hay registros</td>
                                    </tr>
                                    <style>
                                        .paginacion{
                                            display:none;
                                        }
                                        .mostrando{
                                            display:none;
                                        }
                                    </style>
                                    
                                    <?php
                                    
                                }

                            
                        ?>

                    </table>

                    
                    <script>
                        //comproabando que cargan los elementos 
                        console.log("cantidad de paginas a cargar: <?php echo $paginas ?>" )
                    </script>

                    <style>
                        .pagination li.active .page-link,
                        .pagination li .page-link:hover {
                        background-color: #5a5c69;
                        color: #fff;
                        font-weight: bold;
                        border: solid 1px #5a5c69;
                        }
                        .pagination > li > a
                        {
                            background-color: white;
                            color: #5a5c69;
                        }
                        .paginacionForm{
                            display:flex;
                            flex-direction:row;
                            justify-content:space-between;
                        }
                        .mostrando{
                            height:30px;
                            margin-top:10px;
                            margin-left:5px;
                        }

                    </style>
                    <div class="paginacionForm">
                        <div class="mostrando">
                            <h3 style="color:black; font-size:15px;" >Página <?php echo $_GET['paginas'] ?> de <?php echo $paginas ?></h3>
                        </div>
                        <nav aria-label="Page navigation example" class="paginacion">
                            <ul class="pagination">
                                <li class="page-item <?php echo $_GET['paginas']<=1? 'disabled':''?>"">
                                    <a class="page-link" href="empresaMonedas.php?id=<?php echo $id_empresa?>&paginas=<?php echo $_GET['paginas']-1 ?>">
                                        Anterior
                                    </a>
                                </li>
                                
                                
                                <li  class="page-item <?php echo $_GET['paginas']==$i+1 ? 'active' : '' ?>">
                                    <a style="background-color:#5a5c69; color:white;" class="page-link" href="empresaMonedas.php?id=<?php echo $id_empresa?>&paginas=<?php echo $i+1 ; ?>">
                                        <?php echo $_GET['paginas'] ; ?>
                                    </a>
                                </li>
                                

                                <li class="page-item <?php echo $_GET['paginas']>=$paginas? 'disabled':''?>" >
                                <a class="page-link" href="empresaMonedas.php?id=<?php echo $id_empresa?>&paginas=<?php echo $_GET['paginas']+1 ?>" style="position: relative; left: 0;">
                                    Siguiente
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    
                    
                    
                    <ul class="pagination">
                        <a style="background-color:#5a5c69;border:none;" class="btn btn-secondary btnVolver" href="empresaMonedas.php?id=<?php echo $id_empresa?>&paginas=1">
                            Volver
                        </a>
                    </ul>    

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

    <!--Responsive-->
    
    <style>
        @media only screen and (max-width: 600px) {
        body {
            background-color: lightblue;
        }
        }
    </style>
    <script>
    $(document).ready(function() {
    $('#formEditar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes
        var gestion = button.data('gestion'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find('.modal-title').text('Editar Gestión ');
        modal.find('#id_gestion_').val(gestion.id_gestion);
        modal.find('#nombre_gestion_').val(gestion.nombre_gestion);
        modal.find('#fecha_inicio_').val(gestion.fecha_inicio);
        modal.find('#fecha_fin_').val(gestion.fecha_fin);
        modal.find('#id_empresa_gestion_').val(gestion.id_empresa_gestion);
        // ... actualizar otros campos del formulario aquí ...
    });
    });
    </script>

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
    

    
</body>

</html>