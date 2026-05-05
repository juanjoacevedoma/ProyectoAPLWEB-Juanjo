/**
 * Hardware Hub Pro - Global Scripts
 * Handles interaction logic globally (spotlight, tilt, reveal).
 */

// --- GLOBAL MOUSE TRACKING (For Spotlight/Tilt) ---
document.addEventListener('mousemove', (e) => {
    // --- SPOTLIGHT TRACKER ---
    document.querySelectorAll('.glass').forEach(card => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        card.style.setProperty('--mouse-x', `${x}px`);
        card.style.setProperty('--mouse-y', `${y}px`);
    });

    // --- 3D TILT EFFECT ---
    document.querySelectorAll('.tilt-parent').forEach(parent => {
        const child = parent.querySelector('.tilt-child');
        if (!child) return;
        
        const rect = parent.getBoundingClientRect();
        if (e.clientX >= rect.left && e.clientX <= rect.right && e.clientY >= rect.top && e.clientY <= rect.bottom) {
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (centerY - y) / 25;
            const rotateY = (x - centerX) / 25;
            child.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        } else {
            child.style.transform = 'rotateX(0) rotateY(0)';
        }
    });
});

// --- GLOBAL SCROLL REVEAL ---
document.addEventListener('DOMContentLoaded', () => {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
});
