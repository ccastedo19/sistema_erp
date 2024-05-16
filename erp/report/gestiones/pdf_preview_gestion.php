<?php

require '../../vendor/autoload.php';

use Dompdf\Dompdf;

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "erp");

//llegada de datos
$id_empresa = $_GET['id_empresa'];

$qry = "SELECT nombre_empresa FROM empresas WHERE id_empresa = $id_empresa";
$run = $conexion -> query($qry);
if($run -> num_rows > 0 ){
    while($row = $run -> fetch_assoc()){
        $nombre_empresa=$row['nombre_empresa'];
    }
} 
date_default_timezone_set('America/La_Paz');
// Obtener datos de la tabla empresas
$result = mysqli_query($conexion, "SELECT nombre_gestion, fecha_inicio, fecha_fin, estado_gestion FROM gestiones WHERE id_empresa_gestion = '$id_empresa'");

// Crear contenido HTML para el PDF
$fecha_actual = date('d/m/Y');
$html = <<<EOT
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        .contenedor{
            width: 43rem;
        }
        /*Parte del article*/
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
        
        
        /* Estilos de las cabeceras */
        th {
            background-color: #fff;
            font-weight: bold;
        }
        /* Estilos para subtitulos */
        .fecha_usuario{
            text-align: right;
            font-size: 12px;
            font-family:Arial, Helvetica, sans-serif;
            margin-bottom: 40px;
        }
        .titulo{
            text-align:center;
            font-family:Arial, Helvetica, sans-serif;
        }
        .titulo h1{
            font-size: 25px;
            color: #7DA5D4;
        }
        .titulo h2{
            font-size: 20px;
            position: relative;
            bottom: 10px;
        }
        .subUsuario{
            position: relative;
            bottom: 7px;
        }
    
    </style>
</head>
<body>
    <div class="contenedor">
        <div class="titulo">
            <h1>Reporte de Gestión</h1>
            <h2>Empresa: $nombre_empresa </h2>
        </div>
        <div class="fecha_usuario">
            <h3>Fecha Rep: $fecha_actual <br></h3>
            <h3 class="subUsuario">Usuario: Administrador</h3>
        </div>

        <table border="1" cellspacing="0" cellpadding="5" width="100%">
            <tr>
                <th>Razon Social</th>
                <th>Feha Inicio</th>
                <th>Fecha Fin</th>
                <th>Estado</th>
            </tr>
EOT;

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['estado_gestion']) {
        $estado = "Abierto";
    } else {
        $estado = "Cerrado";
    } 
    $html .= "<tr>";
    $html .= "<td style='text-align:center;' >{$row['nombre_gestion']}</td>";
    $html .= "<td style='text-align:center;'>" . date('d/m/Y', strtotime($row['fecha_inicio'])) . "</td>";
    $html .= "<td style='text-align:center;'>" . date('d/m/Y', strtotime($row['fecha_fin'])) . "</td>";
    $html .= "<td style='text-align:center;'>{$estado}</td>";
    $html .= "</tr>";
}

$html .= <<<EOT
        </table>
    </div>
    <script type="text/php">
        if ( isset(\$pdf) ) {
          \$x = 500;
          \$y = 820;
          \$text = "Página {PAGE_NUM} de {PAGE_COUNT}";
          \$font = \$fontMetrics->get_font("Arial, sans-serif", "normal");
          \$size = 12;
          \$color = array(0,0,0);
          \$word_space = 0.0;  //  default
          \$char_space = 0.0;  //  default
          \$angle = 0.0;   //  default
          \$pdf->page_text(\$x, \$y, \$text, \$font, \$size, \$color, \$word_space, \$char_space, \$angle);
        }
    </script>
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
