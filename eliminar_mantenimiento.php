<?php
require_once 'config.php';
require_auth();

$id = $_GET['id'] ?? 0;

if ($id > 0) {
    try {
        $sql = "DELETE FROM mantenimientos WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        set_alert('Registro técnico eliminado correctamente.', 'success');
    } catch (PDOException $e) {
        set_alert('Error al eliminar el registro: ' . $e->getMessage(), 'error');
    }
}

header("Location: historial.php");
exit;
?>
