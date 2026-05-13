<?php
$pageTitle = 'Registrar Evento Técnico | Hardware Hub Pro';
$currentPage = 'historial';
require_once 'layout/header.php';
require_auth();

// Obtener componentes para el selector
$stmt = $pdo->query("SELECT id, nombre FROM componentes ORDER BY nombre ASC");
$componentes = $stmt->fetchAll();

$selected_component_id = $_GET['componente_id'] ?? '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $componente_id = $_POST['componente_id'];
    $descripcion = $_POST['descripcion'];
    $tecnico = $_POST['tecnico'] ?? 'Admin Juanjo';
    $estado = $_POST['estado'] ?? 'Completado';

    if (!empty($componente_id) && !empty($descripcion)) {
        try {
            $sql = "INSERT INTO mantenimientos (componente_id, descripcion, tecnico, estado) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$componente_id, $descripcion, $tecnico, $estado]);
            
            set_alert('Evento de mantenimiento registrado con éxito.', 'success');
            header("Location: historial.php");
            exit;
        } catch (PDOException $e) {
            set_alert('Error técnico al registrar el evento: ' . $e->getMessage(), 'error');
        }
    } else {
        set_alert('Por favor, complete todos los campos requeridos.', 'warning');
    }
}
?>

<main class="container">
    <header class="reveal" style="margin-bottom: 4rem;">
        <span style="color: var(--primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.2em; font-size: 0.8rem;">REGISTRO DE SERVICIO</span>
        <h1 class="text-gradient">Nuevo Mantenimiento</h1>
    </header>

    <div class="glass reveal" style="max-width: 850px; margin: 0 auto; padding: 4rem; border-radius: var(--radius);">
        <form method="POST" style="display: flex; flex-direction: column; gap: 2.5rem;">
            <!-- Select Component -->
            <div class="form-group">
                <label class="form-label">Activo / Componente</label>
                <div class="input-group">
                    <i data-lucide="package"></i>
                    <select name="componente_id" required>
                        <option value="" disabled <?php echo empty($selected_component_id) ? 'selected' : ''; ?>>Seleccione el componente...</option>
                        <?php foreach ($componentes as $comp): ?>
                            <option value="<?php echo $comp['id']; ?>" <?php echo ($selected_component_id == $comp['id']) ? 'selected' : ''; ?>>
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
                        <input type="text" name="tecnico" value="" required placeholder="Nombre del técnico...">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Estado Post-Servicio</label>
                    <div class="input-group">
                        <i data-lucide="activity"></i>
                        <select name="estado">
                            <option value="Completado">✓ Completado</option>
                            <option value="Pendiente">⚠ Pendiente / Revisión</option>
                            <option value="Fallo">✖ Fallo Crítico</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label class="form-label">Descripción técnica de la intervención</label>
                <div class="input-group">
                    <i data-lucide="file-text" style="align-self: flex-start; margin-top: 1.25rem;"></i>
                    <textarea name="descripcion" required placeholder="Detalle las acciones realizadas, diagnósticos o piezas cambiadas..."></textarea>
                </div>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 1.5rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center; height: 3.5rem;">
                    <span>💾</span> Guardar Registro
                </button>
                <a href="historial.php" class="btn btn-secondary" style="border: 1px solid var(--border); background: rgba(255,255,255,0.02); height: 3.5rem; display: flex; align-items: center; justify-content: center;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</main>

<?php require_once 'layout/footer.php'; ?>
