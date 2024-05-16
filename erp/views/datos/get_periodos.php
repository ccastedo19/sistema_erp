<?php
$conexion = mysqli_connect('localhost', 'root', '', 'erp');

$id_gestion = $_POST['id_gestion'];

$qry = "SELECT id_periodo, nombre_periodo FROM periodos WHERE id_gestion_periodo = $id_gestion";

$result = mysqli_query($conexion, $qry);

if (mysqli_num_rows($result) == 0) {?>
    <span style="color:#fff;font-size:20px;" >No se encontraron resultados de Periodos en la empresa,<br>por lo tanto no es posible relizar un reporte del Balance Inicial</span>
    <style>
        .ContainerGestion, .txtPeriodo, .ContainerMoneda, .botonBalance, #Selectperiodo{
            display:none;
        }
    </style>
    <?php
    
}

$cadena = "<span class='textBalance txtPeriodo'>Seleccionar Periodo</span>
            <select class='form-control' id='Selectperiodo' name='Selectperiodo'>
            <option value='0'>Todos los Periodos</option>";
                
while ($ver = mysqli_fetch_assoc($result)) {
    $cadena = $cadena . '<option value=' . $ver['id_periodo'] . '>' . utf8_encode($ver['nombre_periodo']) . '</option>';
}

echo $cadena . "</select>";
?>
