
<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Border;
use PhpOffice\PhpPresentation\Shape\Table;

// Conexión a la base de datos, consulta de datos y procesamiento de datos
$conexion = mysqli_connect("localhost", "root", "", "erp");
if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Traer datos para la BD
$id_comprobante = $_GET['idComprobante'];

// Consultar datos del comprobante, moneda, empresa y detalles del comprobante
$query_comprobante = "SELECT comprobantes.*, monedas.nombre_moneda, empresas.nombre_empresa FROM comprobantes INNER JOIN monedas ON comprobantes.id_moneda = monedas.id_moneda INNER JOIN empresas ON comprobantes.id_empresa_comprobante = empresas.id_empresa WHERE comprobantes.id_comprobante = $id_comprobante";
$result_comprobante = mysqli_query($conexion, $query_comprobante);
if ($result_comprobante->num_rows > 0) {
    $comprobante = $result_comprobante->fetch_assoc();
} else {
    die("Error al obtener el comprobante: Comprobante no encontrado.");
}
// Agregue aquí las consultas y la lógica para extraer los datos de las tablas
$query_detalle_comprobante = "SELECT detalle_comprobantes.*, cuentas.nombre_cuenta FROM detalle_comprobantes INNER JOIN cuentas ON detalle_comprobantes.id_cuenta = cuentas.id_cuenta WHERE detalle_comprobantes.id_comprobante = $id_comprobante";
$result_detalle_comprobante = mysqli_query($conexion, $query_detalle_comprobante);

//configurando el estado
if($comprobante['estado'] == '1' || $comprobante['estado'] == 1){
    $estadoNuevo = "Abierto";
}else if($comprobante['estado'] == '0' || $comprobante['estado'] == 0){
    $estadoNuevo = "Anulado";
}

//Ajustar Fechas
$fecha_actual = date('d/m/Y');//fecha actual

$fecha_comprobante = $comprobante['fecha_comprobante'];
$fechaOriginal = DateTime::createFromFormat('Y-m-d', $fecha_comprobante);
$fecha_Formateada = $fechaOriginal->format('d/m/Y');//fecha_comprobante

// Almacenar los detalles del comprobante en el array $detalles
$detalles = array();
// Almacenar los detalles del comprobante en el array $detalles
$detalles = array();
$total_debe = 0;
$total_haber = 0;
while ($row = mysqli_fetch_assoc($result_detalle_comprobante)) {
    $monto_debe = $row['monto_debe'] > 0 ? $row['monto_debe'] : $row['monto_debe_alt'];
    $monto_haber = $row['monto_haber'] > 0 ? $row['monto_haber'] : $row['monto_haber_alt'];

    $total_debe += $monto_debe;
    $total_haber += $monto_haber;

    $row['monto_debe'] = $monto_debe;
    $row['monto_haber'] = $monto_haber;

    $detalles[] = $row;
}


// Crear un nuevo objeto PhpPresentation
$objPHPPresentation = new PhpPresentation();

// Configurar propiedades de la presentación
$objPHPPresentation->getDocumentProperties()->setTitle('Reporte Comprobante Contable');

// Crear una diapositiva
$currentSlide = $objPHPPresentation->getActiveSlide();

// Agregar título y datos del comprobante
$currentSlide = $objPHPPresentation->createSlide(); 

// Título
$titleShape = $currentSlide->createRichTextShape()
    ->setHeight(100)
    ->setWidth(900)
    ->setOffsetX(170)
    ->setOffsetY(50);
$titleShape->getActiveParagraph()->getFont()
    ->setBold(true)
    ->setSize(24)
    ->setName('Arial');
$titleShape->createTextRun('Reporte Comprobante Contable');

// Nombre de la empresa
$empresaShape = $currentSlide->createRichTextShape()
    ->setHeight(100)
    ->setWidth(900)
    ->setOffsetX(170)
    ->setOffsetY(100);
$empresaShape->getActiveParagraph()->getFont()
    ->setBold(true)
    ->setSize(16)
    ->setName('Arial');
$empresaShape->createTextRun("Empresa: {$comprobante['nombre_empresa']}");

// Serie
$serieShape = $currentSlide->createRichTextShape()
    ->setHeight(100)
    ->setWidth(300)
    ->setOffsetX(170)
    ->setOffsetY(150);
$serieShape->getActiveParagraph()->getFont()
    ->setSize(14)
    ->setName('Arial');
$serieShape->createTextRun("Serie: {$comprobante['serie']}");

// Fecha de reporte
$fechaReporteShape = $currentSlide->createRichTextShape()
    ->setHeight(100)
    ->setWidth(600)
    ->setOffsetX(420)
    ->setOffsetY(150);
$fechaReporteShape->getActiveParagraph()->getFont()
    ->setSize(14)
    ->setName('Arial');
$fechaReporteShape->createTextRun("Fecha de reporte: " . date('d/m/Y'));

// Moneda
$monedaShape = $currentSlide->createRichTextShape()
    ->setHeight(100)
    ->setWidth(300)
    ->setOffsetX(170)
    ->setOffsetY(200);
