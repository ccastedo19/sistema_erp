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
    <!--LIBRERIA SWEETALERT2-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <!--TOASTER-->
    <link href="../css/toastr.min.css" rel="stylesheet">

    <!--LIBRERIA PARA JQERY PARA VALIDAR EN AJAX FORMULARIO-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--JsTree-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" />


</head>


<body id="page-top"> 
<!--script-->
<script>
    $(document).ready(function() {
    $('#formularioEditHija').submit(function(event) {
        // Evitar que el formulario se envíe de forma predeterminada
        event.preventDefault();

        // Obtener los valores del formulario
        var id_cuenta = $('#id_cuenta_').val();
        var nombre_cuenta = $('#nombre_cuenta_').val();
        var id_empresa_cuenta = $('#id_empresa_cuenta_').val();
        
        //enviar datos a funcion
        actualizarCuenta(id_cuenta,nombre_cuenta,id_empresa_cuenta,event);

        
        // Enviar los datos al servidor con AJAX
        $.ajax({
            url: '<?php echo $_SERVER["PHP_SELF"]; ?>',
            type: 'POST',
            data: {
                id_cuenta: id_cuenta,
                nombre_cuenta: nombre_cuenta,
                id_empresa_cuenta: id_empresa_cuenta,
                
            },
            success: function(response) {
                // Manejar la respuesta del servidor aquí
                console.log(id_cuenta);
                console.log(nombre_cuenta);
                console.log(id_empresa_cuenta);
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
    $db = mysqli_connect("localhost","root","","erp");
    $id_empresa = $_GET['id'];
        $qry = "SELECT * FROM empresas WHERE id_empresa = $id_empresa";
        $run = $db -> query($qry);
        $num_rows = 0;
        if($run -> num_rows > 0 ){
            while($row = $run -> fetch_assoc()){
                $nombre_empresa=$row['nombre_empresa'];
                $nivel_empresa = $row['nivel'];
            }
        } 
?>




<!--estilos titulo-->
<style>
    .contenedorTituloImg{
        height: 10rem;
        display: flex;
        align-items: center;
        justify-content: centerijo
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
                        .accionCuenta{
                            width:100%;
                            display: flex;
                            flex-direction:row-reverse;
                            justify-content: space-between;
                            margin-bottom: 5px;
                        }
                        .btnCuenta{
                            display: flex;
                            align-items: right;
                            gap:15px;
                        }

                    </style>
                    
                    <!-- Page Heading -->
                    <div class="ImagenAutor">
                        <div>
                            <img class="FotoAutor"src="../img/chart.png">
                        </div>
                        <div>
                            <h2 style="font-size:47px; margin-top:2.5rem;" class="txtDichoAutor">Plan de Cuentas</h2>
                        </div>
                        
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <!--<h1 style="margin-left:10px; margin-top:5px; font-family:cursive" class="h3 mb-0 text-gray-800">Empresas</h1>-->
                        
                    </div>

                    <!--Very importan!-->

                <div  class="card shadow mb-4">
                    <div style="height:37rem;" class="card-header py-3">
                        <div class="accionCuenta">
                            <div class="reporte">
                                <a href="../report/reporteCuenta.php?id_empresa=<?php echo $id_empresa; ?>" class="btn btn-primary" role="button" target="_blank">Reporte  <i class="fas fa fa-print" aria-hidden="true"></i></a> 
                            </div>
                            <div class="btnCuenta">
                                <button type="button" class="btn btn-success action-button" data-toggle="modal" data-target="#addModal" id="addBtn" disabled><span>Añadir</span></button>
                                <button type="button" class="btn btn-warning action-button" data-toggle="modal" data-target="#editModal" id="editBtn" disabled><span >Editar</span></button>
                                <button type="button" class="btn btn-danger action-button" id="deleteBtn" disabled><span>Eliminar</span></button>
                            </div>
                        
                        </div>
                        
                        <!--Formulario-->
                        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#1cc88a">
                            <h5 class="modal-title" id="exampleModalLabel" style="color:#fff;">Nueva Cuenta Raíz</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            <form class="needs-validation" novalidate data-offset="70" id="formularioAdd" method="POST" onsubmit="guardarCuenta2(event)">
                                <div class="form-group col-12">
                                    <label for="validationCustom01" class="col-form-label">Nombre de la Cuenta</label>
                                    <input type="text" class="form-control inputAgregar" id="nombre_cuenta" name="nombre_cuenta" required>
                                    <div class="invalid-feedback">
                                        Campo Obligatorio
                                    </div>
                                </div>
                                <div style="display:none;" class="form-group col-12">
                                    <label for="validationCustom01" class="col-form-label">Cuenta padre</label>
                                    <input type="text" class="form-control inputAgregar" id="id_cuenta_padre" name="id_cuenta_padre" value="0" required readonly>
                                    <div class="invalid-feedback">
                                        Campo Obligatorio
                                    </div>
                                </div>


                                
                                <div style="display:none;" class="form-group col-12">
                                    <label for="id_empresa_gestion" class="col-form-label">id de la empresa</label>
                                    <input type="number" class="form-control inputAgregar" id="id_empresa_cuenta" name="id_empresa_cuenta" required="true" value="<?php echo $id_empresa ?>" readonly>
                                </div>
                                <div class="modal-footer">
                                    <div style="margin-left:18.2rem;" class="btnAdd">
                                        <button style="position:relative;right:8px;" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button style="background-color:#1cc88a; border:none;" type="submit" class="btn btn-primary">Añadir</button>
                                    </div>                                 
                                </div>
                            </form>

                            </div>
                            </div>
                        </div>
                    </div>


                        <!---->

                        
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
                            .ContainerArbolForm{
                                display:flex;
                                flex-direction:row;
                                justify-content:space-between;
                            }
                            .arbol{
                                width:100%;
                                /**background-color:red;**/
                                overflow:scroll;
                                height:32rem;
                                border:1px solid #958C8A;
                            }
                            /*formulario */
                            .formArbol{
                                background-color:blue;
                                width:45rem;
                            }
                            /*Boton */
                            .btn-add {
                                width: 20px;
                                height: 20px;
                                background-color: transparent;
                                border: 1px solid #858796;
                                cursor: pointer;
                                padding: 0;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                            }

                            .btn-add:hover {
                                background-color: #858796;
                            }

                            .plus-sign {
                                width: 100%;
                                height: 100%;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                font-size: 14px;
                                font-weight: 30px;
                                color: #858796;
                            }

                            .plus-sign:hover {
                                color: #fff;
                            }
                            .btnEye{
                                background-color: transparent;
                                border:none;
                            }
                            .modal-footer{
                                display:flex;
                                flex-direction:row;
                                justify-content: space-between;
                            }

                        </style>
                        <!--codigo dentro del card-->
                        <div class="ContainerArbolForm">
                            <div class="arbol">
                            <?php
                                include '../../erpApi/conexion/bd_directa.php';
                                
                                // Consulta para obtener todas las cuentas en una sola llamada
                                $sqlCuentas = "SELECT * FROM cuentas WHERE id_empresa_cuenta = $id_empresa";
                                $queryCuentas = mysqli_query($conexion, $sqlCuentas);

                                $cuentas = [];
                                while ($cuenta = mysqli_fetch_array($queryCuentas)) {
                                    $cuentas[] = $cuenta;
                                }

                                function buildTree(array $elements, $parentId = null) {
                                    $branch = [];

                                    foreach ($elements as $element) {
                                        if ($element['id_cuenta_padre'] == $parentId) {
                                            $children = buildTree($elements, $element['id_cuenta']);
                                            if ($children) {
                                                $element['children'] = $children;
                                            }
                                            $branch[] = $element;
                                        }
                                    }

                                    return $branch;
                                }

                                $tree = buildTree($cuentas);

                                function cuentasToJsTree($cuentas, $isRoot = false) {
                                    $treeData = [];
                                
                                    if ($isRoot) {
                                        $treeData[] = [
                                            'id' => 'root',
                                            'text' => 'Raíz',
                                            'children' => [],
                                            'data' => [
                                                'codigo' => '',
                                                'nombre_cuenta' => 'Raíz',
                                                'tipo_cuenta' => ''
                                            ],
                                            'state' => [
                                                'opened' => true
                                            ]
                                        ];
                                    }
                                
                                    foreach ($cuentas as $cuenta) {
                                        $disabled = ($cuenta['tipo_cuenta'] === 'Detalle') ? true : false;
                                
                                        $treeData[] = [
                                            'id' => $cuenta['id_cuenta'],
                                            'text' => $cuenta['codigo'] . ' ' . $cuenta['nombre_cuenta'],
                                            'children' => isset($cuenta['children']) ? cuentasToJsTree($cuenta['children']) : [],
                                            'data' => [
                                                'codigo' => $cuenta['codigo'],
                                                'nombre_cuenta' => $cuenta['nombre_cuenta'],
                                                'tipo_cuenta' => $cuenta['tipo_cuenta']
                                            ],
                                            'disabled' => $disabled,
                                            'state' => [
                                                'opened' => true
                                            ]
                                        ];
                                    }
                                
                                    return $treeData;
                                }
                                
                                
                                

                                $treeData = cuentasToJsTree($tree, true);

                                
                                ?>
                                <div id="jstree-container"></div>
                                    
                                    
                            
                    
                            </div><!--final arbol plan de cuentas -->
                
                        </div><!--final container arbol -->


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

<!-- Modal Editar -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm">
                <div class="modal-header" style="background-color:#17a2b8">
                <h4 class="modal-title" style="color:#fff;">Editar Cuenta</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <div style="display:none;" class="form-group">
                    <label for="edit_id_cuenta">Id</label>
                    <input type="number" class="form-control" id="edit_id_cuenta" name="edit_id_cuenta" required readonly>
                </div>
                <div class="form-group">
                    <label for="edit_codigo">Codigo</label>
                    <input type="text" class="form-control" id="edit_codigo" name="edit_codigo" readonly required>
                </div>
                <div class="form-group">
                    <label for="edit_nombre_cuenta">Nombre de la cuenta</label>
                    <input type="text" class="form-control" id="edit_nombre_cuenta" name="edit_nombre_cuenta" required>
                </div>
                <div style="display:none;" class="form-group">
                    <label for="edit_id_empresa">IdEmpresa</label>
                    <input type="number" class="form-control" id="edit_id_empresa" name="edit_id_empresa" value="<?php echo $id_empresa; ?>" readonly>
                </div>
                </div>
                <div class="modal-footer">
                <div class="cerrarMD">
                    <button style="position:relative;left:18rem;" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
                <div class="acciones">
                    <button style="background-color:#17a2b8; border:none;position:relative;left:5px;" 
                    type="submit" class="btn btn-primary" id="btn-submit">Actualizar</button>           
                </div>    
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal Adicionar-->  
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="addForm">
            <div class="modal-header" style="background-color:#1cc88a">
                <h4 class="modal-title" style="color:#fff;">Añadir Cuenta</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <div style="display:none;" class="form-group">
                <label for="add_id_cuenta">Id cuenta</label>
                <input type="number" class="form-control" id="add_id_cuenta" name="add_id_cuenta" required readonly>
            </div>
            <div class="form-group">
                <label for="add_nombre_cuenta">Nombre</label>
                <input type="text" class="form-control" id="add_nombre_cuenta" name="add_nombre_cuenta" required>
            </div>
            <div style="display:none;" class="form-group">
                <label for="add_id_empresa">IdEmpresa</label>
                <input type="number" class="form-control" id="add_id_empresa" name="add_id_empresa" value="<?php echo $id_empresa; ?>" readonly>
            </div>
            </div>
            <div class="modal-footer">
            <div class="cerrarMD">
                <button style="position:relative;left:19rem;" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            <div class="acciones">
                <button style="background-color:#1cc88a; border:none;position:relative;left:5px;" 
                type="submit" class="btn btn-primary" id="btn-submit">Guardar</button>           
            </div>    
            </div>
        </form>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function () {
    var treeData = <?php echo json_encode($treeData); ?>;
    var jstree = $("#jstree-container").jstree({
        "core": {
        "data": treeData,
        "themes": {
            "dots": true
        }
        }
    });

    jstree.on('ready.jstree', function () {
        jstree.jstree('open_all');
    });
    


    // Variables globales para almacenar información del nodo seleccionado
    var selectedNodeId;
    var selectedNodeText;
    var idCuentaToDelete;
    
    $("#deleteBtn").click(function() {
        if (selectedNodeId) {
            idCuentaToDelete = selectedNodeId;
            console.log("idCuentaToDelete:", idCuentaToDelete);
            var id_empresaE = <?php echo $id_empresa ?>
            // Aquí puedes agregar el código para manejar la eliminación del nodo (por ejemplo, realizar una solicitud AJAX para eliminar el nodo de la base de datos)
            eliminarCuenta(idCuentaToDelete, id_empresaE);
        }
    });

    $("#jstree-container").on("select_node.jstree", function (e, data) {
        selectedNodeId = data.node.id;
        selectedNodeText = data.node.text;

        var parts = selectedNodeText.split(" ");
        codigo = parts.shift(); // Actualiza la variable global
        nombreCuenta = parts.join(" "); // Actualiza la variable global
        $("#edit_nombre_cuenta").val(nombreCuenta);
        $("#edit_id_cuenta").val(selectedNodeId);
        $("#edit_codigo").val(codigo);

        var nodeType = data.node.data.tipo_cuenta;

        if (selectedNodeId === "root") {
            $("#addBtn").prop("disabled", false);
            $("#editBtn").prop("disabled", true);
            $("#deleteBtn").prop("disabled", true);
        } else {
            $("#editBtn").prop("disabled", false);
            $("#deleteBtn").prop("disabled", false);

            if (nodeType === "Detalle") {
                $("#addBtn").prop("disabled", true);
            } else {
                $("#addBtn").prop("disabled", false);
            }
        }

        // Establece el valor predeterminado para el campo add_id_cuenta según el nodo seleccionado
        $("#add_id_cuenta").val(selectedNodeId);
    });


    $("#addModal").on("show.bs.modal", function () {
        if (selectedNodeId === "root") {
        $("#add_id_cuenta").val(0);
        $("#add_codigo").val("");
        } else {
        $("#add_id_cuenta").val(selectedNodeId);
        $("#add_codigo").val(selectedNodeText);
        }
    });

    // Variables para almacenar los valores del formulario
    var addIdCuenta;
    var addNombreCuenta;
    var addIdEmpresa;

    $("#addForm").submit(function (event) {
    event.preventDefault(); // Evita que el formulario se envíe y recargue la página

    // Almacena los valores de los campos del formulario en las variables
    addIdCuenta = $("#add_id_cuenta").val(); // No se convierte a número
    addNombreCuenta = $("#add_nombre_cuenta").val();
    addIdEmpresa = $("#add_id_empresa").val();

    // Si addIdCuenta está vacío, asignarle el valor "0"
    if (addIdCuenta === "") {
        addIdCuenta = "0";
    }

    // Muestra los valores en la consola
    console.log("addIdCuenta:", addIdCuenta);
    console.log("addNombreCuenta:", addNombreCuenta);
    console.log("addIdEmpresa:", addIdEmpresa);

    // Aquí puedes agregar el código para manejar los valores del formulario (por ejemplo, realizar una solicitud AJAX para guardar los datos en la base de datos)
    guardarCuenta(addIdCuenta, addNombreCuenta, addIdEmpresa,event)
    });

    $("#editModal").on("shown.bs.modal", function () { 
        $("#edit_id_cuenta").val(selectedNodeId);
        $("#edit_codigo").val(codigo);
        $("#edit_nombre_cuenta").val(nombreCuenta);
});

    // Variables para almacenar los valores del formulario
    var editIdCuenta;
    var editNombreCuenta;
    var editIdEmpresa;

    $("#editForm").submit(function (event) {
    event.preventDefault(); // Evita que el formulario se envíe y recargue la página

    // Almacena los valores de los campos del formulario en las variables
    editIdCuenta = $("#edit_id_cuenta").val(); // No se convierte a número
    editNombreCuenta = $("#edit_nombre_cuenta").val();
    editIdEmpresa = $("#edit_id_empresa").val();

    // Muestra los valores en la consola
    console.log("editIdCuenta:", editIdCuenta);
    console.log("editNombreCuenta:", editNombreCuenta);
    console.log("editIdEmpresa:", editIdEmpresa);

    // Aquí puedes agregar el código para manejar los valores del formulario (por ejemplo, realizar una solicitud AJAX para guardar los datos en la base de datos)
    actualizarCuenta(editIdCuenta,editNombreCuenta,editIdEmpresa,event)
    });
    
});



</script>


    <!-- Bootstrap core JavaScript-->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
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
    <!--Validaciones formulario-->
    <script src="../js/validarFormulario.js"></script>
    <!--Toaster-->
    <script src="../js/toastr.min.js"></script>

    <script src="../js/accionesArbol.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>

    
</body>

</html>