<?php
require_once '../../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\TablePosition;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "erp");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

date_default_timezone_set('America/La_Paz');

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

// Crear un nuevo documento de Word
$phpWord = new PhpWord();

// Agregar una sección al documento
$section = $phpWord->addSection();

// Agregar un título al documento
$section->addTitle("Reporte Libro Diario", 1);

// Agregar un texto con la información de la empresa, gestión, periodo y moneda
$texto = "Empresa: $nombre_empresa" . PHP_EOL;
$texto .= "Gestión: $nombre_gestion" . PHP_EOL;
$texto .= "Periodo: $nombre_periodo" . PHP_EOL;
$texto .= "Moneda: $nombre_moneda" . PHP_EOL . PHP_EOL;
$section->addText($texto);

// Agregar la tabla con los datos de la consulta SQL
$table = $section->addTable();
$table->addRow();
$table->addCell(500)->addText("Fecha");
$table->addCell(500)->addText("Codigo");
$table->addCell(5000)->addText("Cuenta");
$table->addCell(1000)->addText("Debe");
$table->addCell(1000)->addText("Haber");

// Iterar a través de los datos de la consulta SQL para agregar filas a la tabla
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
    $table->addRow();
    $table->addCell(500)->addText($fecha_actual);
    $table->addCell(500)->addText("");
    $table->addCell(5000)->addText($row['glosa_principal']);
    $table->addCell(1000)->addText("");
    $table->addCell(1000)->addText("");

    $fecha_anterior = $fecha_actual;
}
$total_debe += $monto_debe;
$total_haber += $monto_haber;

// Fila con los datos de la cuenta
$table->addRow();
$table->addCell(500)->addText("");
$table->addCell(500)->addText($row['codigo']);
$table->addCell(5000)->addText($row['nombre_cuenta']);
$table->addCell(1000)->addText(number_format($monto_debe));
$table->addCell(1000)->addText(number_format($monto_haber));
}

// Agregar fila de totales a la tabla
$table->addRow();
$table->addCell(500, ['gridSpan' => 3])->addText("Total:", ['bold' => true]);
$table->addCell(1000)->addText(number_format($total_debe), ['bold' => true]);
$table->addCell(1000)->addText(number_format($total_haber), ['bold' => true]);


// Guardar y descargar el archivo de Word
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="reporte_libroDiario.docx"');
$objWriter->save('php://output');
