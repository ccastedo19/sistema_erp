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
//reciclar variable
$id_monedaForm = $id_moneda;

?>
<?php
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

$fecha_actual = date('d/m/Y');

$html = <<<EOT
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
        <style>
            .Contenido{
                width:50rem;
                margin-bottom: 10px;
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
                margin-bottom: 10px;
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
<div class="Contenedor">
    <div class="Titulo">
        <div class="ParteArriba">
            <h2 style="color:#7DA5D4;font-size:27px;font-family:Arial, Helvetica, sans-serif;">Reporte de Sumas y Saldos</h2>
        </div>  
        <div class="ParteAbajo">
            <div>
                <span class="txtTitle">Empresa: {$nombre_empresa}</span>
            </div>
            <div>
                <span class="txtTitle">Gestión: {$nombre_gestion}</span>
            </div>
            <div>
                <span class="txtTitle">Moneda: {$nombre_moneda}</span>
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
    </div>
    <table>
        <tr>
            <th rowspan='2'>Cuentas</th>
            <th colspan='2'>Sumas</th>
            <th colspan='2'>Saldos</th>
        </tr>
        <tr>
            <th>Debe</th>
            <th>Haber</th>
            <th>Debe</th>
            <th>Haber</th>
        </tr>
EOT;

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

    $html .= <<<EOT
        <tr>
            <td>{$codigo_nombre_cuenta}</td>
            <td style='text-align:right;'>{$suma['debe']}</td>
            <td style='text-align:right;'>{$suma['haber']}</td>
            <td style='text-align:right;'>{$debeOp}</td>
            <td style='text-align:right;'>{$haberOp}</td>
        </tr>
EOT;

    $total_debeOp += $debeOp;
    $total_haberOp += $haberOp;
}

$html .= <<<EOT
    <tr>
        <td style='text-align:right;font-weight:bold;'>Total</td>
        <td style='text-align:right;'>{$total_debe}</td>
        <td style='text-align:right;'>{$total_haber}</td>
        <td style='text-align:right;'>{$total_debeOp}</td>
        <td style='text-align:right;'>{$total_haberOp}</td>
    </tr>
    </table>
</div>
</body>
</html>
EOT; 


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