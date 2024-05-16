<?php
ob_start();

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

//Conexion 
include_once '../../../erpApi/conexion/bd_directa.php';

//llegada de datos
$id_gestion = $_GET['id_gestion'];
$id_periodo = $_GET['id_periodo'];
$id_moneda = $_GET['id_moneda'];
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

// Consulta para obtener la moneda principal o alternativa
// Conexión a la base de datos    
$conn = new mysqli('localhost', 'root', '', 'erp');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

// Crear un objeto Spreadsheet
$spreadsheet = new Spreadsheet();

// Seleccionar la hoja activa
$sheet = $spreadsheet->getActiveSheet();

// Escribir el título del reporte en la celda A1
$sheet->setCellValue('A1', 'Reporte Libro Mayor');

// Escribir los datos de la empresa, la gestión, el período y la moneda en las celdas A2 a D2
$sheet->setCellValue('A2', 'Empresa: ' . $nombre_empresa);
$sheet->setCellValue('B2', 'Gestión: ' . $nombre_gestion);
$sheet->setCellValue('B3', 'Periodo: ' . $nombre_periodo);
$sheet->setCellValue('D2', 'Moneda: ' . $nombre_moneda);

// Escribir la fecha actual y el nombre del usuario en las celdas A3 y D3
$sheet->setCellValue('A3', 'Fecha: ' . $fecha_actual);
$sheet->setCellValue('D3', 'Usuario: Administrador');

// Definir los encabezados de la tabla
$sheet->setCellValue('A5', 'Fecha');
$sheet->setCellValue('B5', 'NroComp');
$sheet->setCellValue('C5', 'Cuenta');
$sheet->setCellValue('D5', 'Tipo');
$sheet->setCellValue('E5', 'Glosa');
$sheet->setCellValue('F5', 'Debe');
$sheet->setCellValue('G5', 'Haber');
$sheet->setCellValue('H5', 'Saldo');

// Inicializar algunas variables
$id_cuenta_actual = null;
$saldo_acumulado = 0;
$fila_actual = 6; // Empezar a escribir desde la fila 6

// Recorrer los resultados de la consulta SQL
while ($row = $result->fetch_assoc()) {
    if ($id_cuenta_actual != $row['id_cuenta']) {
        if ($id_cuenta_actual != null) {
            $fila_actual++; // Avanzar a la siguiente fila
        }

        // Escribir la información de la cuenta en la primera fila de la nueva tabla
        $sheet->setCellValue('C' . $fila_actual, 'Cuenta: ' . $row['codigo'] . '-' . $row['nombre_cuenta']);
        $fila_actual++; // Avanzar a la siguiente fila

        $id_cuenta_actual = $row['id_cuenta'];
        $saldo_acumulado = 0;
    }

    $debe = $id_moneda == $moneda_principal ? $row['monto_debe'] : $row['monto_debe_alt'];
    $haber = $id_moneda == $moneda_principal ? $row['monto_haber'] : $row['monto_haber_alt'];

    // Actualizar el saldo acumulado
    $saldo_acumulado += $debe - $haber;
    /**----------------------------------- */

        // Formatear la fecha y escribir los datos en la fila actual
        $fecha_formateada = date("d/m/Y", strtotime($row['fecha_comprobante']));
        $sheet->setCellValue('A' . $fila_actual, $fecha_formateada);
        $sheet->setCellValue('B' . $fila_actual, $row['serie']);
        $sheet->setCellValue('D' . $fila_actual, $row['tipo_comprobante']);
        $sheet->setCellValue('E' . $fila_actual, $row['glosa_secundaria']);
        $sheet->setCellValue('F' . $fila_actual, $debe);
        $sheet->setCellValue('G' . $fila_actual, $haber);
        $sheet->setCellValue('H' . $fila_actual, $saldo_acumulado);
    
        // Avanzar a la siguiente fila
        $fila_actual++;
    }
    
    // Establecer el ancho de las columnas
    $sheet->getColumnDimension('A')->setWidth(25);
    $sheet->getColumnDimension('B')->setWidth(12);
    $sheet->getColumnDimension('C')->setWidth(20);
    $sheet->getColumnDimension('D')->setWidth(12);
    $sheet->getColumnDimension('E')->setWidth(40);
    $sheet->getColumnDimension('F')->setWidth(12);
    $sheet->getColumnDimension('G')->setWidth(12);
    $sheet->getColumnDimension('H')->setWidth(12);
    
   
    
    // Establecer el estilo de las celdas con saldos negativos
    $saldos_negativos_style = [
        'font' => [
            'color' => ['rgb' => '0000'],
        ],
    ];
    for ($i = 6; $i <= $fila_actual; $i++) {
        if ($sheet->getCell('H' . $i)->getValue() < 0) {
            $sheet->getStyle('H' . $i)->applyFromArray($saldos_negativos_style);
        }
    }
    

// Guardar el archivo en formato XLSX
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="reporte_libroMayor.xlsx"');
header('Cache-Control: max-age=0');
ob_end_clean();
$writer->save('php://output');

?>