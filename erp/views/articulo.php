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
    <script
	src="https://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <!--TOASTER-->
    <link href="../css/toastr.min.css" rel="stylesheet">


    <!--LIBRERIA PAR VALIDAR FORMULARIO-->
    
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
            $qry = "SELECT * FROM articulos WHERE id_empresa_articulo = $id_empresa";
            $run = $db -> query($qry);
            $num_rows = 0;
            if($run -> num_rows > 0 ){
                while($row = $run -> fetch_assoc()){
                    $nombre_articulo=$row['nombre_articulo'];
                }
                
            } 

        }
        
    }else{
        $db = mysqli_connect("localhost","root","","erp");

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

    $sqlCliente = ("SELECT * FROM articulos Where id_empresa_articulo = $id_empresa");
    $queryArticulo = mysqli_query($con, $sqlCliente);
    $cantidad     = mysqli_num_rows($queryArticulo);

    $articulos_x_pagina = 5;

    //contar articulos de la bd
    $total_articulos_db = $cantidad; //la cantidad viene de 'mysqli_num_rows'
    $paginas = $total_articulos_db/5;
    $paginas = ceil($paginas); //redondear paginas

            
?>
<?php
    if(!$_GET){
        header("Location:articulo.php?id=$id_empresa&paginas=1");
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

            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-dolly"></i>
                    <span>Inventario</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-dark py-2 collapse-inner rounded">
                        <a style="color:white;" class="collapse-item" href="categoria.php?id=<?php echo $id_empresa ?>"><i style= "margin-right:10px;" class="fas fa-bookmark"></i><span>Categoría</span></a>
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

                <style>
                    .buscar{
                        display:flex;
                        flex-direction:row;
                        justify-content:space-between;
                    }
                    .buscador{
                        width:250px;
                    }
                    .btnBuscar{
                        height:38px;
                        margin-left:10px;
                    }
                    /* #5a5c69 -- negro*/
                    .formularioBalance{
                        background-color: #5a5c69;
                        border:1px solid #464647;
                        width: 40rem;
                        height: 35rem;
                        margin: 0 auto;
                        border-radius: 15px;
                        padding: 35px;
                    }
                    .tituloBalance{
                        color:#ffff;
                        text-align:center;
                        font-size:35px;   
                    }
                    .textBalance{
                        color:white;
                        font-size:20px;
                    }
                    .contenForm{
                        display:flex;
                        flex-direction:column;
                        margin-top:30px;
                    }
                    .botonBalance{
                        background-color:#E34724;
                        color:#fff;
                        width:35.7rem;
                        text-align:center;
                        border-color:#464647;
                        height:42.5px;
                        font-size:18px;
                        border-radius:7.5px;
                        padding-top:6px;
                        margin-top:20px;
                    }
                    .botonBalance:hover{
                        background-color:#CD4223;
                        border-color:#464647;
                        text-decoration:none;
                        color:#fff;
                    }
                    .botonBalance:active{
                        background-color:#CD4223;
                    }
                    .formReport .form-group {
                        margin-bottom: 25px; /* Cambia este valor según la cantidad de espacio que desees agregar entre los divs */
                    }
                    .Titulo{
                        display:flex;
                        flex-direction:row;
                        margin-bottom:15px;
                    }
                    .txtDichoAutor{
                        /*background-color:yellow;*/
                        width:80rem;
                        margin-top:18px;
                        margin-left:10px;
                        font-family:cursive;
                    }
                    .contenidoForm{
                        border-radius:5px;
                        width:100%;
                        height:11rem;
                        display:flex;
                        flex-direction:column;
                    }
                    .inputArticulo{
                        width:25rem;
                    }
                    .selectArticulo{
                        width:29rem;
                    }
                    .ParteArriba{
                        display:flex;
                        flex-direction:row;
                        justify-content: space-between;
                    }
                    .btnAccion{
                        padding-top:32px;
                        padding-right:15px;
                    }
                    .selectCat{
                        display:flex;
                        flex-direction:column;
                    }
                    .ParteAbajo{
                        margin-top:20px;
                    }
                    .selectCat {
                        visibility: hidden;
                    }
                </style>
                
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="crudAutor">
                    
                    <!-- Page Heading -->

                        <!--<h1 style="margin-left:10px; margin-top:5px; font-family:cursive" class="h3 mb-0 text-gray-800">Empresas</h1>-->
                    <div class="Titulo">
                        <img style="width:100px; height:100px;position:relative; left:5px;" src="../img/articuloFoto.png">
                        <h2 style="font-size:40px;position:relative;top:30px;" class="txtDichoAutor">Articulos</h2>
                    </div>
                    

                    <!--Very importan!-->

                    <div class="card shadow mb-4" style="padding:55px;">
                        
                        <div class="Contenido-articulo">
                            <div style="display:none;" class="formArticulo">
                                
                                <hr>
                            </div>
                        </div>
                        <div class="ContenidoCrud">
                            
                            <form action="" method="GET">
                                <div class="buscar">
                                    <div style="display:flex;flex-direction:row;">
                                        <input style="border-color:#858796; margin-bottom:15px;" title="" type="text" class="form-control buscador"  required  name="busqueda" placeholder="Buscar...">
                                        <input type="hidden" name="id_empresa" value="<?php echo $id_empresa; ?>">
                                        <button type="submit" name="enviar" class="btn btnBuscar" style="background-color:#3598D9; color:white; border:none;">Buscar</button>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-success action-button" data-toggle="modal" data-target="#addModal" id="addBtn"><span>Añadir</span></button>
                                    </div>
                                    
                                </div>
                            </form>
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
                                    $where = "WHERE (articulos.nombre_articulo LIKE '%".$busqueda."%') AND id_empresa_articulo = $id_empresa ";
                                    
                                    //consulta
                                    $sqlCliente = "SELECT * FROM articulos $where ";
                                    

                                    $queryArticulo = mysqli_query($con, $sqlCliente);
                                    if (!$queryArticulo) {
                                        echo "Error en la consulta: " . mysqli_error($con);
                                    }
                                        
                                    
                                    $queryArticulo = mysqli_query($con, $sqlCliente);
                                    $cantidad     = mysqli_num_rows($queryArticulo);?>
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
                                            header('Location:articulo.php?id=$id_empresa&paginas=1');
                                        }

                                    }else{
                                        $iniciar = ($_GET['paginas']-1) * $articulos_x_pagina;
                                        //echo $iniciar;
                                        //consulta
                                        $sqlCliente   = ("SELECT * FROM articulos WHERE id_empresa_articulo = $id_empresa ORDER BY id_articulo DESC LIMIT $iniciar,5");                            
                                        $queryArticulo = mysqli_query($con, $sqlCliente);
                                        $cantidad     = mysqli_num_rows($queryArticulo);

                                        

                                        if($cantidad > 0){?>
                                            <style>
                                                .btnVolver{
                                                    display:none;
                                                }
                                            </style>
                                        <?php    
                                        }

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
                            
                            
                            <table class="table">
                                <thead style="background-color:#5a5c69; color:#fff;">
                                    <tr>
                                        <th scope="col">Articulo</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Categorías</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($queryArticulo->num_rows > 0) {
                                        while ($dataArticulo = mysqli_fetch_array($queryArticulo)) {
                                            // Obtener las categorías del artículo
                                            $articuloId = $dataArticulo['id_articulo'];
                                            $consultaCategorias = "SELECT c.nombre_categoria FROM articulo_categorias ac INNER JOIN categorias c ON ac.id_categoria_ca = c.id_categoria WHERE ac.id_articulo_ca = '$articuloId'";
                                            $resultadoCategorias = mysqli_query($conexion, $consultaCategorias);

                                            // Construir la lista de categorías
                                            $categorias = '';
                                            while ($categoria = mysqli_fetch_assoc($resultadoCategorias)) {
                                                $categorias .= $categoria['nombre_categoria'] . ', ';
                                            }
                                            $categorias = rtrim($categorias, ', ');

                                            ?>
                                            <tr>
                                                <td style="width:13rem;"><?php echo $dataArticulo['nombre_articulo']; ?></td>
                                                <td style="width:15rem;"><?php echo $dataArticulo['descripcion_articulo']; ?></td>
                                                <td style="width:8rem;"><?php echo $dataArticulo['precio_venta']; ?></td>
                                                <td style="width:8rem;"><?php echo $dataArticulo['cantidad']; ?></td>
                                                <td style="width:15rem;"><?php echo $categorias; ?></td>
                                                <td style="width:10rem;">
                                                    <?php
                                                    if($dataArticulo['estado_articulo'] == 1){ ?>
                                                        <button style="background-color:#1DBC26;border-color:#1DBC26;width:6rem;font-family:Inherit;cursor: default;color: #fff;outline: none;" type="button" class="btn btn-success">ACTIVO</button>
                                                    <?php
                                                    }else if($dataArticulo['estado_articulo'] == 0){ ?>
                                                        <button style="background-color:#0F0F0F;border-color:#0F0F0F; width:7rem;font-family:Inherit" type="button" class="btn btn-dark">ANULADO</button>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td style="width:8rem;">
                                                    <button data-toggle="modal2" data-target="#MostrarLote" class="btn btn-warning" data-id="<?php echo $dataArticulo['id_articulo']; ?>">
                                                        <i style="font-size:18px;padding-top:3px;" class="fas fa-info-circle" aria-hidden="true"></i>
                                                    </button>
                                                    <?php
                                                    if($dataArticulo['estado_articulo'] == 1 ){?>
                                                        <button style="background-color:#e74a3b; border-color:#e74a3b" title="Eliminar" type="button" class="btn btn-info" onclick="eliminarArticulo(<?php echo $dataArticulo['id_articulo']; ?>)">
                                                        <i style="font-size:18px;padding-top:3px;" class="fas fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModal" onclick="editarArticulo(<?php echo $dataArticulo['id_articulo']; ?>, '<?php echo $dataArticulo['nombre_articulo']; ?>', '<?php echo $dataArticulo['descripcion_articulo']; ?>', '<?php echo $dataArticulo['precio_venta']; ?>')">
                                                            <i style="font-size:18px;padding-top:3px;" class="fas fa fa-edit" aria-hidden="true"></i>
                                                        </button>

                                                    <?php
                                                    }else{?>
                                                        <button style="background-color:#e74a3b; border-color:#e74a3b;visibility:hidden;" title="Eliminar" type="button" class="btn btn-info" onclick="eliminarArticulo(<?php echo $dataArticulo['id_articulo']; ?>)">
                                                        <i class="fas fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                        <button style="visibility:hidden;" type="button" class="btn btn-info" data-toggle="modal" data-target="#editModal" onclick="editarArticulo(<?php echo $dataArticulo['id_articulo']; ?>, '<?php echo $dataArticulo['nombre_articulo']; ?>', '<?php echo $dataArticulo['descripcion_articulo']; ?>', '<?php echo $dataArticulo['precio_venta']; ?>')">
                                                            <i class="fas fa fa-edit" aria-hidden="true"></i>
                                                        </button>
                                                    <?php
                                                    }
                                                    ?>
                                                    
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr class="text-center">
                                            <td style="color:black;" colspan="7">No hay registros</td>
                                        </tr>
                                        <style>
                                            .btnVolver{
                                                display:none;
                                            }
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
                                </tbody>
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
                                            <a class="page-link" href="articulo.php?id=<?php echo $id_empresa?>&paginas=<?php echo $_GET['paginas']-1 ?>">
                                                Anterior
                                            </a>
                                        </li>
                                        
                                        
                                        <li  class="page-item <?php echo $_GET['paginas']==$i+1 ? 'active' : '' ?>">
                                            <a style="background-color:#5a5c69; color:white;" class="page-link" href="articulo.php?id=<?php echo $id_empresa?>&paginas=<?php echo $i+1 ; ?>">
                                                <?php echo $_GET['paginas'] ; ?>
                                            </a>
                                        </li>
                                        

                                        <li class="page-item <?php echo $_GET['paginas']>=$paginas? 'disabled':''?>" >
                                        <a class="page-link" href="articulo.php?id=<?php echo $id_empresa?>&paginas=<?php echo $_GET['paginas']+1 ?>" style="position: relative; left: 0;">
                                            Siguiente
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            
                            
                            
                            <ul class="pagination">
                                <a style="background-color:#5a5c69;border:none;" class="btn btn-secondary btnVolver" href="articulo.php?id=<?php echo $id_empresa?>&paginas=1">
                                    Volver
                                </a>
                            </ul> 



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

    <style>
        .tables th, .tables td {
            border: 1px solid #ccc; /* Añade un borde gris a todas las celdas de la tabla */
            text-align: center; /* Centra el texto en todas las celdas de la tabla */
        }
        .tables th{
            color:#fff;
            background-color:#EAB735;
        }
        .table-scroll{
            position:relative;
            bottom:15px;
            width:100%;
            height:400px;
            padding:1.5em;
            overflow-y: auto; /* habilita el scroll vertical */
            display: block; /* establece el contenedor como un bloque para permitir el desplazamiento */
        }
    </style>
<!--Modal tabla-->
<div class="modal fade" id="MostrarLote">
    <div class="modal-dialog">
        <div style="width:60rem;height:30rem;position:relative;right:15rem;" class="modal-content">
            <div class="modal-header" style="background-color:#f6c23e">
                <h4 class="modal-title" style="color:#fff;">Lotes del Articulo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="contenido table-scroll" id="contenidoModal">
                

                </div>
                
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('[data-toggle="modal2"]').click(function(e) {
            e.preventDefault(); // previene la acción por defecto del botón

            var idArticulo = $(this).data('id');

            // Llamada AJAX
            $.ajax({
                url: 'datos/get_lote.php',
                type: 'POST',
                data: { id_articulo: idArticulo },
                success: function(data) {
                    // Inserta la respuesta en el modal y luego abre el modal
                    $('#contenidoModal').html(data);
                    $('#MostrarLote').modal('show');
                }
            });
        });
    });
</script>




<!--Modal Adicionar-->  
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="formAdd" class="formAdd">
            <div class="modal-header" style="background-color:#1cc88a">
            <h4 class="modal-title" style="color:#fff;">Añadir Articulo</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <div class="form-group">
                <label for="">Nombre</label>
                <input type="text" class="form-control" id="nombreInput" name="nombreInput" maxlength="50" required>
            </div>
            <div class="form-group">
                <label for="">Precio</label>
                <input type="number" min="1" class="form-control" id="precioInput" name="precioInput" required>
            </div>
            <div class="form-group">
                <label for="">Descripción</label>
                <input type="text" class="form-control" id="descripcionInput" name="descripcionInput" maxlength="80">
            </div>
            <div class="form-group">
                <label for="">Categoria</label>
                <select class="mi-select2 selectArticulo form-control" multiple="multiple" id="categoriasInput" required data-max-options="3">
                <?php
                // Conexión
                include_once '../../erpApi/conexion/bd_directa.php';

                // Consulta para obtener todas las categorías
                $sql = "SELECT * FROM categorias WHERE id_empresa_categoria = $id_empresa";
                $result = mysqli_query($conexion, $sql);

                // Recorrer los resultados y generar las opciones
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['id_categoria'] . '">' . $row['nombre_categoria'] . '</option>';
                }
                ?>
                </select>
            </div>
            <div style="display:none;" class="form-group">
                <label for="add_id_empresa">IdEmpresa</label>
                <input type="number" class="form-control" id="idEmpresaInput" name="idEmpresaInput" value="<?php echo $id_empresa; ?>" readonly>
            </div>
            </div>
            <div class="modal-footer">
            <div class="cerrarMD">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            <div class="acciones">
                <button style="background-color:#1cc88a; border:none;position:relative;left:5px;" type="submit" class="btn btn-primary" id="btn-submit">Guardar</button>
            </div>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="editForm" name="editForm">
            <div class="modal-header" style="background-color:#17a2b8">
            <h4 class="modal-title" style="color:#fff;">Editar Articulo</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <div style="display:none;" class="form-group">
                <label>Id</label>
                <input type="number" class="form-control" id="edit_id_articulo" name="edit_id_articulo" required readonly>
            </div>
            <div class="form-group">
                <label>Articulo</label>
                <input type="text" class="form-control" id="edit_nombre" name="edit_nombre" required>
            </div>
            <div class="form-group">
                <label>Precio</label>
                <input type="number" class="form-control" id="edit_precio" name="edit_precio" required>
            </div>
            <div class="form-group">
                <label>Descripción</label>
                <input type="text" class="form-control" id="edit_descripcion" name="edit_descripcion">
            </div>
            <div class="form-group">
                <label for="">Categoria</label>
                <select class="mi-select2 selectArticulo form-control" multiple="multiple" id="edit_categoriasInput" required data-max-options="3">
                <?php
                // Conexión
                include_once '../../erpApi/conexion/bd_directa.php';

                // Consulta para obtener todas las categorías
                $sql = "SELECT * FROM categorias WHERE id_empresa_categoria = $id_empresa";
                $result = mysqli_query($conexion, $sql);

                // Recorrer los resultados y generar las opciones
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['id_categoria'] . '">' . $row['nombre_categoria'] . '</option>';
                }
                ?>
                </select>
            </div>

            <div style="display:none;" class="form-group">
                <label>IdEmpresa</label>
                <input type="number" class="form-control" id="edit_id_empresa" name="edit_id_empresa" value="<?php echo $id_empresa; ?>" readonly>
            </div>
            </div>
            <div class="modal-footer">
            <div class="cerrarMD">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            <div class="acciones">
                <button style="background-color:#17a2b8; border:none;position:relative;left:5px;" type="submit" class="btn btn-primary" id="btn-submit">Actualizar</button>
            </div>
            </div>
        </form>
        </div>
    </div>
