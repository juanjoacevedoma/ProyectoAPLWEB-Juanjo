<?php
require_once 'config.php';
$stmt = $pdo->query("SELECT id, nombre, imagen_url FROM componentes");
$res = $stmt->fetchAll();
header('Content-Type: application/json');
echo json_encode($res, JSON_PRETTY_PRINT);
?>
