<?php
require '../../vendor/autoload.php';

use Dompdf\Dompdf;

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "erp");
if (!$conn ) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Aquí debes obtener y asignar los valores de $id_periodo, $id_empresa y $id_moneda
$id_empresa = $_GET['id_empresa'];
$id_gestion = $_GET['id_gestion'];
$id_periodo = $_GET['id_periodo'];
$id_moneda = $_GET['id_moneda'];

// ... (Resto del código de la consulta y tabla del libro diario)
//sacar el nombre de la empresa
$qry = "SELECT nombre_empresa FROM empresas WHERE id_empresa = $id_empresa";
    $run = $conn -> query($qry);
    if($run -> num_rows > 0 ){
        while($row = $run -> fetch_assoc()){
            $nombre_empresa=$row['nombre_empresa'];
        }
    } 
//sacar el nombre de la gestion
$qry = "SELECT nombre_gestion FROM gestiones WHERE id_empresa_gestion = $id_empresa";
    $run = $conn -> query($qry);
    if($run -> num_rows > 0 ){
        while($row = $run -> fetch_assoc()){
            $nombre_gestion=$row['nombre_gestion'];
        }
    }

//sacar el nombre de la moneda
$qry = "SELECT nombre_moneda FROM monedas WHERE id_moneda = $id_moneda";
$run = $conn -> query($qry);
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
    $run = $conn -> query($qry);
    if($run -> num_rows > 0 ){
        while($row = $run -> fetch_assoc()){
            $nombre_periodo=$row['nombre_periodo'];
        }
    }
}

date_default_timezone_set('America/La_Paz');
?>



<?php
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

$fecha_actual = date('d/m/Y');

$html = <<<EOT
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        .Contenedor{
            width:43rem;
            margin-bottom: 10px;
        }
        span{
            font-family:Arial, Helvetica, sans-serif;
        }
        .ParteAbajo{
            display:flex;
            flex-direction:column;
            position:relative;
            bottom:10px;
            font-size:17px;
        }
        .ParteAbajoDerecha{
            display:flex;
            flex-direction:column;
            text-align: right;
            font-family:Arial, Helvetica, sans-serif;
        }
        .txtTitle{
            font-size:17px;
            font-family:Arial, Helvetica, sans-serif;
            margin-top:3px;
        }
        .Titulo{
            text-align:center;
            margin-bottom:10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            border: 1px solid #ccc;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <!--Reporte-->
            <!-- Aquí va el contenido HTML del libro diario -->
            <!--Reporte-->
            <!-- Aquí va el contenido HTML del libro diario -->
            <div class="Contenedor">
                <div class="Titulo">
                    <div class="ParteArriba">
                        <h2 style="color:#7DA5D4;font-size:27px;font-family:Arial, Helvetica, sans-serif;">Reporte Libro Diario</h2>
                    </div>  
                    <div class="ParteAbajo">
                        <div>
                            <span class="txtTitle">Empresa: {$nombre_empresa}</span>
                        </div>
                        <div>
                            <span class="txtTitle">Gestión:{$nombre_gestion} </span>
                        </div>
                        <div>
                            <span class="txtTitle">Periodo: {$nombre_periodo}</span>
                        </div>
                        <div>
                            <span class="txtTitle">Moneda: {$nombre_moneda}</span>
                        </div>
                    </div>
                    <div class="ParteAbajoDerecha">
                        <div>
                            <span>Fecha: {$fecha_actual} </span>
                        </div>
                        <div>
                            </span>Usuario: Administrador</span>
                        </div>
                    </div>
                </div>
                <!--tabla del libro diario-->
                {libro_diario}
                
            </div>            
        </div>                
    </div>
</div>
</body>
</html>
EOT;

$tabla_libro_diario = '<table>
    <tr>
        <th>Fecha</th>
        <th>Codigo</th>
        <th>Cuenta</th>
        <th>Debe</th>
        <th>Haber</th>
    </tr>';

$fecha_anterior = "";
$total_debe = 0;
$total_haber = 0;
while ($row = $result->fetch_assoc()):
    if ($id_moneda == $row['id_moneda_principal']) {
        $monto_debe = $row['monto_debe'];
        $monto_haber = $row['monto_haber'];
    } elseif ($id_moneda == $row['id_moneda_alternativa']) {
        $monto_debe = $row['monto_debe_alt'];
        $monto_haber = $row['monto_haber_alt'];
    } 
    $fecha_actual = date('d/m/Y', strtotime($row['fecha_comprobante']));
    if ($fecha_actual != $fecha_anterior) {
        $tabla_libro_diario .= "<tr>
            <td>$fecha_actual</td>
            <td></td>
            <td>{$row['glosa_principal']}</td>
            <td></td>
            <td></td>
        </tr>";

        $fecha_anterior = $fecha_actual;
    }
    $total_debe += $monto_debe;
    $total_haber += $monto_haber;

    $tabla_libro_diario .= "<tr>
        <td></td>
        <td>{$row['codigo']}</td>
        <td>{$row['nombre_cuenta']}</td>
        <td style=\"text-align:right;\">{$monto_debe}</td>
        <td style=\"text-align:right;\">{$monto_haber}</td>
    </tr>";
endwhile;

$tabla_libro_diario .= "<tr>
    <td colspan=\"3\" style=\"text-align: right;\"><strong>Total:</strong></td>
    <td style=\"text-align:right;\">$total_debe</td>
    <td style=\"text-align:right;\">$total_haber</td>
</tr>
</table>";

$html = str_replace('{libro_diario}', $tabla_libro_diario, $html);


// Crear el PDF usando Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
// Agregar pie de página con número de página
$canvas = $dompdf->get_canvas();
$font = $dompdf->getFontMetrics()->get_font("Arial, Helvetica, sans-serif");
$canvas->page_text(500, 820, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0, 0, 0));

$output = $dompdf->output();
header('Content-Type: application/pdf');
echo $output;

?>