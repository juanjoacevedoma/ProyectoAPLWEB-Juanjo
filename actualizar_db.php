<?php
require_once 'config.php';

echo "<h1>Actualización de Base de Datos</h1>";

try {
    // 1. Añadir columna categoria
    $pdo->exec("ALTER TABLE componentes ADD COLUMN categoria VARCHAR(100) DEFAULT 'Sin categoría' AFTER marca_id");
    echo "Columna 'categoria' añadida con éxito.<br>";
} catch (PDOException $e) {
    echo "Aviso: 'categoria' puede que ya exista. " . $e->getMessage() . "<br>";
}

try {
    // 2. Añadir columna imagen_url
    $pdo->exec("ALTER TABLE componentes ADD COLUMN imagen_url VARCHAR(500) DEFAULT NULL AFTER categoria");
    echo "Columna 'imagen_url' añadida con éxito.<br>";
} catch (PDOException $e) {
    echo "Aviso: 'imagen_url' puede que ya exista. " . $e->getMessage() . "<br>";
}

echo "<br><a href='index.php'>Volver al Inicio</a>";
?>
