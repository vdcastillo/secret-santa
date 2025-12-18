<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Wichtlä.ch - Wichteln en línea, así de fácil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Organiza tu Wichteln en línea: fácil, rápido y gratis. Crea grupos, sortea nombres y envía los resultados por correo electrónico.">
    <link rel="apple-touch-icon" sizes="57x57" href="/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- CSS Stylesheet -->
    <link rel="stylesheet" href="css/styles.css">
    <!-- Matomo -->
    <?php if (file_exists('config.php')) { require_once 'config.php'; } ?>
    <?php if (defined('MATOMO_URL') && defined('MATOMO_SITE_ID')): ?>
    <script>
      var _paq = window._paq = window._paq || [];
      _paq.push(['trackPageView']);
      _paq.push(['enableLinkTracking']);
      (function() {
        var u="<?php echo MATOMO_URL; ?>";
        _paq.push(['setTrackerUrl', u+'matomo.php']);
        _paq.push(['setSiteId', '<?php echo MATOMO_SITE_ID; ?>']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
      })();
    </script>
    <?php endif; ?>
    <!-- End Matomo Code -->
</head>
<body>
    <?php include 'includes/navigation.php'; ?>
    
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == '1'): ?>
        <div class="notification success" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000; max-width: 500px; width: 90%;">
            El grupo se eliminó correctamente.
        </div>
        <script>
            setTimeout(function() {
                var notification = document.querySelector('.notification');
                if (notification) {
                    notification.style.opacity = '0';
                    notification.style.transition = 'opacity 0.5s ease';
                    setTimeout(function() { notification.remove(); }, 500);
                }
            }, 3000);
        </script>
    <?php endif; ?>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-background">
            <div class="snowflake">❄</div>
            <div class="snowflake">❄</div>
            <div class="snowflake">❄</div>
            <div class="snowflake">❄</div>
            <div class="snowflake">❄</div>
        </div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">✨ Gratis y fácil</div>
                <h1 class="hero-title">
                    <span class="hero-title-main">Wichteln, así de fácil</span>
                    <span class="hero-title-sub">Organiza tu Wichteln en línea</span>
                </h1>
                <p class="hero-subtitle">La forma más sencilla de organizar tu Wichteln. Sin registro, sin costos ocultos: ¡empieza ya!</p>
                
                <div class="hero-features">
                    <div class="hero-feature">
                        <span class="feature-icon-small">📧</span>
                        <span>Sorteo de nombres por correo</span>
                    </div>
                    <div class="hero-feature">
                        <span class="feature-icon-small">⚖️</span>
                        <span>Exclusiones posibles</span>
                    </div>
                    <div class="hero-feature">
                        <span class="feature-icon-small">💰</span>
                        <span>100% gratis</span>
                    </div>
                </div>
                
                <div class="hero-cta">
                    <a href="create_group.php" class="cta-button cta-button-primary">
                        <span>Crear grupo ahora</span>
                        <span class="cta-arrow">→</span>
                    </a>
                    <a href="participant.php" class="cta-button cta-button-secondary">
                        <span>Ir al área de participantes</span>
                        <span class="cta-arrow">→</span>
                    </a>
                    <p class="cta-subtext">No requiere registro • Empieza al instante</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
        <div class="container">
            <h2 class="section-title">Cómo funciona</h2>
            
            <div class="steps">
                <div class="step">
                    <span class="step-number">1</span>
                    <span class="step-icon">📝</span>
                    <h3>Crear grupo</h3>
                    <p>Crea un grupo de Wichteln con nombre, presupuesto y fecha de intercambio. Obtén al instante un enlace de administrador para gestionarlo.</p>
                </div>
                
                <div class="step">
                    <span class="step-number">2</span>
                    <span class="step-icon">👥</span>
                    <h3>Invitar participantes</h3>
                    <p>Comparte el enlace de invitación con todos los participantes. Cada quien se registra por su cuenta con su nombre y, opcionalmente, su correo.</p>
                </div>
                
                <div class="step">
                    <span class="step-number">3</span>
                    <span class="step-icon">🎯</span>
                    <h3>Definir exclusiones</h3>
                    <p>Indica quién no debe tocarle a quién; perfecto para parejas o hermanos que no quieren regalarse entre sí.</p>
                </div>
                
                <div class="step">
                    <span class="step-number">4</span>
                    <span class="step-icon">🎲</span>
                    <h3>Sorteo</h3>
                    <p>Con un clic se sortean los nombres. Cada participante recibe automáticamente un correo con su persona asignada.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2 class="section-title">¿Por qué Wichtlä.ch?</h2>
            
            <div class="feature-grid">
                <div class="feature-card">
                    <h3><span class="feature-icon">🔒</span> Seguro y privado</h3>
                    <p>Tus datos están protegidos. Nadie más que tú conoce todas las asignaciones. Cada participante solo ve a su propia persona asignada.</p>
                </div>
                
                <div class="feature-card">
                    <h3><span class="feature-icon">⚡</span> Rapidísimo</h3>
                    <p>En menos de 2 minutos tu grupo de Wichteln está creado y las primeras invitaciones enviadas. ¡No necesitas registrarte!</p>
                </div>
                
                <div class="feature-card">
                    <h3><span class="feature-icon">🎨</span> Moderno y bonito</h3>
                    <p>Una interfaz moderna y atractiva que funciona perfecto en todos los dispositivos, del móvil al escritorio.</p>
                </div>
                
                <div class="feature-card">
                    <h3><span class="feature-icon">💝</span> Exclusiones</h3>
                    <p>Define quién no puede tocarle a quién. Ideal para parejas, hermanos o compañeros de piso que no deberían coincidir.</p>
                </div>
                
                <div class="feature-card">
                    <h3><span class="feature-icon">📧</span> Notificación por correo</h3>
                    <p>Todos los participantes reciben automáticamente un correo con su nombre asignado, incluyendo los detalles importantes del grupo.</p>
                </div>
                
                <div class="feature-card">
                    <h3><span class="feature-icon">💰</span> Completamente gratis</h3>
                    <p>Sin costos ocultos, sin funciones premium. Úsalo gratis y sin limitaciones.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq">
        <div class="container">
            <h2 class="section-title">Preguntas frecuentes</h2>
            
            <div class="faq-list">
                <div class="faq-item" onclick="toggleFAQ(this)">
                    <div class="faq-question">
                        <h3>¿Cómo funciona el sorteo?</h3>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Al hacer clic en "Sortear", los nombres se asignan de forma automática y aleatoria. Nos aseguramos de que nadie se toque a sí mismo y de respetar todas las exclusiones. Después, cada participante recibe un correo con su persona asignada.</p>
                    </div>
                </div>
                
                <div class="faq-item" onclick="toggleFAQ(this)">
                    <div class="faq-question">
                        <h3>¿Puedo configurar exclusiones?</h3>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>¡Sí! Como administrador puedes definir antes del sorteo qué personas no deberían tocarse entre sí. Es especialmente útil para parejas o hermanos. Puedes crear tantas exclusiones como necesites.</p>
                    </div>
                </div>
                
                <div class="faq-item" onclick="toggleFAQ(this)">
                    <div class="faq-question">
                        <h3>¿Qué pasa después del sorteo?</h3>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Todos los participantes que hayan indicado correo reciben automáticamente un mensaje con el nombre de su persona asignada. Además, pueden consultar en cualquier momento, mediante su enlace personal, a quién deben obsequiar.</p>
                    </div>
                </div>
                
                <div class="faq-item" onclick="toggleFAQ(this)">
                    <div class="faq-question">
                        <h3>¿Es necesario registrarse?</h3>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>¡No! Puedes empezar de inmediato sin registrarte. Tras crear un grupo, recibirás un enlace de administrador que deberías guardar. Los participantes tampoco necesitan registrarse.</p>
                    </div>
                </div>
                
                <div class="faq-item" onclick="toggleFAQ(this)">
                    <div class="faq-question">
                        <h3>¿Puedo reiniciar el sorteo?</h3>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Sí, como administrador puedes reiniciar el sorteo en cualquier momento. Se eliminarán todas las asignaciones y podrás sortear de nuevo, por ejemplo, si se han añadido nuevos participantes.</p>
                    </div>
                </div>
                
                <div class="faq-item" onclick="toggleFAQ(this)">
                    <div class="faq-question">
                        <h3>¿Cuántos participantes son posibles?</h3>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>¡Teóricamente ilimitados! El sorteo funciona a partir de 2 participantes y también se puede realizar sin problema con grupos grandes de 20, 30 o más personas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer CTA -->
    <section class="footer-cta">
        <div class="container">
            <h2>¿Listo para tu Wichteln?</h2>
            <p>Empieza ahora y organiza tu Wichteln perfecto en pocos minutos</p>
            <a href="create_group.php" class="cta-button">Crear grupo gratis »</a>
        </div>
    </section>

    <!-- Simple Footer -->
    <footer style="background: var(--secondary-dark); color: white; text-align: center; padding: 2rem;">
        <p style="margin: 0; color: white; opacity: 1;">
            © <?php echo date('Y'); ?> wichtlä.ch • 
            <a href="impressum.php" style="color: white; text-decoration: underline;">Aviso legal</a> • 
            <a href="datenschutz.php" style="color: white; text-decoration: underline;">Privacidad</a>
        </p>
    </footer>

    <script>
        function toggleFAQ(element) {
            const isActive = element.classList.contains('active');
            
            // Schließe alle anderen FAQs
            document.querySelectorAll('.faq-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Öffne/Schließe die geklickte FAQ
            if (!isActive) {
                element.classList.add('active');
            }
        }

        // Smooth scroll für CTA Buttons
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animation beim Scrollen
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Beobachte alle Schritte und Feature-Cards
        document.querySelectorAll('.step, .feature-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    </script>
    
    <!-- Cookie Banner -->
    <?php include 'cookie-banner.php'; ?>
</body>
</html>