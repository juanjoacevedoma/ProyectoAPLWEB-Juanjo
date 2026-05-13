<?php
/**
 * PLANTILLA DE CONFIGURACIÓN - HARDWARE HUB PRO
 * Instrucciones:
 * 1. Renombrar este archivo a config.php
 * 2. Rellenar los datos de conexión con tus credenciales de base de datos local/servidor.
 */

// Parámetros de conexión
$host = "localhost";
$dbname = "catalogo_hardware"; // Cambiar por el nombre de tu BD
$user = "root";              // Tu usuario de BD (típicamente 'root' en local)
$pass = "";                  // Tu contraseña de BD

try {
    // Establecer conexión con charset utf8mb4 para compatibilidad total
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);

    // Configuración robusta de PDO (Pro Mode)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Gestión global de sesiones
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

} catch (PDOException $e) {
    // Si la conexión falla, detenemos la ejecución con un mensaje técnico
    die("Error crítico de base de datos: " . $e->getMessage());
}

// Inclusión obligatoria del módulo de funciones globales
require_once 'functions.php';
?>