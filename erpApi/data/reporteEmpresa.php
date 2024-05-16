<?php
$conexion = mysqli_connect("localhost", "root", "", "erp");

// Verificar la conexión
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Consulta para obtener todos los registros de la tabla 'tu_tabla'
$sql = "SELECT sigla, nombre_empresa, nit, telefono, correo FROM empresas";
$resultado = mysqli_query($conexion, $sql);

// Verificar si la consulta se realizó correctamente
if (!$resultado) {
    die("Error al realizar la consulta: " . mysqli_error($conexion));
}

// Crear un array para almacenar los registros
$registros = [];

// Iterar sobre los resultados y guardar los datos en el array
while ($fila = mysqli_fetch_assoc($resultado)) {
    $registros[] = $fila;
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);

// Convertir el array a JSON
$json = json_encode($registros, JSON_PRETTY_PRINT);

// Mostrar el JSON
echo $json;