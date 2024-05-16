<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Reporting Service</title>
    <link rel="icon" href="../img/nivelesIcon.ico">
    <link href="../css/reportes.css" rel="stylesheet" type="text/css">
    <link href="style/EstiloEstadoResultado.css" rel="stylesheet" type="text/css">
</head>
<?php
//Conexion 
include_once '../../erpApi/conexion/bd_directa.php';

//llegada de datos
$id_gestion = $_POST['Selectgestion'];
$id_empresa = $_GET['id_empresa'];
$id_moneda = $_POST['id_moneda'];

//sacar el nombre de la empresa
$qry = "SELECT nombre_empresa FROM empresas WHERE id_empresa = $id_empresa";
    $run = $conexion -> query($qry);
    if($run -> num_rows > 0 ){
        while($row = $run -> fetch_assoc()){
            $nombre_empresa=$row['nombre_empresa'];
        }
    } 
//sacar el nombre de la gestion
$qry = "SELECT nombre_gestion FROM gestiones WHERE id_empresa_gestion = $id_empresa";
    $run = $conexion -> query($qry);
    if($run -> num_rows > 0 ){
        while($row = $run -> fetch_assoc()){
            $nombre_gestion=$row['nombre_gestion'];
        }
    }

//sacar el nombre de la moneda
$qry = "SELECT nombre_moneda FROM monedas WHERE id_moneda = $id_moneda";
$run = $conexion -> query($qry);
if($run -> num_rows > 0 ){
    while($row = $run -> fetch_assoc()){
        $nombre_moneda=$row['nombre_moneda'];
    }
}

date_default_timezone_set('America/La_Paz');

