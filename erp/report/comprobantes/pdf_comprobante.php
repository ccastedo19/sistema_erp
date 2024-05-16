
<?php
require '../../vendor/autoload.php';

use Dompdf\Dompdf;

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "erp");
if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}


//traer datos para la bd
$id_comprobante = $_GET['idComprobante'];
//echo $id_comprobante;
$qry = "SELECT * FROM comprobantes WHERE id_comprobante = $id_comprobante";
$run = mysqli_query($conexion, $qry);
if ($run->num_rows > 0) {
    while ($row = $run->fetch_assoc()) {
        $serie = $row['serie'];
        $glosa_principal = $row['glosa_principal'];
        $fecha_comprobante = $row['fecha_comprobante'];
        $tc = $row['tc'];
        $estado = $row['estado'];
        $tipo_comprobante = $row['tipo_comprobante'];
        $id_moneda_comprobante = $row['id_moneda'];
        $id_empresa_comprobante = $row['id_empresa_comprobante'];
    }
}
//reutilizar dato
$id_empresa = $id_empresa_comprobante;
$id_moneda = $id_moneda_comprobante;

//configurando el estado
if($estado == '1' || $estado == 1){
    $estadoNuevo = "Abierto";
}else if($estado == '0' || $estado == 0){
    $estadoNuevo = "Anulado";
}

// Consultar tabla moneda
$qry2 = "SELECT nombre_moneda FROM monedas Where id_moneda = $id_moneda_comprobante";
$run = mysqli_query($conexion, $qry2);
if ($run->num_rows > 0) {
    while ($row = $run->fetch_assoc()) {
        $nombre_moneda = $row['nombre_moneda'];
    }
}
// Consultar Empresa
$qry3 = "SELECT nombre_empresa FROM empresas Where id_empresa = $id_empresa_comprobante";
$run = mysqli_query($conexion, $qry3);
if ($run->num_rows > 0) {
    while ($row = $run->fetch_assoc()) {
        $nombre_empresa = $row['nombre_empresa'];
    }
}

$fecha_actual = date('d/m/Y');
$fechaOriginal = DateTime::createFromFormat('Y-m-d', $fecha_comprobante);
$fecha_Formateada = $fechaOriginal->format('d/m/Y');

// Consulta actualizada para obtener la moneda principal y alternativa
$sqlMoneda = "SELECT empresa_monedas.id_moneda_principal, empresa_monedas.id_moneda_alternativa FROM empresa_monedas INNER JOIN comprobantes ON comprobantes.id_empresa_comprobante = empresa_monedas.id_empresa_m WHERE comprobantes.id_comprobante = $id_comprobante AND empresa_monedas.activo = 1";
$queryMoneda = mysqli_query($conexion, $sqlMoneda);
$infoMoneda = mysqli_fetch_assoc($queryMoneda);

// Verificar si se utiliza moneda principal o alternativa
$usarMonedaPrincipal = $id_moneda == $infoMoneda['id_moneda_principal'];

// Preparar el contenido de la tabla
$table_content = '';
$result = mysqli_query($conexion, "SELECT detalle_comprobantes.*, cuentas.nombre_cuenta, cuentas.codigo FROM detalle_comprobantes INNER JOIN cuentas ON detalle_comprobantes.id_cuenta = cuentas.id_cuenta WHERE detalle_comprobantes.id_comprobante = $id_comprobante");

$total_debe = 0;
$total_haber = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $monto_debe = $usarMonedaPrincipal ? $row['monto_debe'] : $row['monto_debe_alt'];
    $monto_haber = $usarMonedaPrincipal ? $row['monto_haber'] : $row['monto_haber_alt'];

    $total_debe += $monto_debe;
    $total_haber += $monto_haber;
    $table_content .= <<<EOT
<tr>
    <td>{$row['codigo']} {$row['nombre_cuenta']}</td>
    <td>{$row['glosa_secundaria']}</td>
    <td style="text-align:right;">{$monto_debe}</td>
    <td style="text-align:right;">{$monto_haber}</td>
</tr>
EOT;
}

$table_content .= <<<EOT
<tr>
    <td colspan="2" style="text-align:right;"><strong>Total:</strong></td>
    <td style="text-align:right;"><strong>{$total_debe}</strong></td>
    <td style="text-align:right;"><strong>{$total_haber}</strong></td>
</tr>
EOT;


$html = <<<EOT
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        .contenedor{
            width: 45rem;
        }
        .Contenido {
            display: flex;
            flex-direction: row;
            font-size: 10px;
            font-family: Arial, Helvetica, sans-serif;
            justify-content: space-between;
        }
        .Contenido h3{
            font-size: 15px;
        }
        
        .subContenido {
            display: flex;
            flex-direction: column;
        }
        .primero{
            text-align: left;
        }
        .segundo{
            text-align: right;
            position:relative;
            bottom: 5.5rem;
        }
        
        .h2-juntos {
            margin-top: 2px; 
            margin-bottom: 2px;
        }
        
        /* Estilos de la tabla */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        /* Estilos de las celdas */
        th, td {
            border: 1px solid #ccc;
            padding: 5px;
            font-family:Arial, Helvetica, sans-serif;
        }
        th{
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="contenedor">
        <div class="row">
            <div class="col-md-4">
                <!--Reporte-->
                <div class="Titulo">
                    <h2 style="color:#7DA5D4;font-size:25px;text-align:center;font-family:Arial, Helvetica, sans-serif;"><strong>Reporte Comprobante Contable</strong></h2>
                    <h1 style="font-size:20px;text-align:center;font-family:Arial, Helvetica, sans-serif;">Empresa: {$nombre_empresa} </h1>
                </div>
                <div class="Contenido">
                    <div class="subContenido primero">
                        <div><h3 class="h2-juntos">Serie:{$serie}</h3></div>
                        <div><h3 class="h2-juntos">Moneda:{$nombre_moneda}</h3></div>
                        <div><h3 class="h2-juntos">Cambio:{$tc}</h2></div>
                        <div><h3 class="h2-juntos">Estado del comprobante:$estadoNuevo</h3></div>     
                    </div>
                    <div class="subContenido segundo">                
                        <div><h3 class="h2-juntos">Fecha de reporte:{$fecha_actual}</h3></div>
                        <div><h3 class="h2-juntos">Fecha del periodo:{$fecha_Formateada}</h3></div>
                        <div><h3 class="h2-juntos">Tipo de Comprobante:{$tipo_comprobante}</h3></div>
                    </div>
                </div>
                </br></br>
                <div style="position:relative;bottom:5.2rem;" class="tablaComprobante">
                    <table cellpadding="5" width="100%">
                        <tbody style="position:relative;bottom:50px;">
                            <tr>
                                <th>Cuenta</th>
                                <th>Glosa</th>
                                <th>Debe</th>
                                <th>Haber</th>
                            </tr>
                            {$table_content}
                        </tbody>
                    </table>
                </div>    
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

$dompdf->stream('reporte_comprobante.pdf');