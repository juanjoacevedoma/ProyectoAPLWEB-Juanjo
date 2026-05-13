<?php
$pageTitle = 'Ingeniería de Hardware | Hardware Hub Pro';
$currentPage = 'nuevo';
require_once 'layout/header.php';
require_auth();

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $marca_id = $_POST['marca_id'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $categoria = $_POST['categoria'] ?? '';
    $imagen_url = $_POST['imagen_url'] ?? '';

    if ($nombre && $marca_id) {
        try {
            $sql = "INSERT INTO componentes (nombre, marca_id, descripcion, precio, stock, categoria, imagen_url) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $marca_id, $descripcion, $precio, $stock, $categoria, $imagen_url]);

            set_alert('Activo registrado en la base de datos central.', 'success');
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            set_alert('Fallo en la comunicación con el servidor: ' . $e->getMessage(), 'error');
        }
    } else {
        set_alert('Los campos marcados con (*) son obligatorios para la integridad del sistema.', 'warning');
    }
}

// Obtener marcas
$marcas = $pdo->query("SELECT * FROM marcas ORDER BY nombre")->fetchAll();
?>

<main class="container">
    <div class="header-meta reveal" style="margin-bottom: 4rem;">
        <div>
            <span style="color: var(--primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.2rem; font-size: 0.75rem;">Módulo de Registro de Activos</span>
            <h1 class="text-gradient">Nuevo Hardware</h1>
            <p style="color: var(--text-muted); font-weight: 500; margin-top: 0.5rem;">Introduzca las especificaciones técnicas del nuevo componente.</p>
        </div>
    </div>

    <div class="glass reveal" style="border-radius: 24px; padding: 4rem; max-width: 1100px; margin: 0 auto; border: 1px solid var(--border);">
        <form action="nuevo.php" method="POST" id="form-hardware" style="display: grid; grid-template-columns: 1.3fr 1fr; gap: 5rem;">
            
            <!-- Columna de Datos Técnicos -->
            <div class="form-inputs">
                <div class="form-group" style="margin-bottom: 2.5rem;">
                    <label class="form-label">Identificación del Activo *</label>
                    <div class="input-group">
                        <i data-lucide="tag"></i>
                        <input type="text" name="nombre" required placeholder="Nombre del componente (Ej: AMD Ryzen 9 7950X)">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2.5rem;">
                    <div class="form-group">
                        <label class="form-label">Fabricante / Marca *</label>
                        <div class="input-group" style="position: relative;">
                            <i data-lucide="building-2"></i>
                            <select name="marca_id" required>
                                <option value="">Seleccionar Fabricante</option>
                                <?php foreach ($marcas as $m): ?>
                                    <option value="<?php echo $m['id']; ?>" style="background: var(--bg-alt);"><?php echo htmlspecialchars($m['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <i data-lucide="chevron-down" style="position: absolute; right: 1.25rem; pointer-events: none; opacity: 0.5;"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Clasificación / Categoría</label>
                        <div class="input-group">
                            <i data-lucide="layers"></i>
                            <input type="text" name="categoria" placeholder="GPU, CPU, Motherboard...">
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2.5rem;">
                    <div class="form-group">
                        <label class="form-label">Valor Unitario (€)</label>
                        <div class="input-group">
                            <i data-lucide="coins"></i>
                            <input type="number" step="0.01" name="precio" placeholder="0.00">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unidades de Inventario</label>
                        <div class="input-group">
                            <i data-lucide="box"></i>
                            <input type="number" name="stock" placeholder="0">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Enlace Multimedia (Imagen)</label>
                    <div class="input-group">
                        <i data-lucide="link-2"></i>
                        <input type="url" name="imagen_url" id="imageUrlInput" placeholder="https://cdn.hardwarehub.com/images/...">
                    </div>
                    <p style="font-size: 0.7rem; color: var(--text-muted); margin-top: 0.75rem;">Admite formatos JPG, PNG y WEBP de alta resolución.</p>
                </div>
            </div>

            <!-- Columna de Visualización y Detalles -->
            <div class="form-preview" style="display: flex; flex-direction: column;">
                <label class="form-label">Vista Previa del Activo</label>
                <div id="previewContainer" class="glass" style="width: 100%; aspect-ratio: 1; border-radius: 20px; position: relative; overflow: hidden; background: rgba(0,0,0,0.4); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center;">
                    <div class="scan-line"></div>
                    <div id="placeholderUI" style="text-align: center; color: var(--text-muted);">
                        <i data-lucide="image" style="width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.2;"></i>
                        <p style="font-size: 0.7rem; font-weight: 800; letter-spacing: 0.1em; opacity: 0.5;">ESPERANDO SEÑAL DE IMAGEN...</p>
                    </div>
                    <img id="liveImage" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                </div>

                <div class="form-group" style="margin-top: 2.5rem; flex: 1;">
                    <label class="form-label">Especificaciones Técnicas / Descripción</label>
                    <div class="input-group">
                        <i data-lucide="file-text" style="align-self: flex-start; margin-top: 1.25rem;"></i>
                        <textarea name="descripcion" placeholder="Detalles de rendimiento, compatibilidad, garantía..."></textarea>
                    </div>
                </div>

                <div style="margin-top: 3rem; display: grid; grid-template-columns: 2fr 1fr; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="justify-content: center; height: 60px; font-weight: 800;">
                        <span>🚀</span> EJECUTAR REGISTRO
                    </button>
                    <a href="index.php" class="btn btn-ghost" style="justify-content: center; height: 60px; font-weight: 700;">
                        CERRAR
                    </a>
                </div>
            </div>
        </form>
    </div>
</main>

<script>
    const imageUrlInput = document.getElementById('imageUrlInput');
    const previewContainer = document.getElementById('previewContainer');
    const placeholderUI = document.getElementById('placeholderUI');
    const liveImage = document.getElementById('liveImage');

    imageUrlInput.addEventListener('input', function() {
        const url = this.value;
        if (url) {
            previewContainer.classList.add('scanning');
            const img = new Image();
            img.onload = function() {
                setTimeout(() => {
                    liveImage.src = url;
                    liveImage.style.display = 'block';
                    placeholderUI.style.display = 'none';
                    previewContainer.classList.remove('scanning');
                }, 800); // Dar tiempo al efecto de escaneo
            };
            img.onerror = function() {
                previewContainer.classList.remove('scanning');
                liveImage.style.display = 'none';
                placeholderUI.style.display = 'block';
                placeholderUI.innerHTML = `
                    <i data-lucide="octagon-alert" style="width: 48px; height: 48px; margin-bottom: 1rem; color: #f87171;"></i>
                    <p style="font-size: 0.7rem; color: #f87171; font-weight: 800;">ERROR: SEÑAL DE IMAGEN INVÁLIDA</p>
                `;
                lucide.createIcons();
            };
            img.src = url;
        } else {
            previewContainer.classList.remove('scanning');
            liveImage.style.display = 'none';
            placeholderUI.style.display = 'block';
            placeholderUI.innerHTML = `
                <i data-lucide="image" style="width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.2;"></i>
                <p style="font-size: 0.7rem; font-weight: 800; letter-spacing: 0.1em; opacity: 0.5;">ESPERANDO SEÑAL DE IMAGEN...</p>
            `;
            lucide.createIcons();
        }
    });

    // Hover effect persistence for textarea
    const textarea = document.querySelector('textarea');
    textarea.addEventListener('focus', () => textarea.style.backgroundColor = 'rgba(30, 41, 59, 0.6)');
    textarea.addEventListener('blur', () => textarea.style.backgroundColor = 'rgba(15, 23, 42, 0.4)');
</script>

<?php require_once 'layout/footer.php'; ?>