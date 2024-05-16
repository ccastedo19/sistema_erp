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

    <!--jquery para no recargar-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--TOASTER-->
    <link href="../css/toastr.min.css" rel="stylesheet">
    <!--quitar validacion de check en formulario-->
    <link href="../css/validacionForm.css" rel="stylesheet">
</head>

<body id="page-top">
<script>    
    $(document).ready(function() {
    $('#formularioEdit').submit(function(event) {
        // Evitar que el formulario se envíe de forma predeterminada
        event.preventDefault();

        // Obtener los valores del formulario
        var id_periodo = $('#id_periodo_').val();
        var nombre_periodo = $('#nombre_periodo_').val();
        var fecha_inicio_periodo = $('#fecha_inicio_periodo_').val();
        var fecha_fin_periodo = $('#fecha_fin_periodo_').val();
        var estado_periodo = $('#estado_periodo_').val();
        var id_gestion_periodo = $('#id_gestion_periodo_').val();
        var id_usuario_periodo = $('#id_usuario_periodo_').val();
        //enviar datos a funcion
        actualizarPeriodo(id_periodo,nombre_periodo,fecha_inicio_periodo,fecha_fin_periodo,estado_periodo,id_gestion_periodo,id_usuario_periodo,event);

        
        // Enviar los datos al servidor con AJAX
        $.ajax({
            url: '<?php echo $_SERVER["PHP_SELF"]; ?>',
            type: 'POST',
            data: {
                nombre_periodo:nombre_periodo,
                fecha_inicio_periodo: fecha_inicio_periodo,
                fecha_fin_periodo: fecha_fin_periodo,
                estado_periodo: estado_periodo,
                id_gestion_periodo: id_gestion_periodo,
                id_usuario_periodo: id_usuario_periodo
            },
            success: function(response) {
                // Manejar la respuesta del servidor aquí
                console.log(nombre_periodo);
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Manejar los errores aquí
                console.log(textStatus, errorThrown);
            }
        });

        // Evitar la recarga de la página
        return false;
    });
});
</script>


<?php
    //llegada de datos
    include_once '../../erpApi/conexion/bd_directa.php';

    if(isset($_GET['enviar'])){

        $busqueda = $_GET['busqueda'];
        $id_gestion = $_GET['id_gestion'];
        if (isset($_GET['busqueda']))
        {
            $qry = "SELECT * FROM gestiones WHERE id_gestion = $id_gestion";
            $run = $conexion -> query($qry);
            $num_rows = 0;
            if($run -> num_rows > 0 ){
                while($row = $run -> fetch_assoc()){
                    $nombre_gestion=$row['nombre_gestion'];
                    $id_empresa = $row['id_empresa_gestion'];
                    $fecha_inicio = $row['fecha_inicio'];
                    $fecha_fin = $row['fecha_fin'];
                }
                
            } 

        }
        
    }else{

        $id_gestion = $_GET['id'];
        $qry = "SELECT * FROM gestiones WHERE id_gestion = $id_gestion";
        $run = $conexion -> query($qry);
        $num_rows = 0;
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                $nombre_gestion=$row['nombre_gestion'];
                $id_empresa = $row['id_empresa_gestion'];
                $fecha_inicio = $row['fecha_inicio'];
                $fecha_fin = $row['fecha_fin'];
            }
            
        } 
    }
    //sacar nombre empresa:
    $qry = "SELECT * FROM empresas WHERE id_empresa = $id_empresa";
    $run = $conexion -> query($qry);
    $num_rows = 0;
    if($run -> num_rows > 0 ){
        while($row = $run -> fetch_assoc()){
            $nombre_empresa=$row['nombre_empresa'];
            
        }
    } 

