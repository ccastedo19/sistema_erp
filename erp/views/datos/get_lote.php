<?php
// Conexión a la base de datos
$host = "localhost";
$db   = "erp";
$user = "root";
$pass = "";

$conexion = new mysqli($host, $user, $pass, $db);

// Intenta conectar a la base de datos y maneja cualquier error
$conexion = new mysqli($host, $user, $pass, $db);
if ($conexion->connect_error) {
    die("Error al conectar a la base de datos: " . $conexion->connect_error);
}

// Comprueba si este script fue invocado por una solicitud AJAX con un id_articulo
if (isset($_POST['id_articulo'])) {
    $id_articulo = $_POST['id_articulo'];

    // Realiza tu consulta
    $consulta = "SELECT * FROM lotes WHERE id_articulo_lote = $id_articulo";
    $resultados = $conexion->query($consulta);

    // Inicia tu tabla
    $tabla = "<table class='table tables'>";
    $tabla .= "<thead style='background-color:#5a5c69; color:#fff;'>
                        <tr>
                            <th scope='col'>#</th>
                            <th scope='col'>Fecha de Ingreso</th>
                            <th scope='col'>Fecha de Venc.</th>
                            <th scope='col'>Cantidad</th>
                            <th scope='col'>Stock</th>
                            <th scope='col'>Estado</th>
                        </tr>
                    </thead>";

    // Si no hay resultados, muestra un mensaje indicándolo
    if ($resultados->num_rows == 0) {
        $tabla .= "<tr><td colspan='7'>No hay registros</td></tr>";
    } else {
        $cont = 1;
        while ($fila = $resultados->fetch_assoc()) {
            // Crea un objeto DateTime a partir de la fecha de vencimiento y de ingreso
            $fechaVencimiento = new DateTime($fila['fecha_vencimiento']);
            $fechaIngreso = new DateTime($fila['fecha_ingreso']);
    
            // Comprueba si el año de las fechas es menor a 2000
            if ($fechaVencimiento->format('Y') < 2000) {
                $fechaFormateadaVencimiento = '';
            } else {
                $fechaFormateadaVencimiento = $fechaVencimiento->format('d/m/Y');
            }
    
            if ($fechaIngreso->format('Y') < 2000) {
                $fechaFormateadaIngreso = '';
            } else {
                $fechaFormateadaIngreso = $fechaIngreso->format('d/m/Y');
            }
            if ($fila['estado_lote'] == 0) {
                $estado = '<button style="background-color:#0F0F0F;border-color:#0F0F0F; width:7rem;font-family:Inherit" type="button" class="btn btn-dark">ANULADO</button>';
            } else if($fila['estado_lote'] == 1){
                $estado = '<button style="background-color:#1DBC26;border-color:#1DBC26;width:6rem;font-family:Inherit;cursor: default;color: #fff;outline: none;" type="button" class="btn btn-success">ACTIVO</button>';
            }else if($fila['estado_lote'] == 2){
                $estado = '<button style="background-color:#e74a3b;border-color:#e74a3b;width:6.5rem;font-family:Inherit;cursor: default;color: #fff;outline: none;" type="button" class="btn btn-success">AGOTADO</button>';
            }
    
            $subtotal = $fila['cantidad_lote'] * $fila['precio_compra'];
            $tabla .= "<tr>";
            $tabla .= "<td>" . $cont . "</td>";
            $tabla .= "<td>" . $fechaFormateadaIngreso . "</td>";
            $tabla .= "<td>" . $fechaFormateadaVencimiento . "</td>";
            $tabla .= "<td>" . $fila['cantidad_lote'] . "</td>";
            $tabla .= "<td>" . $fila['stock'] . "</td>";
            $tabla .= "<td>" . $estado . "</td>";
            $tabla .= "</tr>";
    
            $cont = $cont + 1;
        }
    }
    $tabla .= "</table>";
    

    // Imprime la tabla (esto se devolverá como respuesta AJAX)
    echo $tabla;
}
?>
