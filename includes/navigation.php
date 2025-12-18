<!-- Navigation -->
<nav class="main-nav">
    <div class="nav-container">
        <a href="index.php" class="nav-logo">
            <img src="images/logo.png" alt="Logo de Wichtlä.ch" height="40">
        </a>
        
        <button class="nav-toggle" id="navToggle" aria-label="Abrir menú">
            <span></span>
            <span></span>
            <span></span>
        </button>
        
        <ul class="nav-menu" id="navMenu">
            <li><a href="index.php" class="nav-link">Inicio</a></li>
            <li><a href="was-ist-wichteln.php" class="nav-link">¿Qué es Wichteln?</a></li>
            <li><a href="wichtel-ideen.php" class="nav-link">Ideas de regalos</a></li>
            <li><a href="firmenwichteln-tipps.php" class="nav-link">Wichteln para empresas</a></li>
            <li><a href="faq.php" class="nav-link">Preguntas frecuentes</a></li>
            <li><a href="create_group.php" class="nav-link nav-link-primary">Crear grupo</a></li>
        </ul>
    </div>
</nav>

<script>
// Mobile Navigation Toggle
document.addEventListener('DOMContentLoaded', function() {
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            navToggle.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!navToggle.contains(event.target) && !navMenu.contains(event.target)) {
                navToggle.classList.remove('active');
                navMenu.classList.remove('active');
            }
        });
    }
});
</script>