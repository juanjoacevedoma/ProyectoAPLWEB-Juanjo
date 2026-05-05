<?php
$pageTitle = 'Especificaciones Técnicas | Hardware Hub';
$currentPage = 'detalle';
require_once 'layout/header.php';

$id = $_GET['id'] ?? 0;

$sql = "SELECT c.*, m.nombre AS marca_nombre 
        FROM componentes c 
        JOIN marcas m ON c.marca_id = m.id 
        WHERE c.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$comp = $stmt->fetch();

if (!$comp) {
    header("Location: index.php");
    exit;
}
?>

<main class="container">
    <div style="margin-bottom: 3rem; display: flex; align-items: center; justify-content: space-between;" class="reveal">
        <a href="index.php" class="btn btn-secondary">
            <span>←</span> Volver al Catálogo
        </a>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span class="badge" style="background: rgba(255,255,255,0.05); color: var(--text-muted);">SKU: #<?php echo str_pad($comp['id'], 6, '0', STR_PAD_LEFT); ?></span>
            <span class="badge badge-brand"><?php echo htmlspecialchars($comp['categoria'] ?? 'Hardware'); ?></span>
        </div>
    </div>

    <div class="glass-card glass reveal" style="padding: 0; overflow: hidden;">
        <div style="display: grid; grid-template-columns: 1fr 1.2fr;">
            
            <!-- Galería Pro -->
            <div style="background: rgba(0,0,0,0.3); padding: 4rem; display: flex; align-items: center; justify-content: center; border-right: 1px solid var(--border);">
                <div style="width: 100%; aspect-ratio: 1; border-radius: 20px; overflow: hidden; box-shadow: 0 30px 60px rgba(0,0,0,0.5); border: 1px solid var(--border);">
                    <?php if (!empty($comp['imagen_url'])): ?>
                        <img src="<?php echo htmlspecialchars($comp['imagen_url']); ?>" alt="<?php echo htmlspecialchars($comp['nombre']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; background: var(--bg-alt);">
                            <div style="font-size: 5rem; margin-bottom: 2rem; opacity: 0.2;">🖼️</div>
                            <p style="font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">Sin Visualización</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Información Técnica -->
            <div style="padding: 5rem;">
                <div style="margin-bottom: 2rem;">
                    <p style="color: var(--primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.2em; font-size: 0.85rem; margin-bottom: 1rem;">
                        <?php echo htmlspecialchars($comp['marca_nombre']); ?> high performance
                    </p>
                    <h1 class="text-gradient" style="font-size: 3.5rem; line-height: 1.1; margin-bottom: 1.5rem;">
                        <?php echo htmlspecialchars($comp['nombre']); ?>
                    </h1>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 3rem; padding: 2rem 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">Precio de Mercado</label>
                        <p style="font-size: 2.5rem; font-weight: 900; color: white;">
                            <?php echo number_format($comp['precio'], 2, ',', '.'); ?> <span style="font-size: 1.2rem; font-weight: 500; color: var(--text-muted);">€</span>
                        </p>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">Estado de Stock</label>
                        <?php 
                            $stockColor = $comp['stock'] > 5 ? '#4ade80' : ($comp['stock'] > 0 ? '#fbbf24' : '#f87171');
                            $stockLabel = $comp['stock'] > 0 ? $comp['stock'] . ' Unidades Disponibles' : 'Agotado Temporalmente';
                        ?>
                        <p style="font-size: 1.1rem; font-weight: 700; color: <?php echo $stockColor; ?>; display: flex; align-items: center; gap: 0.5rem; margin-top: 1rem;">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: <?php echo $stockColor; ?>; box-shadow: 0 0 10px <?php echo $stockColor; ?>;"></span>
                            <?php echo $stockLabel; ?>
                        </p>
                    </div>
                </div>

                <div style="margin-bottom: 3rem;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1.5rem;">Descripción y Notas Técnicas</label>
                    <div style="color: #cbd5e1; font-size: 1.05rem; line-height: 1.8; background: rgba(255,255,255,0.02); padding: 2rem; border-radius: 12px; border: 1px solid var(--border);">
                        <?php echo nl2br(htmlspecialchars($comp['descripcion'])); ?>
                    </div>
                </div>

                <div style="display: flex; gap: 1.5rem;">
                    <button class="btn btn-primary" style="flex: 2; height: 65px; justify-content: center; font-size: 1rem;">
                        <span>🛒</span> Gestionar Pedido
                    </button>
                    <button class="btn btn-secondary" style="flex: 1; height: 65px; justify-content: center;">
                        <span>📊</span> Reporte
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Mantenimiento y Logs -->
    <?php
    $sqlLogs = "SELECT * FROM mantenimientos WHERE componente_id = ? ORDER BY fecha DESC";
    $stmtLogs = $pdo->prepare($sqlLogs);
    $stmtLogs->execute([$id]);
    $logsComp = $stmtLogs->fetchAll();
    ?>
    <section style="margin-top: 6rem;" class="reveal">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
            <h2 style="font-size: 2.2rem;" class="text-gradient">Bitácora de Servicio</h2>
            <a href="registrar_mantenimiento.php?componente_id=<?php echo $id; ?>" class="btn btn-primary" style="padding: 1rem 2rem;">
                <span>🛠️</span> Registrar Revisión
            </a>
        </div>

        <div class="glass" style="border-radius: var(--radius); overflow: hidden;">
            <?php if (count($logsComp) > 0): ?>
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border); background: rgba(0,0,0,0.1);">
                            <th style="padding: 1.5rem 2rem; font-size: 0.75rem; text-transform: uppercase;">Intervención / Descripción</th>
                            <th style="padding: 1.5rem 2rem; font-size: 0.75rem; text-transform: uppercase;">Estado</th>
                            <th style="padding: 1.5rem 2rem; font-size: 0.75rem; text-transform: uppercase;">Metadatos Técnicos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logsComp as $log): ?>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="padding: 1.5rem 2rem;">
                                    <div style="font-weight: 700; color: white;"><?php echo htmlspecialchars($log['descripcion']); ?></div>
                                </td>
                                <td style="padding: 1.5rem 2rem;">
                                    <span style="font-size: 0.7rem; font-weight: 800; padding: 0.3rem 0.7rem; border-radius: 6px; 
                                        <?php 
                                            if($log['estado'] == 'Completado') echo 'background: rgba(16, 185, 129, 0.15); color: #4ade80;';
                                            elseif($log['estado'] == 'Pendiente') echo 'background: rgba(245, 158, 11, 0.15); color: #fbbf24;';
                                            else echo 'background: rgba(239, 68, 68, 0.15); color: #f87171;';
                                        ?>">
                                        <?php echo $log['estado']; ?>
                                    </span>
                                </td>
                                <td style="padding: 1.5rem 2rem;">
                                    <div style="font-size: 0.75rem; color: var(--text-muted); font-family: monospace;">TÉCNICO: <?php echo htmlspecialchars($log['tecnico']); ?></div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted); font-family: monospace;"><?php echo date('d/m/Y H:i', strtotime($log['fecha'])); ?></div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="padding: 4rem; text-align: center; color: var(--text-muted);">
                    <p>No hay intervenciones técnicas registradas para este activo.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Sección de Productos Relacionados -->
</main>

<?php require_once 'layout/footer.php'; ?>