<?php
// layout/header.php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Hardware Hub'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body>
    <?php
    $alert = get_alert();
    if ($alert): ?>
        <script>
            Swal.fire({
                title: '<?php echo ($alert['type'] == 'success') ? "¡Hecho!" : "Aviso Técnico"; ?>',
                text: '<?php echo $alert['message']; ?>',
                icon: '<?php echo $alert['type']; ?>',
                confirmButtonColor: '#818cf8',
                background: 'rgba(15, 23, 42, 0.95)',
                color: '#fff'
            });
        </script>
    <?php endif; ?>

    <nav>
        <div class="nav-container">
            <div class="nav-left">
                <a href="index.php" class="logo">HARDWARE<span>HUB</span></a>
            </div>
            
            <div class="nav-center">
                <div class="nav-group">
                    <a href="index.php" class="<?php echo ($currentPage == 'index') ? 'active' : ''; ?>">Inventario</a>
                    <a href="analitica.php" class="<?php echo ($currentPage == 'analitica') ? 'active' : ''; ?>">Analítica</a>
                    <a href="auditoria.php" class="<?php echo ($currentPage == 'auditoria') ? 'active' : ''; ?>">Auditoría</a>
                    <a href="historial.php" class="<?php echo ($currentPage == 'historial') ? 'active' : ''; ?>">Historial</a>
                    
                    <?php if (is_logged_in()): ?>
                        <a href="nuevo.php" class="nav-btn-add <?php echo ($currentPage == 'nuevo') ? 'active' : ''; ?>">
                            <i data-lucide="plus"></i> Registro
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="nav-right">
                <div class="nav-group">
                    <a href="portafolio.html" class="nav-link-alt">Portafolio</a>
                    <div class="nav-divider"></div>
                    
                    <?php if (is_logged_in()): ?>
                        <div class="user-profile">
                            <div class="user-avatar"><?php echo strtoupper(substr(get_logged_user(), 0, 1)); ?></div>
                            <div class="user-details">
                                <span class="u-name"><?php echo get_logged_user(); ?></span>
                                <a href="logout.php" class="u-logout">Cerrar Sesión</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="nav-login-btn">Acceso Admin</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <script>lucide.createIcons();</script>