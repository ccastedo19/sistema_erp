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
// Función para mostrar las cuentas
function mostrarCuentas($conexion, $id_empresa, $id_cuenta_padre = null, $nivel = 0) {
    // Preparar la consulta SQL
    $sql = "SELECT * FROM cuentas WHERE id_empresa_cuenta = $id_empresa ";
    $sql .= is_null($id_cuenta_padre) ? "AND (id_cuenta_padre IS NULL OR id_cuenta_padre = 0) " : "AND id_cuenta_padre = $id_cuenta_padre ";
    $sql .= "ORDER BY codigo";

    // Ejecutar la consulta
    $result = mysqli_query($conexion, $sql);
    
    // Si no se encuentran cuentas, salir de la función
    if (mysqli_num_rows($result) == 0) {
        return "";
    }

    $cuentas = "";

    // Para cada cuenta encontrada...
    while ($row = mysqli_fetch_assoc($result)) {
        $cuentas .= '<span class="cuentas">'. str_repeat('&nbsp;', $nivel * 4) . $row['codigo'] . ' ' . $row['nombre_cuenta'] . "<br/>\n</span>";
        
        // ...y luego buscar y mostrar sus subcuentas
        $cuentas .= mostrarCuentas($conexion, $id_empresa, $row['id_cuenta'], $nivel + 1);
    }

    return $cuentas;
}

$contenidoCuentas = mostrarCuentas($conexion, $id_empresa);

// Crear contenido HTML para el PDF
$fecha_actual = date('d/m/Y');

$html = <<<EOT
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>

        .contenedor{
            width: 45rem;
        }
        
        h1, h2, h3{
            font-family:Arial, Helvetica, sans-serif;
        }
        
        .titulo h1{
            text-align: center;
            font-size: 25px;
            color: #7DA5D4;
        }
        .titulo h2{
            text-align: center;
            font-size: 22px;
        }
        .subtitulos{
            margin-bottom:3rem;
        }
        .subtitulos h3{
            text-align: right;
            font-size: 13px;
        }
        .cuentas{
            font-family:Arial, Helvetica, sans-serif;
            font-size: 20px;
        }
    
    </style>
</head>
<body>
    <div class="contenedor">
        <div class="titulo">
            <h1>Reporte de Plan de Cuentas</h1>
            <h2>Empresa: $nombre_empresa </h2>
        </div>
        <div class="subtitulos">
            <h3>Fecha Rep: $fecha_actual </h3>
            <h3>Usuario: Administrador </h3>
        </div>
        $contenidoCuentas
    </div>   
    

        
EOT;


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