$monedaShape->getActiveParagraph()->getFont()
    ->setSize(14)
    ->setName('Arial');
$monedaShape->createTextRun("Moneda: {$comprobante['nombre_moneda']}");

// Fecha del periodo
$fechaPeriodoShape = $currentSlide->createRichTextShape()
    ->setHeight(100)
    ->setWidth(600)
    ->setOffsetX(420)
    ->setOffsetY(200);
$fechaPeriodoShape->getActiveParagraph()->getFont()
    ->setSize(14)
    ->setName('Arial');
$fechaPeriodoShape->createTextRun("Fecha del periodo: " . date('d/m/Y', strtotime($comprobante['fecha_comprobante'])));

// Cambio
$cambioShape = $currentSlide->createRichTextShape()
    ->setHeight(100)
    ->setWidth(300)
    ->setOffsetX(170)
    ->setOffsetY(250);
$cambioShape->getActiveParagraph()->getFont()
    ->setSize(14)
    ->setName('Arial');
$cambioShape->createTextRun("Cambio: {$comprobante['tc']}");

// Tipo de Comprobante
$tipoComprobanteShape = $currentSlide->createRichTextShape()
    ->setHeight(100)
    ->setWidth(600)
    ->setOffsetX(420)
    ->setOffsetY(250);
$tipoComprobanteShape->getActiveParagraph()->getFont()
    ->setSize(14)
    ->setName('Arial');
$tipoComprobanteShape->createTextRun("Tipo de Comprobante: {$comprobante['tipo_comprobante']}");

// Estado del comprobante
$estadoComprobanteShape = $currentSlide->createRichTextShape()
    ->setHeight(100)
    ->setWidth(600)
    ->setOffsetX(170)
    ->setOffsetY(300);
$estadoComprobanteShape->getActiveParagraph()->getFont()
    ->setSize(14)
    ->setName('Arial');
$estadoComprobanteShape->createTextRun("Estado del comprobante: " . ($comprobante['estado'] == 1 ? "Abierto" : "Anulado"));



// Crear una tabla
$tableShape = $currentSlide->createTableShape(4); // Asegúrate de que haya al menos una columna en la tabla

// Añadir filas y celdas a la tabla
$rowCount = count($detalles) + 3;
for ($i = 0; $i < $rowCount; $i++) {
    $row = $tableShape->createRow();
    for ($j = 0; $j < 4; $j++) {
        $cell = $row->getCell($j);
    }
}


// Añadir información del comprobante y detalles a las celdas
// Añadir encabezados de la tabla
$tableShape->getCell(0, 0)->getFill()->setFillType(\PhpOffice\PhpPresentation\Style\Fill::FILL_SOLID)->setStartColor(new \PhpOffice\PhpPresentation\Style\Color('D9D9D9'));
$tableShape->getCell(0, 0)->createTextRun('Cuenta');
$tableShape->getCell(1, 0)->createTextRun('Glosa');
$tableShape->getCell(2, 0)->createTextRun('Debe');
$tableShape->getCell(3, 0)->createTextRun('Haber');


// Añadir detalles del comprobante a la tabla
$row = 1;
foreach ($detalles as $detalle) {
    $monto_debe = isset($detalle['monto_debe']) ? $detalle['monto_debe'] : $detalle['monto_debe_alt'];
    $monto_haber = isset($detalle['monto_haber']) ? $detalle['monto_haber'] : $detalle['monto_haber_alt'];
    
    $tableShape->getCell(0, $row)->createTextRun($detalle['nombre_cuenta']);
    $tableShape->getCell(1, $row)->createTextRun($detalle['glosa_secundaria']);
    $tableShape->getCell(2, $row)->createTextRun(number_format($monto_debe, 2));
    $tableShape->getCell(3, $row)->createTextRun(number_format($monto_haber, 2));
    $row++;
}

// Añadir totales
$tableShape->getCell($row, 1)->createTextRun('Total:');
$tableShape->getCell($row, 2)->createTextRun(number_format($total_debe, 2));
$tableShape->getCell($row, 3)->createTextRun(number_format($total_haber, 2));

// Establecer estilos de celda
for ($row = 0; $row < count($detalles) + 3; $row++) {
    for ($col = 0; $col < 4; $col++) {
        $cell = $tableShape->getActiveCell($col, $row);
        $cell->getBorders()->getTop()->setLineWidth(1)->setLineStyle(Border::LINE_SINGLE);
        $cell->getBorders()->getBottom()->setLineWidth(1)->setLineStyle(Border::LINE_SINGLE);
        $cell->getBorders()->getLeft()->setLineWidth(1)->setLineStyle(Border::LINE_SINGLE);
        $cell->getBorders()->getRight()->setLineWidth(1)->setLineStyle(Border::LINE_SINGLE);
        
        $cell->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $cell->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }
}

// Crear un objeto de escritura y guardar la presentación en formato PPTX
$oWriterPPTX = IOFactory::createWriter($objPHPPresentation, 'PowerPoint2007');
header('Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation');
header('Content-Disposition: attachment;filename="reporte_comprobante.pptx"');
header('Cache-Control: max-age=0');
$oWriterPPTX->save('php://output');

