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

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Animación de aparición suave para elementos con clase reveal
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>
</html>
