<?php
/**
 * participant.php
 * 
 * Teilnehmerbereich für Wichtel-Gruppen
 * 
 * Features:
 * - Cookie-basiertes Token-Management für automatisches Login
 * - Unterstützung für mehrere Gruppen pro Benutzer
 * - Gruppenauswahl-Interface wenn mehrere Gruppen vorhanden
 * - Token in URL hat Vorrang vor Cookie-Daten
 * - Sichere Cookie-Verwaltung (httpOnly, SameSite, begrenzte Speicherung)
 * 
 * Konfiguration:
 * - COOKIE_NAME: Name des Cookies (config.php)
 * - COOKIE_LIFETIME: Lebensdauer des Cookies in Sekunden (config.php)
 * - COOKIE_MAX_TOKENS: Max. Anzahl gespeicherter Tokens (config.php)
 * 
 * Sicherheit:
 * - Token-Validierung (nur alphanumerische Zeichen)
 * - Maximale Anzahl gespeicherter Tokens (konfigurierbar)
 * - Secure-Flag bei HTTPS
 * - SameSite=Lax zur CSRF-Prävention
 * - HttpOnly-Flag gegen XSS-Angriffe
 */

require_once 'functions.php';

session_start();

$pdo = db_connect();

/**
 * Speichert einen Token im Cookie (fügt ihn zur Liste hinzu, falls noch nicht vorhanden)
 */
function save_token_to_cookie($token) {
    $tokens = get_tokens_from_cookie();
    
    // Token validieren (nur alphanumerische Zeichen)
    if (!preg_match('/^[a-zA-Z0-9]+$/', $token)) {
        return false;
    }
    
    // Token zur Liste hinzufügen, wenn noch nicht vorhanden
    if (!in_array($token, $tokens)) {
        $tokens[] = $token;
    }
    
    // Nur die letzten X Tokens behalten (konfigurierbar in config.php)
    $tokens = array_slice($tokens, -COOKIE_MAX_TOKENS);
    
    // Cookie mit Sicherheitseinstellungen setzen
    $cookie_options = [
        'expires' => time() + COOKIE_LIFETIME,
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'httponly' => true,
        'samesite' => 'Lax'
    ];
    
    return setcookie(COOKIE_NAME, json_encode($tokens), $cookie_options);
}

/**
 * Liest alle gespeicherten Tokens aus dem Cookie
 */
function get_tokens_from_cookie() {
    if (!isset($_COOKIE[COOKIE_NAME])) {
        return [];
    }
    
    $tokens = json_decode($_COOKIE[COOKIE_NAME], true);
    
    if (!is_array($tokens)) {
        return [];
    }
    
    // Nur gültige Tokens zurückgeben
    return array_filter($tokens, function($token) {
        return preg_match('/^[a-zA-Z0-9]+$/', $token);
    });
}

/**
 * Lädt alle Teilnehmerdaten für die gespeicherten Tokens
 */
