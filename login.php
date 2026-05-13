<?php
require_once 'config.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($usuario) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nombre'] = $user['nombre'];
            $_SESSION['user_rol'] = $user['rol'];

            $welcomeMsg = "Bienvenido de nuevo, " . $user['nombre'];
            set_alert($welcomeMsg, "success");

            // Redirección inteligente
            $redirectTo = $_SESSION['redirect_to'] ?? 'index.php';
            unset($_SESSION['redirect_to']);
            header("Location: " . $redirectTo);
            exit();
        } else {
            $error = "Credenciales incorrectas.";
        }
    } else {
        $error = "Por favor, rellena todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrativo | Hardware Hub Juanjo</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="login-page">
    <div class="login-wrapper">
        <div class="brand-side">
            <div class="brand-content">
                <div class="brand-logo">
                    <i data-lucide="cpu"></i>
                    <span>HARDWARE<span>HUBJUANJO</span></span>
                </div>
                <h2>Panel Administrativo</h2>
                <p>Gestión avanzada de inventario y analítica de hardware para profesionales.</p>

                <div class="brand-footer">
                    <div class="badge-item">
                        <i data-lucide="shield-check"></i> Acceso Seguro
                    </div>
                </div>
            </div>
            <div class="grid-overlay"></div>
        </div>

        <div class="form-side">
            <div class="login-form-container">
                <div class="form-header">
                    <h1>Bienvenido</h1>
                    <p>Por favor, ingresa tus credenciales.</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <i data-lucide="alert-circle"></i>
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <div class="input-wrapper">
                            <i data-lucide="user"></i>
                            <input type="text" id="usuario" name="usuario" required placeholder="Nombre de usuario"
                                autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-wrapper">
                            <i data-lucide="lock"></i>
                            <input type="password" id="password" name="password" required placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Entrar al Sistema
                    </button>
                </form>

                <div class="login-footer">
                    <a href="index.php">
                        <i data-lucide="layout-dashboard"></i>
                        Volver al Catálogo Público
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>