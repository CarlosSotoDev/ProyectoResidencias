<?php
include('../../includes/config.php');

$id_proyecto = $_GET['id_proyecto'];

// Consulta para obtener los integrantes del proyecto
$query = "SELECT Integrante_1, Integrante_2, Integrante_3 FROM proyecto WHERE ID_Proyecto = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param('i', $id_proyecto);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Crear un array para los integrantes
$integrantes = [];

if ($row['Integrante_1']) {
    $integrantes[] = ['id' => 'Integrante_1', 'nombre' => 'Integrante 1'];  // Aquí puedes ajustar según el nombre real
}
if ($row['Integrante_2']) {
    $integrantes[] = ['id' => 'Integrante_2', 'nombre' => 'Integrante 2'];
}
if ($row['Integrante_3']) {
    $integrantes[] = ['id' => 'Integrante_3', 'nombre' => 'Integrante 3'];
}

echo json_encode($integrantes);
?>
