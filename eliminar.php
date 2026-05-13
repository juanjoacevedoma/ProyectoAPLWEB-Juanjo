<?php
require_once 'config.php';
require_auth();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $sql = "DELETE FROM componentes WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        if ($stmt->rowCount() > 0) {
            set_alert("El componente ha sido eliminado definitivamente.", "success");
        } else {
            set_alert("No se encontró el registro para eliminar.", "error");
        }
    } catch (PDOException $e) {
        set_alert("Error al eliminar: " . $e->getMessage(), "error");
    }
}

header("Location: index.php");
exit;
?>
