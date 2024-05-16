<?php
require '../../vendor/autoload.php';

use Dompdf\Dompdf;

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "erp");

// Obtener datos de la tabla empresas
$result = mysqli_query($conexion, "SELECT sigla, nombre_empresa, nit, telefono, correo FROM empresas WHERE estado = 1");

// Crear contenido HTML para el PDF
$fecha_actual = date('d/m/Y');
$html = <<<EOT
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
    .contenedor{
        width:43rem;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    
    th, td {
        border: 1px solid #ccc;
        padding: 5px;
        font-family:Arial, Helvetica, sans-serif;
    }
    th{
        text-align: center;
    }
    
    th {
        background-color: #fff;
        font-weight: bold;
    }
    .fecha_usuario{
        text-align: right;
        font-size: 10px;
        font-family:Arial, Helvetica, sans-serif;
        margin-bottom: 10px;
    }
    .titulo{
        text-align:center;
        font-family:Arial, Helvetica, sans-serif;
    }
    .subUsuario{
        position: relative;
        bottom: 7px;
    }
    table{
        position:relative;
        bottom:25px;
    }
    
    .pagenum:before {
        content: counter(page);
    }
    .pagecount:before {
        content: counter(pages);
    }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1 class="titulo">Reporte de Empresas</h1>
        <div class="fecha_usuario">
            <h2>Fecha Rep: $fecha_actual<br></h2>
            <h2 class="subUsuario">Usuario: Administrador</h2>
        </div>
        </br></br>
        <table border="1" cellspacing="0" cellpadding="5" width="100%">
            <tr>F
                <th>Sigla</th>
                <th>Nombre Empresa</th>
                <th>NIT</th>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
EOT;

while ($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>";
    $html .= "<td style='text-align:center;' >{$row['sigla']}</td>";
    $html .= "<td style='text-align:center;' >{$row['nombre_empresa']}</td>";
    $html .= "<td style='text-align:center;' >{$row['nit']}</td>";
    $html .= "<td style='text-align:center;' >{$row['telefono']}</td>";
    $html .= "<td style='text-align:center;' >{$row['correo']}</td>";
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

$dompdf->stream('reporte_empresas.pdf');
