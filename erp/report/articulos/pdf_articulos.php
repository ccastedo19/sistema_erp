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
$fecha_actual = date('d/m/Y');
//variables de llegada
$id_categoria = $_GET['id_categoria'];
$cantidad = $_GET['cantidad'];

$qry = "SELECT nombre_categoria FROM categorias WHERE id_categoria = '$id_categoria'";
$run = $conexion -> query($qry);
if($run -> num_rows > 0 ){
    while($row = $run -> fetch_assoc()){
        $nombre_categoria=$row['nombre_categoria'];
    }
} 

$result = mysqli_query($conexion, "SELECT DISTINCT a.nombre_articulo, a.cantidad, a.precio_venta
FROM articulos AS a
INNER JOIN articulo_categorias AS ac ON a.id_articulo = ac.id_articulo_ca
INNER JOIN categorias AS c ON ac.id_categoria_ca = c.id_categoria
WHERE (ac.id_categoria_ca = $id_categoria OR c.id_categoria_padre = $id_categoria)
AND a.cantidad <= $cantidad");

// Crear contenido HTML para el PDF
$fecha_actual = date('d/m/Y');
$html = <<<EOT
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        .contenedor{
            width:45rem;
        }
        
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
        
        .combo1, .combo2{
            display:flex;
            flex-direction:column;
        }
        .combo1{
            text-align:left;
        }
        .combo2{
            text-align:right;
            position:relative;
            bottom:5.3rem;
        }

        .titulo{
            text-align:center;
            font-family:Arial, Helvetica, sans-serif;
        }
        .subUsuario{
            position: relative;
            bottom: 7px;
        }
        .subUsuario2{
            position: relative;
            bottom: 5px;
        }
        .fecha_usuario{
            display:flex;
            flex-direction:row;
            font-size: 10px;
            font-family:Arial, Helvetica, sans-serif;
            margin-bottom: 40px;
            height:5rem;
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
        <h2 class="titulo">Reporte de Articulos de Bajo Stock</h2>
        <h2 class="titulo">Empresa: $nombre_empresa</h2>
        <div class="fecha_usuario">
            <div class="combo1">
                <div>
                    <h2>Categoria: $nombre_categoria</h2>
                </div>
                <div>
                    <h2 class="subUsuario2">Cantidad: $cantidad</h2>
                </div>
            </div>
            <div class="combo2"> 
                <div>
                    <h2>Fecha Rep: $fecha_actual</h2>
                </div>
                <div>
                    <h2 class="subUsuario">Usuario: Administrador</h2>
                </div>
            </div>
            
        </div>
        <table cellpadding="5" width="100%">
            <tbody>
                <tr>
                    <th>Nombre Artículo</th>
                    <th>Precio de venta</th>
                    <th>Cantidad</th>
                </tr>
            
EOT;   
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "<tr>
            <td style='text-align:center'>" . $row['nombre_articulo'] . "</td>
            <td style='text-align:right'>" . $row['precio_venta'] . "</td>
            <td style='text-align:right'>" . $row['cantidad'] . "</td>
        </tr>";
    }
} else {
    $html .= '<tr style="text-align:center;"><td colspan="3">No se encontraron artículos que cumplan con los criterios de búsqueda.</td></tr>';
}

$html .= <<<EOT
        </tbody>
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

$dompdf->stream('reporte_articuloStock.pdf');

