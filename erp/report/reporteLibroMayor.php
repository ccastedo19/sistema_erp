<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL REPORTING SERVICE</title>
    <link rel="icon" href="../img/nivelesIcon.ico">
    <link href="../css/reportes.css" rel="stylesheet" type="text/css">
    <link href="style/EstiloLibroMayor.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php
//Conexion 
include_once '../../erpApi/conexion/bd_directa.php';

//llegada de datos
$id_gestion = $_POST['Selectgestion'];
$id_periodo = $_POST['Selectperiodo'];
$id_moneda = $_POST['id_moneda'];
$id_empresa = $_GET['id_empresa'];

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
//sacar el nombre deL periodo
if($id_periodo == 0){
    $nombre_periodo = 'Todos';
}else{
    $qry = "SELECT nombre_periodo FROM periodos WHERE id_periodo = $id_periodo";
    $run = $conexion -> query($qry);
    if($run -> num_rows > 0 ){
        while($row = $run -> fetch_assoc()){
            $nombre_periodo=$row['nombre_periodo'];
        }
    }
}

date_default_timezone_set('America/La_Paz');
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
            <span class="Nombre_Reporte">reporteLibroMayor</span> <!--Este el nombre del reporte puede ser cambiado-->
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
                        <a href="libroMayor/excel_libroMayor.php?id_empresa=<?php echo $id_empresa; ?>&id_gestion=<?php echo $id_gestion; ?>&id_periodo=<?php echo $id_periodo; ?>&id_moneda=<?php echo $id_moneda; ?>" target="_blank" >Excel</a>
                        <a href="#">PowerPoint</a>
                        <a href="libroMayor/pdf_libroMayor.php?id_empresa=<?php echo $id_empresa; ?>&id_gestion=<?php echo $id_gestion; ?>&id_periodo=<?php echo $id_periodo; ?>&id_moneda=<?php echo $id_moneda; ?>" target="_blank">PDF</a>
                        <a href="#">Archivo TIFF</a>
                        <a href="#">MHTML (archivo web)</a>
                        <a href="#">CSV (delimitado por comp...)</a>
                        <a href="#">Fuente de datos</a>
                    </div>
                </div>
            
                <div class="impresora">
                    <hr class="vertical-line">
                    <a onclick="showPdfPreview('libroMayor/pdf_preview_libroMayor.php?id_empresa=<?php echo $id_empresa; ?>&id_gestion=<?php echo $id_gestion; ?>&id_periodo=<?php echo $id_periodo; ?>&id_moneda=<?php echo $id_moneda; ?>')"><img class="imprimir" src="../img/impresora.png"></a>
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

    <div class="Contenedor">
        <div class="Titulo" style="margin-bottom:15px;">
            <div class="ParteArriba">
                <h2 style="color:#7DA5D4;font-size:27px;font-family:Arial, Helvetica, sans-serif;">Reporte Libro Mayor</h2>
            </div>  
            <div class="ParteAbajo">
                <span class="txtTitle">Empresa: <?php echo $nombre_empresa; ?></span>
                <span class="txtTitle">Gestión: <?php echo $nombre_gestion; ?></span>
                <span class="txtTitle">Periodo: <?php echo $nombre_periodo; ?></span>
                <span class="txtTitle">Moneda: <?php echo $nombre_moneda; ?></span>
            </div>
            <div class="ParteAbajoDerecha">
                <span style="font-size:17px;">Fecha:<?php echo $fecha_actual ?></span> <!--el tamaño de la fecha solo ponerala aca(por pdf se ve bien)-->
                </span>Usuario: Administrador</span>
            </div>
        </div>
        <?php
        // Conexión a la base de datos    
        $conn = new mysqli('localhost', 'root', '', 'erp');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Consulta para obtener la moneda principal o alternativa
        $sql_moneda = "SELECT id_moneda_principal, id_moneda_alternativa FROM empresa_monedas WHERE activo = 1 AND id_empresa_m = $id_empresa";
        $result_moneda = $conn->query($sql_moneda);
        $row_moneda = $result_moneda->fetch_assoc();
        $moneda_principal = $row_moneda['id_moneda_principal'];
        $moneda_alternativa = $row_moneda['id_moneda_alternativa'];

        // Obtener rango de fechas de la gestión y el período
        $sql_fecha_rango = "SELECT g.fecha_inicio AS gestion_inicio, g.fecha_fin AS gestion_fin, p.fecha_inicio_periodo AS periodo_inicio, p.fecha_fin_periodo AS periodo_fin
        FROM gestiones g
        INNER JOIN periodos p ON p.id_gestion_periodo = g.id_gestion
        WHERE g.id_gestion = $id_gestion AND (p.id_periodo = $id_periodo OR $id_periodo = 0)";
        $result_fecha_rango = $conn->query($sql_fecha_rango);
        $row_fecha_rango = $result_fecha_rango->fetch_assoc();

        $gestion_inicio = $row_fecha_rango['gestion_inicio'];
        $gestion_fin = $row_fecha_rango['gestion_fin'];
        $periodo_inicio = $id_periodo == 0 ? $gestion_inicio : $row_fecha_rango['periodo_inicio'];
        $periodo_fin = $id_periodo == 0 ? $gestion_fin : $row_fecha_rango['periodo_fin'];

        // Consulta para obtener todas las transacciones para todas las cuentas en el rango de fechas
        $sql = "SELECT c.id_cuenta, c.codigo, c.nombre_cuenta, comp.fecha_comprobante, comp.serie, comp.tipo_comprobante, dc.glosa_secundaria, dc.monto_debe, dc.monto_haber, dc.monto_debe_alt, dc.monto_haber_alt
        FROM detalle_comprobantes dc
        INNER JOIN comprobantes comp ON dc.id_comprobante = comp.id_comprobante
        INNER JOIN gestiones g ON g.id_empresa_gestion = comp.id_empresa_comprobante
        INNER JOIN cuentas c ON c.id_cuenta = dc.id_cuenta
        WHERE c.id_empresa_cuenta = $id_empresa AND g.id_gestion = $id_gestion AND comp.fecha_comprobante BETWEEN '$periodo_inicio' AND '$periodo_fin' AND comp.estado = 1
        ORDER BY c.codigo, comp.fecha_comprobante";

        $result = $conn->query($sql);

        $id_cuenta_actual = null;
        $saldo_acumulado = 0;

        while ($row = $result->fetch_assoc()) {
        if ($id_cuenta_actual != $row['id_cuenta']) {
            if ($id_cuenta_actual != null) {
                echo "</table><br>"; // Fin de la tabla anterior y separador
            }

        // Inicio de una nueva tabla
        echo "<span>Cuenta: {$row['codigo']}-{$row['nombre_cuenta']}</span>";
        echo "<table>";
        echo "<tr>
                <th>Fecha</th>
                <th>NroComp</th>
                <th>Tipo</th>
                <th>Glosa</th>
                <th>Debe</th>
                <th>Haber</th>
                <th>Saldo</th>
            </tr>";

        $id_cuenta_actual = $row['id_cuenta'];
        $saldo_acumulado = 0;
        }

        $debe = $id_moneda == $moneda_principal ? $row['monto_debe'] : $row['monto_debe_alt'];
        $haber = $id_moneda == $moneda_principal ? $row['monto_haber'] : $row['monto_haber_alt'];

        // Actualizar el saldo acumulado
        $saldo_acumulado += $debe - $haber;
        $fecha_formateada = date("d/m/Y", strtotime($row['fecha_comprobante']));

        echo "<tr>
            <td>{$fecha_formateada}</td>
            <td>{$row['serie']}</td>
            <td>{$row['tipo_comprobante']}</td>
            <td>{$row['glosa_secundaria']}</td>
            <td style='text-align:right;'>$debe</td>
            <td style='text-align:right;'>$haber</td>
            <td style='text-align:right;'>$saldo_acumulado</td>
        </tr>";
        }
        if ($id_cuenta_actual != null) {
            echo "</table><br>"; // Fin de la última tabla y separador
        }
        $conn->close();
        
        
   

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