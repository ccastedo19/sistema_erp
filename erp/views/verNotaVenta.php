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
    <!-- Incluir Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

        $id_empresa = $_GET['id'];
        $qry = "SELECT * FROM empresas WHERE id_empresa = $id_empresa";
        $run = $db -> query($qry);
        $num_rows = 0;
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                $nombre_empresa=$row['nombre_empresa'];
            }
        } 

        $id_nota = $_GET['id_nota'];
        $qry2 = "SELECT * FROM notas WHERE id_nota = $id_nota";
        $run = $db -> query($qry2);
        $num_rows = 0;
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                $nro_notaValue = $row['nro_nota'];
                $descripcionValue = $row['descripcion'];
                $fecha_notaValue = $row['fecha_nota'];
                $estado_nota = $row['estado_nota'];
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
                            width:40px;
                            height:40px;
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
                            margin-bottom:10px;
                            
                        }
                        .inputMoneda{
                            width:17rem;
                        }
                        .btnPrincipales{
                            display:flex;
                            flex-direction:row;
                            justify-content:space-between;
                            margin-bottom:15px;
                        }
                        .btnP {
                            width: 20px;
                            height: 20px;
                            filter: invert(1);
                        }
                        .formTabla{
                            width:100%;
                            display:flex;
                            flex-direction:column-reverse;
                        }
                        .ParteArriba{
                            display:flex;
                            flex-direction:row;
                            justify-content:space-between;
                        }
                        .ParteAnajo{
                            display:flex;
                            flex-direction:row;
                        }
                        .parteFuncional{
                            display:flex;
                            flex-direction:row;
                            justify-content: space-between;
                            margin-bottom:1rem;
                        }
                        .parteDerechaOff{
                            display:flex;
                            flex-direction:row;
                            gap:3rem;
                            
                        }
                    </style>
                    
                    <!-- Page Heading -->

                    <div class="ImagenAutor">
                        <div>
                            <img class="FotoAutor"src="../img/detalleVentas.png">
                        </div>
                        <div>
                            <h2 style="font-size:18px;position:relative;top:15px;right:5px;" class="txtDichoAutor">Detalles para la Nota de Venta</h2>
                        </div>
                        
                    </div>

                    
                

                    <!--Very importan!-->
                    <?php
                        date_default_timezone_set('America/La_Paz'); // Establece la zona horaria a Bolivia, La Paz

                        $fecha_actual = date('Y-m-d'); // Obtiene la fecha actual en formato 'YYYY-MM-DD'
                    ?>
                    <?php
                        include_once '../../erpApi/conexion/bd_directa.php';
                        $query = "SELECT nro_nota FROM notas WHERE id_empresa_nota = $id_empresa ORDER BY id_nota DESC LIMIT 1";
                        $resultado = mysqli_query($conexion, $query);
                        if ($fila = mysqli_fetch_assoc($resultado)) {
                            $nro_nota = $fila['nro_nota'];
                            $nro_notaV = $nro_nota + 1;
                        } else{
                            $nro_notaV = 1;
                        }

                    ?>


                <div class="card shadow mb-4" >
                    <div class="card-header py-3">
                    <div class="parteFuncional">
                        <div>
                            <a class="btn btn-info" href="notaVenta.php?id=<?php echo $id_empresa?>&paginas=1" title="Volver">Volver</a>                     
                        </div>
                        <div class="parteDerechaOff">
                            <div>
                                <?php
                                    if($estado_nota == 1){?>
                                        <button style="background-color:#000;"  title="Anular" type="button" onclick="editarNotaVenta(<?php echo $id_nota; ?>,<?php echo $id_empresa ?>, event)" class="btn btn-dark">Anular</button> 
                                    <?php
                                    }else{?>
                                        <button style="background-color:#000;display:none;"  title="Anular" type="button"  class="btn btn-dark">Anular</button>
                                    <?php
                                    }
                                ?>
                            </div>
                            <div>
                                <a title="Reporte" target="_blank" style="" class="btn btn-primary" href="../report/reporteNotaVenta.php?id_empresa=<?php echo $id_empresa; ?>&id_nota=<?php echo $id_nota; ?>"><span>Reporte </span><i class="fas fa fa-print" aria-hidden="true"></i></a>
                            </div>
                            <div>
                                <a class="btn btn-success" href="notaVentaDetalle.php?id=<?php echo $id_empresa; ?>">Nuevo</a>
                            </div>
                        </div>
                    </div>
                    
                    <form class="formPrincipal" method="POST" id="formularioAdd">
                        
                        <div class="formTabla">
                            <div class="ParteArriba">
                                <div class="">
                                    <label for="validationCustom01" class="col-form-label">Nro</label>
                                    <input type="number" id="nro_nota" class="form-control no-arrow inputMoneda" value="<?php echo $nro_notaValue ?>" readonly>
                                </div>

                                <div class="">
                                    <label for="validationCustom01" class="col-form-label">Descripcion</label>
                                    <input type="text" id="descripcion" class="form-control inputMoneda" value="<?php echo $descripcionValue ?>" readonly>
                                </div>

                                <div class="">
                                    <label for="validationCustom01" class="col-form-label">Fecha</label>
                                    <input type="date" id="fecha_ingreso" class="form-control inputMoneda" no-arrow value="<?php echo $fecha_notaValue ?>" required readonly>

                                </div>
                            </div>
                            
                            
                        
                            
                        </div>

                        
                    </form>


                    <hr style="margin-top:3rem;">
                    
                    
                    
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
                        .table {
                            border-collapse: collapse; /* Para asegurarse de que los bordes de las celdas se toquen */
                        }
                        
                        .table th, .table td {
                            border: 1px solid #ccc; /* Añade un borde gris a todas las celdas de la tabla */
                            text-align: center; /* Centra el texto en todas las celdas de la tabla */
                        }
                        .table-scroll{
                            position:relative;
                            bottom:15px;
                            width:100%;
                            height:400px;
                            overflow-y: auto; /* habilita el scroll vertical */
                            display: block; /* establece el contenedor como un bloque para permitir el desplazamiento */
                        }

                        .nuevaNota{
                            display:flex;
                            flex-direction:row;
                            justify-content:end;
                            margin-bottom:1.3rem;
                            
                        }
                </style>


                    <div class="nuevaNota">
                        <div style="visibility:hidden;">
                            <button class="btn btn-success" data-toggle="modal" data-target="#addModal">Añadir Detalle</button>
                        </div>
                    </div>
                    <?php
                        include_once '../../erpApi/conexion/bd.php';
                        //consulta
                        $sqlCliente = "SELECT de.*, na.nombre_articulo, lo.nro_lote
                            FROM detalles AS de
                            INNER JOIN articulos AS na ON de.id_articulo_detalle = na.id_articulo
                            INNER JOIN lotes AS lo ON de.id_lote_detalle = lo.id_lote
                            AND de.id_nota_detalle = $id_nota";

                        $queryNota = mysqli_query($con, $sqlCliente);
                        $cantidad     = mysqli_num_rows($queryNota);
                    ?>
                    <div class="table-scroll">
                    <table class="table" id="tablaDetalles">
                        <thead style="background-color:#5a5c69; color:#fff;">
                            <tr>
                                <th scope="col">Articulo</th>
                                <th scope="col">Nro Lote</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $total = 0; // Inicializar el total a 0
                            if ($queryNota -> num_rows > 0){
                                while ($dataNota = mysqli_fetch_array($queryNota)) {
                                    $subtotal = $dataNota['cantidad'] * $dataNota['precio_venta'];
                                    $total += $subtotal; // Agregar el subtotal al total
                        ?>
                            <tr>
                                <td style="width:10rem;"><?php echo $dataNota['nombre_articulo'] ?></td>
                                <td style="width:5rem;text-align:right"><?php echo $dataNota['nro_lote'] ?></td>
                                <td style="width:5rem;text-align:right"><?php echo $dataNota['cantidad'] ?></td>
                                <td style="width:5rem;text-align:right"><?php echo $dataNota['precio_venta'] ?></td>
                                <td style="width:5rem;text-align:right"><?php echo $subtotal; ?></td>
                            </tr>
                        <?php
                                }
                            }
                        ?>
                        <!-- Agregar una nueva fila para mostrar el total -->
                        <tr>
                            <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                            <td style="text-align: right;"><?php echo $total; ?></td>
                        </tr>
                        </tbody>
                    </table>

                        
                    </div>

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

    <!--Modal editar-->
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 80rem;position:relative; right:25rem;top:8rem;">
            <form id="editForm">
                <div class="modal-header" style="background-color:#36b9cc">
                    <h4 class="modal-title" style="color:#fff;">Editar Detalle</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div style="display:flex;flex-direction:column; margin-top:2px;" class="form-group col">
                            <label for="form-control">Articulo</label><!--detalle_comprobantes(plan de cuentas)-->
                            <?php
                                include_once '../../erpApi/conexion/bd_directa.php';
                                $query = "SELECT id_articulo, nombre_articulo FROM articulos WHERE id_empresa_articulo = '$id_empresa'";
                                $resultado = mysqli_query($conexion, $query);
                                ?>

                                <div>
                                    <select class="form-control" id="edit_articulo" name="edit_articulo" style="width:14.5rem;">
                                        <?php
                                        // Generar las opciones del elemento select con los datos obtenidos
                                        while ($fila = mysqli_fetch_assoc($resultado)) {
                                            $id_articulo = $fila['id_articulo'];
                                            $nombre_articulo = $fila['nombre_articulo'];
                                            echo "<option value='$id_articulo'>$nombre_articulo</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group col">
                            <label for="form-control">Fecha Venc.</label>
                            <input type="date" class="form-control no-arrow" id="edit_fechaVenc" name="edit_fechaVenc">
                        </div>
                        <div class="form-group col">
                            <label for="form-control">Cantidad</label><!--detalle_comprobantes(misma que la glosa de )-->
                            <input type="number" class="form-control no-arrow" id="edit_cantidad" name="edit_cantidad">
                        </div>
                        <div class="form-group col">
                            <label for="form-control">Precio</label><!--detalle_comprobantes-->
                            <input  type="number" class="form-control no-arrow" id="edit_precio" name="edit_precio">
                        </div>
                        <div class="form-group col">
                            <label for="form-control">Subtotal</label><!--detalle_comprobantes-->
                            <input type="number" class="form-control no-arrow" id="edit_subtotal" name="edit_subtotal" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="cerrarMD">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                    <div class="acciones">
                        <button type="submit" class="btn btn-info" id="btn-submit">Guardar</button>           
                    </div>    
                </div>
            </form>
            </div>
        </div>
    </div>

    <!--Modal añadir-->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 80rem;position:relative; right:25rem;top:8rem;">
            <form id="addForm">
                <div class="modal-header" style="background-color:#1cc88a">
                    <h4 class="modal-title" style="color:#fff;">Añadir Detalle</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div style="display:flex;flex-direction:column; margin-top:2px;" class="form-group col">
                            <label for="form-control">Articulo</label><!--detalle_comprobantes(plan de cuentas)-->
                            <?php
                                include_once '../../erpApi/conexion/bd_directa.php';
                                $query = "SELECT id_articulo, nombre_articulo FROM articulos WHERE id_empresa_articulo = '$id_empresa'";
                                $resultado = mysqli_query($conexion, $query);
                                ?>

                                <div>
                                    <select class="form-control" id="add_articulo" name="add_articulo" style="width:14.5rem;">
                                        <?php
                                        // Generar las opciones del elemento select con los datos obtenidos
                                        while ($fila = mysqli_fetch_assoc($resultado)) {
                                            $id_articulo = $fila['id_articulo'];
                                            $nombre_articulo = $fila['nombre_articulo'];
                                            echo "<option value='$id_articulo'>$nombre_articulo</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group col">
                            <label for="form-control">Fecha Venc.</label><!--detalle_comprobantes(misma que la glosa de )-->
                            <input type="date" class="form-control no-arrow" id="add_fechaVenc" name="add_fechaVenc" min="yyyy-mm-dd">
                        </div>
                        <div class="form-group col">
                            <label for="form-control">Cantidad</label><!--detalle_comprobantes(misma que la glosa de )-->
                            <input type="number" class="form-control no-arrow" id="add_cantidad" name="add_cantidad">
                        </div>
                        <div class="form-group col">
                            <label for="form-control">Precio</label><!--detalle_comprobantes-->
                            <input  type="number" class="form-control no-arrow" id="add_precio" name="add_precio">
                        </div>
                        <div class="form-group col">
                            <label for="form-control">Subtotal</label><!--detalle_comprobantes-->
                            <input type="number" class="form-control no-arrow" id="add_subtotal" name="add_subtotal" readonly>
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
  


    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Incluir Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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