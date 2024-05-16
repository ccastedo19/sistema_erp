<?php
require '../../vendor/autoload.php';

use Dompdf\Dompdf;

// Conexión a la base de datos    
$conexion = new mysqli('localhost', 'root', '', 'erp');

if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}
//llegada de datos
$id_empresa = $_GET['id_empresa'];
$id_nota = $_GET['id_nota'];

//sacar el nombre de la empresa
$qry = "SELECT nombre_empresa FROM empresas WHERE id_empresa = $id_empresa";
    $run = $conexion -> query($qry);
    if($run -> num_rows > 0 ){
        while($row = $run -> fetch_assoc()){
            $nombre_empresa=$row['nombre_empresa'];
        }
    } 
    date_default_timezone_set('America/La_Paz');

    $fecha_actual = date('d/m/Y');

//crear aqui las tablas para el pdf
$result = mysqli_query($conexion, "SELECT de.*, na.nombre_articulo, lo.nro_lote
FROM detalles AS de
INNER JOIN articulos AS na ON de.id_articulo_detalle = na.id_articulo
INNER JOIN lotes AS lo ON de.id_lote_detalle = lo.id_lote
AND de.id_nota_detalle = $id_nota");

$html = '
<html>
<head>
<style>
.contenedor{
    width:43rem;
    margin-bottom: 10px;
}
h1, h2, h3, span{
    font-family: Arial, Helvetica, sans-serif;
}
.Titulo h1{
    color:#7da5d4;
    text-align: center;
    font-size: 25px;
}
.Titulo h2{
    text-align: center;
    font-size: 20px;
}
.ParteDerecha h3{
    text-align: right;
    font-size: 15px;;
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
.ParteArriba{
    height:13rem;
}
.ParteAbajo{
    position:relative;
    bottom:20px;
</style>
</head>
<body>
<article>
    <div class="contenedor">
        <div class="ParteArriba">
            <div class= "Titulo">
                <h1>Reporte de Nota de Venta </h1>
                <h2>Empresa:'. $nombre_empresa .'</h2>
            </div>
            <div class="ParteDerecha">
                <h3>Fecha:'. $fecha_actual .'<h3>
                <h3 style="position:relative;bottom:25px;">Usuario:Administrador<h3>
            </div>
        </div>
        <div class="ParteAbajo">
            <div class="tabla">
                <table cellpadding="5" width="100%">
                    <tbody style="position:relative;bottom:50px;">
                        <tr>
                            <th>Articulo</th>
                            <th>Nro Lote</th>
                            <th>Cantidad</th>
                            <th>Precio</th>                            
                            <th>Subtotal</th>
                        </tr>';
                        $total = 0; // Inicializar total a 0
                        while ($row = mysqli_fetch_assoc($result)) {
                            $subtotal = $row['cantidad'] * $row['precio_venta'];
                            $total += $subtotal; // Agregar el subtotal al total
                            $html .= '
                            <tr>
                                <td style="text-align:center;">'. $row['nombre_articulo'] .'</td>
                                <td style="text-align:right;">'. $row['nro_lote'] .'</td>
                                <td style="text-align:right;">'. $row['cantidad'] .'</td>
                                <td style="text-align:right;">'. $row['precio_venta'] .'</td>
                                <td style="text-align:right;">'. $subtotal .'</td>
                            </tr>';
                        }
                    $html .= '
                    <tr>
                        <td colspan="4" style="text-align:right;">Total:</td>
                        <td style="text-align:right;">'. $total .'</td>
                    </tr>
                </tbody>
                </table>
            </div>  
        </div>
    </div>
</article>';


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

?>