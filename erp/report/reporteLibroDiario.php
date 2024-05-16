<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL REPORTING SERVICE</title>
    <link rel="icon" href="../img/nivelesIcon.ico">
    <link href="../css/reportes.css" rel="stylesheet" type="text/css">
    <link href="style/EstiloLibroDiario.css" rel="stylesheet" type="text/css">
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
//sacar el nombre del periodo
if ($id_periodo == 0){
    $nombre_periodo = "Todos";
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
$fecha_actual = date('d/m/Y'); 
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
            <span class="Nombre_Reporte">reporteLibroDiario</span> <!--Este el nombre del reporte puede ser cambiado-->
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
                        <a href="libroDiario/word_libroDiario.php?id_empresa=<?php echo $id_empresa; ?>&id_gestion=<?php echo $id_gestion; ?>&id_periodo=<?php echo $id_periodo; ?>&id_moneda=<?php echo $id_moneda; ?>" target="_blank">Word</a>
                        <a href="libroDiario/excel_libroDiario.php?id_empresa=<?php echo $id_empresa; ?>&id_gestion=<?php echo $id_gestion; ?>&id_periodo=<?php echo $id_periodo; ?>&id_moneda=<?php echo $id_moneda; ?>" target="_blank"">Excel</a>
                        <a href="#">PowerPoint</a>
                        <a href="libroDiario/pdf_libroDiario.php?id_empresa=<?php echo $id_empresa; ?>&id_gestion=<?php echo $id_gestion; ?>&id_periodo=<?php echo $id_periodo; ?>&id_moneda=<?php echo $id_moneda; ?>" target="_blank">PDF</a>
                        <a href="#">Archivo TIFF</a>
                        <a href="#">MHTML (archivo web)</a>
                        <a href="#">CSV (delimitado por comp...)</a>
                        <a href="#">Fuente de datos</a>
                    </div>
                </div>
            
                <div class="impresora">
                    <hr class="vertical-line">
                    <a onclick="showPdfPreview('libroDiario/pdf_preview_libroDiario.php?id_empresa=<?php echo $id_empresa; ?>&id_gestion=<?php echo $id_gestion; ?>&id_periodo=<?php echo $id_periodo; ?>&id_moneda=<?php echo $id_moneda; ?>')"><img class="imprimir" src="../img/impresora.png"></a>
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


    <article>
    <?php
    // Conectar a la base de datos
    $conn = new mysqli("localhost", "root", "", "erp");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener información del periodo y gestion
    if ($id_periodo == 0) {
        $sql_periodo = "SELECT id_periodo, nombre_periodo, fecha_inicio_periodo, fecha_fin_periodo FROM periodos WHERE id_gestion_periodo = $id_gestion";
    } else {
        $sql_periodo = "SELECT id_periodo, nombre_periodo, fecha_inicio_periodo, fecha_fin_periodo FROM periodos WHERE id_periodo = $id_periodo";
    }
    $result_periodo = $conn->query($sql_periodo);
    $periodos = $result_periodo->fetch_all(MYSQLI_ASSOC);

    // Crear un arreglo de fechas de inicio y fin de los periodos
    $periodo_fechas = [];
    foreach ($periodos as $periodo) {
        $periodo_fechas[] = "c.fecha_comprobante BETWEEN '{$periodo['fecha_inicio_periodo']}' AND '{$periodo['fecha_fin_periodo']}'";
    }

    // Crear la condición SQL con las fechas de los periodos
    $periodo_condicion = implode(' OR ', $periodo_fechas);


    // Consulta SQL para obtener los datos requeridos
    $sql = "SELECT c.fecha_comprobante, c.glosa_principal, cu.codigo, cu.nombre_cuenta, 
        dc.monto_debe, dc.monto_haber, dc.monto_debe_alt, dc.monto_haber_alt, 
        em.id_moneda_principal, em.id_moneda_alternativa
        FROM comprobantes c
        JOIN detalle_comprobantes dc ON c.id_comprobante = dc.id_comprobante
        JOIN cuentas cu ON dc.id_cuenta = cu.id_cuenta
        JOIN empresa_monedas em ON c.id_empresa_comprobante = em.id_empresa_m
        WHERE c.id_empresa_comprobante = $id_empresa
        AND c.estado = 1
        AND ($periodo_condicion)
        AND em.activo = 1
        ORDER BY c.fecha_comprobante, cu.codigo";



    $result = $conn->query($sql);


    ?>
    <div class="Contenedor">
        <div class="Titulo">
            <div class="ParteArriba">
                <h2 style="color:#7DA5D4;font-size:27px;font-family:Arial, Helvetica, sans-serif;">Reporte Libro Diario</h2>
            </div>  
            <div class="ParteAbajo">
                <span class="txtTitle">Empresa: <?php echo $nombre_empresa; ?></span>
                <span class="txtTitle">Gestión: <?php echo $nombre_gestion; ?></span>
                <span class="txtTitle">Periodo: <?php echo $nombre_periodo; ?></span>
                <span class="txtTitle">Moneda: <?php echo $nombre_moneda; ?></span>
            </div>
            <div class="ParteAbajoDerecha">
                <span style="font-size:17px;">Fecha:<?php echo $fecha_actual ?></span> 
                </span>Usuario: Administrador</span>
            </div>
        </div>
        
        <table>
            <tr>
                <th>Fecha</th>
                <th>Codigo</th>
                <th>Cuenta</th>
                <th>Debe</th>
                <th>Haber</th>
            </tr>
            <?php
            $fecha_anterior = "";
            $total_debe = 0;
            $total_haber = 0;

            while ($row = $result->fetch_assoc()){
                if ($id_moneda == $row['id_moneda_principal']) {
                    $monto_debe = $row['monto_debe'];
                    $monto_haber = $row['monto_haber'];
                } elseif ($id_moneda == $row['id_moneda_alternativa']) {
                    $monto_debe = $row['monto_debe_alt'];
                    $monto_haber = $row['monto_haber_alt'];
                } 

                $fecha_actual = date('d/m/Y', strtotime($row['fecha_comprobante']));
                if ($fecha_actual != $fecha_anterior) {
                    // Fila con fecha_comprobante y glosa_principal
                    echo "<tr>";
                    echo "<td>$fecha_actual</td>";
                    echo "<td></td>";
                    echo "<td>{$row['glosa_principal']}</td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "</tr>";

                    $fecha_anterior = $fecha_actual;
                }
                $total_debe += $monto_debe;
                $total_haber += $monto_haber;
            

            ?>
                <tr>
                    <td></td>
                    <td><?php echo $row['codigo']; ?></td>
                    <td><?php echo $row['nombre_cuenta']; ?></td>
                    <td style="text-align:right;"><?php echo number_format($monto_debe); ?></td>
                    <td style="text-align:right;"><?php echo number_format($monto_haber); ?></td>

                </tr>
            <?php }  ?>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                <td style="text-align:right;"><?php echo number_format($total_debe); ?></td>
                <td style="text-align:right;"><?php echo number_format($total_haber); ?></td>
            </tr>
        </table>
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