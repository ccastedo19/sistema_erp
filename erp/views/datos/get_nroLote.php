<?php
// Conexión a la base de datos
$host = "localhost";
$db   = "erp";
$user = "root";
$pass = "";

// Intenta conectar a la base de datos y maneja cualquier error
$conexion = new mysqli($host, $user, $pass, $db);
if ($conexion->connect_error) {
    die("Error al conectar a la base de datos: " . $conexion->connect_error);
}
// El id del artículo lo obtienes desde los datos enviados por la petición AJAX
$id_articulo = $_POST['id_articulo'];

// Consulta para obtener los números de lote correspondientes al id del artículo
$query = "SELECT id_lote,nro_lote FROM lotes WHERE id_articulo_lote = '$id_articulo' AND estado_lote = 1";

// Ejecutas la consulta
$resultado = mysqli_query($conexion, $query);

// Compruebas si se encontraron resultados
if(mysqli_num_rows($resultado) > 0){
    // Si se encontraron resultados, generas las opciones del elemento select
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $nro_lote = $fila['nro_lote'];
        $id_lote = $fila['id_lote'];
        echo "<option value='$id_lote'>$nro_lote</option>";
    }
} else {
    // Si no se encontraron resultados, añades una opción indicándolo
    echo "<option value=''>Sin resultados</option>";
}
?>