$fecha_actual = date('d/m/Y');
?>
<body>
    <nav>
        <div class="tituloNav"> 
        <div class="tituloPrincipal ">
                <img class="logoNav" src="../img/reportService.PNG">
                <img class="textoNav" src="../img/tituloReporting.png">
            </div>
            <div class="tituloSecundario">
                <hr class="Tiv">
                <div>
                    <img class="ajuste" src="../img/configuraciones.png">
                </div>
                <hr class="Tiv">
                <div>
                    <img class="descarga" src="../img/descargarIcon.png">
                </div>
                <hr class="Tiv">
                <div>
                    <img class="signo" src="../img/signoInterrogacion.png">
                </div>
                <hr class="Tiv">
                <div>
                    <span class="nombre">Cesar</span>
                </div>
                
            </div>
        </div>
        <div class="subtituloNav">
            <div class="PrimeraParte">
                <div class="ParteFavoritos">
                    <img class="estrella" src="../img/estrella.png">
                    <span class="favorito">Favoritos</span>
                </div>
                <div class="ParteExaminar">
                    <img class="cuaderno" src="../img/cuaderno.png">
                    <span class="examinar">Examinar</span>
                </div>
            </div>
            <div class="SegundoParte">
                <div class="Partecomentario">
                    <img class="globo" src="../img/comentario.png">
                    <span class="comentario">Comentarios</span>
                </div>
            </div>
        </div>
        <div class="tertituloNav">
            <span class="inicioText">Inicio</span>
            <img class="flecha_gris"src="../img/flecha_derecha_gris.png">
            <span class="EmpresaErp">report</span>
            <img class="flecha_gris"src="../img/flecha_derecha_gris.png">
            <span class="Nombre_Reporte">reporteEstadoResultado</span> <!--Este el nombre del reporte puede ser cambiado-->
        </div>
        <div class="contenido-funciones">
            <div class="funcionesPrincipales">
                <div class="flechaRetroceder">
                    <img class="flecha_Retroceder" src="../img/reportes_flecha_izquierda.png">
                </div>
                <div class="flechaIzquierda">
                    <img class="flecha_Izquierda" src="../img/flecha_izquierda.png">
                </div>
                <div class="Cantidadpaginas">
                    <input style="width: 3rem;border: 1px solid #b7b3b0;" class="Npagina" value="1" readonly >
                    <span style="padding-left: 5px;">de <span style="padding-left: 3.5px;">1</span></span>
                </div>
                <div class="flechaDerecha">
                    <img class="flecha_Derecha" src="../img/flecha_derecha.png">
                </div>
                <div class="flechaAdelantar">
                    <img class="flecha_Adelantar" src="../img/reportes_flecha_derecha.png">
                </div>
            </div>
            <div class="skill actualizar" style="display: flex;flex-direction: row;">
                <hr style="margin-left: 20px;" class="vertical-line">
                <div style="margin-left:5px;" class="tootlip">
                    <img style="position: relative;right: 4px;" class="flecha_Actualizar" src="../img/flecha_actualizar.png">
                    <h3 style="margin-top:5.5rem;visibility:hidden;">Actualizar</h3>
                </div>
                <hr style="margin-left:5px;" class="vertical-line">
            </div>
            <div class="retroceso">
                <img class="retro" src="../img/flecha_avanzada.png">
            </div>
            <div style="display: flex;flex-direction: row;" class="zoom">
                <hr style="margin-left: 20px;" class="vertical-line">
                <select style="width: 9rem;border: 1px solid #b7b3b0; height: 20px;position: relative;left:10px;top:20px;" name="refZoom" id="refZoom">
                    <option>Ancho de la página</option>
                    <option>Toda la página</option>
                    <option>500%</option>
                    <option>200%</option>
                    <option>150%</option>
                    <option selected>100%</option>
                    <option>75%</option>
                    <option>50%</option>
                    <option>25%</option>
                    <option>10%</option>
                </select>
                <hr style="margin-left: 20px;" class="vertical-line">
            </div>

            <div class="container">
                <div class="guardado" onclick="toggleDropdown(event)">
                    <img class="guardadoSelect" src="../img/guardar_caset.png" alt="Guardar">
                    <img class="flechaAbajo" src="../img/flecha_abajo.png">
                    <div id="dropdown" class="dropdown-content">
                        <a href="comprobantes/word_comprobante.php?idComprobante=<?php echo $id_comprobante?>" target="_blank">Word</a>
                        <a href="comprobantes/excel_comprobante.php?idComprobante=<?php echo $id_comprobante?>" target="_blank">Excel</a>
                        <a href="comprobantes/powerPoint_comprobante.php?idComprobante=<?php echo $id_comprobante?>" target="_blank">PowerPoint</a>
                        <a href="comprobantes/pdf_comprobante.php?idComprobante=<?php echo $id_comprobante?>" target="_blank">PDF</a>
                        <a href="#">Archivo TIFF</a>
                        <a href="#">MHTML (archivo web)</a>
                        <a href="comprobantes/excel_comprobante.php?idComprobante=<?php echo $id_comprobante?>" target="_blank">CSV (delimitado por comp...)</a>
                        <a href="#">Fuente de datos</a>
                    </div>
                </div>
            
                <div class="impresora">
                    <hr class="vertical-line">
                    <a onclick="showPdfPreview('comprobantes/pdf_preview_comprobante.php?idComprobante=<?php echo $id_comprobante;?>')"><img class="imprimir" src="../img/impresora.png"></a>

                    <hr class="vertical-line">
                </div>

                <div id="pdfModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:100;">
                    <iframe id="pdfPreview" style="position:relative; top:10%; left:10%; width:80%; height:80%; border:1px solid #ccc;"></iframe>
                </div>

                <div class="busqueda">
                    <input style="width: 6.8rem; border: 1px solid #b7b3b0;position: relative;padding-left: 3.5px;"class="InputBuscar">
                    <span style="color:#b7b3b0;cursor: pointer;" class="Buscar">Buscar</span>
                    <span style="color:#b7b3b0;" class="separetor">|</span>
                    <span style="color:#b7b3b0;cursor: pointer;" class="next">Siguiente</span>
                </div>

            </div>
            
            
        </div>

    </nav>

    <!--solo realizar cambios en esta parte-->
    <article>
        <div class="contenedor">
            <div class="ParteArriba">
                <div class= "Titulo">
                    <h1>Reporte de Estado de Resultados </h1>
                    <h2>Empresa:<?php echo $nombre_empresa ?></h2>
                    <h2>Gestion:<?php echo $nombre_gestion ?></h2>
                    <h2>Moneda:<?php echo $nombre_moneda ?></h2>
                </div>
                <div class="ParteDerecha">
                    <h3 style="position:relative;top:10px;">Fecha:<?php echo $fecha_actual; ?><h3>
                    <h3>Usuario:Administrador<h3>
                </div>
            </div>
            <div class="ParteAbajo">
                <?php
                    // Obtiene la moneda que se usará
                    $query = "SELECT id_moneda_principal, id_moneda_alternativa FROM empresa_monedas WHERE id_empresa_m = '$id_empresa' AND activo = 1";
                    $resultado = mysqli_query($conexion, $query);
                    $moneda = mysqli_fetch_assoc($resultado);

                    $moneda_usada = $moneda['id_moneda_principal'] == $id_moneda ? "principal" : "alternativa";

                    // Obtiene los detalles de la gestión
                    $query = "SELECT fecha_inicio, fecha_fin FROM gestiones WHERE id_gestion = '$id_gestion' AND estado_gestion = 1";
                    $resultado = mysqli_query($conexion, $query);
                    $gestion = mysqli_fetch_assoc($resultado);

                    // Obtiene la lista de cuentas
                    $query = "SELECT id_cuenta, nombre_cuenta FROM cuentas WHERE id_empresa_cuenta = '$id_empresa' AND (nombre_cuenta = 'Ingresos' OR nombre_cuenta = 'Costos' OR nombre_cuenta = 'Gastos')";
                    $resultado = mysqli_query($conexion, $query);
                    $cuentas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

                    foreach($cuentas as $cuenta) {
                        // Calcula el total del Debe y el Haber
                        $query = "SELECT SUM(monto_debe) AS total_debe, SUM(monto_haber) AS total_haber FROM detalle_comprobantes 
                            JOIN comprobantes ON detalle_comprobantes.id_comprobante = comprobantes.id_comprobante 
                            WHERE detalle_comprobantes.id_cuenta = '{$cuenta['id_cuenta']}' 
                            AND comprobantes.fecha_comprobante BETWEEN '{$gestion['fecha_inicio']}' AND '{$gestion['fecha_fin']}' 
                            AND comprobantes.estado = 1";
                    
                        $resultado = mysqli_query($conexion, $query);
                        $total = mysqli_fetch_assoc($resultado);
                    
                        // Dependiendo del tipo de cuenta se calcula el total de diferentes maneras
                        if($cuenta['nombre_cuenta'] == 'Ingresos') {
                            $total_cuenta = $total['total_haber'] - $total['total_debe'];
                        } else { // Costos y Gastos
                            $total_cuenta = $total['total_debe'] - $total['total_haber'];
                        }
                    
                        echo "Total {$cuenta['nombre_cuenta']}: $total_cuenta";
                    }
                    

                                        
                ?>
                
            </div>

        </div>

        
    </article>

    <!--funcion del menu guardar y mostrar impresion-->
    <script src="../js/imprimir.js"></script>
    <script src="../js/reporte.js"></script>
    <!--para la impresion-->
    <script src="pdfjs/build/pdf.js"></script>
    <script src="pdfjs/web/viewer.js"></script>
    
</body>
</html>