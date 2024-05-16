
<?php
$conexion = mysqli_connect('localhost', 'root', '', 'erp');

$id_empresa = $_GET['id_empresa'];

$sqlCategorias = "SELECT * FROM categorias WHERE id_empresa_categoria = $id_empresa";
$queryCategorias = mysqli_query($conexion, $sqlCategorias);

$categorias = [];
while ($categoria = mysqli_fetch_array($queryCategorias)) {
    $categorias[] = $categoria;
}

function buildTree(array $elements, $parentId = null) {
    $branch = [];

    foreach ($elements as $element) {
        if ($element['id_categoria_padre'] == $parentId) {
            $children = buildTree($elements, $element['id_categoria']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }
    
    return $branch;
}

$tree = buildTree($categorias);

function categoriasToJsTree($categorias, $isRoot = false) {
    $treeData = [];

    if ($isRoot) {
        $treeData[] = [
            'id' => 'root',
            'text' => 'Raíz',
            'children' => [],
            'data' => [
                'nombre_categoria' => 'Raíz',
                'descripcion_categoria' => '',  // No hay descripción para el nodo raíz
            ],
            'state' => [
                'opened' => true
            ]
        ];
    }

    foreach ($categorias as $categoria) {
        $treeData[] = [
            'id' => $categoria['id_categoria'],
            'text' => $categoria['nombre_categoria'],
            'children' => isset($categoria['children']) ? categoriasToJsTree($categoria['children']) : [],
            'data' => [
                'nombre_categoria' => $categoria['nombre_categoria'],
                'descripcion_categoria' => $categoria['descripcion_categoria'], // Añade descripción de la categoría
            ],
            'state' => [
                'opened' => true
            ],
        ];
    }
    

    return $treeData;
}

$treeData = categoriasToJsTree($tree, true);

echo json_encode($treeData);
