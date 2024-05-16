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
    <!-- Incluir Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <script defer src="../js/autor.js" ></script>
    <!--TOASTER-->
    <link href="../css/toastr.min.css" rel="stylesheet">

    <!--LIBRERIA PAR VALIDAR FORMULARIO-->
    
</head>


<body id="page-top">
<?php
    //llegada de datos
    $conexion = mysqli_connect("localhost","root","","erp");

        $id_empresa = $_GET['id'];
        $qry = "SELECT * FROM empresas WHERE id_empresa = $id_empresa";
        $run = $conexion -> query($qry);
        $num_rows = 0;
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                $nombre_empresa=$row['nombre_empresa'];
            }
        } 

    //verficar la cantidad de integraciones en la bd
    $sql = "SELECT COUNT(*) as cantidad FROM integraciones WHERE id_empresa_integracion = $id_empresa";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        $fila = mysqli_fetch_assoc($resultado);
        $cantidad_integracion = $fila['cantidad'];
    } 
    if($cantidad_integracion >= 1){
        $qry = "SELECT * FROM integraciones WHERE id_empresa_integracion = '$id_empresa' AND estado = 1";
        $run = $conexion -> query($qry);
        $num_rows = 0;
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                $id_caja = $row['caja'];
                $id_credito_fiscal = $row['credito_fiscal'];
                $id_debito_fiscal = $row['debito_fiscal'];
                $id_compra = $row['compra'];
                $id_venta = $row['venta'];
                $id_it = $row['it'];
                $id_it_pago = $row['it_pago'];
                $activacion = $row['activacion'];
            }
        } 
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
                    /* #5a5c69 -- negro*/
                    .formularioBalance{
                        background-color: #5a5c69;
                        border:1px solid #464647;
                        width: 40rem;
                        height: 53rem;
                        margin: 0 auto;
                        border-radius: 15px;
                        padding: 30px;
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
                        gap:40px;
                    }
                    .botonBalance{
                        background-color:#E34724;
                        color:#fff;
                        width:15rem;
                        text-align:center;
                        height:48px;
                        font-size:18px;
                        border-radius:7.5px;
                        padding-top:0px;
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
                    .Integracion{
                        display:flex;
                        flex-direction:row;
                        justify-content:space-between;
                        margin-bottom:20px;
                    }
                    .eleccion{
                        display:flex;
                        flex-direction:row;
                        gap:2rem;
                    }
                    .formIntegracion{
                        position:relative;
                        bottom:20px;
                    }
                    .botones{
                        height:3rem;
                        margin-top:2rem;
                        display:flex;
                        flex-direction:row;
                        justify-content:space-between;
                    }
                        
                </style>
                
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="crudAutor">
                    
                    <!-- Page Heading -->

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <!--<h1 style="margin-left:10px; margin-top:5px; font-family:cursive" class="h3 mb-0 text-gray-800">Empresas</h1>-->
                        
                    </div>

                    <!--Very importan!-->
                    <style>
                        .select2-container .select2-selection--single {
                            height: 35px; /* Altura que desees */
                            border: 1px solid #d1d3e2;
                        }

                        .select2-container--default .select2-selection--single .select2-selection__rendered {
                            line-height: 35px; /* Altura que desees */
                            
                        }

                        .select2-container--default .select2-selection--single .select2-selection__arrow {
                            height: 35px; /* Altura que desees */
                        }

                    </style>


                    <div class="card shadow mb-4" style="padding:30px; height:57rem; position:relative; bottom:45px;">
                        <div class="formularioBalance"> 
                            <h2 class="tituloBalance">Configuración de integración</h2>
                            <div class="contenForm">
                            
                            <?php
                                if($cantidad_integracion == 0){?>
                                    <form class="formIntegracion" id="formularioAdd" method="POST" onsubmit="integracion(event)">
                                        <input type="hidden" id="id_empresa" value="<?php echo $id_empresa ?>">
                                        <div class="Integracion">
                                            <div>
                                                <span style="color:#fff;font-size:20px;">Integracion:</span>
                                            </div>
                                            <div class="eleccion">
                                                <label for="eleccion1">
                                                    <input type="radio" name="eleccion" id="eleccion1"><span style="color:#fff;">Si</span>
                                                </label>

                                                <label for="eleccion2">
                                                    <input type="radio" name="eleccion" id="eleccion2" checked ><span style="color:#fff;">No</span>
                                                </label>
                                            </div>
                                        
                                        </div>
                                        <div class="form-group ContainerGestion">
                                            <span class="textBalance txtGestion">Caja: </span>
                                            <?php
                                            include_once '../../erpApi/conexion/bd_directa.php';

                                            $qry = "SELECT id_cuenta, nombre_cuenta, codigo FROM cuentas WHERE id_empresa_cuenta = $id_empresa AND tipo_cuenta = 'Detalle'";

                                            $result = mysqli_query($conexion, $qry);
                                            ?>

                                            <select name="selectCaja" id="selectCaja" class="form-control select2">
                                                <?php
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_cuenta'] . '">' . $row['codigo'] . ' ' .$row['nombre_cuenta'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group ContainerGestion">
                                            <span class="textBalance txtGestion">Credito Fiscal: </span>
                                            <?php
                                            include_once '../../erpApi/conexion/bd_directa.php';

                                            $qry = "SELECT id_cuenta, nombre_cuenta, codigo FROM cuentas WHERE id_empresa_cuenta = $id_empresa AND tipo_cuenta = 'Detalle'";

                                            $result = mysqli_query($conexion, $qry);
                                            ?>

                                            <select name="selectCredito" id="selectCredito" class="form-control select2">
                                                <?php
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_cuenta'] . '">' . $row['codigo'] . ' ' .$row['nombre_cuenta'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group ContainerGestion">
                                            <span class="textBalance txtGestion">Debito Fiscal: </span>
                                            <?php
                                            include_once '../../erpApi/conexion/bd_directa.php';

                                            $qry = "SELECT id_cuenta, nombre_cuenta, codigo FROM cuentas WHERE id_empresa_cuenta = $id_empresa AND tipo_cuenta = 'Detalle'";

                                            $result = mysqli_query($conexion, $qry);
                                            ?>

                                            <select name="selectDebito" id="selectDebito" class="form-control select2">
                                                <?php
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_cuenta'] . '">' . $row['codigo'] . ' ' .$row['nombre_cuenta'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group ContainerGestion">
                                            <span class="textBalance txtGestion">Compra: </span>
                                            <?php
                                            include_once '../../erpApi/conexion/bd_directa.php';

                                            $qry = "SELECT id_cuenta, nombre_cuenta, codigo FROM cuentas WHERE id_empresa_cuenta = $id_empresa AND tipo_cuenta = 'Detalle'";

                                            $result = mysqli_query($conexion, $qry);
                                            ?>

                                            <select name="selectCompra" id="selectCompra" class="form-control select2">
                                                <?php
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_cuenta'] . '">' . $row['codigo'] . ' ' .$row['nombre_cuenta'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group ContainerGestion">
                                            <span class="textBalance txtGestion">Venta: </span>
                                            <?php
                                            include_once '../../erpApi/conexion/bd_directa.php';

                                            $qry = "SELECT id_cuenta, nombre_cuenta, codigo FROM cuentas WHERE id_empresa_cuenta = $id_empresa AND tipo_cuenta = 'Detalle'";

                                            $result = mysqli_query($conexion, $qry);
                                            ?>

                                            <select name="selectVenta" id="selectVenta" class="form-control select2">
                                                <?php
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_cuenta'] . '">' . $row['codigo'] . ' ' .$row['nombre_cuenta'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group ContainerGestion">
                                            <span class="textBalance txtGestion">IT: </span>
                                            <?php
                                            include_once '../../erpApi/conexion/bd_directa.php';

                                            $qry = "SELECT id_cuenta, nombre_cuenta, codigo FROM cuentas WHERE id_empresa_cuenta = $id_empresa AND tipo_cuenta = 'Detalle'";

                                            $result = mysqli_query($conexion, $qry);
                                            ?>

                                            <select name="selectIT" id="selectIT" class="form-control select2">
                                                <?php
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_cuenta'] . '">' . $row['codigo'] . ' ' .$row['nombre_cuenta'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group ContainerGestion">
                                            <span class="textBalance txtGestion">IT por Pagar: </span>
                                            <?php
                                            include_once '../../erpApi/conexion/bd_directa.php';

                                            $qry = "SELECT id_cuenta, nombre_cuenta, codigo FROM cuentas WHERE id_empresa_cuenta = $id_empresa AND tipo_cuenta = 'Detalle'";

                                            $result = mysqli_query($conexion, $qry);
                                            ?>

                                            <select name="selectITpago" id="selectITpago" class="form-control select2">
                                                <?php
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_cuenta'] . '">' . $row['codigo'] . ' ' .$row['nombre_cuenta'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="botones">
                                            <button style="width:15rem; background-color:#e34724; border-color:#e34724;color:#fff;" type="submit" class="btn btn-light">Guardar</button>
                                            <a href="integraciones.php?id=<?php echo $id_empresa; ?>" style="width:15rem;padding-top:10px;" class="btn btn-light">Cancelar</a>
                                        </div>
                                    </form>
                                <?php
                                }else{?>
                                    <form class="formIntegracion" id="formularioAdd" method="POST" onsubmit="integracion(event)">
                                        <input type="hidden" id="id_empresa" value="<?php echo $id_empresa ?>">
                                        <div class="Integracion">
                                            <div>
                                                <span style="color:#fff;font-size:20px;">Integracion:</span>
                                            </div>
                                            <div class="eleccion">
                                                <label for="eleccion1">
                                                    <input type="radio" name="eleccion" id="eleccion1" <?php if($activacion == 1){echo 'checked';} ?>><span style="color:#fff;">Si</span>
                                                </label>
                                                <label for="eleccion2">
                                                    <input type="radio" name="eleccion" id="eleccion2" <?php if($activacion == 0){echo 'checked';} ?>><span style="color:#fff;">No</span>
                                                </label>
                                            </div>
                                        </div>

                                        <?php
                                        include_once '../../erpApi/conexion/bd_directa.php';

                                        $qry = "SELECT id_cuenta, nombre_cuenta, codigo FROM cuentas WHERE id_empresa_cuenta = $id_empresa AND tipo_cuenta = 'Detalle'";
                                        $result = mysqli_query($conexion, $qry);
                                        ?>

                                        <div class="form-group ContainerGestion">
                                            <span class="textBalance txtGestion">Caja: </span>
                                            <select name="selectCaja" id="selectCaja" class="form-control select2">
                                                <?php
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_cuenta'] . '"';
                                                    if($row['id_cuenta'] == $id_caja) echo ' selected';
                                                    echo '>' . $row['codigo'] . ' ' . $row['nombre_cuenta'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group ContainerGestion">
                                            <span class="textBalance txtGestion">Credito Fiscal: </span>
                                            <select name="selectCredito" id="selectCredito" class="form-control select2">
                                                <?php
                                                mysqli_data_seek($result, 0);  // Reset result pointer
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_cuenta'] . '"';
                                                    if($row['id_cuenta'] == $id_credito_fiscal) echo ' selected';
                                                    echo '>' . $row['codigo'] . ' ' . $row['nombre_cuenta'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group ContainerGestion">
                                            <span class="textBalance txtGestion">Debito Fiscal: </span>
                                            <select name="selectDebito" id="selectDebito" class="form-control select2">
                                                <?php
                                                mysqli_data_seek($result, 0);  // Reset result pointer
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_cuenta'] . '"';
                                                    if($row['id_cuenta'] == $id_debito_fiscal) echo ' selected';
                                                    echo '>' . $row['codigo'] . ' ' . $row['nombre_cuenta'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group ContainerGestion">
                                            <span class="textBalance txtGestion">Compra: </span>
                                            <select name="selectCompra" id="selectCompra" class="form-control select2">
                                                <?php
                                                mysqli_data_seek($result, 0);  // Reset result pointer
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_cuenta'] . '"';
                                                    if($row['id_cuenta'] == $id_compra) echo ' selected';
                                                    echo '>' . $row['codigo'] . ' ' . $row['nombre_cuenta'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group ContainerGestion">
                                            <span class="textBalance txtGestion">Venta: </span>
                                            <select name="selectVenta" id="selectVenta" class="form-control select2">
                                                <?php
                                                mysqli_data_seek($result, 0);  // Reset result pointer
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_cuenta'] . '"';
                                                    if($row['id_cuenta'] == $id_venta) echo ' selected';
                                                    echo '>' . $row['codigo'] . ' ' . $row['nombre_cuenta'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group ContainerGestion">
                                            <span class="textBalance txtGestion">IT: </span>
                                            <select name="selectIT" id="selectIT" class="form-control select2">
                                                <?php
                                                mysqli_data_seek($result, 0);  // Reset result pointer
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_cuenta'] . '"';
                                                    if($row['id_cuenta'] == $id_it) echo ' selected';
                                                    echo '>' . $row['codigo'] . ' ' . $row['nombre_cuenta'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group ContainerGestion">
                                            <span class="textBalance txtGestion">IT por Pagar: </span>
                                            <select name="selectITpago" id="selectITpago" class="form-control select2">
                                                <?php
                                                mysqli_data_seek($result, 0);  // Reset result pointer
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['id_cuenta'] . '"';
                                                    if($row['id_cuenta'] == $id_it_pago) echo ' selected';
                                                    echo '>' . $row['codigo'] . ' ' . $row['nombre_cuenta'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="botones">
                                            <button style="width:15rem; background-color:#e34724; border-color:#e34724;color:#fff;" type="submit" class="btn btn-light">Guardar</button>
                                            <a href="integraciones.php?id=<?php echo $id_empresa; ?>" style="width:15rem;padding-top:10px;" class="btn btn-light">Cancelar</a>
                                        </div>
                                    </form>
    


                                <?php
                                }
                            ?>


                            </div>
                            
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
    


    <!-- Incluir la biblioteca de jQuery al comienzo del documento -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Incluir Select2 JS después del código -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Esperar a que el documento esté listo
        $(document).ready(function() {
            // Inicializar Select2 en los selectores
            $('.select2').select2();

            // Obtener todos los selectores Select2 y manejar el evento de cambio
            var selectores = ['#selectCaja', '#selectCredito', '#selectDebito', '#selectCompra', '#selectVenta', '#selectIT', '#selectITpago'];

            // Manejar el evento de cambio en los selectores
            $(selectores.join(',')).on('change', function() {
            var valorSeleccionado = $(this).val();

            // Habilitar todas las opciones en los selectores
            $(selectores.join(',')).find('option').prop('disabled', false);

            // Deshabilitar la opción seleccionada en los otros selectores
            $(selectores.join(',')).not(this).find('option[value="' + valorSeleccionado + '"]').prop('disabled', true);

            // Actualizar los selectores para reflejar los cambios
            $(selectores.join(',')).trigger('change.select2');
            });
        });
    </script>


    <!-- Bootstrap core JavaScript-->
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    


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
    <!--Toaster-->
    <script src="../js/toastr.min.js"></script>

    
    

    
</body>

</html>