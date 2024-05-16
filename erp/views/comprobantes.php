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

    

   
?>
<?php
    include('../../erpApi/conexion/bd.php'); //abrimos la conexion

    $sqlCliente   = ("SELECT * FROM comprobantes WHERE id_empresa_comprobante = $id_empresa ORDER BY id_comprobante DESC");
    $queryComprobante= mysqli_query($con, $sqlCliente);
    $cantidad     = mysqli_num_rows($queryComprobante);

    $articulos_x_pagina = 5;

    //contar articulos de la bd
    $total_articulos_db = $cantidad; //la cantidad viene de 'mysqli_num_rows'
    $paginas = $total_articulos_db/5;
    $paginas = ceil($paginas); //redondear paginas


?>
<?php
    if(!$_GET){
        header("Location:comprobantes.php?id=$id_empresa&paginas=1");
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
                            <img class="FotoAutor"src="../img/comprobante.png">
                        </div>
                        <div>
                            <h2 style="font-size:47px; margin-top:2.5rem;" class="txtDichoAutor">Comprobantes de <?php echo $nombre_empresa; ?></h2>
                        </div>
                        
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <!--<h1 style="margin-left:10px; margin-top:5px; font-family:cursive" class="h3 mb-0 text-gray-800">Empresas</h1>-->
                        
                    </div>

                    <!--Very importan!-->

                <div class="card shadow mb-4">
                    <div class="card-header py-3">

                    <div class="arribaTbl">
                        <form action="" method="GET">
                            <div class="buscar">
                                <input style="border-color:#858796; margin-bottom:15px;" title="" type="text" class="form-control buscador"  required  name="busqueda" placeholder="Buscar...">
                                <input type="hidden" name="id_empresa" value="<?php echo $id_empresa; ?>">
                                <button type="submit" name="enviar" class="btn btnBuscar" style="background-color:#3598D9; color:white; border:none;">Buscar</button>
                            </div>
                        </form>
                        
                        <div style="display:flex; flex-direction:row;" class="anadir">

                            <div class="anadirG">
                            <?php
                                include_once '../../erpApi/conexion/bd_directa.php';
                                $query = "SELECT COUNT(*) as count FROM cuentas WHERE id_empresa_cuenta = $id_empresa AND tipo_cuenta = 'Detalle'";

                                $result = mysqli_query($conexion, $query);
                                $row = mysqli_fetch_assoc($result); 
                                $count = $row['count'];

                                if ($count <= 1) {?>
                                    <button style="position:relative;right:-53px;" type="button" class="btn btn-success añadir" id="btnAñadir" disabled>Añadir</button>
                                    <script src="../js/sweetalert2.all.min.js"></script>
                                    <script>
                                        
                                        Swal.fire({
                                            title: '<strong>Tomar en cuenta.</strong>',
                                            icon: 'info',
                                            html:
                                                'No hay cuentas de Detalle suficientes para realizar comprobante. ' +
                                                '' +
                                            '',
                                            showCloseButton: true,
                                            focusConfirm: false,
                                        
                                            confirmButtonText:
                                                'OK',
                                        })
                                    </script>
                                <?php
                                }else if($count >= 2){?>
                                    <a href="detalleComprobantes.php?id=<?php echo $id_empresa?>" style="position:relative;right:-53px;" type="button" class="btn btn-success añadir" id="btnAñadir">Añadir</a><?php
                                }
                                echo "<script>";
                                echo "console.log('contadas:',$count);";
                                echo "</script>";
                            ?>  

                            </div>
                            
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
                            <h5 class="modal-title" id="exampleModalLabel" style="color:#fff;">Añadir Gestión</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            <form class="needs-validation" novalidate data-offset="70" id="formularioAdd" method="POST" onsubmit="guardarGestion(event)">
                                <div class="form-group col-12">
                                    <label for="validationCustom01" class="col-form-label">Nombre de la Gestión</label>
                                    <input type="text" class="form-control inputAgregar" id="nombre_gestion" name="nombre_gestion" required>
                                    <div class="invalid-feedback">
                                        Campo Obligatorio
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="fecha_inicio" class="col-form-label">Fecha De Inicio</label>
                                    <input type="date" class="form-control inputAgregar" id="fecha_inicio" name="fecha_inicio" required>
                                    <div class="invalid-feedback">
                                        Campo Obligatorio
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="fecha_fin" class="col-form-label">Fecha De Finalización</label>
                                    <input type="date" class="form-control inputAgregar" id="fecha_fin" name="fecha_fin" required>
                                    <div class="invalid-feedback">
                                        Campo Obligatorio
                                    </div>
                                </div>
                                
                                <div style="display:none;" class="form-group col-12">
                                    <label for="estado_gestion" class="col-form-label">estado</label>
                                    <input type="number" class="form-control inputAgregar" id="estado_gestion" name="estado_gestion" required="true" value="1" readonly>
                                </div>  
                                <div style="display:none;" class="form-group col-12">
                                    <label for="id_usuario_gestion" class="col-form-label">usuario gestion</label>
                                    <input type="number" class="form-control inputAgregar" id="id_usuario_gestion" name="id_usuario_gestion" required="true" value="1" readonly>
                                </div>
                                <div style="display:none;" class="form-group col-12">
                                    <label for="id_empresa_gestion" class="col-form-label">id de la empresa</label>
                                    <input type="number" class="form-control inputAgregar" id="id_empresa_gestion" name="id_empresa_gestion" required="true" value="<?php echo $id_empresa ?>" readonly>
                                </div>
                                <div class="modal-footer">
                                    <div style="position:relative;left:5px;" class="btnAdd">
                                        <button style="position:relative;right:8px;" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button style="background-color:#1cc88a; border:none;" type="submit" class="btn btn-primary">Añadir</button>
                                    </div>                                 
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
                        
                          if (isset($_GET['busqueda'])){
                            $where = "WHERE (comprobantes.serie LIKE '%" . $busqueda . "%' 
                            OR comprobantes.fecha_comprobante LIKE '%" . $busqueda . "%'
                            OR comprobantes.glosa_principal LIKE '%" . $busqueda . "%'
                            OR comprobantes.tipo_comprobante LIKE '%" . $busqueda . "%') 
                            AND id_empresa_comprobante = $id_empresa";
                            //consulta
                            $sqlCliente = ("SELECT comprobantes.*, monedas.nombre_moneda FROM comprobantes 
                            JOIN monedas ON comprobantes.id_moneda = monedas.id_moneda $where"); //modificar
                            $queryComprobante = mysqli_query($conexion, $sqlCliente);
                            $cantidad = mysqli_num_rows($queryComprobante);?>
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


                            }else{
                                $iniciar = ($_GET['paginas']-1) * $articulos_x_pagina;
                                //echo $iniciar;
                                //consulta
                                $sqlCliente = ("SELECT c.*, m.nombre_moneda FROM comprobantes c
                                    JOIN monedas m ON c.id_moneda = m.id_moneda
                                    WHERE c.id_empresa_comprobante = $id_empresa
                                    ORDER BY c.id_comprobante DESC
                                    LIMIT $iniciar,5");
                                $queryComprobante = mysqli_query($con, $sqlCliente);
                                $cantidad = mysqli_num_rows($queryComprobante);


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
                            <th scope="col">Serie</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Glosa</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Moneda</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Ver</th>
                            
                        </tr>

                        <?php
                            if ($queryComprobante -> num_rows > 0){
                                while ($dataComprobante = mysqli_fetch_array($queryComprobante)) {  
                        ?>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:5rem;"><?php echo $dataComprobante['serie']; ?></td>
                            <td style="width:7rem;"><?php echo date('d/m/Y', strtotime($dataComprobante['fecha_comprobante'])); ?></td>
                            <td style="width:15rem;"><?php echo $dataComprobante['glosa_principal']; ?></td>
                            <td style="width:8rem;"><?php echo $dataComprobante['tipo_comprobante']; ?></td>
                            <td style="width:8rem;"><?php echo $dataComprobante['nombre_moneda']; ?></td>
                            <td style="width:8rem;">
                                <?php
                                if($dataComprobante['estado'] == 1){?>
                                    <button style="background-color:#1DBC26;color:#fff;border-color:#1DBC26;" class="btn btn-success">Abierto</button>
                                <?php
                                }else{?>
                                    <button style="background-color:#000;color:#fff;border-color:#000;" class="btn btn-success">Anulado</button>
                                <?php
                                }
                                ?>
                            </td>
                            <td style="width:4rem;">
                                <div>
                                    <a title="Ver Comprobante" style="display: block; background-color:#E34724; border-color:#E34724; color:#fff; width:45%; height:35px;position: relative; left:25px;border-radius:5px;" href="verComprobante.php?id=<?php echo $dataComprobante['id_empresa_comprobante']?>&id_comprobante=<?php echo $dataComprobante['id_comprobante']?>" class="btn btn-sm">
                                        <i style="font-size: 16px;position:relative;top:3px;" class="fa fa-eye"></i>
                                    </a>

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
                                <li class="page-item <?php echo $_GET['paginas']<=1? 'disabled':''?>">
                                    <a class="page-link" href="comprobantes.php?id=<?php echo $id_empresa?>&paginas=<?php echo $_GET['paginas']-1 ?>">
                                        Anterior
                                    </a>
                                </li>
                                
                                
                                <li  class="page-item <?php echo $_GET['paginas']==$i+1 ? 'active' : '' ?>" >
                                    <a style="background-color:#5a5c69; color:white;" class="page-link" href="comprobantes.php?id=<?php echo $id_empresa?>&paginas=<?php //echo $i+1 ; ?>">
                                        <?php echo $_GET['paginas'] ; ?>
                                    </a>
                                </li>
                                

                                <li class="page-item <?php echo $_GET['paginas']>=$paginas? 'disabled':''?>" >
                                <a class="page-link" href="comprobantes.php?id=<?php echo $id_empresa?>&paginas=<?php echo $_GET['paginas']+1 ?>">
                                    Siguiente
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    
                    
                    
                    <ul class="pagination">
                            <a style="background-color:#5a5c69;border:none;" class="btn btn-secondary btnVolver" href="comprobantes.php?id=<?php echo $id_empresa?>&paginas=1">
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