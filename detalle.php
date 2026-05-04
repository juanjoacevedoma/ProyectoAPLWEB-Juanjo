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

    <!-- Sección de Productos Relacionados (Sugerencia Pro) -->
    <section style="margin-top: 6rem;" class="reveal">
        <h2 style="font-size: 1.8rem; margin-bottom: 2rem;" class="text-gradient">Hardware Relacionado</h2>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem;">
            <?php for($i=0; $i<4; $i++): ?>
                <div class="glass-card glass" style="padding: 1.5rem; opacity: 0.5; cursor: not-allowed;">
                    <div style="width: 100%; aspect-ratio: 1; background: rgba(0,0,0,0.2); border-radius: 10px; margin-bottom: 1rem;"></div>
                    <div style="height: 10px; background: rgba(255,255,255,0.05); width: 80%; border-radius: 5px;"></div>
                </div>
            <?php endfor; ?>
        </div>
    </section>
</main>

<?php require_once 'layout/footer.php'; ?>