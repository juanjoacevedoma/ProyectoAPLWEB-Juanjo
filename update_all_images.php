<?php
require_once 'config.php';

// URLs de imágenes profesionales (Directas y de alta compatibilidad)
$imagenes = [
    1 => 'https://img.freepik.com/foto-gratis/primer-plano-placa-base-circuito-impreso-detalles_169016-11880.jpg', // Placa Base
    3 => 'https://img.freepik.com/foto-gratis/primer-plano-tecnologia-tarjeta-video-gpu_23-2149150337.jpg', // GPU
    4 => 'https://img.freepik.com/foto-gratis/raton-optico-teclado_23-2148116345.jpg', // Ratón
    5 => 'https://img.freepik.com/foto-gratis/tarjeta-video-computadora-aislada_23-2149150338.jpg', // GPU 2
    7 => 'https://img.freepik.com/foto-gratis/microchip-procesador-primer-plano-tecnologia-ia_23-2150361304.jpg' // CPU
];

echo "<h2>Aplicando imágenes de alta fiabilidad...</h2>";

try {
    $stmt = $pdo->prepare("UPDATE componentes SET imagen_url = ? WHERE id = ?");
    
    foreach ($imagenes as $id => $url) {
        $stmt->execute([$url, $id]);
        echo "✅ Activo #$id actualizado.<br>";
    }
    
    echo "<br><strong style='color: #4ade80;'>¡Listo! Estas imágenes deberían cargar sin problemas.</strong>";
    echo "<p><a href='index.php' style='padding: 10px 20px; background: #6366f1; color: white; text-decoration: none; border-radius: 5px;'>Ver Resultados</a></p>";
    
} catch (PDOException $e) {
    echo "<strong style='color: #ef4444;'>Error: " . $e->getMessage() . "</strong>";
}
?>
