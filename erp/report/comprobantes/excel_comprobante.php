<?php
ob_start();

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Conexión a la base de datos
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
$query_detalle_comprobante = "SELECT detalle_comprobantes.*, cuentas.nombre_cuenta, cuentas.codigo FROM detalle_comprobantes INNER JOIN cuentas ON detalle_comprobantes.id_cuenta = cuentas.id_cuenta WHERE detalle_comprobantes.id_comprobante = $id_comprobante";
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
while ($row = mysqli_fetch_assoc($result_detalle_comprobante)) {
    $detalles[] = $row;
}

// Crear un nuevo objeto Spreadsheet
$spreadsheet = new Spreadsheet();
$worksheet = $spreadsheet->getActiveSheet();

// Configurar estilos
$spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
$spreadsheet->getDefaultStyle()->getFont()->setSize(10);
$spreadsheet->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

// Añadir información del comprobante y detalles a las celdas
$worksheet->setCellValue('B1', 'Reporte Comprobante Contable');
$worksheet->setCellValue('B2', 'Empresa: ' . $comprobante['nombre_empresa']);

$worksheet->setCellValue('A4', 'Serie: ' . $comprobante['serie']);
$worksheet->setCellValue('A5', 'Moneda: ' . $comprobante['nombre_moneda']);
$worksheet->setCellValue('A6', 'Cambio: ' . $comprobante['tc']);
$worksheet->setCellValue('A7', 'Estado del comprobante: ' . $estadoNuevo );

$worksheet->setCellValue('C4', 'Fecha de reporte: ' . $fecha_actual);
$worksheet->setCellValue('C5', 'Fecha del periodo: ' . $fecha_Formateada);
$worksheet->setCellValue('C6', 'Tipo de Comprobante: ' . $comprobante['tipo_comprobante']);

// Añadir encabezados de la tabla
$worksheet->setCellValue('A7', 'Cuenta');
$worksheet->setCellValue('B7', 'Glosa');
$worksheet->setCellValue('C7', 'Debe');
$worksheet->setCellValue('D7', 'Haber');

// Añadir detalles del comprobante a la tabla
$row = 8;
$total_debe = 0;
$total_haber = 0;
foreach ($detalles as $detalle) {
    $monto_debe = $detalle['monto_debe'] > 0 ? $detalle['monto_debe'] : $detalle['monto_debe_alt'];
    $monto_haber = $detalle['monto_haber'] > 0 ? $detalle['monto_haber'] : $detalle['monto_haber_alt'];

    // Concatenar código y nombre_cuenta
    $codigo_nombre_cuenta = $detalle['codigo'] . ' ' . $detalle['nombre_cuenta'];
    $worksheet->setCellValue('A' . $row, $codigo_nombre_cuenta); // Línea modificada
    $worksheet->setCellValue('B' . $row, $detalle['glosa_secundaria']);
    $worksheet->setCellValue('C' . $row, $monto_debe);
    $worksheet->setCellValue('D' . $row, $monto_haber);

    $total_debe += $monto_debe;
    $total_haber += $monto_haber;
    $row++;
}


// Añadir totales
$worksheet->setCellValue('B' . $row, 'Total:');
$worksheet->setCellValue('C' . $row, $total_debe);
$worksheet->setCellValue('D' . $row, $total_haber);

// Aplicar estilos a las celdas de la tabla
$worksheet->getStyle('A7:D' . ($row - 1))->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '000000']
        ]
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_LEFT,
        'vertical' => Alignment::VERTICAL_CENTER
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFFFF']
    ]
]);

// Aplicar estilos a las celdas de encabezado de la tabla
$worksheet->getStyle('A7:D7')->applyFromArray([
    'font' => [
        'bold' => true,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFFFF']
    ]
]);



// Configurar anchos de columna
$worksheet->getColumnDimension('A')->setWidth(25);
$worksheet->getColumnDimension('B')->setWidth(35);
$worksheet->getColumnDimension('C')->setWidth(15);
$worksheet->getColumnDimension('D')->setWidth(15);

// Guardar el archivo en formato XLSX
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="reporte_comprobante.xlsx"');
header('Cache-Control: max-age=0');
ob_end_clean();
$writer->save('php://output');