function load_participants_from_tokens($pdo, $tokens) {
    if (empty($tokens)) {
        return [];
    }
    
    $placeholders = str_repeat('?,', count($tokens) - 1) . '?';
    $stmt = $pdo->prepare("SELECT p.*, g.name as group_name, g.is_drawn 
                           FROM `participants` p 
                           JOIN `groups` g ON p.group_id = g.id 
                           WHERE p.participant_token IN ($placeholders)
                           ORDER BY g.name, p.name");
    $stmt->execute($tokens);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Token aus URL hat Vorrang
$participant_token = $_GET['token'] ?? '';
$show_group_selector = false;
$participant = null;
$group = null;
$assigned = null;

// Wenn Token in URL vorhanden ist
if (!empty($participant_token)) {
    // Token validieren
    if (!preg_match('/^[a-zA-Z0-9]+$/', $participant_token)) {
        die('Token no válido.');
    }
    
    // Teilnehmer abrufen
    $stmt = $pdo->prepare("SELECT * FROM `participants` WHERE `participant_token` = ?");
    $stmt->execute([$participant_token]);
    $participant = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$participant) {
        die('Token no válido.');
    }
    
    // Token im Cookie speichern
    save_token_to_cookie($participant_token);
    
} else {
    // Kein Token in URL - versuche aus Cookie zu laden
    $saved_tokens = get_tokens_from_cookie();
    
    if (empty($saved_tokens)) {
        // Keine gespeicherten Tokens - zeige schöne Fehlerseite
        ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>No se encontró ningún grupo - Wichteln</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto&display=swap" rel="stylesheet">
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
    <header>
        <a href="index.php" title="Ir al inicio">
            <img src="images/logo.png" alt="Logo de Wichteln">
        </a>

    </header>
    <div class="container">
        <div class="error-page">
            <div class="error-content">
                <div class="error-icon">🎄</div>
                <h1 class="error-title">No se encontró ningún grupo</h1>
                <p class="error-message">
                    Aún no has visitado ningún grupo de Wichteln o tu enlace ya no es válido.
                    Para acceder a tu área de participante, necesitas un enlace personal de participante.
                </p>
                
                <div class="error-actions">
                    <a href="index.php" class="button primary">🏠 Ir al inicio</a>
                    <a href="create_group.php" class="button secondary">➕ Crear nuevo grupo</a>
                </div>
                
                <div class="error-help">
                    <h3>💡 Cómo acceder a tu área de participante:</h3>
                    <ul>
                        <li><strong>¿Recibiste un enlace de invitación?</strong> Usa el enlace que te envió el administrador del grupo</li>
                        <li><strong>¿Ya te registraste?</strong> Utiliza tu enlace personal de participante de tu correo de confirmación</li>
                        <li><strong>¿Perdiste el enlace?</strong> Contacta al administrador del grupo para obtener uno nuevo</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
        <?php
        exit;
    }
    
    // Teilnehmer für alle gespeicherten Tokens laden
    $participants = load_participants_from_tokens($pdo, $saved_tokens);
    
    if (empty($participants)) {
        die('Keine gültigen Teilnahmen gefunden.');
    }
    
    // Wenn Gruppenauswahl per POST gesendet wurde
    if (isset($_POST['select_group']) && isset($_POST['selected_token'])) {
        $selected_token = $_POST['selected_token'];
        
        // Token validieren
        if (!preg_match('/^[a-zA-Z0-9]+$/', $selected_token) || !in_array($selected_token, $saved_tokens)) {
            die('Ungültiger Token.');
        }
        
        $participant_token = $selected_token;
        
        // Teilnehmer laden
        $stmt = $pdo->prepare("SELECT * FROM `participants` WHERE `participant_token` = ?");
        $stmt->execute([$participant_token]);
        $participant = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$participant) {
            die('Ungültiger Token.');
        }
    } elseif (count($participants) > 1) {
        // Mehrere Gruppen - zeige Auswahlseite
        $show_group_selector = true;
    } else {
        // Nur eine Gruppe - direkt laden
        $participant = $participants[0];
        $participant_token = $participant['participant_token'];
    }
}

