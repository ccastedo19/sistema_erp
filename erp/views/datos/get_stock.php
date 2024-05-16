<?php
$conexion = mysqli_connect('localhost', 'root', '', 'erp');

$id_articulo = $_POST['id_articulo'];
$id_lote = $_POST['id_lote'];

$sql = "SELECT stock FROM lotes WHERE id_articulo_lote = $id_articulo AND id_lote = $id_lote";

$run = $conexion -> query($sql);
if($run -> num_rows > 0 ){
    while($row = $run -> fetch_assoc()){
        $stock = $row['stock'];
    }
} 

echo json_encode($stock);
?>