?>
<?php
    //paginas
    include_once '../../erpApi/conexion/bd.php';

    $sqlCliente   = ("SELECT * FROM periodos WHERE id_gestion_periodo = $id_gestion");
    $queryEmpresa = mysqli_query($con, $sqlCliente);
    $cantidad     = mysqli_num_rows($queryEmpresa);

    $articulos_x_pagina = 5;

    //contar articulos de la bd
    $total_articulos_db = $cantidad; //la cantidad viene de 'mysqli_num_rows'
    $paginas = $total_articulos_db/5;
    $paginas = ceil($paginas); //redondear paginas
    echo "<script type='text/javascript'>
                console.log('Numero de pagina:'.$paginas);
            </script>"; 

    if(!$_GET){
        header("Location:gestiones.php?id=$id_empresa&paginas=1");
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
        height:60px;
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
            <li class="nav-item">
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

            
            <!-- Sidebar Toggler (Sidebar) -->
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

                        <style>
                            
                            .dropdown-item:hover{
                                background-color:#535458;
                            }
                        </style>

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
                        .ImagenAutor{
                            display:flex;
                            flex-direction:row;
                            
                        }
                    </style>
                    
                    <!-- Page Heading -->
                    <div class="ImagenAutor">
                        <div>
                            <img class="FotoAutor"src="../img/calendar.png">
                        </div>
                        <div>
                            <h2 style="font-size:47px; margin-top:2.5rem;" class="txtDichoAutor">Periodos de <?php echo $nombre_gestion; ?></h2>
                        </div>
                        
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <!--<h1 style="margin-left:10px; margin-top:5px; font-family:cursive" class="h3 mb-0 text-gray-800">Empresas</h1>-->
                        
                    </div>

                    <!--Very importan!-->
                    <?php
                        $conexion = mysqli_connect("localhost", "root", "", "erp");

                        // Asegúrate de que $id_gestion esté definida y sea un valor válido


                        $estado_gestion = 0;
                        $query = "SELECT estado_gestion FROM gestiones WHERE id_gestion = $id_gestion";
                        $resultado = mysqli_query($conexion, $query);

                        if ($fila = mysqli_fetch_assoc($resultado)) {
                            $estado_gestion = $fila['estado_gestion'];
                    }
                    ?>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">

                    <div class="arribaTbl">
                        <form action="" method="GET">
                            <div class="buscar">
                                <input style="border-color:#858796; margin-bottom:15px;" title="" type="text" class="form-control buscador"  required  name="busqueda" placeholder="Buscar...">
                                <input type="hidden" name="id_gestion" value="<?php echo $id_gestion; ?>">
                                <button type="submit" name="enviar" class="btn btnBuscar" style="background-color:#3598D9; color:white; border:none;">Buscar</button>
                            </div>
                        </form>
                        
                        <div class="anadir">
                        
                            <a style="position:relative; right:37rem; bottom:5px;" href="../report/reportePeriodo.php?id_empresa=<?php echo $id_empresa; ?>&id_gestion=<?php echo $id_gestion;?>" class="btn btn-primary" role="button" target="_blank">Reporte  <i class="fas fa fa-print" aria-hidden="true"></i></a> 

                            <a style="position:relative; bottom:5px;right:10rem;background-color:#fd7e14;color:white;" href="gestiones.php?id=<?php echo $id_empresa;?>&paginas=1" class="btn btn-" role="button">Volver a Gestiones</a>

                            <button style="position:relative;right:-52px;" type="button" class="btn btn-success añadir" data-toggle="modal" data-target="#exampleModal2" data-whatever="@mdo" <?php echo $estado_gestion == 0 ? 'disabled title="Gestión Cerrada"' : ''; ?>>Añadir Periodo</button>

                        </div>
                        
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

                    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#1cc88a">
                            <h5 class="modal-title" id="exampleModalLabel" style="color:#fff;">Añadir Periodo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            <form class="needs-validation" novalidate data-offset="70" id="formularioAdd" method="POST" onsubmit="guardarPeriodo(event)">
                                <div class="form-group col-12">
                                    <label for="nombre_gestion" class="col-form-label">Nombre del Periodo</label>
                                    <input type="text" class="form-control inputAgregar" id="nombre_periodo" name="nombre_periodo" required >
                                    <div class="invalid-feedback d-none">
                                        Campo Obligatorio
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="fecha_inicio" class="col-form-label">Fecha De Inicio</label>
                                    <input type="date" class="form-control inputAgregar" id="fecha_inicio_periodo" name="fecha_inicio_periodo" min="<?php echo $fecha_inicio;?>" max="<?php echo $fecha_fin?>" value="<?php echo $fecha_inicio;?>" required>
                                    <div class="invalid-feedback d-none">
                                        Campo Obligatorio
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="fecha_fin" class="col-form-label">Fecha De Finalización</label>
                                    <input type="date" class="form-control inputAgregar" id="fecha_fin_periodo" name="fecha_fin_periodo" min="<?php echo $fecha_inicio;?>" max="<?php echo $fecha_fin;?>" value="<?php echo $fecha_fin;?>" required>
                                    <div class="invalid-feedback d-none">
                                        Campo Obligatorio
                                    </div>
                                </div>

                                <div style="display:none;" class="form-group col-12">
                                    <label for="estado_gestion" class="col-form-label">estado</label>
                                    <input type="number" class="form-control inputAgregar" id="estado_periodo" name="estado_periodo" required="true" value="1" readonly>
                                </div>  
                                <div style="display:none;" class="form-group col-12">
                                    <label for="id_usuario_gestion" class="col-form-label">usuario periodo</label>
                                    <input type="number" class="form-control inputAgregar" id="id_usuario_periodo" name="id_usuario_periodo" required="true" value="1" readonly>
                                </div>
                                <div style="display:none;" class="form-group col-12">
                                    <label for="id_empresa_gestion" class="col-form-label">id de la gestion</label>
                                    <input type="number" class="form-control inputAgregar" id="id_gestion_periodo" name="id_gestion_periodo" required="true" value="<?php echo $id_gestion ?>" readonly>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button style="background-color:#1cc88a; border:none;" type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>

                            </div>
                            </div>
                        </div>
                    </div>


                    <?php
                        include '../../erpApi/conexion/bd.php';
                        $conexion = mysqli_connect("localhost","root","","erp");
                        $where="";
                        
                        if(isset($_GET['enviar'])){
                          $busqueda = $_GET['busqueda'];
                        
                          if (isset($_GET['busqueda']))
                          {
                            $where = "WHERE (periodos.nombre_periodo LIKE '%".$busqueda."%' OR fecha_inicio_periodo LIKE '%".$busqueda."%' OR fecha_fin_periodo LIKE '%".$busqueda."%') AND id_gestion_periodo = $id_gestion";
                            //consulta
                            $sqlCliente   = ("SELECT * FROM periodos $where");
                            $queryPeriodo = mysqli_query($con, $sqlCliente);
                            $cantidad     = mysqli_num_rows($queryPeriodo);?>
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
                                //if($_GET['busqueda'] == ''){
                                //    header('Location:empresas.php?paginas=1');
                                //}

                            }else{
                                $iniciar = ($_GET['paginas']-1) * $articulos_x_pagina;
                                //echo $iniciar;
                                //consulta
                                $sqlCliente = ("SELECT * FROM periodos WHERE id_gestion_periodo = $id_gestion ORDER BY fecha_inicio_periodo ASC LIMIT $iniciar,5");
                                $queryPeriodo= mysqli_query($con, $sqlCliente);
                                $cantidad     = mysqli_num_rows($queryPeriodo);

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
                            <th scope="col">Periodo</th>
                            <th scope="col">Fecha de Inicio</th>
                            <th scope="col">Fecha de Conclusión</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acción <i class="fas fa fa-edit" aria-hidden="true"></i></th>
                        </tr>

                        <?php
                            if ($queryPeriodo -> num_rows > 0){
                                while ($dataPeriodo = mysqli_fetch_array($queryPeriodo)) {  
                        ?>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:18rem;"><?php echo $dataPeriodo['nombre_periodo']; ?></td>
                            <td style="width:10rem;"><?php echo date('d/m/Y', strtotime($dataPeriodo['fecha_inicio_periodo'])); ?></td>
                            <td style="width:10rem;"><?php echo date('d/m/Y', strtotime($dataPeriodo['fecha_fin_periodo'])); ?></td>

                            <td style="width:15rem;">
                                <?php if($dataPeriodo['estado_periodo'] == 0){?>
                                    <button style="background-color:red ;border-color:red; width:7rem;font-family:Inherit" type="button" class="btn btn-danger">INACTIVA</button>
                                <?php
                                }else if($dataPeriodo['estado_periodo'] == 1){ ?>
                                    <button style="background-color:#1DBC26;border-color:#1DBC26; width:6rem;font-family:Inherit;cursor: default;" type="button" class="btn btn-success">ABIERTO</button>
                                <?php
                                }else if($dataPeriodo['estado_periodo'] == 2){ ?>
                                    <button style="background-color:#0F0F0F;border-color:#0F0F0F; width:7rem;font-family:Inherit" type="button" class="btn btn-dark">CERRADA</button>
                                <?php
                                }
                                ?>
                            </td>

                            <td style="width:15rem;">
                                <!--SIN USO TODAVIA-->
                                <button title="Eliminar" style="background-color:#e74a3b; border-color:#e74a3b" title="Eliminar" type="button" class="btn btn-info" onclick="eliminarPeriodo(<?php echo $dataPeriodo['id_periodo']; ?>)" >
                                    <i class="fas fa fa-trash" aria-hidden="true"> </i>
                                </button>
                                
                                
                                <button type="button" title="Editar Periodo" class="btn btn-info" data-toggle="modal" data-target="#formEditar" data-whatever="@mdo" data-id="<?php echo $dataPeriodo['id_periodo']; ?>" data-periodo='<?php echo json_encode($dataPeriodo); ?>'>
                                        <i class="fas fa fa-edit" aria-hidden="true"></i>
                                </button>

                                    
                                    <!--Ventana Modal para la Alerta de Editar--->
                                    <div class="modal fade" id="formEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:#17a2b8">
                                            <h5 class="modal-title" id="exampleModalLabel" style="color:#fff;">Editar Periodo</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                            <form class="needs-validation" novalidate data-offset="70" id="formularioEdit" method="POST" action="<?php ($_SERVER["PHP_SELF"]); ?>" >
                                            
                                                <div style="display:none;" class="form-group col-12">
                                                    <label for="validationCustom01" class="col-form-label">ID</label>
                                                    <input type="text" class="form-control inputAgregar" id="id_periodo_" name="id_periodo_" required value="<?php echo $dataPeriodo['id_periodo'] ?>">
                                                    <div class="invalid-feedback d-none">
                                                        Campo Obligatorio
                                                    </div>
                                                </div>
                                                    <div class="form-group col-12">
                                                        <label style="position:relative; right:8.9rem;" for="validationCustom01" class="col-form-label">Nombre del Periodo</label>
                                                        <input type="text" class="form-control inputAgregar" id="nombre_periodo_" name="nombre_periodo_" required value="<?php echo $dataPeriodo['nombre_periodo'] ?>">
                                                        <div class="invalid-feedback d-none">
                                                            Campo Obligatorio
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <label style="position:relative; right:10.4rem;" for="fecha_inicio_periodo" class="col-form-label">Fecha De Inicio</label>
                                                        <input type="date" class="form-control inputAgregar" id="fecha_inicio_periodo_" name="fecha_inicio_periodo_" min="<?php echo $fecha_inicio;?>" max="<?php echo $fecha_fin?>" required value="<?php echo $dataPeriodo['fecha_inicio_periodo'] ?>">
                                                        <div class="invalid-feedback d-none">
                                                            Campo Obligatorio
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12">



                                                        <label style="position:relative; right:8.9rem;" for="fecha_fin_periodo" class="col-form-label">Fecha De Finalización</label>
                                                        <input type="date" class="form-control inputAgregar" id="fecha_fin_periodo_" name="fecha_fin_periodo_" min="<?php echo $fecha_inicio;?>" max="<?php echo $fecha_fin?>" required value="<?php echo $dataPeriodo['fecha_fin_periodo'] ?>">
                                                        <div class="invalid-feedback d-none">
                                                            Campo Obligatorio
                                                        </div>
                                                    </div>

                                                    <div style="display:none;" class="form-group col-12">
                                                        <label for="estado_periodo" class="col-form-label">estado</label>
                                                        <input type="number" class="form-control inputAgregar" id="estado_periodo_" name="estado_periodo_" required="true" value="1" readonly>
                                                    </div>  
                                                    <div style="display:none;" class="form-group col-12">
                                                        <label for="id_usuario_periodo" class="col-form-label">usuario periodo</label>
                                                        <input type="number" class="form-control inputAgregar" id="id_usuario_periodo_" name="id_usuario_periodo_" required="true" value="1" readonly>
                                                    </div>
                                                    <div style="display:none;" class="form-group col-12">
                                                        <label for="id_empresa_gestion" class="col-form-label">id de la gestion</label>
                                                        <input type="number" class="form-control inputAgregar" id="id_gestion_periodo_" name="id_gestion_periodo_" required="true" value="<?php echo $dataPeriodo['id_gestion_periodo'] ?>" readonly>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        <button style="background-color:#17a2b8; border:none;position:relative;left:5px;" type="submit" class="btn btn-primary" id="btn-submit">Guardar</button>
                                                            
                                                    </div>
                                                </form>
                                            

                                            </div>
                                            </div>
                                        </div>
                                    </div>


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
                                    <a class="page-link" href="periodos.php?id=<?php echo $id_gestion?>&paginas=<?php echo $_GET['paginas']-1 ?>">
                                        Anterior
                                    </a>
                                </li>
                                
                                
                                <li  class="page-item <?php echo $_GET['paginas']==$i+1 ? 'active' : '' ?>">
                                    <a style="background-color:#5a5c69; color:white;" class="page-link" href="periodos.php?id=<?php echo $id_gestion?>&paginas=<?php echo $i+1 ; ?>">
                                        <?php echo $_GET['paginas'] ; ?>
                                    </a>
                                </li>
                                

                                <li class="page-item <?php echo $_GET['paginas']>=$paginas? 'disabled':''?>" >
                                <a class="page-link" href="periodos.php?id=<?php echo $id_gestion?>&paginas=<?php echo $_GET['paginas']+1 ?>" style="position: relative; left: 0;">
                                    Siguiente
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    
                    
                    
                    <ul class="pagination">
                        <a style="background-color:#5a5c69;border:none;" class="btn btn-secondary btnVolver" href="periodos.php?id=<?php echo $id_gestion?>&paginas=1">
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
        var periodo = button.data('periodo'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find('.modal-title').text('Editar Periodo ');
        modal.find('#id_periodo_').val(periodo.id_periodo);
        modal.find('#nombre_periodo_').val(periodo.nombre_periodo);
        modal.find('#fecha_inicio_periodo_').val(periodo.fecha_inicio_periodo);
        modal.find('#fecha_fin_periodo_').val(periodo.fecha_fin_periodo);
        modal.find('#estado_periodo_').val(periodo.estado_periodo);
        modal.find('#id_usuario_periodo_').val(periodo.id_usuario_periodo);
        modal.find('#id_gestion_periodo_').val(periodo.id_gestion_periodo);
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