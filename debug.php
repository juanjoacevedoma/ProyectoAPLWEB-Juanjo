<?php
/**
 * Script de Diagnóstico para Hardware Hub
 * Ejecuta este archivo en tu navegador (http://localhost/ProyectoAPLWEB-Juanjo/debug.php)
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Diagnóstico de Backend</h1>";

// 1. Verificar PHP y Extensiones
echo "<h2>1. Entorno PHP</h2>";
echo "Versión de PHP: " . phpversion() . "<br>";
echo "Extensión PDO MySQL: " . (extension_loaded('pdo_mysql') ? "✅ Cargada" : "❌ NO CARGADA") . "<br>";
echo "Sesiones activas: " . (session_status() !== PHP_SESSION_DISABLED ? "✅ Sí" : "❌ NO") . "<br>";

// 2. Verificar Archivos Críticos
echo "<h2>2. Archivos del Proyecto</h2>";
$files = ['config.php', 'functions.php', 'index.php', 'nuevo.php', 'styles.css'];
foreach ($files as $file) {
    echo "Archivo $file: " . (file_exists($file) ? "✅ Encontrado" : "❌ NO ENCONTRADO") . "<br>";
}

// 3. Verificar Conexión y Base de Datos
echo "<h2>3. Base de Datos</h2>";
require_once 'config.php';

try {
    echo "Conexión a MySQL: ✅ Exitosa<br>";
    
    // Verificar si la base de datos es la correcta
    $stmt = $pdo->query("SELECT DATABASE()");
    $current_db = $stmt->fetchColumn();
    echo "Base de Datos actual: <strong>$current_db</strong><br>";

    // Verificar Tablas
    $tables = ['marcas', 'componentes'];
    foreach ($tables as $table) {
        try {
            $pdo->query("SELECT 1 FROM $table LIMIT 1");
            echo "Tabla '$table': ✅ Existe<br>";
            
            if ($table == 'marcas') {
                $count = $pdo->query("SELECT COUNT(*) FROM marcas")->fetchColumn();
                echo "- Registros en marcas: $count " . ($count > 0 ? "✅" : "⚠️ (Deberías tener al menos una marca)") . "<br>";
            }
        } catch (Exception $e) {
            echo "Tabla '$table': ❌ NO EXISTE o error: " . $e->getMessage() . "<br>";
        }
    }

} catch (Exception $e) {
    echo "Conexión a MySQL: ❌ FALLIDA<br>";
    echo "Error: " . $e->getMessage() . "<br>";
    echo "<p style='color: red;'>Asegúrate de que MySQL esté encendido en XAMPP y que hayas importado el archivo 'database.sql'.</p>";
}

echo "<h2>4. Sugerencia de Solución</h2>";
echo "<p>Si las tablas no existen, abre <strong>phpMyAdmin</strong> e importa el archivo <strong>database.sql</strong> que está en tu carpeta del proyecto.</p>";
?>
