<?php
/**
 * Configuración de la base de datos y utilidades globales
 */

// Datos de conexión
$host = "localhost";
$dbname = "catalogo_hardware";
$user = "root";
$pass = "";

try {
    // Establecer conexión con charset adecuado
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);

    // Configurar el modo de error de PDO para que lance excepciones (Pro Mode)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Configurar el modo de obtención predeterminado a array asociativo
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Iniciar sesión globalmente
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

} catch (PDOException $e) {
    // En producción no deberíamos mostrar el error detallado, pero aquí es útil para depurar
    die("Error crítico de base de datos: " . $e->getMessage());
}

// Incluir funciones auxiliares
require_once 'functions.php';
?>