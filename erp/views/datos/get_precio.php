<?php
$conexion = mysqli_connect('localhost', 'root', '', 'erp');

$id_articulo = $_POST['id_articulo'];
$query = "SELECT precio_venta FROM articulos WHERE id_articulo = '$id_articulo'";
$resultado = mysqli_query($conexion, $query);
$fila = mysqli_fetch_assoc($resultado);
echo $fila['precio_venta'];
?>
