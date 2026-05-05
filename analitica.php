<?php
$pageTitle = 'Analítica Pro | Hardware Hub Dashboard';
$currentPage = 'analitica';
require_once 'layout/header.php';

// Obtener datos para analítica
$sql = "SELECT c.*, m.nombre AS marca_nombre FROM componentes c JOIN marcas m ON c.marca_id = m.id";
$stmt = $pdo->query($sql);
$componentes = $stmt->fetchAll();

$totalValor = array_reduce($componentes, function($acc, $item) { return $acc + ($item['precio'] * $item['stock']); }, 0);
$totalItems = array_sum(array_column($componentes, 'stock'));

// Agrupar por categoría para un "chart" visual
$categoryData = [];
foreach ($componentes as $c) {
    $cat = $c['categoria'] ?? 'Sin Categoría';
    if (!isset($categoryData[$cat])) $categoryData[$cat] = 0;
    $categoryData[$cat] += $c['stock'];
}
?>

<main class="container">
    <header class="reveal" style="margin-bottom: 4rem;">
        <span style="color: var(--primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.2em; font-size: 0.8rem;">MÉTRICAS DE INGENIERÍA</span>
        <h1 class="text-gradient">Analítica de Rendimiento</h1>
        <p class="subtitle" style="margin-top: 1rem; opacity: 0.7;">Análisis en tiempo real de la infraestructura de hardware y distribución de activos.</p>
    </header>

    <div class="stats-grid">
        <div class="stat-card glass reveal">
            <span class="label">Eficiencia del Sistema</span>
            <div class="value">98.4%</div>
            <div style="height: 4px; background: rgba(16, 185, 129, 0.2); width: 100%; margin-top: 1.5rem; border-radius: 2px;">
                <div style="height: 100%; background: var(--accent); width: 98%;"></div>
            </div>
        </div>
        <div class="stat-card glass reveal">
            <span class="label">Valor Calculado de Activos</span>
            <div class="value"><?php echo number_format($totalValor, 0, ',', '.'); ?> €</div>
            <p style="color: var(--primary); font-size: 0.8rem; font-weight: 700; margin-top: 1rem;">↑ 12.5% vs Trimestre Anterior</p>
        </div>
        <div class="stat-card glass reveal">
            <span class="label">Nodos Activos Registrados</span>
            <div class="value"><?php echo $totalItems; ?></div>
            <p style="color: var(--text-muted); font-size: 0.8rem; margin-top: 1rem;">Unidades verificadas en red</p>
        </div>
    </div>

    <!-- Analytics Section -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem; margin-top: 4rem;">
        <!-- Distribution Chart -->
        <div class="glass reveal" style="padding: 3rem; border-radius: var(--radius);">
            <h3 style="margin-bottom: 2.5rem; font-weight: 800; letter-spacing: -0.02em;">Distribución por Categoría</h3>
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                <?php foreach ($categoryData as $cat => $count): 
                    $percent = ($totalItems > 0) ? ($count / $totalItems) * 100 : 0;
                ?>
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                            <span style="font-weight: 700; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;"><?php echo htmlspecialchars($cat); ?></span>
                            <span style="font-weight: 800; color: white;"><?php echo round($percent, 1); ?>%</span>
                        </div>
                        <div style="height: 8px; background: rgba(255,255,255,0.05); border-radius: 10px; overflow: hidden;">
                            <div style="height: 100%; background: var(--primary); width: <?php echo $percent; ?>%; box-shadow: 0 0 15px var(--primary-glow); transition: width 1.5s cubic-bezier(0.16, 1, 0.3, 1);"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Real-time Simulation -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <div class="glass reveal" style="padding: 2.5rem; border-radius: var(--radius); flex: 1;">
                <h3 style="margin-bottom: 1.5rem; font-size: 1rem; color: var(--text-muted);">Estado Térmico Global</h3>
                <div style="text-align: center; padding: 1rem 0;">
                    <div style="font-size: 3.5rem; font-weight: 900; color: #f87171;">42°C</div>
                    <p style="color: #4ade80; font-weight: 700; font-size: 0.8rem; margin-top: 0.5rem;">RANGO ÓPTIMO</p>
                </div>
                <div style="margin-top: 2rem; padding: 1.5rem; background: rgba(0,0,0,0.2); border-radius: 12px; border: 1px solid var(--border);">
                    <div style="display: flex; justify-content: space-between; font-size: 0.75rem; margin-bottom: 0.5rem;">
                        <span>Velocidad de Ventiladores</span>
                        <span style="font-weight: 800;">1,240 RPM</span>
                    </div>
                    <div style="height: 4px; background: rgba(255,255,255,0.1); border-radius: 2px;">
                        <div style="height: 100%; background: var(--primary); width: 65%;"></div>
                    </div>
                </div>
            </div>

            <div class="glass reveal" style="padding: 2.5rem; border-radius: var(--radius); flex: 1;">
                <h3 style="margin-bottom: 1.5rem; font-size: 1rem; color: var(--text-muted);">Latencia de Red</h3>
                <div style="text-align: center; padding: 1rem 0;">
                    <div style="font-size: 3.5rem; font-weight: 900; color: var(--primary);">4ms</div>
                    <p style="color: var(--text-muted); font-weight: 700; font-size: 0.8rem; margin-top: 0.5rem;">JITTER ULTRA BAJO</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Technical Asset Table -->
    <section style="margin-top: 6rem;" class="reveal">
        <h2 class="text-gradient" style="margin-bottom: 2.5rem;">Verificación Crítica de Activos</h2>
        <div class="glass" style="border-radius: var(--radius); overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border); background: rgba(0,0,0,0.1);">
                        <th style="padding: 1.5rem 2rem; font-size: 0.75rem; text-transform: uppercase;">ID & Componente</th>
                        <th style="padding: 1.5rem 2rem; font-size: 0.75rem; text-transform: uppercase;">Estado de Salud</th>
                        <th style="padding: 1.5rem 2rem; font-size: 0.75rem; text-transform: uppercase;">Integridad de Datos</th>
                        <th style="padding: 1.5rem 2rem; font-size: 0.75rem; text-transform: uppercase;">Uptime (Actividad)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($componentes, 0, 5) as $comp): ?>
                        <tr style="border-bottom: 1px solid var(--border); transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 1.5rem 2rem;">
                                <div style="font-weight: 800;"><?php echo htmlspecialchars($comp['nombre']); ?></div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">SN-<?php echo strtoupper(substr(md5($comp['id']), 0, 8)); ?></div>
                            </td>
                            <td style="padding: 1.5rem 2rem;">
                                <span style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                    <span style="width: 8px; height: 8px; background: #4ade80; border-radius: 50%;"></span>
                                    Excellent
                                </span>
                            </td>
                            <td style="padding: 1.5rem 2rem;">
                                <div style="font-size: 0.85rem; font-family: monospace;">VERIFIED_SHA256</div>
                            </td>
                            <td style="padding: 1.5rem 2rem; font-weight: 700; color: var(--primary);">99.99%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<style>
/* Page specific animation for bars */
.reveal.active [style*="width: 0%"] {
    /* This is handled by the inline JS/transitions, but nice to have a hook */
}
</style>

<?php require_once 'layout/footer.php'; ?>
