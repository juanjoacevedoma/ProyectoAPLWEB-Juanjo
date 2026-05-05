<?php
$pageTitle = 'Historial de Mantenimiento | Hardware Hub Pro';
$currentPage = 'historial';
require_once 'layout/header.php';

// Obtener historial completo
$sql = "SELECT m.*, c.nombre AS componente_nombre, c.imagen_url 
        FROM mantenimientos m 
        JOIN componentes c ON m.componente_id = c.id 
        ORDER BY m.fecha DESC";
$stmt = $pdo->query($sql);
$historial = $stmt->fetchAll();
?>

<main class="container">
    <header class="reveal" style="margin-bottom: 4rem; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <span style="color: var(--primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.2em; font-size: 0.8rem;">REGISTROS DE SERVICIO</span>
            <h1 class="text-gradient">Historial Técnico</h1>
        </div>
        <a href="registrar_mantenimiento.php" class="btn btn-primary">
            <span>🛠️</span> Registrar Nuevo Servicio
        </a>
    </header>

    <?php if (count($historial) > 0): ?>
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <?php foreach ($historial as $log): ?>
                <div class="glass reveal" style="padding: 1.5rem 2rem; border-radius: var(--radius); display: grid; grid-template-columns: 80px 1fr 150px 150px 100px; align-items: center; gap: 2rem;">
                    <!-- Component Mini View -->
                    <div style="width: 60px; height: 60px; border-radius: 12px; background: rgba(0,0,0,0.2); overflow: hidden; border: 1px solid var(--border);">
                        <?php if (!empty($log['imagen_url'])): ?>
                            <img src="<?php echo htmlspecialchars($log['imagen_url']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">🔌</div>
                        <?php endif; ?>
                    </div>

                    <!-- Details -->
                    <div>
                        <div style="font-weight: 800; color: white;"><?php echo htmlspecialchars($log['componente_nombre']); ?></div>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.4rem; line-height: 1.4;"><?php echo htmlspecialchars($log['descripcion']); ?></p>
                    </div>

                    <!-- Meta -->
                    <div>
                        <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Técnico</div>
                        <div style="font-weight: 700; color: var(--primary); font-size: 0.85rem;"><?php echo htmlspecialchars($log['tecnico']); ?></div>
                    </div>

                    <!-- Status & Date -->
                    <div style="text-align: right;">
                        <span style="display: inline-block; padding: 0.3rem 0.7rem; border-radius: 6px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; 
                            <?php 
                                if($log['estado'] == 'Completado') echo 'background: rgba(16, 185, 129, 0.15); color: #4ade80;';
                                elseif($log['estado'] == 'Pendiente') echo 'background: rgba(245, 158, 11, 0.15); color: #fbbf24;';
                                else echo 'background: rgba(239, 68, 68, 0.15); color: #f87171;';
                            ?>">
                            <?php echo $log['estado']; ?>
                        </span>
                        <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 0.5rem; font-family: monospace;">
                            <?php echo date('d/m/Y H:i', strtotime($log['fecha'])); ?>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="text-align: right; display: flex; gap: 0.5rem; justify-content: flex-end;">
                        <a href="editar_mantenimiento.php?id=<?php echo $log['id']; ?>" class="btn-icon" style="background: rgba(99, 102, 241, 0.1); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.2); width: 40px; height: 40px; border-radius: 8px; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; text-decoration: none;" title="Editar Registro">
                            ✏️
                        </a>
                        <button onclick="confirmarBorrado(<?php echo $log['id']; ?>)" class="btn-icon" style="background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); width: 40px; height: 40px; border-radius: 8px; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;" title="Eliminar Registro">
                            🗑️
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="glass reveal" style="padding: 8rem 0; text-align: center; border-radius: var(--radius);">
            <div style="font-size: 4rem; margin-bottom: 2rem; opacity: 0.3;">📋</div>
            <h2 style="color: var(--text-muted);">Sin registros de mantenimiento</h2>
            <p style="margin-top: 1rem; opacity: 0.5;">Inicie su primer registro para comenzar el seguimiento de salud.</p>
            <a href="registrar_mantenimiento.php" class="btn btn-primary" style="margin-top: 2rem;">Registrar Evento Técnico</a>
        </div>
    <?php endif; ?>
</main>

<script>
function confirmarBorrado(id) {
    Swal.fire({
        title: '¿Eliminar registro?',
        text: "Esta acción no se puede deshacer en el historial técnico.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: 'rgba(255,255,255,0.1)',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        background: '#0f172a',
        color: '#ffffff'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'eliminar_mantenimiento.php?id=' + id;
        }
    })
}
</script>

<?php require_once 'layout/footer.php'; ?>
