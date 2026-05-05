<?php
$pageTitle = 'Panel de Control Juanjo | Hardware Hub Pro';
$currentPage = 'index';
require_once 'layout/header.php';

// Obtener datos maestros
$sql = "SELECT c.*, m.nombre AS marca_nombre 
        FROM componentes c 
        JOIN marcas m ON c.marca_id = m.id 
        ORDER BY c.id DESC";
$stmt = $pdo->query($sql);
$componentes = $stmt->fetchAll();

// Estadísticas Pro
$totalValor = array_reduce($componentes, function ($acc, $item) {
    return $acc + ($item['precio'] * $item['stock']);
}, 0);
$totalStock = array_sum(array_column($componentes, 'stock'));
$categoriasArr = array_values(array_unique(array_filter(array_column($componentes, 'categoria'))));
$numCategorias = count($categoriasArr);
sort($categoriasArr);
?>

<main class="container">
    <!-- Dashboard Header -->
    <header class="header-meta reveal"
        style="margin-bottom: 5rem; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <span
                style="color: var(--primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.2em; font-size: 0.8rem;">SISTEMA
                DE CONTROL DE ACTIVOS</span>
            <h1 class="text-gradient">Inicio</h1>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="nuevo.php" class="btn btn-primary">
                <span>➕</span> Registrar Nuevo Activo
            </a>
        </div>
    </header>

    <!-- Resumen Analítico -->
    <div class="stats-grid reveal">
        <div class="stat-card glass">
            <span class="label">Valor Total del Inventario</span>
            <div class="value"><?php echo number_format($totalValor, 0, ',', '.'); ?> €</div>
            <div
                style="height: 4px; background: rgba(99, 102, 241, 0.2); width: 100%; margin-top: 1.5rem; border-radius: 2px; overflow: hidden;">
                <div style="height: 100%; background: var(--primary); width: 85%;"></div>
            </div>
        </div>
        <div class="stat-card glass">
            <span class="label">Unidades en Existencia</span>
            <div class="value"><?php echo number_format($totalStock, 0, ',', '.'); ?></div>
            <p style="color: #4ade80; font-size: 0.8rem; font-weight: 700; margin-top: 1rem;">● Operativo</p>
        </div>
        <div class="stat-card glass">
            <span class="label">Tipos de Categorías</span>
            <div class="value"><?php echo $numCategorias; ?></div>
            <p style="color: var(--text-muted); font-size: 0.8rem; margin-top: 1rem;">Diversificación de catálogo</p>
        </div>
    </div>

    <!-- Barra de Herramientas Premium -->
    <div class="search-container reveal" style="margin-bottom: 3rem;">
        <div style="display: flex; flex: 1; align-items: center; padding-left: 1.5rem;">
            <span style="font-size: 1.2rem;">🔍</span>
            <input type="text" id="searchInput" class="search-input"
                placeholder="Buscar por nombre, fabricante o SKU...">
        </div>
        <div style="width: 1px; background: var(--border); margin: 0.5rem 0;"></div>
        <select id="filterCategory"
            style="background: transparent; border: none; color: white; padding: 0 2rem; font-weight: 600; cursor: pointer; outline: none;">
            <option value="all">Todas las Categorías</option>
            <?php foreach ($categoriasArr as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat); ?>" style="background: var(--bg-alt);">
                    <?php echo htmlspecialchars($cat); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Inventory Grid -->
    <div class="hardware-grid">
        <?php if (count($componentes) > 0): ?>
            <?php foreach ($componentes as $comp): ?>
                <div class="hardware-card glass reveal inventory-item"
                    data-name="<?php echo htmlspecialchars(strtolower($comp['nombre'] . ' ' . $comp['marca_nombre'])); ?>"
                    data-category="<?php echo htmlspecialchars($comp['categoria'] ?? ''); ?>">

                    <div class="card-img-container">
                        <?php if (!empty($comp['imagen_url'])): ?>
                            <img src="<?php echo htmlspecialchars($comp['imagen_url']); ?>" alt="">
                        <?php else: ?>
                            <div
                                style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                                <span style="font-size: 2.5rem; opacity: 0.3; filter: grayscale(1);">🔌</span>
                            </div>
                        <?php endif; ?>

                        <!-- Quick Badge -->
                        <div
                            style="position: absolute; top: 1rem; right: 1rem; padding: 0.4rem 0.8rem; border-radius: 8px; background: rgba(0,0,0,0.6); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.1); font-size: 0.7rem; font-weight: 800; color: white;">
                            #<?php echo str_pad($comp['id'], 3, '0', STR_PAD_LEFT); ?>
                        </div>
                    </div>

                    <div class="card-body">
                        <span class="card-category"><?php echo htmlspecialchars($comp['categoria'] ?? 'General'); ?></span>
                        <h3 class="card-title"><?php echo htmlspecialchars($comp['nombre']); ?></h3>

                        <div style="margin-top: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
                            <span
                                style="font-size: 0.75rem; padding: 0.3rem 0.7rem; border-radius: 6px; background: rgba(99, 102, 241, 0.1); color: var(--primary); font-weight: 700;">
                                <?php echo htmlspecialchars($comp['marca_nombre']); ?>
                            </span>
                            <?php if ($comp['stock'] < 5): ?>
                                <span
                                    style="font-size: 0.75rem; padding: 0.3rem 0.7rem; border-radius: 6px; background: rgba(239, 68, 68, 0.1); color: #f87171; font-weight: 700;">
                                    Stock Crítico
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="card-footer">
                            <div class="price"><?php echo number_format($comp['precio'], 2, ',', '.'); ?> €</div>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="detalle.php?id=<?php echo $comp['id']; ?>" class="btn"
                                    style="padding: 0.6rem; border: 1px solid var(--border); background: rgba(255,255,255,0.02);"
                                    title="Ver Detalles">
                                    👁️
                                </a>
                                <button
                                    onclick="confirmDelete(<?php echo $comp['id']; ?>, '<?php echo addslashes($comp['nombre']); ?>')"
                                    class="btn"
                                    style="padding: 0.6rem; border: 1px solid rgba(239, 68, 68, 0.2); background: rgba(239, 68, 68, 0.05);"
                                    title="Eliminar">
                                    🗑️
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 10rem 0;">
                <h2 style="font-size: 2rem; color: var(--text-muted);">Sin Activos Registrados</h2>
                <a href="nuevo.php" class="btn btn-primary" style="margin-top: 2rem;">Inicializar Inventario</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
    const searchInput = document.getElementById('searchInput');
    const filterCategory = document.getElementById('filterCategory');
    const items = document.querySelectorAll('.inventory-item');

    function filterItems() {
        const searchTerm = searchInput.value.toLowerCase();
        const categoryTerm = filterCategory.value;

        items.forEach(item => {
            const name = item.getAttribute('data-name');
            const category = item.getAttribute('data-category');

            const matchesSearch = name.includes(searchTerm);
            const matchesCategory = categoryTerm === 'all' || category === categoryTerm;

            if (matchesSearch && matchesCategory) {
                item.style.display = 'flex';
                item.classList.add('animate__animated', 'animate__fadeIn');
            } else {
                item.style.display = 'none';
                item.classList.remove('animate__animated', 'animate__fadeIn');
            }
        });
    }

    searchInput.addEventListener('input', filterItems);
    filterCategory.addEventListener('change', filterItems);

    function confirmDelete(id, nombre) {
        Swal.fire({
            title: '¿Confirmar Baja de Activo?',
            text: `Esta acción eliminará "${nombre}" de la base de datos central.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Sí, dar de baja',
            cancelButtonText: 'Cancelar',
            background: '#0f172a',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `eliminar.php?id=${id}`;
            }
        })
    }
</script>

<?php require_once 'layout/footer.php'; ?>