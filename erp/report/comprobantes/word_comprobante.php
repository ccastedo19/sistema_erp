
<?php
require_once '../../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\TablePosition;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "erp");
if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Traer datos de la base de datos
$id_comprobante = $_GET['idComprobante'];
// Consultas a las tablas
$query_comprobante = "SELECT comprobantes.*, monedas.nombre_moneda, empresas.nombre_empresa FROM comprobantes INNER JOIN monedas ON comprobantes.id_moneda = monedas.id_moneda INNER JOIN empresas ON comprobantes.id_empresa_comprobante = empresas.id_empresa WHERE comprobantes.id_comprobante = $id_comprobante";
$result_comprobante = mysqli_query($conexion, $query_comprobante);

if ($result_comprobante->num_rows > 0) {
    $comprobante = $result_comprobante->fetch_assoc();
} else {
    die("Error al obtener el comprobante: Comprobante no encontrado.");
}

$query_detalle_comprobante = "SELECT detalle_comprobantes.*, cuentas.nombre_cuenta, cuentas.codigo FROM detalle_comprobantes INNER JOIN cuentas ON detalle_comprobantes.id_cuenta = cuentas.id_cuenta WHERE detalle_comprobantes.id_comprobante = $id_comprobante";
$result_detalle_comprobante = mysqli_query($conexion, $query_detalle_comprobante);

$phpWord = new PhpWord();
$section = $phpWord->addSection();

// Estilos de la tablas
$tableStyle = [
    'borderColor' => '000000',
    'borderSize' => 6,
    'cellMarginTop' => 80,
    'cellMarginLeft' => 80,
    'cellMarginRight' => 80,
    'cellMarginBottom' => 80,
    'alignment' => Jc::CENTER
];
$phpWord->addTableStyle('tableStyle', $tableStyle);

// Estilos de celda
$cellStyle = ['valign' => 'center'];

// Agregar título y datos del comprobante
$section->addText('Reporte Comprobante Contable', ['bold' => true, 'size' => 16], ['alignment' => Jc::CENTER]);
$section->addText("Empresa: {$comprobante['nombre_empresa']}", ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);

$section->addTextBreak(1);
$section->addText("Serie: {$comprobante['serie']} \t\t\t\t\t\t Fecha de reporte: " . date('d/m/Y'));
$section->addText("Moneda: {$comprobante['nombre_moneda']} \t\t\t\t\t Fecha del periodo: " . date('d/m/Y', strtotime($comprobante['fecha_comprobante'])));
$section->addText("Cambio: {$comprobante['tc']} \t\t\t\t\t\t Tipo de Comprobante: {$comprobante['tipo_comprobante']}");
$section->addText("Estado del comprobante: " . ($comprobante['estado'] == 1 ? "Abierto" : "Anulado"));

$section->addTextBreak(1);

// Agregar tabla de detalle del comprobante
$table = $section->addTable('tableStyle');

// Encabezado de la tabla
$table->addRow();
$table->addCell(2000, $cellStyle)->addText("Cuenta", ['bold' => true], ['alignment' => Jc::CENTER]);
$table->addCell(2000, $cellStyle)->addText("Glosa", ['bold' => true], ['alignment' => Jc::CENTER]);
$table->addCell(2000, $cellStyle)->addText("Debe", ['bold' => true], ['alignment' => Jc::CENTER]);
$table->addCell(2000, $cellStyle)->addText("Haber", ['bold' => true], ['alignment' => Jc::CENTER]);

$total_debe = 0;
$total_haber = 0;

while ($row = mysqli_fetch_assoc($result_detalle_comprobante)) {
    $monto_debe = $row['monto_debe'] > 0 ? $row['monto_debe'] : $row['monto_debe_alt'];
    $monto_haber = $row['monto_haber'] > 0 ? $row['monto_haber'] : $row['monto_haber_alt'];

    $total_debe += $monto_debe;
    $total_haber += $monto_haber;

    // Concatenar código y nombre_cuenta
    $codigo_nombre_cuenta = $row['codigo'] . ' ' . $row['nombre_cuenta'];

    // Agregar filas con los detalles
    $table->addRow();
    $table->addCell(2000, $cellStyle)->addText($codigo_nombre_cuenta, null, ['alignment' => Jc::CENTER]); // Línea modificada
    $table->addCell(2000, $cellStyle)->addText($row['glosa_secundaria'], null, ['alignment' => Jc::CENTER]);
    $table->addCell(2000, $cellStyle)->addText($monto_debe, null, ['alignment' => Jc::CENTER]);
    $table->addCell(2000, $cellStyle)->addText($monto_haber, null, ['alignment' => Jc::CENTER]);
}


// Agregar fila con los totales
$table->addRow();
$table->addCell(2000, $cellStyle)->addText("", null, ['alignment' => Jc::CENTER]);
$table->addCell(2000, $cellStyle)->addText("Total", ['bold' => true], ['alignment' => Jc::RIGHT]);
$table->addCell(2000, $cellStyle)->addText($total_debe, ['bold' => true], ['alignment' => Jc::CENTER]);
$table->addCell(2000, $cellStyle)->addText($total_haber, ['bold' => true], ['alignment' => Jc::CENTER]);

// Guardar y descargar el archivo de Word
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="reporte_comprobante.docx"');
$objWriter->save('php://output');

