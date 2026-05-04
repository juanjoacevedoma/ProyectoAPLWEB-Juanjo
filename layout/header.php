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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <?php
    $alert = get_alert();
    if ($alert): ?>
        <script>
            Swal.fire({
                title: '<?php echo ($alert['type'] == 'success') ? "¡Muy bien!" : "Aviso"; ?>',
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
            <a href="index.php" class="logo">HARDWARE<span>HUB</span></a>
            <div class="nav-links">
                <a href="index.php" class="<?php echo ($currentPage == 'index') ? 'active' : ''; ?>">Inventario</a>
                <a href="nuevo.php" class="<?php echo ($currentPage == 'nuevo') ? 'active' : ''; ?>">Añadir</a>
                <a href="portafolio.html">Portafolio</a>
            </div>
        </div>
    </nav>
