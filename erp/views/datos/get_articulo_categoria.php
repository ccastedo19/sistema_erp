<?php
// Conexión
$conexion = mysqli_connect('localhost', 'root', '', 'erp');

// Obtener el ID del artículo de los datos POST
$id_articulo = $_POST['id_articulo'];

// Consulta para obtener las categorías del artículo
$sql = "SELECT id_categoria_ca FROM articulo_categorias WHERE id_articulo_ca = $id_articulo";
$result = mysqli_query($conexion, $sql);

// Crear un array para almacenar los ID de las categorías
$categorias = array();

// Recorrer los resultados y añadir los ID de las categorías al array
while ($row = mysqli_fetch_assoc($result)) {
    $categorias[] = $row['id_categoria_ca'];
}

// Devolver los ID de las categorías en formato JSON
echo json_encode($categorias);
?>