</div>



    <script>
        $(document).ready(function() {
            $('.mi-select2').each(function() {
                $(this).select2({
                    maximumSelectionLength: 15
                });
            });
        });


    </script>
    <script>
        function editarArticulo(id, nombre, descripcion, precio) {
            document.getElementById('edit_id_articulo').value = id;
            document.getElementById('edit_nombre').value = nombre;
            document.getElementById('edit_descripcion').value = descripcion;
            document.getElementById('edit_precio').value = precio;

            $.ajax({
                url: 'datos/get_articulo_categoria.php',
                type: 'POST',
                data: { id_articulo: id },
                success: function(data) {
                    var categoriasArticulo = JSON.parse(data); // Parsear la respuesta como JSON
                    $('#edit_categoriasInput').val(categoriasArticulo).trigger('change');
                }
            });
        }

        function enviarFormularioEdicion(event) {
            event.preventDefault(); // Evitar el envío del formulario por defecto

            // Obtener los valores del formulario
            var idArticulo = document.getElementById('edit_id_articulo').value;
            var nombre = document.getElementById('edit_nombre').value;
            var descripcion = document.getElementById('edit_descripcion').value;
            var precio = document.getElementById('edit_precio').value;
            var idEmpresa = document.getElementById('edit_id_empresa').value;

            // Obtener las categorías seleccionadas
            var categorias = $('#edit_categoriasInput').val();

            // Mostrar los valores en variables
            console.log('ID Artículo:', idArticulo);
            console.log('Nombre:', nombre);
            console.log('Descripción:', descripcion);
            console.log('Precio:', precio);
            console.log('ID Empresa:', idEmpresa);
            console.log('Categorías:', categorias);

            editArticulo(idArticulo,nombre,descripcion,precio,idEmpresa,categorias,event)
        }

        document.getElementById('editForm').addEventListener('submit', enviarFormularioEdicion);

        // Restablecer los valores del formulario al cerrar el modal
        $('#editModal').on('hidden.bs.modal', function() {
            document.getElementById('editForm').reset();
        });

    </script>


    <script>
        $(document).ready(function() {
            $('#formAdd').submit(function(e) {
                e.preventDefault();

                var nombre = $('#nombreInput').val();
                var precio = $('#precioInput').val();
                var categorias = $('#categoriasInput').select2('val');  // Obtiene los valores seleccionados como un array
                var descripcion = $('#descripcionInput').val();
                var idEmpresa = $('#idEmpresaInput').val();

                // Ahora, puedes hacer lo que quieras con los valores...
                console.log('Nombre:', nombre);
                console.log('Precio:', precio);
                console.log('Categorias:', categorias);
                console.log('Descripcion:', descripcion);
                console.log('IDEmpresa:',idEmpresa);
                //js accion
                guardarArticulo(nombre, descripcion, precio, idEmpresa, categorias, event);
            });
        });
    </script>
    <!--Responsive-->

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
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
    <!--select2-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <!--Toaster-->
    <script src="../js/toastr.min.js"></script>

    
    

    
</body>

</html>