<?php
ob_start();

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Crear una nueva hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

date_default_timezone_set('America/La_Paz');
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "erp");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// Aquí debes obtener y asignar los valores de $id_periodo, $id_empresa y $id_moneda
$id_empresa = $_GET['id_empresa'];
$id_gestion = $_GET['id_gestion'];
$id_periodo = $_GET['id_periodo'];
$id_moneda = $_GET['id_moneda'];

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

// Crear la información de la empresa, gestión, periodo y moneda
$info_row = $sheet->getRowDimension(2);
$info_row->setRowHeight(30);

$sheet->setCellValue('A1', 'Empresa: ' . $nombre_empresa);
$sheet->setCellValue('A2', 'Gestión: ' . $nombre_gestion);
$sheet->setCellValue('A3', 'Periodo: ' . $nombre_periodo);
$sheet->setCellValue('A4', 'Moneda: ' . $nombre_moneda);

// Establecer el estilo de las celdas de información
$info_style = $sheet->getStyle('A1:A4');
$info_style->getFont()->setBold(true);
$info_style->getFont()->setSize(10);
$info_style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$info_style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);



// Establecer los encabezados de la tabla
$sheet->setCellValue('A7', 'Fecha');
$sheet->setCellValue('B7', 'Codigo');
$sheet->setCellValue('C7', 'Cuenta');
$sheet->setCellValue('D7', 'Debe');
$sheet->setCellValue('E7', 'Haber');

// Establecer el formato de las celdas de encabezado
$sheet->getStyle('A7:E7')->getFont()->setBold(true);
$sheet->getStyle('A7:E7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A7:E7')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// Ajustar el ancho de las columnas
$sheet->getColumnDimension('A')->setWidth(15);
$sheet->getColumnDimension('B')->setWidth(15);
$sheet->getColumnDimension('C')->setWidth(40);
$sheet->getColumnDimension('D')->setWidth(15);
$sheet->getColumnDimension('E')->setWidth(15);

// Llenar la tabla con los datos obtenidos
$fila = 8;
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
    $sheet->setCellValue("A$fila", $fecha_actual);
    $sheet->getStyle("A$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValue("C$fila", $row['glosa_principal']);
    $fecha_anterior = $fecha_actual;
}
$sheet->setCellValue("B$fila", $row['codigo']);
$sheet->setCellValue("C$fila", $row['nombre_cuenta']);

if ($id_moneda == $row['id_moneda_principal']) {
$monto_debe = $row['monto_debe'];
$monto_haber = $row['monto_haber'];
} elseif ($id_moneda == $row['id_moneda_alternativa']) {
$monto_debe = $row['monto_debe_alt'];
$monto_haber = $row['monto_haber_alt'];
}

$sheet->setCellValue("D$fila", $monto_debe);
$sheet->getStyle("D$fila")->getNumberFormat()->setFormatCode("#,##0.00");
$sheet->getStyle("D$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->setCellValue("E$fila", $monto_haber);
$sheet->getStyle("E$fila")->getNumberFormat()->setFormatCode("#,##0.00");
$sheet->getStyle("E$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

$total_debe += $monto_debe;
$total_haber += $monto_haber;

$fila++;
}

// Agregar una fila con los totales
$sheet->setCellValue("C$fila", "Total");
$sheet->setCellValue("D$fila", $total_debe);
$sheet->getStyle("D$fila")->getNumberFormat()->setFormatCode("#,##0.00");
$sheet->getStyle("D$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->setCellValue("E$fila", $total_haber);
$sheet->getStyle("E$fila")->getNumberFormat()->setFormatCode("#,##0.00");
$sheet->getStyle("E$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

// Establecer los bordes de la fila con los totales
$sheet->getStyle("C$fila:E$fila")->applyFromArray(
[
    'borders' => [
        'top' => [
        'borderStyle' => Border::BORDER_THIN,
        'color' => ['rgb' => '000000'],
        ],
        'bottom' => [
        'borderStyle' => Border::BORDER_THIN,
        'color' => ['rgb' => '000000'],
        ],
    ],
]);

// Establecer el ancho y alto de la fila
$sheet->getRowDimension($fila)->setRowHeight(20);

$fecha_anterior = $fecha_actual;


$total_debe += $monto_debe;
$total_haber += $monto_haber;

$sheet->setCellValue("B$fila", $row['codigo']);
$sheet->getStyle("B$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue("D$fila", $row['nombre_cuenta']);
$sheet->getStyle("D$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue("E$fila", $monto_debe);
$sheet->getStyle("E$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->setCellValue("F$fila", $monto_haber);
$sheet->getStyle("F$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

$fila++;


// Fila con los totales
$sheet->setCellValue("D$fila", "Total:");
$sheet->getStyle("D$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->setCellValue("E$fila", $total_debe);
$sheet->getStyle("E$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->setCellValue("F$fila", $total_haber);
$sheet->getStyle("F$fila")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

// Establecer el ancho de las columnas
$sheet->getColumnDimension('A')->setWidth(15);
$sheet->getColumnDimension('B')->setWidth(15);
$sheet->getColumnDimension('C')->setWidth(30);
$sheet->getColumnDimension('D')->setWidth(30);
$sheet->getColumnDimension('E')->setWidth(15);
$sheet->getColumnDimension('F')->setWidth(15);

// Crear el archivo de Excel
$writer = new Xlsx($spreadsheet);
$writer->save('Reporte Libro Diario.xlsx');

// Descargar el archivo de Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte Libro Diario.xlsx"');
header('Cache-Control: max-age=0');

//$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//$writer->save('php://output');


// Guardar el archivo en formato XLSX
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="reporte_libroDiario.xlsx"');
header('Cache-Control: max-age=0');
ob_end_clean();
$writer->save('php://output');

?>