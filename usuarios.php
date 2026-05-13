<?php
$pageTitle = 'Gestión de Usuarios | Hardware Hub Pro';
$currentPage = 'usuarios';
require_once 'layout/header.php';
require_admin();

// Procesar el registro de nuevo usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_usuario = $_POST['usuario'] ?? '';
    $nuevo_nombre = $_POST['nombre'] ?? '';
    $pass = $_POST['password'] ?? '';
    $rol = $_POST['rol'] ?? 'editor';

    if (!empty($nuevo_usuario) && !empty($pass)) {
        try {
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, nombre, password, rol) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nuevo_usuario, $nuevo_nombre, $hashed_pass, $rol]);
            set_alert("Usuario '$nuevo_usuario' registrado correctamente.", "success");
            header("Location: usuarios.php");
            exit();
        } catch (PDOException $e) {
            set_alert("Error: El usuario ya existe o hubo un fallo en la BD.", "error");
        }
    } else {
        set_alert("Por favor, rellena los campos obligatorios.", "warning");
    }
}

// Obtener lista de usuarios
$stmt = $pdo->query("SELECT id, usuario, nombre, rol FROM usuarios ORDER BY id DESC");
$usuarios = $stmt->fetchAll();
?>

<main class="container">
    <header class="header-meta reveal" style="margin-bottom: 4rem;">
        <div>
            <span style="color: var(--primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.2rem; font-size: 0.75rem;">Administración de Sistema</span>
            <h1 class="text-gradient">Gestión de Usuarios</h1>
            <p style="color: var(--text-muted); font-weight: 500; margin-top: 0.5rem;">Control de acceso y roles para el personal técnico.</p>
        </div>
    </header>

    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 3rem; align-items: start;">
        <!-- Formulario de Creación -->
        <div class="glass reveal" style="padding: 2.5rem; border-radius: 24px;">
            <h2 style="font-size: 1.5rem; margin-bottom: 2rem; color: white;">Añadir Nuevo Usuario</h2>
            <form action="usuarios.php" method="POST">
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label">Nombre de Usuario *</label>
                    <div class="input-group">
                        <i data-lucide="user"></i>
                        <input type="text" name="usuario" required placeholder="User ID">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label">Nombre Completo</label>
                    <div class="input-group">
                        <i data-lucide="info"></i>
                        <input type="text" name="nombre" placeholder="Nombre real">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label">Contraseña *</label>
                    <div class="input-group">
                        <i data-lucide="lock"></i>
                        <input type="password" name="password" required placeholder="••••••••">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 2rem;">
                    <label class="form-label">Rol del Sistema</label>
                    <div class="input-group" style="position: relative;">
                        <i data-lucide="shield"></i>
                        <select name="rol">
                            <option value="editor" style="background: var(--bg-alt);">Editor (Gestión de Stock)</option>
                            <option value="admin" style="background: var(--bg-alt);">Admin (Control Total)</option>
                        </select>
                        <i data-lucide="chevron-down" style="position: absolute; right: 1.25rem; pointer-events: none; opacity: 0.5;"></i>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; height: 50px;">
                    <span>👤+</span> CREAR CUENTA
                </button>
            </form>
        </div>

        <!-- Lista de Usuarios -->
        <div class="glass reveal" style="padding: 2.5rem; border-radius: 24px;">
            <h2 style="font-size: 1.5rem; margin-bottom: 2rem; color: white;">Usuarios Registrados</h2>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: separate; border-spacing: 0 0.75rem;">
                    <thead>
                        <tr style="text-align: left; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em;">
                            <th style="padding: 0 1rem;">Usuario</th>
                            <th style="padding: 0 1rem;">Nombre</th>
                            <th style="padding: 0 1rem;">Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $u): ?>
                            <tr class="glass" style="background: rgba(255,255,255,0.02);">
                                <td style="padding: 1.25rem 1rem; border-radius: 12px 0 0 12px; font-weight: 700; color: var(--primary);">
                                    <?php echo htmlspecialchars($u['usuario']); ?>
                                </td>
                                <td style="padding: 1.25rem 1rem;">
                                    <?php echo htmlspecialchars($u['nombre']); ?>
                                </td>
                                <td style="padding: 1.25rem 1rem; border-radius: 0 12px 12px 0;">
                                    <span style="font-size: 0.7rem; padding: 0.3rem 0.75rem; border-radius: 20px; background: <?php echo ($u['rol'] == 'admin') ? 'rgba(99, 102, 241, 0.1)' : 'rgba(16, 185, 129, 0.1)'; ?>; color: <?php echo ($u['rol'] == 'admin') ? 'var(--primary)' : 'var(--accent)'; ?>; font-weight: 800; border: 1px solid currentColor;">
                                        <?php echo strtoupper($u['rol'] == 'admin' ? 'Administrador' : 'Editor'); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php require_once 'layout/footer.php'; ?>
