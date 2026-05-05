<?php
$pageTitle = 'Monitor de Auditoría | Hardware Hub Pro';
$currentPage = 'auditoria';
require_once 'layout/header.php';
?>

<main class="container">
    <header class="reveal" style="margin-bottom: 4rem; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <span style="color: var(--primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.2em; font-size: 0.8rem;">MONITOR DE INTEGRIDAD DEL SISTEMA</span>
            <h1 class="text-gradient">Auditoría y Logs</h1>
        </div>
        <div style="text-align: right;">
            <div id="status-badge" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 20px; color: #4ade80; font-size: 0.75rem; font-weight: 800;">
                <span style="display: inline-block; width: 8px; height: 8px; background: #4ade80; border-radius: 50%; box-shadow: 0 0 10px #4ade80; animation: pulse 2s infinite;"></span>
                ENCRIPTACIÓN_ACTIVA_SEGURA
            </div>
        </div>
    </header>

    <!-- Global Monitoring Grid -->
    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 2.5rem;">
        
        <!-- Live Audit Stream -->
        <div class="glass reveal" style="padding: 2rem; border-radius: var(--radius); display: flex; flex-direction: column;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h3 style="font-weight: 800; font-size: 1.1rem; letter-spacing: -0.02em;">Flujo de Eventos en Vivo</h3>
                <span style="font-family: monospace; font-size: 0.75rem; color: var(--text-muted);">REFRESCO: 2.4s</span>
            </div>
            
            <div id="audit-log" style="background: rgba(0,0,0,0.3); border-radius: 12px; border: 1px solid var(--border); height: 450px; padding: 1.5rem; font-family: monospace; font-size: 0.85rem; overflow-y: hidden; position: relative;">
                <div id="log-content" style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <!-- Logs will be injected here -->
                </div>
                <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 100px; background: linear-gradient(transparent, rgba(15,23,42,0.9)); pointer-events: none;"></div>
            </div>
        </div>

        <!-- Health Matrix -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <div class="glass reveal" style="padding: 2rem; border-radius: var(--radius);">
                <h3 style="margin-bottom: 2rem; font-weight: 800; font-size: 1rem;">Matriz de Estado de Hardware</h3>
                <div id="health-matrix" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.75rem;">
                    <!-- 16 indicator nodes -->
                    <?php for($i=1; $i<=16; $i++): ?>
                        <div class="matrix-node" style="aspect-ratio: 1; background: rgba(99,102,241,<?php echo rand(1, 5)/10; ?>); border-radius: 4px; border: 1px solid rgba(255,255,255,0.05); transition: all 0.5s;" title="Nodo #<?php echo $i; ?>"></div>
                    <?php endfor; ?>
                </div>
                <div style="margin-top: 2rem; display: flex; justify-content: space-between; font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">
                    <span>Consistencia: 99.4%</span>
                    <span>Carga: Baja</span>
                </div>
            </div>

            <div class="glass reveal" style="padding: 2rem; border-radius: var(--radius);">
                <h3 style="margin-bottom: 1.5rem; font-weight: 800; font-size: 1rem;">Autenticación Admin</h3>
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <div style="width: 60px; height: 60px; border-radius: 12px; background: linear-gradient(135deg, var(--primary) 0%, #444cf7 100%); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; border: 1px solid rgba(255,255,255,0.2);">
                        🔒
                    </div>
                    <div>
                        <div style="font-weight: 800; color: white;">ACCESO_PRO_JUANJO</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">Clave: 4FA9...B88A</div>
                    </div>
                </div>
                <button class="btn btn-secondary" style="width: 100%; margin-top: 2rem; border: 1px solid var(--border); background: rgba(255,255,255,0.02);">Rotar Credenciales</button>
            </div>
        </div>
    </div>

    <!-- Alert History -->
    <section style="margin-top: 5rem;" class="reveal">
        <h2 class="text-gradient" style="margin-bottom: 2.5rem;">Anomalías Recientes</h2>
        <div class="glass" style="border-radius: var(--radius); padding: 2rem; text-align: center;">
            <div style="color: #4ade80; font-size: 3rem; margin-bottom: 1rem;">🛡️</div>
            <h3 style="font-weight: 800; color: white;">No se detectan amenazas</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">Todos los sistemas operan dentro de los parámetros de seguridad nominales.</p>
        </div>
    </section>
</main>

<style>
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.5; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    .matrix-node:hover {
        background: var(--primary) !important;
        transform: scale(1.1);
        box-shadow: 0 0 15px var(--primary-glow);
    }
</style>

<script>
    // Simulated Audit Log Logic (Spanish)
    const logContent = document.getElementById('log-content');
    const logs = [
        { type: 'INFO', msg: 'Chequeo: Integridad de hardware al 100%' },
        { type: 'SEG', msg: 'Admin Juanjo accedió al Panel de Control' },
        { type: 'NET', msg: 'Respuesta de ping del servidor: 4ms' },
        { type: 'BD', msg: 'Base de datos de inventario sincronizada' },
        { type: 'INFO', msg: 'Sensores térmicos calibrados (Actual: 42°C)' },
        { type: 'SEG', msg: 'Túnel encriptado establecido entre nodos' },
        { type: 'SIS', msg: 'Versión del motor 3.0.4 inicializada' }
    ];

    function addLog() {
        const log = logs[Math.floor(Math.random() * logs.length)];
        const time = new Date().toLocaleTimeString();
        const colors = {
            'INFO': '#6366f1',
            'SEG': '#ef4444',
            'NET': '#10b981',
            'BD': '#f59e0b',
            'SIS': '#ffffff'
        };

        const entry = document.createElement('div');
        entry.style.opacity = '0';
        entry.style.transition = 'all 0.5s';
        entry.style.transform = 'translateX(-10px)';
        entry.innerHTML = `
            <span style="color: var(--text-muted)">[${time}]</span> 
            <span style="color: ${colors[log.type]}; font-weight: 800;">${log.type}</span>: 
            ${log.msg}
        `;

        logContent.prepend(entry);
        
        // Limpiar antiguos
        if (logContent.children.length > 20) {
            logContent.removeChild(logContent.lastChild);
        }

        setTimeout(() => {
            entry.style.opacity = '1';
            entry.style.transform = 'translateX(0)';
        }, 10);
    }

    // Matrix Flicker
    function matrixFlicker() {
        const nodes = document.querySelectorAll('.matrix-node');
        nodes.forEach(node => {
            if (Math.random() > 0.8) {
                node.style.opacity = Math.random();
            }
        });
    }

    setInterval(addLog, 2500);
    setInterval(matrixFlicker, 1000);
    
    // Initial logs
    for(let i=0; i<5; i++) setTimeout(addLog, i * 200);
</script>

<?php require_once 'layout/footer.php'; ?>
