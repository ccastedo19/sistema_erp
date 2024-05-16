<?php
require '../../vendor/autoload.php';

use Dompdf\Dompdf;

// Conexión a la base de datos    
$conn = new mysqli('localhost', 'root', '', 'erp');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
if($id_periodo == 0){
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

$fecha_actual = date('d/m/Y');

//todas las consultas
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
$tabla_html = '';

while ($row = $result->fetch_assoc()) {
    if ($id_cuenta_actual != $row['id_cuenta']) {
        if ($id_cuenta_actual != null) {
            $tabla_html .= "</table><br>"; // Fin de la tabla anterior y separador
        }

        // Inicio de una nueva tabla
        $tabla_html .= "<span>Cuenta: {$row['codigo']}-{$row['nombre_cuenta']}</span>";
        $tabla_html .= "<table>";
        $tabla_html .= "<tr>
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

    $tabla_html .= "<tr>
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
    $tabla_html .= "</table><br>"; // Fin de la última tabla y separador
}




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
            <!-- Insertar tabla del libro Mayor -->
            $tabla_html
            
            
        </div>            
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

$dompdf->stream('reporte_libroMayor.pdf');
?>