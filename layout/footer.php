<?php
// layout/footer.php
?>
    <footer style="margin-top: 8rem; padding: 4rem 0; border-top: 1px solid var(--border); text-align: center;">
        <div class="container" style="margin: 0 auto; color: var(--text-muted); font-size: 0.9rem;">
            <p>&copy; <?php echo date('Y'); ?> Hardware Hub Pro. La herramienta definitiva para entusiastas.</p>
            <div style="margin-top: 1rem; display: flex; justify-content: center; gap: 2rem;">
                <a href="#" style="color: var(--text-muted); text-decoration: none;">GitHub</a>
                <a href="#" style="color: var(--text-muted); text-decoration: none;">Documentación</a>
                <a href="#" style="color: var(--text-muted); text-decoration: none;">Soporte</a>
            </div>
        </div>
    </footer>

    <!-- Global High-End Scripts -->
    <script src="global_scripts.js"></script>
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();
    </script>
</body>
</html>