// Wenn Teilnehmer geladen wurde, lade Gruppendaten
if ($participant) {
    // Gruppe abrufen
    $stmt = $pdo->prepare("SELECT * FROM `groups` WHERE `id` = ?");
    $stmt->execute([$participant['group_id']]);
    $group = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Zugewiesenen Teilnehmer abrufen, falls ausgelost
    if ($group['is_drawn'] && !empty($participant['assigned_to'])) {
        $stmt = $pdo->prepare("SELECT * FROM `participants` WHERE `id` = ?");
        $stmt->execute([$participant['assigned_to']]);
        $assigned = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Wunschliste aktualisieren (nur wenn noch nicht ausgelost)
    if (isset($_POST['update_wishlist']) && !$group['is_drawn']) {
        $wishlist = trim($_POST['wishlist']);
        
        $stmt = $pdo->prepare("UPDATE `participants` SET `wishlist` = ? WHERE `id` = ?");
        $stmt->execute([$wishlist, $participant['id']]);
        
        // Teilnehmer neu abrufen
        $stmt = $pdo->prepare("SELECT * FROM `participants` WHERE `participant_token` = ?");
        $stmt->execute([$participant_token]);
        $participant = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $wishlist_success = "Tu lista de deseos se guardó correctamente.";
    }
}

// Wenn Gruppenauswahl angezeigt werden soll
if ($show_group_selector) {
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar grupo - Wichteln</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
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
    <header>
        <a href="index.php" title="Ir al inicio">
            <img src="images/logo.png" alt="Logo de Wichteln">
        </a>
    </header>
    <div class="container">
        <div class="group-selector">
            <h1>¡Bienvenido de nuevo! 🎄</h1>
            <p>Participas en varios grupos de Wichteln. Por favor, elige el grupo que quieres ver:</p>
            
            <form method="POST" id="group-selector-form">
                <?php foreach ($participants as $p): ?>
                <label class="group-card">
                    <input type="radio" name="selected_token" value="<?php echo htmlspecialchars($p['participant_token']); ?>" required>
                    <div class="group-card-content">
                        <div class="group-card-header">
                            <div>
                                <h2 class="group-name"><?php echo htmlspecialchars($p['group_name']); ?></h2>
                                <p class="group-participant">Como: <strong><?php echo htmlspecialchars($p['name']); ?></strong></p>
                            </div>
                            <span class="group-status <?php echo $p['is_drawn'] ? 'status-drawn' : 'status-pending'; ?>">
                                <?php echo $p['is_drawn'] ? '✓ Sorteado' : 'Pendiente'; ?>
                            </span>
                        </div>
                    </div>
                </label>
                <?php endforeach; ?>
                
                <div class="submit-container">
                    <button type="submit" name="select_group" class="group-submit-button" id="submit-button" disabled>Abrir grupo</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Bei Klick auf die Card auch das Radio-Button aktivieren
        document.querySelectorAll('.group-card').forEach(card => {
            card.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Button aktivieren
                const submitButton = document.getElementById('submit-button');
                submitButton.disabled = false;
                submitButton.classList.add('enabled');
            });
        });
        
        // Button aktivieren wenn Radio-Button geändert wird
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const submitButton = document.getElementById('submit-button');
                submitButton.disabled = false;
                submitButton.classList.add('enabled');
            });
        });
    </script>
