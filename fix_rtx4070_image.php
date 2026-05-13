<?php
require_once 'config.php';

// Nueva URL para la RTX 4070 SUPER (ID 5)
$nueva_url = 'https://images.unsplash.com/photo-1624701928517-44c8ac49d93c?q=80&w=1000&auto=format&fit=crop';

echo "<h2>Actualizando imagen de RTX 4070 SUPER...</h2>";

try {
    $stmt = $pdo->prepare("UPDATE componentes SET imagen_url = ? WHERE id = 5");
    $stmt->execute([$nueva_url]);
    
    echo "<strong style='color: green;'>¡Actualizado con éxito!</strong>";
    echo "<p><a href='index.php'>Volver al inicio</a></p>";
    
} catch (PDOException $e) {
    echo "<strong style='color: red;'>Error: " . $e->getMessage() . "</strong>";
}
?>
