<?php
$pageTitle = 'Editar Registro Técnico | Hardware Hub Pro';
$currentPage = 'historial';
require_once 'layout/header.php';

$id = $_GET['id'] ?? 0;

// Obtener datos actuales del registro
$stmt = $pdo->prepare("SELECT * FROM mantenimientos WHERE id = ?");
$stmt->execute([$id]);
$log = $stmt->fetch();

if (!$log) {
    header("Location: historial.php");
    exit;
}

// Obtener componentes para el selector
$stmtItems = $pdo->query("SELECT id, nombre FROM componentes ORDER BY nombre ASC");
$componentes = $stmtItems->fetchAll();

// Procesar formulario de actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $componente_id = $_POST['componente_id'];
    $descripcion = $_POST['descripcion'];
    $tecnico = $_POST['tecnico'];
    $estado = $_POST['estado'];

    if (!empty($componente_id) && !empty($descripcion)) {
        try {
            $sql = "UPDATE mantenimientos SET componente_id = ?, descripcion = ?, tecnico = ?, estado = ? WHERE id = ?";
            $stmtUpdate = $pdo->prepare($sql);
            $stmtUpdate->execute([$componente_id, $descripcion, $tecnico, $estado, $id]);
            
            set_alert('Registro de mantenimiento actualizado correctamente.', 'success');
            header("Location: historial.php");
            exit;
        } catch (PDOException $e) {
            set_alert('Error técnico al actualizar el registro: ' . $e->getMessage(), 'error');
        }
    } else {
        set_alert('Por favor, complete todos los campos requeridos.', 'warning');
    }
}
?>

<main class="container">
    <header class="reveal" style="margin-bottom: 4rem;">
        <span style="color: var(--primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.2em; font-size: 0.8rem;">EDICIÓN DE SERVICIO</span>
        <h1 class="text-gradient">Editar Mantenimiento</h1>
    </header>

    <div class="glass reveal" style="max-width: 850px; margin: 0 auto; padding: 4rem; border-radius: var(--radius);">
        <form method="POST" style="display: flex; flex-direction: column; gap: 2.5rem;">
            <!-- Select Component -->
            <div class="form-group">
                <label class="form-label">Activo / Componente</label>
                <div class="input-group">
                    <i data-lucide="package"></i>
                    <select name="componente_id" required>
                        <?php foreach ($componentes as $comp): ?>
                            <option value="<?php echo $comp['id']; ?>" <?php echo ($log['componente_id'] == $comp['id']) ? 'selected' : ''; ?>>
                                [ID-<?php echo str_pad($comp['id'], 3, '0', STR_PAD_LEFT); ?>] <?php echo htmlspecialchars($comp['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Técnico & Estado Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem;">
                <div class="form-group">
                    <label class="form-label">Operador Técnico</label>
                    <div class="input-group">
                        <i data-lucide="user"></i>
                        <input type="text" name="tecnico" value="<?php echo htmlspecialchars($log['tecnico']); ?>" required placeholder="Nombre del técnico...">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Estado Post-Servicio</label>
                    <div class="input-group">
                        <i data-lucide="activity"></i>
                        <select name="estado" style="width: 100%; background: rgba(0,0,0,0.2); border: 1px solid var(--border); border-radius: 12px; padding: 1.2rem; color: white; outline: none;">
                            <option value="Completado" <?php echo ($log['estado'] == 'Completado') ? 'selected' : ''; ?>>✓ Completado</option>
                            <option value="Pendiente" <?php echo ($log['estado'] == 'Pendiente') ? 'selected' : ''; ?>>⚠ Pendiente / Revisión</option>
                            <option value="Fallo" <?php echo ($log['estado'] == 'Fallo') ? 'selected' : ''; ?>>✖ Fallo Crítico</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label class="form-label">Descripción técnica de la intervención</label>
                <div class="input-group">
                    <i data-lucide="file-text" style="align-self: flex-start; margin-top: 1.25rem;"></i>
                    <textarea name="descripcion" required><?php echo htmlspecialchars($log['descripcion']); ?></textarea>
                </div>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 1.5rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center; height: 3.5rem;">
                    <span>💾</span> Actualizar Registro
                </button>
                <a href="historial.php" class="btn btn-secondary" style="border: 1px solid var(--border); background: rgba(255,255,255,0.02); height: 3.5rem; display: flex; align-items: center; justify-content: center;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</main>

<?php require_once 'layout/footer.php'; ?>
