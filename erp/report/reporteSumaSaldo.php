<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL REPORTING SERVICE</title>
    <link rel="icon" href="../img/nivelesIcon.ico">
    <link href="../css/reportes.css" rel="stylesheet" type="text/css">
    <link href="style/EstiloSumaSaldo.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php
//Conexion 
include_once '../../erpApi/conexion/bd_directa.php';

//llegada de datos
$id_gestion = $_POST['Selectgestion'];
$id_empresa = $_GET['id_empresa'];
$id_monedaForm = $_POST['id_moneda'];

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
$qry = "SELECT nombre_moneda FROM monedas WHERE id_moneda = $id_monedaForm";
$run = $conexion -> query($qry);
if($run -> num_rows > 0 ){
    while($row = $run -> fetch_assoc()){
        $nombre_moneda=$row['nombre_moneda'];
    }
}
?>


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
            <span class="Nombre_Reporte">reporteSumaSaldo</span> <!--Este el nombre del reporte puede ser cambiado-->
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
                    <input style="width: 3rem;border: 1px solid #b7b3b0; " class="Npagina" value="1" readonly >
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
                        <a href="#">Word</a>
                        <a href="#">Excel</a>
                        <a href="#">PowerPoint</a>
                        <a href="sumaSaldo/pdf_sumaSaldo.php?id_empresa=<?php echo $id_empresa; ?>&id_gestion=<?php echo $id_gestion; ?>&id_moneda=<?php echo $id_monedaForm; ?>" target="_blank">PDF</a>
                        <a href="#">Archivo TIFF</a>
                        <a href="#">MHTML (archivo web)</a>
                        <a href="#">CSV (delimitado por comp...)</a>
                        <a href="#">Fuente de datos</a>
                    </div>
                </div>
            
                <div class="impresora">
                    <hr class="vertical-line">
                    <a onclick="showPdfPreview('sumaSaldo/pdf_preview_sumaSaldo.php?id_empresa=<?php echo $id_empresa; ?>&id_gestion=<?php echo $id_gestion; ?>&id_moneda=<?php echo $id_monedaForm; ?>')"><img class="imprimir" src="../img/impresora.png"></a>
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

    <?php $fecha_actual = date('d/m/Y'); ?>
    <article>

    <div class="Contenido">
        <div class="Titulo">
            <div class="ParteArriba">
                <h2 style="color:#7DA5D4;font-size:27px;font-family:Arial, Helvetica, sans-serif;">Reporte de Sumas y Saldos</h2>
            </div>  
            <div class="ParteAbajo">
                <span class="txtTitle">Empresa: <?php echo $nombre_empresa; ?></span>
                <span class="txtTitle">Gestión: <?php echo $nombre_gestion; ?></span>
                <span class="txtTitle">Moneda: <?php echo $nombre_moneda; ?></span>
            </div>
            <div class="ParteAbajoDerecha">
                <span style="font-size:17px;">Fecha:<?php echo $fecha_actual ?></span> <!--el tamaño de la fecha solo ponerala aca(por pdf se ve bien)-->
                </span>Usuario: Administrador</span>
            </div>
        </div>
        <?php
            // Conectar a la base de datos
            $conn = new mysqli("localhost", "root", "", "erp");

            // Obtener información de la gestión
            $sql_gestion = "SELECT fecha_inicio, fecha_fin FROM gestiones WHERE id_gestion = $id_gestion";
            $result_gestion = $conn->query($sql_gestion);
            $gestion = $result_gestion->fetch_assoc();

            // Obtener comprobantes de la empresa y gestión seleccionadas
            $sql = "SELECT dc.id_cuenta, cu.codigo, cu.nombre_cuenta, dc.monto_debe, dc.monto_haber, dc.monto_debe_alt, dc.monto_haber_alt, em.id_moneda_principal
            FROM comprobantes c
            JOIN detalle_comprobantes dc ON c.id_comprobante = dc.id_comprobante
            JOIN cuentas cu ON dc.id_cuenta = cu.id_cuenta
            JOIN empresa_monedas em ON c.id_empresa_comprobante = em.id_empresa_m
            WHERE c.id_empresa_comprobante = $id_empresa
            AND c.fecha_comprobante BETWEEN '{$gestion['fecha_inicio']}' AND '{$gestion['fecha_fin']}'
            AND cu.id_empresa_cuenta = $id_empresa
            AND em.activo = 1
            ORDER BY cu.codigo";

    
            $result = $conn->query($sql);

            // Calcular las sumas de debe y haber para cada cuenta
            $sumas = [];
            $total_debe = 0;
            $total_haber = 0;

            while ($row = $result->fetch_assoc()) {
                $codigo_nombre_cuenta = $row['codigo'] . ' ' . $row['nombre_cuenta'];

                if (!isset($sumas[$codigo_nombre_cuenta])) {
                    $sumas[$codigo_nombre_cuenta] = ['debe' => 0, 'haber' => 0];
                }

                if ($id_monedaForm == $row['id_moneda_principal']) {
                    $monto_debe = $row['monto_debe'];
                    $monto_haber = $row['monto_haber'];
                } else {
                    $monto_debe = $row['monto_debe_alt'];
                    $monto_haber = $row['monto_haber_alt'];
                }

                $sumas[$codigo_nombre_cuenta]['debe'] += $monto_debe;
                $sumas[$codigo_nombre_cuenta]['haber'] += $monto_haber;

                $total_debe += $monto_debe;
                $total_haber += $monto_haber;

            }

            // Mostrar el resultado en una tabla
            echo "<table>";
            echo "<tr>";
            echo "<th rowspan='2'>Cuentas</th>";
            echo "<th colspan='2'>Sumas</th>";
            echo "<th colspan='2'>Saldos</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<th>Debe</th>";
            echo "<th>Haber</th>";
            echo "<th>Debe</th>";
            echo "<th>Haber</th>";
            echo "</tr>";

            $total_debeOp = 0;
            $total_haberOp = 0;

            foreach ($sumas as $codigo_nombre_cuenta => $suma) {
                $operacion = $suma['debe'] - $suma['haber'];

                if ($operacion > 0) {
                    $debeOp = $operacion;
                    $haberOp = 0;
                } else {
                    $debeOp = 0;
                    $haberOp = abs($operacion);
                }

                echo "<tr>";
                echo "<td>{$codigo_nombre_cuenta}</td>";
                echo "<td style='text-align:right;'>{$suma['debe']}</td>";
                echo "<td style='text-align:right;'>{$suma['haber']}</td>";
                echo "<td style='text-align:right;'>{$debeOp}</td>";
                echo "<td style='text-align:right;'>{$haberOp}</td>";
                echo "</tr>";

                // Agregar estas líneas dentro del bucle foreach, después de imprimir las filas de la tabla
                $total_debeOp += $debeOp;
                $total_haberOp += $haberOp;
            }

            echo "<tr>";
            echo "<td style='text-align:right;font-weight:bold;' >Total</td>";
            echo "<td style='text-align:right;'>{$total_debe}</td>";
            echo "<td style='text-align:right;'>{$total_haber}</td>";
            echo "<td style='text-align:right;'>{$total_debeOp}</td>";
            echo "<td style='text-align:right;'>{$total_haberOp}</td>";
            echo "</tr>";
            echo "</table>";


        ?>
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