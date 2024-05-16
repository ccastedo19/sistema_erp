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
        var id_empresa = $('#id_empresa_').val();
        var nombre_empresa = $('#nombre_empresa_').val();
        var nit = $('#nit_').val();
        var sigla = $('#sigla_').val();
        var telefono = $('#telefono_').val();
        var correo = $('#correo_').val();
        var direccion = $('#direccion_').val();
        var nivel = $('#nivel_').val();
        var estado = $('#estado_').val();
        var id_usuario_empresa = $('#id_usuario_empresa_').val();
        //enviar datos a funcion
        actualizarEmpresa(id_empresa,nombre_empresa,nit,sigla,telefono,correo,direccion,nivel,estado,id_usuario_empresa,event);

        
        // Enviar los datos al servidor con AJAX
        $.ajax({
            url: '<?php echo $_SERVER["PHP_SELF"]; ?>',
            type: 'POST',
            data: {
                nombre_empresa: nombre_empresa,
                nit: nit,
                sigla: sigla,
                
            },
            success: function(response) {
                // Manejar la respuesta del servidor aquí
                console.log(nombre_empresa);
                console.log(nit);
                console.log(sigla);
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
    include('../../erpApi/conexion/bd.php'); //abrimos la conexion
    //$conexion = mysqli_connect("localhost","root","","erp");

    $sqlCliente   = ("SELECT * FROM empresas WHERE estado = 1");
    $queryEmpresa = mysqli_query($con, $sqlCliente);
    $cantidad     = mysqli_num_rows($queryEmpresa);

    $articulos_x_pagina = 5;

    //contar articulos de la bd
    $total_articulos_db = $cantidad; //la cantidad viene de 'mysqli_num_rows'
    $paginas = $total_articulos_db/5;
    $paginas = ceil($paginas); //redondear paginas
    echo "<script type='text/javascript'>
                console.log('Numero de pagina:'$paginas)';
            </script>"; 
    if(!$_GET){
        header("Location:empresas.php?paginas=1");
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
            


            <!-- Nav Item - Dashboard -->
            <li style="visibility:hidden" class="nav-item active">
                <a class="nav-link" href="empresas.php">
                    <i class="fas fa fa-desktop"></i>
                    <span>Empresas</span></a>
            </li>

    

            <!-- Sidebar Toggler (Sidebar) -->
            
            <div style="margin-top: 45rem;" class="text-center d-none d-md-inline">
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
                    </style>
                
                    
                    

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

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
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown" style="background-color:#5a5c69;">
                                
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
                            <img class="FotoAutor"src="../img/institucion.png">
                        </div>
                        <div>
                            <h2 style="font-size:47px; margin-top:2.5rem;" class="txtDichoAutor">Empresas</h2>
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
                                <button type="submit" name="enviar" class="btn btnBuscar" style="background-color:#3598D9; color:white; border:none;">Buscar</button>
                            </div>
                        </form>

                        <div class="reporte">
                            <a style="position:relative; right:15px;" href="../report/reporteEmpresa.php" class="btn btn-primary" role="button" target="_blank">Reporte  <i class="fas fa fa-print" aria-hidden="true"></i></a>
                        </div>
                        
                        <div class="anadir">
                            <button style="position:relative;left:53px;" type="button" class="btn btn-success añadir" data-toggle="modal" data-target="#exampleModal2" data-whatever="@mdo">Añadir Empresa</button>
                        </div>
                        
                        
                    </div>
                    
                    <!--MODAL PARA AÑADIR-->

                    <style>
                        .inputAgregar{
                            width:18rem;
                        }
                        /* Estilos para quitar las flechas del input de tipo number */
                        .no-arrow::-webkit-outer-spin-button,
                        .no-arrow::-webkit-inner-spin-button {
                            -webkit-appearance: none;
                            margin: 0;
                        }
                        .no-arrow {
                            -moz-appearance: textfield;
                        }
                        .valido2{
                            display:flex;
                            flex-direction:row;
                        }                                  

                    </style>

                    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div style="width:40rem; position:relative; right:2.5rem;" class="modal-content">
                            <div class="modal-header" style="background-color:#1cc88a">
                            <h5 class="modal-title" id="exampleModalLabel" style="color:#fff;">Añadir Empresa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <form class="row g-3 needs-validation" novalidate data-offset="70" id="formularioAdd" onsubmit="guardarEmpresa(event)" method="POST">
                                    <div style="margin-left:15px;" class="formValidos">
                                        <div class="valido1">
                                            <div class="form-group">
                                                <label for="validationCustom01" class="form-label">Empresa<span style="color:#e74a3b; font-size:13px;">*<span></label>
                                                <input style="width:600px;" type="text" class="form-control inputAgregar" id="nombre_empresa" name="nombre_empresa" required>
                                                <div class="invalid-feedback d-none">
                                                    Campo Obligatorio
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div style="gap:10px;" class="valido2">
                                            <div  class="form-group">
                                                <label for="recipient-name" class="form-label">Nit<span style="color:#e74a3b; font-size:13px;">*<span></label>
                                                <input type="number" class="form-control inputAgregar no-arrow" id="nit" name="nit" required maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                <div class="invalid-feedback d-none">
                                                    Campo Obligatorio
                                                </div>
                                            </div>

                                            <div style="margin-left:12px;" class="form-group">
                                                <label for="recipient-name" class="form-label">Sigla<span style="color:#e74a3b; font-size:13px;">*<span></label>
                                                <input type="text" class="form-control inputAgregar" id="sigla" name="sigla" required>
                                                <div class="invalid-feedback d-none">
                                                    Campo Obligatorio
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>  
                                        
                                    <div style="margin-left:15px;" class="form-group">
                                            <label for="recipient-name" class="form-label">Correo</label>
                                            <input style="width:600px;" type="email" class="form-control inputAgregar" id="correo" name="correo" >
                                            <div class="invalid-feedback d-none">
                                                Por favor, ingrese un correo electrónico válido.
                                            </div>
                                        </div>
                                        
                                        <div style="margin-left:15px;" class="form-group">
                                            <label for="validationCustom01" class="form-label">Dirección</label>
                                            <input style="width:600px;" type="text" class="form-control" id="direccion" name="direccion">
                                        </div>
                                        <div style="display:flex; flex-direction:row; margin-left:15px;gap:25px;" class="formSinValidacion">
                                            <div class="form-group">
                                                <label for="phone" class="form-label">Número de teléfono</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                    </div>
                                                    <input style="width:255px;" type="number" class="form-control no-arrow" id="telefono" name="telefono" pattern="[0-9\+\-]+">
                                                </div>    
                                            </div>

                                        <div style="margin-left:10px;" class="form-group">
                                            <label for="validationCustom04" class="form-label">Nivel</label>
                                                <select style="width:270px;" class="form-control" name="nivel" id="nivel" >
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                </select>
                                            </div>
                                        </div>

                                        <?php
                                        include('../../erpApi/conexion/bd_directa.php');

                                        // Consulta para obtener las monedas de la tabla 'monedas'
                                        $query = "SELECT id_moneda, nombre_moneda, abreviatura FROM monedas";
                                        $resultado = mysqli_query($conexion, $query);
                                        ?>
                                        <div style="margin-left:15px;" class="form-group">
                                            <label for="validationCustom04" class="form-label">Moneda Principal</label>
                                            <select style="width:295px;" class="form-control" name="id_moneda_principal" id="id_moneda_principal">
                                                
                                                <?php
                                                // Recorre los resultados y genera las opciones del elemento <select>
                                                while ($row = mysqli_fetch_assoc($resultado)) {
                                                    echo '<option value="' . $row['id_moneda'] . '">' . $row['nombre_moneda'] . ' ' . $row['abreviatura'];'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        
                                        
                                        
                                        <!--VALORES ORIGINALES E INTOCABLES-->
                                        <div style="display:none;" class="form-group">
                                            <label for="validationCustom01" class="form-label">Estado</label>
                                            <input style="width:600px;" type="number" class="form-control" id="estado" name="estado" value="1" readonly>
                                        </div>
                                        <!--VALORES Temporal-->
                                        <div style="display:none;" class="form-group">
                                            <label for="validationCustom01" class="form-label">Id_usuario_empresa</label>
                                            <input style="width:600px;" type="number" class="form-control" id="id_usuario_empresa" name="id_usuario_empresa" value="1" readonly>
                                        </div>                                   
            
                                        <div class="col-12">
                                            <hr>
                                            <div style="margin-left:27.9rem;" class="btnFinalForm">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                <button class="btn btn-success" type="submit">Guardar</button>
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
                        
                          if (isset($_GET['busqueda']))
                          {
                            $where="WHERE (empresas.nombre_empresa LIKE '%".$busqueda."%' OR nit LIKE '%".$busqueda."%') AND estado = 1";
                            //consulta
                            $sqlCliente   = ("SELECT * FROM empresas $where");
                            $queryEmpresa = mysqli_query($con, $sqlCliente);
                            $cantidad     = mysqli_num_rows($queryEmpresa);?>
                                    <style>
                                        .paginacion{
                                            display:none;
                                        }
                                        .btnVolver{
                                            width:72.5px;
                                            display: unset;
                                            text-decoration: none;
                                            
                                        }
                                        .mostrando{
                                            display:none;
                                        }
                                        
                                        .TxTVolver{
                                            width: 7.5px;
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
                                    header('Location:empresas.php?paginas=1');
                                }

                            }else{
                                $iniciar = ($_GET['paginas']-1) * $articulos_x_pagina;
                                //echo $iniciar;
                                //consulta
                                $sqlCliente   = ("SELECT * FROM empresas WHERE estado = 1 ORDER BY id_empresa DESC LIMIT $iniciar,5");
                                $queryEmpresa = mysqli_query($con, $sqlCliente);
                                $cantidad     = mysqli_num_rows($queryEmpresa);

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
                        <th style="background-color:#E34724;" scope="col">Ingresar</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Sigla</th>
                        <th scope="col">Nit</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Acción <i class="fas fa fa-edit" aria-hidden="true"></i></th>
                        </tr>

                        <?php
                            if ($queryEmpresa -> num_rows > 0){
                                while ($dataEmpresa = mysqli_fetch_array($queryEmpresa)) { 
                        ?>
                    </thead>
                    <tbody>
                        <tr>
                        <td style="width:8rem;">
                            <a style="display: block; background-color:#E34724; border-color:#E34724; color:#fff; width:50%; height:100%; margin-left:25px;" href="inicio.php?id=<?php echo $dataEmpresa['id_empresa'] ?>" class="btn btn-sm">
                                <i style="font-size: 16px;" class="fa fa-eye"></i>
                            </a>
                        </td>
                            <td style="width:18rem;"><?php echo $dataEmpresa['nombre_empresa']; ?></td>
                            <td style="width:10rem;"><?php echo $dataEmpresa['sigla']; ?></td>
                            <td style="width:10rem;"><?php echo $dataEmpresa['nit']; ?></td>
                            <td style="width:15rem;"><?php echo $dataEmpresa['telefono']; ?></td>
                            <td style="width:25rem;"><?php echo $dataEmpresa['correo']; ?></td>
                            <td style="width:15rem;">
                                
                                <button style="background-color:#e74a3b; border-color:#e74a3b" title="Eliminar"  type="button" class="btn btn-info" onclick="eliminarEmpresa(<?php echo $dataEmpresa['id_empresa']; ?>)">
                                    <i class="fas fa fa-trash" aria-hidden="true"></i>
                                </button>
                                
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#formEditar" data-whatever="@mdo" data-id="<?php echo $dataEmpresa['id_empresa']; ?>" data-empresa='<?php echo json_encode($dataEmpresa); ?>'>
                                    <i class="fas fa fa-edit" aria-hidden="true"></i>
                                </button>

                                <!--Ventana Modal para la Alerta de Editar--->
                                <div class="modal fade" id="formEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div style="width:40rem; position:relative; right:2.5rem;" class="modal-content">
                                    <div class="modal-header" style="background-color:#36b9cc">
                                    <h5 class="modal-title" id="exampleModalLabel" style="color:#fff;">Editar Empresa</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">    
                                        <form class="row g-3 needs-validation" novalidate data-offset="70" id="formularioEdit" method="POST" action="<?php ($_SERVER["PHP_SELF"]); ?>">
                                            <div style="margin-left:15px;" class="formValidos">
                                                <div class="valido1">
                                                    <div style="display:none;" class="form-group">
                                                        <label style="margin-right:33rem;" for="validationCustom01" class="form-label">id_empresa</label>
                                                        <input style="width:600px;" type="text" class="form-control" id="id_empresa_" name="id_empresa_" value="<?php echo $dataEmpresa['id_empresa'] ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="margin-right:35rem;" for="validationCustom01" class="form-label">Empresa<span style="color:#e74a3b; font-size:13px;">*<span></label>
                                                        <input style="width:600px;" type="text" class="form-control inputAgregar" id="nombre_empresa_" name="nombre_empresa_" required value="<?php echo $dataEmpresa['nombre_empresa'] ?>">
                                                        <div style="position: relative; right:16rem;" class="invalid-feedback d-none">
                                                            Campo Obligatorio
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div style="gap:10px;" class="valido2">
                                                    <div  class="form-group">
                                                        <label style="margin-right:17rem;" for="recipient-name" class="form-label">Nit<span style="color:#e74a3b; font-size:13px;">*<span></label>
                                                        <input type="number" class="form-control inputAgregar no-arrow" id="nit_" name="nit_" required maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?php echo $dataEmpresa['nit'] ?>">
                                                        <div style="position:relative;right:5.8rem;" class="invalid-feedback d-none">
                                                            Campo Obligatorio
                                                        </div>
                                                    </div>

                                                    <div style="margin-left:12px;" class="form-group">
                                                        <label style="margin-right:15rem;" for="recipient-name" class="form-label">Sigla<span style="color:#e74a3b; font-size:13px;">*<span></label>
                                                        <input type="text" class="form-control inputAgregar" id="sigla_" name="sigla_" required value="<?php echo $dataEmpresa['sigla'] ?>">
                                                        <div style="position:relative;right:5.8rem;" class="invalid-feedback d-none">
                                                            Campo Obligatorio
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>  
                                                
                                            <div style="margin-left:15px;" class="form-group">
                                                    <label style="margin-right:35rem;" for="recipient-name" class="form-label">Correo</label>
                                                    <input style="width:600px;" type="email" class="form-control inputAgregar" id="correo_" name="correo_" value="<?php echo $dataEmpresa['correo'] ?>" >
                                                    <div style="position:relative;right:10.5rem;" class="invalid-feedback d-none">
                                                        Por favor, ingrese un correo electrónico válido.
                                                    </div>
                                                </div>
                                                
                                                <div style="margin-left:15px;" class="form-group">
                                                    <label style="margin-right:33rem;" for="validationCustom01" class="form-label">Dirección</label>
                                                    <input style="width:600px;" type="text" class="form-control" id="direccion_" name="direccion_" value="<?php echo $dataEmpresa['direccion'] ?>">
                                                </div>
                                                <div style="display:flex; flex-direction:row; margin-left:15px;gap:25px;" class="formSinValidacion">
                                                    <div class="form-group">
                                                        <label style="margin-right:10rem;" for="phone" class="form-label">Número de teléfono</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                            </div>
                                                            <input style="width:255px;" type="number" class="form-control no-arrow" id="telefono_" name="telefono_" pattern="[0-9\+\-]+" value="<?php echo $dataEmpresa['telefono'] ?>">
                                                        </div>    
                                                    </div>

                                                    <div style="margin-left:10px;" class="form-group">
                                                    <label style="margin-right:15rem;" for="validationCustom01" class="form-label">Nivel</label>
                                                        <select style="width:270px;" class="form-control" name="nivel_" id="nivel_" disabled >
                                                            <option value="3" <?php if ($dataEmpresa['nivel'] == 3) echo 'selected'; ?>>3</option>
                                                            <option value="4" <?php if ($dataEmpresa['nivel'] == 4) echo 'selected'; ?>>4</option>
                                                            <option value="5" <?php if ($dataEmpresa['nivel'] == 5) echo 'selected'; ?>>5</option>
                                                            <option value="6" <?php if ($dataEmpresa['nivel'] == 6) echo 'selected'; ?>>6</option>
                                                            <option value="7" <?php if ($dataEmpresa['nivel'] == 7) echo 'selected'; ?>>7</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <?php
                                                include('../../erpApi/conexion/bd_directa.php');

                                                // Consulta para obtener la moneda principal de la empresa
                                                $sqlEmpresaMoneda = "SELECT id_moneda_principal FROM empresa_monedas WHERE id_empresa_m = " . $dataEmpresa['id_empresa'];
                                                $queryEmpresaMoneda = mysqli_query($conexion, $sqlEmpresaMoneda);
                                                $dataEmpresaMoneda = mysqli_fetch_assoc($queryEmpresaMoneda);

                                                // Consulta para obtener las opciones del select de moneda principal
                                                $sqlMonedas = "SELECT id_moneda, nombre_moneda, abreviatura FROM monedas";
                                                $queryMonedas = mysqli_query($conexion, $sqlMonedas);
                                                ?>

                                                <div style="margin-left:15px;" class="form-group">
                                                    <label style="margin-right:15rem;" for="validationCustom04" class="form-label">Moneda Principal</label>
                                                    <select style="width:295px;" class="form-control" name="id_moneda_principal" id="id_moneda_principal" disabled>
                                                        <?php
                                                        // Recorre los resultados y genera las opciones del elemento <select>
                                                        while ($rowMonedas = mysqli_fetch_assoc($queryMonedas)) {
                                                            // Comprueba si el 'id_moneda' coincide con el 'id_moneda_principal' de la empresa
                                                            $selectedMonedas = ($dataEmpresaMoneda['id_moneda_principal'] == $rowMonedas['id_moneda']) ? 'selected' : '';
                                                            echo '<option value="' . $rowMonedas['id_moneda'] . '" ' . $selectedMonedas . '>' . $rowMonedas['nombre_moneda'] . ' ' . $rowMonedas['abreviatura'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                    
                                                <!--VALORES ORIGINALES E INTOCABLES-->
                                                <div style="display:none;" class="form-group">
                                                    <label for="validationCustom01" class="form-label">Estado</label>
                                                    <input style="width:600px;" type="number" class="form-control" id="estado_" name="estado_" value="1" readonly>
                                                </div>
                                                <!--VALORES Temporal-->
                                                <div style="display:none;" class="form-group">
                                                    <label for="validationCustom01" class="form-label">Id_usuario_empresa</label>
                                                    <input style="width:600px;" type="number" class="form-control" id="id_usuario_empresa_" name="id_usuario_empresa_" value="1" readonly>
                                                </div>                                   
                    
                                                <div class="col-12">
                                                    <hr>
                                                    <div style="margin-left:27.9rem;" class="btnFinalForm">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        <button class="btn btn-info" type="submit">Guardar</button>
                                                    </div>
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
                                <li class="page-item <?php echo $_GET['paginas']<=1? 'disabled':''?>">
                                    <a class="page-link" href="empresas.php?paginas=<?php echo $_GET['paginas']-1 ?>">
                                        Anterior
                                    </a>
                                </li>
                                
                                
                                <li  class="page-item <?php echo $_GET['paginas']==$i+1 ? 'active' : '' ?>">
                                    <a style="background-color:#5a5c69; color:white;" class="page-link" href="empresas.php?paginas=<?php echo $i+1 ; ?>">
                                        <?php echo $_GET['paginas'] ; ?>
                                    </a>
                                </li>
                                

                                <li class="page-item <?php echo $_GET['paginas']>=$paginas? 'disabled':''?>" >
                                <a class="page-link" href="empresas.php?paginas=<?php echo $_GET['paginas']+1 ?>" style="position: relative; left: 0;">
                                    Siguiente
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    
                    
                    
                    <ul class="pagination">
                        <a style="background-color:#5a5c69;border:none;" class="btn btn-secondary btnVolver" href="empresas.php?paginas=1">
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
                <div style="background-color:#E34724; color:#ffff;" class="modal-header">
                    <h5  class="modal-title" id="exampleModalLabel">Administrador</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div style="font-size:25px;" class="modal-body">Desea cerrar sesión?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a style="background-color:#E34724; border:none; width:100px;" class="btn btn-primary" href="../index.php">Sí, Cerrar</a>
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
        var empresa = button.data('empresa'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find('.modal-title').text('Editar Empresa ');
        modal.find('#id_empresa_').val(empresa.id_empresa);
        modal.find('#nombre_empresa_').val(empresa.nombre_empresa);
        modal.find('#nit_').val(empresa.nit);
        modal.find('#sigla_').val(empresa.sigla);
        modal.find('#telefono_').val(empresa.telefono);
        modal.find('#correo_').val(empresa.correo);
        modal.find('#direccion_').val(empresa.direccion);
        modal.find('#nivel_').val(empresa.nivel);
        modal.find('#estado_').val(empresa.estado);
        modal.find('#id_usuario_empresa_').val(empresa.id_usuario_empresa);
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
    <!--Validaciones formulario-->
    <script src="../js/validarFormulario.js"></script>
    <!--Toaster-->
    <script src="../js/toastr.min.js"></script>
    
    
    

    
</body>

</html>