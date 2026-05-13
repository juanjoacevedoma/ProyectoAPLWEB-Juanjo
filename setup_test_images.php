<?php
require_once 'config.php';

// URLs de imágenes de prueba (Unsplash Hardware)
$imagenes = [
    1 => 'https://images.unsplash.com/photo-1555617766-c94804975da3?q=80&w=1000&auto=format&fit=crop', // Placa Base
    3 => 'https://images.unsplash.com/photo-1591488320449-011701bb6704?q=80&w=1000&auto=format&fit=crop', // GPU 4060 Ti
    4 => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?q=80&w=1000&auto=format&fit=crop', // Mouse
    5 => 'https://images.unsplash.com/photo-1597334751726-259160538804?q=80&w=1000&auto=format&fit=crop', // GPU 4070 Super
    7 => 'https://images.unsplash.com/photo-1591405351990-4726e331f141?q=80&w=1000&auto=format&fit=crop'  // CPU
];

echo "<h2>Actualizando imágenes de componentes...</h2>";

try {
    $stmt = $pdo->prepare("UPDATE componentes SET imagen_url = ? WHERE id = ?");
    
    foreach ($imagenes as $id => $url) {
        $stmt->execute([$url, $id]);
        echo "Componente ID: $id actualizado.<br>";
    }
    
    echo "<br><strong style='color: green;'>¡Éxito! Todas las imágenes han sido vinculadas.</strong>";
    echo "<p><a href='index.php'>Volver al inicio</a></p>";
    
} catch (PDOException $e) {
    echo "<strong style='color: red;'>Error al actualizar: " . $e->getMessage() . "</strong>";
}
?>
