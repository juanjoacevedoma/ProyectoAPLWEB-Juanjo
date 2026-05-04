<?php
require_once 'config.php';

try {
    // Crear tabla de usuarios
    $sql = "CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        nombre VARCHAR(100),
        email VARCHAR(100) UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);

    // Insertar usuario administrativo por defecto si no existe
    $username = 'admin';
    $password = password_hash('admin123', PASSWORD_DEFAULT);
    
    $check = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = ?");
    $check->execute([$username]);
    
    if (!$check->fetch()) {
        $insert = $pdo->prepare("INSERT INTO usuarios (usuario, password, nombre, email) VALUES (?, ?, 'Administrador Pro', 'admin@hardwarehub.pro')");
        $insert->execute([$username, $password]);
        echo "Base de Datos actualizada: Usuario 'admin' creado con éxito.\n";
    } else {
        echo "Base de Datos ya estaba actualizada.\n";
    }

} catch (PDOException $e) {
    die("Error en la migración: " . $e->getMessage());
}
?>
