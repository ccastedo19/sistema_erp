<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Reporting Service</title>
    <link rel="icon" href="../img/nivelesIcon.ico">
    <link href="../css/reportes.css" rel="stylesheet" type="text/css">
    <link href="style/EstiloComprobante.css" rel="stylesheet" type="text/css">
</head>
<?php
//llegada de datos para editar para la tabla comprobantes
include_once '../../erpApi/conexion/bd_directa.php';
$id_comprobante = $_GET['idComprobante'];
$id_empresa = $_GET['id_empresa'];
$qry = "SELECT * FROM comprobantes WHERE id_empresa_comprobante = $id_empresa AND id_comprobante = $id_comprobante";
$run = $conexion ->query($qry);
$num_rows = 0;
if($run -> num_rows > 0 ){
    while($row = $run -> fetch_assoc()){
        $serie = $row['serie'];
        $glosa_principal = $row['glosa_principal'];
        $fecha_comprobante = $row['fecha_comprobante'];
        $tc = $row['tc'];
        $estado_comprobante = $row['estado'];
        $tipo_comprobante = $row['tipo_comprobante'];
        $id_moneda = $row['id_moneda'];
    }
}
date_default_timezone_set('America/La_Paz');
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
            <span class="Nombre_Reporte">reporteComprobante</span> <!--Este el nombre del reporte puede ser cambiado-->
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
        <?php
            include_once '../../erpApi/conexion/bd_directa.php';
            // Consultar datos de la tabla comprobante
            $id_comprobante = $_GET['idComprobante'];
            $qry = "SELECT * FROM comprobantes WHERE id_comprobante = $id_comprobante";
            $run = $conexion ->query($qry);
            if($run -> num_rows > 0){
                while($row = $run -> fetch_assoc()){
                    $serie = $row['serie'];
                    $glosa_principal = $row['glosa_principal'];
                    $fecha_comprobante = $row['fecha_comprobante'];
                    $tc = $row['tc'];
                    $estado = $row['estado'];
                    $tipo_comprobante = $row['tipo_comprobante'];
                    $id_moneda_comprobante = $row['id_moneda'];
                    $id_empresa_comprobante = $row['id_empresa_comprobante'];
                }
            }
            //Consultar tabla moneda
            $qry2 = "SELECT nombre_moneda FROM monedas Where id_moneda = $id_moneda_comprobante";
            $run = $conexion ->query($qry2);
            if($run -> num_rows > 0){
                while($row = $run -> fetch_assoc()){
                    $nombre_moneda = $row['nombre_moneda'];
                }
            }
            //Consultar Empresa
            $qry3 = "SELECT nombre_empresa FROM empresas Where id_empresa = $id_empresa_comprobante";
            $run = $conexion ->query($qry3);
            if($run -> num_rows > 0){
                while($row = $run -> fetch_assoc()){
                    $nombre_empresa = $row['nombre_empresa'];
                  
                }
            }

            $fecha_actual = date('d/m/Y');
            $fechaOriginal = DateTime::createFromFormat('Y-m-d', $fecha_comprobante);
            $fecha_Formateada = $fechaOriginal->format('d/m/Y');
        ?>
         <?php
            // Obtener información de la moneda principal y alternativa
            $sqlMoneda = "SELECT empresa_monedas.id_moneda_principal, empresa_monedas.id_moneda_alternativa FROM empresa_monedas INNER JOIN comprobantes ON comprobantes.id_empresa_comprobante = empresa_monedas.id_empresa_m WHERE comprobantes.id_comprobante = $id_comprobante AND empresa_monedas.activo = 1";
            $queryMoneda = mysqli_query($conexion, $sqlMoneda);
            $infoMoneda = mysqli_fetch_assoc($queryMoneda);

            // Verificar si se utiliza moneda principal o alternativa
            $usarMonedaPrincipal = $id_moneda == $infoMoneda['id_moneda_principal'];

            // Consulta para obtener detalles del comprobante
            $result = mysqli_query($conexion, "SELECT detalle_comprobantes.*, cuentas.nombre_cuenta, cuentas.codigo FROM detalle_comprobantes INNER JOIN cuentas ON detalle_comprobantes.id_cuenta = cuentas.id_cuenta WHERE detalle_comprobantes.id_comprobante = $id_comprobante");
        ?>

        <div class="contenedor">
            <div class="row">
                <div class="col-md-4">
                    <!--Reporte-->
                    <div class="Titulo">
                        <h2 style="color:#7DA5D4;font-size:25px;text-align:center;font-family:Arial, Helvetica, sans-serif;"><strong>Reporte Comprobante Contable</strong></h2>
                        <h1 style="font-size:20px;text-align:center;font-family:Arial, Helvetica, sans-serif;">Empresa: <?php echo $nombre_empresa ?> </h2>
                    </div>
                    <div class="Contenido">
                        <div class="subContenido primero">
                            <h3 class="h2-juntos">Serie:<?php echo $serie;?> </h3>
                            <h3 class="h2-juntos">Moneda:<?php echo $nombre_moneda; ?></h3>
                            <h3 class="h2-juntos">Cambio:<?php echo $tc ?></h3>
                            <h3 class="h2-juntos">Estado del comprobante:<?php
                            if($estado == 1){
                                echo "Abierto";
                            }else{
                                echo "Cerrado";
                            } 
                            ?></h2>
                        </div>
                        <div class="subContenido segundo">
                            <h3 class="h2-juntos">Fecha de reporte:<?php echo $fecha_actual; ?></h3>
                            <h3 class="h2-juntos">Fecha del periodo:<?php echo $fecha_Formateada; ?></h3>
                            <h3 class="h2-juntos">Tipo de Comprobante:<?php echo $tipo_comprobante; ?></h3>
                        </div>
                    </div>

                    </br></br>
                    <table cellpadding="5" width="100%">
                        <tbody style="position:relative;bottom:50px;">
                            <tr>
                                <th>Cuenta</th>
                                <th>Glosa</th>
                                <th>Debe</th>
                                <th>Haber</th>
                            </tr>
                            <?php
                                $total_debe = 0;
                                $total_haber = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $monto_debe = $usarMonedaPrincipal ? $row['monto_debe'] : $row['monto_debe_alt'];
                                    $monto_haber = $usarMonedaPrincipal ? $row['monto_haber'] : $row['monto_haber_alt'];

                                    $total_debe += $monto_debe;
                                    $total_haber += $monto_haber;
                                ?>
                                <tr>
                                    <td><?php echo $row['codigo'].' '.$row['nombre_cuenta'] ?></td>
                                    <td><?php echo $row['glosa_secundaria']?></td>
                                    <td style="text-align:right;"><?php echo $monto_debe; ?></td>
                                    <td style="text-align:right;"><?php echo $monto_haber; ?></td>
                                </tr>
                                <?php
                                }
                            ?>
                            <!-- Mostrar las sumas totales -->
                            <tr>
                                <td colspan="2" style="text-align:right;"><strong>Total:</strong></td>
                                <td style="text-align:right;"><strong><?php echo $total_debe; ?></strong></td>
                                <td style="text-align:right;"><strong><?php echo $total_haber; ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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