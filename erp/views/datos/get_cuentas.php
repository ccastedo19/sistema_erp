<?php
// Aquí debes incluir la conexión a tu base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'erp');

// Consulta para obtener todas las cuentas en una sola llamada
$id_empresa = $_GET['id_empresa'];

$sqlCuentas = "SELECT * FROM cuentas WHERE id_empresa_cuenta = $id_empresa";
$queryCuentas = mysqli_query($conexion, $sqlCuentas);

$cuentas = [];
while ($cuenta = mysqli_fetch_array($queryCuentas)) {
    $cuentas[] = $cuenta;
}

function buildTree(array $elements, $parentId = null) {
    $branch = [];

    foreach ($elements as $element) {
        if ($element['id_cuenta_padre'] == $parentId) {
            $children = buildTree($elements, $element['id_cuenta']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }

    return $branch;
}

$tree = buildTree($cuentas);

function cuentasToJsTree($cuentas, $isRoot = false) {
    $treeData = [];

    if ($isRoot) {
        $treeData[] = [
            'id' => 'root',
            'text' => 'Raíz',
            'children' => [],
            'data' => [
                'codigo' => '',
                'nombre_cuenta' => 'Raíz',
                'tipo_cuenta' => ''
            ],
            'state' => [
                'opened' => true
            ]
        ];
    }

    foreach ($cuentas as $cuenta) {
        $disabled = ($cuenta['tipo_cuenta'] === 'Detalle') ? true : false;

        $treeData[] = [
            'id' => $cuenta['id_cuenta'],
            'text' => $cuenta['codigo'] . ' ' . $cuenta['nombre_cuenta'],
            'children' => isset($cuenta['children']) ? cuentasToJsTree($cuenta['children']) : [],
            'data' => [
                'codigo' => $cuenta['codigo'],
                'nombre_cuenta' => $cuenta['nombre_cuenta'],
                'tipo_cuenta' => $cuenta['tipo_cuenta']
            ],
            'disabled' => $disabled,
            'state' => [
                'opened' => true
            ]
        ];
    }

    return $treeData;
}


$treeData = cuentasToJsTree($tree, true);

// Devolver los datos en formato JSON
echo json_encode($treeData);
?>