</body>
</html>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Área de participantes - <?php echo htmlspecialchars($participant['name']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- CSS Stylesheet -->
    <link rel="stylesheet" href="css/styles.css">
    <!-- JavaScript für Kopieren-Button -->
    <script>
        function copyToClipboard(elementId) {
            var element = document.getElementById(elementId);
            var copyText = element.getAttribute('data-url') || element.innerText || element.textContent;
            
            // Moderne Clipboard API (bevorzugt)
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(copyText).then(function() {
                    // Zeige Erfolgs-Feedback
                    var btn = event.target.closest('button');
                    var originalText = btn.innerHTML;
                    btn.innerHTML = '✓ ¡Copiado!';
                    btn.style.background = 'linear-gradient(135deg, #10b981, #059669)';
                    setTimeout(function() {
                        btn.innerHTML = originalText;
                        btn.style.background = '';
                    }, 2000);
                }).catch(function(err) {
                    fallbackCopy(copyText);
                });
            } else {
                fallbackCopy(copyText);
            }
        }
        
        function fallbackCopy(text) {
            var tempInput = document.createElement("textarea");
            tempInput.value = text;
            tempInput.style.position = "fixed";
            tempInput.style.opacity = "0";
            document.body.appendChild(tempInput);
            tempInput.select();
            tempInput.setSelectionRange(0, 99999);
            try {
                document.execCommand("copy");
                alert("¡Enlace copiado!");
            } catch (err) {
                alert("Error al copiar. Copia manualmente, por favor.");
            }
            document.body.removeChild(tempInput);
        }
    </script>
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
    <!-- Navigation -->
    <?php include 'includes/navigation.php'; ?>
    
    <div class="container" style="margin-top: 2rem;">
        <!-- Welcome Card -->
        <div class="participant-info-card">
            <div class="participant-welcome">
                <h1 class="participant-greeting">¡Bienvenido, <?php echo htmlspecialchars($participant['name']); ?>! 🎄</h1>
                <p class="participant-group-name">📦 Grupo: <?php echo htmlspecialchars($group['name']); ?></p>
            </div>
        </div>
        
        <?php if (isset($wishlist_success)): ?>
            <div class="notification success">
                ✓ <?php echo htmlspecialchars($wishlist_success); ?>
            </div>
        <?php endif; ?>
        
        <!-- Partner Reveal Card -->
        <?php if ($group['is_drawn']): ?>
            <div class="partner-reveal-card">
                <div class="partner-reveal-header">
                    <span class="partner-reveal-icon">🎁</span>
                    <h2 class="partner-reveal-title">Tu persona asignada</h2>
                </div>
                
                <?php if ($assigned): ?>
                    <div class="partner-name-container">
                        <p class="partner-name"><?php echo htmlspecialchars($assigned['name']); ?></p>
                    </div>
                    
                    <?php if (!empty($assigned['wishlist'])): ?>
                        <div class="partner-wishlist-section">
                            <h3 class="wishlist-heading">
                                <span class="wishlist-icon">📝</span>
                                Lista de deseos de <?php echo htmlspecialchars($assigned['name']); ?>
                            </h3>
                            <div class="wishlist-display">
                                <p><?php echo nl2br(htmlspecialchars($assigned['wishlist'])); ?></p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="empty-wishlist">
                            <span class="empty-wishlist-icon">📋</span>
                            <p><?php echo htmlspecialchars($assigned['name']); ?> aún no ha añadido una lista de deseos.</p>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="notification error">
                        ⚠️ No se pudo encontrar a tu persona asignada.
                    </div>
                <?php endif; ?>
            </div>
            
            <?php 
            // Google Ad Position 1: Nach Wichtelpartner-Bereich
            if (defined('GOOGLE_ADS_ENABLED') && GOOGLE_ADS_ENABLED && 
                defined('GOOGLE_ADS_SHOW_OPTION1') && GOOGLE_ADS_SHOW_OPTION1): 
                $is_testing = defined('GOOGLE_ADS_TESTING') && GOOGLE_ADS_TESTING;
            ?>
            <div class="ad-container">
                <div class="ad-label"><?php echo $is_testing ? 'Anuncio de prueba (Posición 1)' : 'Anuncio'; ?></div>
                <?php if ($is_testing): ?>
                    <div class="ad-test-placeholder">
                        📊 Google Ad Placeholder<br>
                        Position 1: Nach Wichtelpartner<br>
                        Responsive Display Ad
                    </div>
                <?php else: ?>
                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?php echo htmlspecialchars(GOOGLE_ADS_CLIENT); ?>"
                         crossorigin="anonymous"></script>
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="<?php echo htmlspecialchars(GOOGLE_ADS_CLIENT); ?>"
                         data-ad-slot="<?php echo htmlspecialchars(GOOGLE_ADS_SLOT_OPTION1); ?>"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>
                         (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="section-card waiting-card">
                <div class="waiting-icon">⏳</div>
                <h2>Sorteo pendiente</h2>
                <p>Aún no se ha realizado el sorteo. ¡Vuelve más tarde!</p>
            </div>
        <?php endif; ?>
        
        <!-- Wunschliste Section -->
        <!-- Wunschliste Section -->
        <div class="section-card">
            <div class="section-card-header">
                <span class="section-icon">📝</span>
                <h2>Tu lista de deseos</h2>
            </div>
            
            <?php if (!$group['is_drawn']): ?>
                <p class="section-description">Escribe aquí tus deseos. Tu persona asignada podrá verlos después del sorteo.</p>
                <form method="POST" class="wishlist-form">
                    <div class="form-group">
                        <label for="wishlist" class="form-label">
                            <span>Tus deseos</span>
                            <span class="form-hint">p. ej., libros, chocolate, algo hecho a mano...</span>
                        </label>
                        <textarea id="wishlist" 
                                  name="wishlist" 
                                  rows="6" 
                                  class="form-textarea"
                                  placeholder="- Libros sobre...&#10;- Chocolate&#10;- Algo hecho a mano&#10;- ¡Sorpresa!"><?php echo htmlspecialchars($participant['wishlist'] ?? ''); ?></textarea>
                    </div>
                    <button type="submit" name="update_wishlist" class="button primary">
                        <span>💾</span>
                        Guardar lista de deseos
                    </button>
                </form>
            <?php else: ?>
                <?php if (!empty($participant['wishlist'])): ?>
                    <div class="wishlist-display locked">
                        <div class="wishlist-locked-header">
                            <span class="lock-icon">🔒</span>
                            <span>Tu lista de deseos guardada</span>
                        </div>
                        <p><?php echo nl2br(htmlspecialchars($participant['wishlist'])); ?></p>
                    </div>
                <?php else: ?>
                    <div class="empty-wishlist">
                        <span class="empty-wishlist-icon">📋</span>
                        <p>No has añadido ninguna lista de deseos.</p>
                    </div>
                <?php endif; ?>
                <p class="text-muted">
                    <span class="info-icon">ℹ️</span>
                    La lista de deseos no se puede cambiar después del sorteo.
                </p>
            <?php endif; ?>
        </div>
        
        <!-- Gruppendetails Section -->
        <div class="section-card">
            <div class="section-card-header">
                <span class="section-icon">ℹ️</span>
                <h2>Detalles del grupo</h2>
            </div>
            
            <div class="group-info-grid">
                <div class="group-info-item">
                    <span class="info-label">💰 Presupuesto</span>
                <span class="info-value">
                        <?php echo $group['budget'] !== null ? number_format($group['budget'], 2) . " CHF" : "No especificado"; ?>
                </span>
                </div>
                <div class="group-info-item">
                    <span class="info-label">📅 Entrega de regalos</span>
                <span class="info-value">
                        <?php echo $group['gift_exchange_date'] ? date('d.m.Y', strtotime($group['gift_exchange_date'])) : "No especificada"; ?>
                </span>
                </div>
                <?php if (!empty($group['description'])): ?>
                <div class="group-info-item full-width">
                    <span class="info-label">📄 Descripción</span>
                    <span class="info-value"><?php echo htmlspecialchars($group['description']); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Teilnehmer-Link Section -->
        <div class="section-card">
            <div class="section-card-header">
                <span class="section-icon">🔗</span>
                <h2>Tu enlace personal</h2>
            </div>
            
            <p class="section-description">Puedes usar este enlace para volver a acceder a tu participación más tarde.</p>
            
            <div class="link-display-container">
                <pre id="participant-link" class="link-display" data-url="<?php echo htmlspecialchars(get_display_url('/participant.php?token=' . urlencode($participant_token))); ?>"><?php echo htmlspecialchars(get_display_url('/participant.php?token=' . urlencode($participant_token))); ?></pre>
                <button class="button secondary copy-btn" onclick="copyToClipboard('participant-link')">
                    <span>📋</span>
                    Copiar enlace
                </button>
            </div>
        </div>

        <?php
        // Prüfen ob mehrere Gruppen im Cookie gespeichert sind
        $saved_tokens = get_tokens_from_cookie();
        if (count($saved_tokens) > 1):
        ?>
        <!-- Multi-Group Navigation -->
        <div class="multi-group-nav">
            <p class="multi-group-text">
                <span class="multi-group-icon">🎁</span>
                Participas en varios grupos de Wichteln
            </p>
            <a href="participant.php" class="button secondary">
                🔄 Cambiar de grupo
            </a>
        </div>
        <?php endif; ?>

        <?php 
        // Google Ad Position 2: Am Ende der Seite
        if (defined('GOOGLE_ADS_ENABLED') && GOOGLE_ADS_ENABLED && 
            defined('GOOGLE_ADS_SHOW_OPTION2') && GOOGLE_ADS_SHOW_OPTION2): 
            $is_testing = defined('GOOGLE_ADS_TESTING') && GOOGLE_ADS_TESTING;
        ?>
        <div class="ad-container">
            <div class="ad-label"><?php echo $is_testing ? 'Anuncio de prueba (Posición 2)' : 'Anuncio'; ?></div>
            <?php if ($is_testing): ?>
                <div class="ad-test-placeholder">
                    📊 Google Ad Placeholder<br>
                    Position 2: Am Ende der Seite<br>
                    Responsive Display Ad
                </div>
            <?php else: ?>
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?php echo htmlspecialchars(GOOGLE_ADS_CLIENT); ?>"
                     crossorigin="anonymous"></script>
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="<?php echo htmlspecialchars(GOOGLE_ADS_CLIENT); ?>"
                     data-ad-slot="<?php echo htmlspecialchars(GOOGLE_ADS_SLOT_OPTION2); ?>"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Cookie Banner -->
    <?php include 'cookie-banner.php'; ?>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>