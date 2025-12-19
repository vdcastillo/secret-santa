<?php
// admin.php

require_once 'functions.php';

$admin_token = $_GET['token'] ?? '';
$pdo = db_connect();

// Gruppe abrufen
$stmt = $pdo->prepare("SELECT * FROM `groups` WHERE `admin_token` = ?");
$stmt->execute([$admin_token]);
$group = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$group) {
    die('Token no válido.');
}

// Teilnehmer abrufen
$stmt = $pdo->prepare("SELECT * FROM `participants` WHERE `group_id` = ?");
$stmt->execute([$group['id']]);
$participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Auslosung zurücksetzen
if (isset($_POST['reset_draw'])) {
    $pdo->beginTransaction();
    try {
        // Setze is_drawn auf 0
        $stmt = $pdo->prepare("UPDATE `groups` SET `is_drawn` = 0 WHERE `id` = ?");
        $stmt->execute([$group['id']]);
        
        // Setze assigned_to auf NULL für alle Teilnehmer der Gruppe
        $stmt = $pdo->prepare("UPDATE `participants` SET `assigned_to` = NULL WHERE `group_id` = ?");
        $stmt->execute([$group['id']]);
        
        $pdo->commit();
        $reset_success = "Sorteo reiniciado correctamente. Ahora puedes volver a sortear.";
        
        // Gruppe neu abrufen
        $stmt = $pdo->prepare("SELECT * FROM `groups` WHERE `admin_token` = ?");
        $stmt->execute([$admin_token]);
        $group = $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        $reset_error = "Error al reiniciar el sorteo: " . $e->getMessage();
    }
}

// Gruppe löschen
if (isset($_POST['delete_group'])) {
    $pdo->beginTransaction();
    try {
        $group_id = $group['id'];
        
        // Setze assigned_to auf NULL für alle Teilnehmer
        $stmt = $pdo->prepare("UPDATE `participants` SET `assigned_to` = NULL WHERE `group_id` = ?");
        $stmt->execute([$group_id]);
        
        // Lösche alle Ausschlüsse
        $stmt = $pdo->prepare("DELETE FROM `exclusions` WHERE `group_id` = ?");
        $stmt->execute([$group_id]);
        
        // Lösche alle Teilnehmer
        $stmt = $pdo->prepare("DELETE FROM `participants` WHERE `group_id` = ?");
        $stmt->execute([$group_id]);
        
        // Lösche die Gruppe
        $stmt = $pdo->prepare("DELETE FROM `groups` WHERE `id` = ?");
        $stmt->execute([$group_id]);
        
        $pdo->commit();
        
        // Redirección a la página principal con mensaje de éxito
        header("Location: index.php?deleted=1");
        exit();
        
    } catch (Exception $e) {
        $pdo->rollBack();
        $delete_error = "Error al eliminar el grupo: " . $e->getMessage();
    }
}

// Teilnehmer E-Mail aktualisieren
if (isset($_POST['update_participant_email'])) {
    $participant_id = intval($_POST['participant_id']);
    $new_email = trim($_POST['participant_email']);
    
    // Validación
    if (!empty($new_email) && !filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $participant_error = "Dirección de correo no válida.";
    } else {
        // Verificar si el participante pertenece al grupo
        $stmt = $pdo->prepare("SELECT id FROM `participants` WHERE `id` = ? AND `group_id` = ?");
        $stmt->execute([$participant_id, $group['id']]);
        
        if ($stmt->fetch()) {
            $stmt = $pdo->prepare("UPDATE `participants` SET `email` = ? WHERE `id` = ?");
            $stmt->execute([$new_email ?: null, $participant_id]);
            $participant_success = "Correo actualizado correctamente.";
            
            // Recargar participantes
            $stmt = $pdo->prepare("SELECT * FROM `participants` WHERE `group_id` = ?");
            $stmt->execute([$group['id']]);
            $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $participant_error = "Participante no encontrado.";
        }
    }
}

// E-Mail erneut senden
if (isset($_POST['resend_email'])) {
    $participant_id = intval($_POST['participant_id']);
    
    // Prüfe ob Gruppe ausgelost wurde und Teilnehmer zur Gruppe gehört
    if (!$group['is_drawn']) {
        $email_error = "Die Auslosung wurde noch nicht durchgeführt.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM `participants` WHERE `id` = ? AND `group_id` = ?");
        $stmt->execute([$participant_id, $group['id']]);
        $participant = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$participant) {
            $email_error = "Teilnehmer nicht gefunden.";
        } elseif (empty($participant['email'])) {
            $email_error = "Teilnehmer hat keine E-Mail-Adresse hinterlegt.";
        } elseif (empty($participant['assigned_to'])) {
            $email_error = "Diesem Teilnehmer wurde noch keine Person zugewiesen.";
        } else {
            // Zugewiesenen Teilnehmer abrufen
            $stmt = $pdo->prepare("SELECT * FROM `participants` WHERE `id` = ?");
            $stmt->execute([$participant['assigned_to']]);
            $assigned = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($assigned) {
                // Gruppendetails abrufen
                $group_budget = $group['budget'] !== null ? number_format($group['budget'], 2) . " CHF" : "Nicht festgelegt";
                $group_description = $group['description'] ?: "Keine Beschreibung.";
                $gift_exchange_date = $group['gift_exchange_date'] ? date('d.m.Y', strtotime($group['gift_exchange_date'])) : "Nicht festgelegt";

                // Erstelle HTML-E-Mail
                $subject = 'Dein Wichtelpartner 🎁';
                $html_message = create_html_email(
                    $participant['name'],
                    $assigned['name'],
                    $assigned['wishlist'] ?? '',
                    $group_budget,
                    $group_description,
                    $gift_exchange_date
                );

                if (send_email($participant['email'], $subject, $html_message, true)) {
                    $email_success = "E-Mail erfolgreich an " . htmlspecialchars($participant['name']) . " gesendet.";
                } else {
                    $email_error = "Fehler beim Versenden der E-Mail an " . htmlspecialchars($participant['name']) . ".";
                }
            } else {
                $email_error = "Zugewiesener Teilnehmer nicht gefunden.";
            }
        }
    }
}

// Teilnehmer löschen
if (isset($_GET['delete'])) {
    $participant_id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM `participants` WHERE `id` = ?");
    $stmt->execute([$participant_id]);
    header("Location: admin.php?token=" . urlencode($admin_token));
    exit();
}

// Ausschluss hinzufügen
if (isset($_POST['add_exclusion'])) {
    $participant_id = intval($_POST['participant_id']);
    $excluded_id = intval($_POST['excluded_participant_id']);
    
    if ($participant_id && $excluded_id && $participant_id !== $excluded_id) {
        try {
            $stmt = $pdo->prepare("INSERT INTO `exclusions` (`group_id`, `participant_id`, `excluded_participant_id`) VALUES (?, ?, ?)");
            $stmt->execute([$group['id'], $participant_id, $excluded_id]);
            $exclusion_success = "Ausschluss erfolgreich hinzugefügt.";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Duplicate entry
                $exclusion_error = "Dieser Ausschluss existiert bereits.";
            } else {
                $exclusion_error = "Fehler beim Hinzufügen des Ausschlusses.";
            }
        }
    } else {
        $exclusion_error = "Ungültige Auswahl.";
    }
}

// Ausschluss löschen
if (isset($_GET['delete_exclusion'])) {
    $exclusion_id = intval($_GET['delete_exclusion']);
    $stmt = $pdo->prepare("DELETE FROM `exclusions` WHERE `id` = ? AND `group_id` = ?");
    $stmt->execute([$exclusion_id, $group['id']]);
    header("Location: admin.php?token=" . urlencode($admin_token));
    exit();
}

// Alle Ausschlüsse für diese Gruppe abrufen
$stmt = $pdo->prepare("
    SELECT e.*, 
           p1.name as participant_name, 
           p2.name as excluded_name 
    FROM `exclusions` e
    JOIN `participants` p1 ON e.participant_id = p1.id
    JOIN `participants` p2 ON e.excluded_participant_id = p2.id
    WHERE e.group_id = ?
    ORDER BY p1.name, p2.name
");
$stmt->execute([$group['id']]);
$exclusions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gruppe bearbeiten
if (isset($_POST['update_group'])) {
    $new_budget = trim($_POST['budget']) ?: null;
    $new_description = trim($_POST['description']) ?: null;
    $new_gift_exchange_date = trim($_POST['gift_exchange_date']) ?: null;
    
    // Validierung (optional)
    if ($new_budget !== null && !is_numeric($new_budget)) {
        $update_error = "Budget muss eine Zahl sein.";
    } elseif ($new_gift_exchange_date !== null && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $new_gift_exchange_date)) {
        $update_error = "Datum der Geschenkübergabe muss im Format YYYY-MM-DD sein.";
    } else {
        // Aktualisiere die Gruppe
        $stmt = $pdo->prepare("UPDATE `groups` SET `budget` = ?, `description` = ?, `gift_exchange_date` = ? WHERE `id` = ?");
        $stmt->execute([$new_budget, $new_description, $new_gift_exchange_date, $group['id']]);
        
        // Aktualisiere das $group-Array
        $group['budget'] = $new_budget;
        $group['description'] = $new_description;
        $group['gift_exchange_date'] = $new_gift_exchange_date;
        
        $update_success = "Gruppeninformationen erfolgreich aktualisiert.";
    }
}

// Auslosung durchführen
if (isset($_POST['draw'])) {
    if (count($participants) < 2) {
        $draw_error = 'Es müssen mindestens 2 Teilnehmer vorhanden sein.';
    } else {
        // Ausschlüsse laden
        $stmt = $pdo->prepare("SELECT participant_id, excluded_participant_id FROM `exclusions` WHERE `group_id` = ?");
        $stmt->execute([$group['id']]);
        $exclusion_rules = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Exclusions-Map erstellen
        $exclusions_map = [];
        foreach ($exclusion_rules as $rule) {
            if (!isset($exclusions_map[$rule['participant_id']])) {
                $exclusions_map[$rule['participant_id']] = [];
            }
            $exclusions_map[$rule['participant_id']][] = $rule['excluded_participant_id'];
        }
        
        $participant_ids = array_column($participants, 'id');
        $assigned_ids = $participant_ids;
        
        // Versuche eine gültige Zuteilung zu finden (max 1000 Versuche)
        $max_attempts = 1000;
        $attempt = 0;
        $valid_assignment = false;
        
        while (!$valid_assignment && $attempt < $max_attempts) {
            shuffle($assigned_ids);
            $valid_assignment = true;
            
            for ($i = 0; $i < count($participant_ids); $i++) {
                $giver = $participant_ids[$i];
                $receiver = $assigned_ids[$i];
                
                // Prüfe ob Person sich selbst zieht
                if ($giver == $receiver) {
                    $valid_assignment = false;
                    break;
                }
                
                // Prüfe ob diese Zuteilung ausgeschlossen ist
                if (isset($exclusions_map[$giver]) && in_array($receiver, $exclusions_map[$giver])) {
                    $valid_assignment = false;
                    break;
                }
            }
            
            $attempt++;
        }
        
        if (!$valid_assignment) {
            $draw_error = 'Es konnte keine gültige Auslosung gefunden werden. Bitte überprüfe die Ausschlüsse - möglicherweise sind zu viele Ausschlüsse definiert.';
        } else {
            // Zuordnungen speichern
            for ($i = 0; $i < count($participant_ids); $i++) {
                $stmt = $pdo->prepare("UPDATE `participants` SET `assigned_to` = ? WHERE `id` = ?");
                $stmt->execute([$assigned_ids[$i], $participant_ids[$i]]);
            }

            // Gruppe als ausgelost markieren
            $stmt = $pdo->prepare("UPDATE `groups` SET `is_drawn` = 1 WHERE `id` = ?");
            $stmt->execute([$group['id']]);

            // Teilnehmer erneut abrufen, um die aktualisierten `assigned_to`-Werte zu erhalten
            $stmt = $pdo->prepare("SELECT * FROM `participants` WHERE `group_id` = ?");
            $stmt->execute([$group['id']]);
            $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // E-Mails versenden
            foreach ($participants as $participant) {
                if (!empty($participant['email'])) {
                    // Zugewiesenen Teilnehmer abrufen
                    if (!empty($participant['assigned_to'])) {
                        $stmt = $pdo->prepare("SELECT * FROM `participants` WHERE `id` = ?");
                        $stmt->execute([$participant['assigned_to']]);
                        $assigned = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($assigned) {
                            // Gruppendetails abrufen
                            $group_budget = $group['budget'] !== null ? number_format($group['budget'], 2) . " CHF" : "Nicht festgelegt";
                            $group_description = $group['description'] ?: "Keine Beschreibung.";
                            $gift_exchange_date = $group['gift_exchange_date'] ? date('d.m.Y', strtotime($group['gift_exchange_date'])) : "Nicht festgelegt";

                            // Erstelle HTML-E-Mail
                            $subject = 'Tu Santa secreto 🎁';
                            $html_message = create_html_email(
                                $participant['name'],
                                $assigned['name'],
                                $assigned['wishlist'] ?? '',
                                $group_budget,
                                $group_description,
                                $gift_exchange_date
                            );

                            $response = send_email($participant['email'], $subject, $html_message, true);
                            if (!$response['success']) {
                                // Fehlerbehandlung, falls E-Mail nicht gesendet werden konnte
                                error_log("E-Mail konnte nicht an {$participant['email']} gesendet werden. {$response['response']}");
                            }
                        } else {
                            // Fehlerprotokollierung, wenn der zugewiesene Teilnehmer nicht gefunden wird
                            error_log("Zugewiesener Teilnehmer mit ID {$participant['assigned_to']} nicht gefunden.");
                        }
                    } else {
                        // Fehlerprotokollierung, wenn `assigned_to` leer ist
                        error_log("Teilnehmer mit ID {$participant['id']} hat keinen zugewiesenen Teilnehmer.");
                    }
                }
            }

            // Weiterleitung zum Adminbereich ohne vorherige Ausgabe
            header("Location: admin.php?token=" . urlencode($admin_token));
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Área de administración - <?php echo htmlspecialchars($group['name']); ?></title>
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
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto&display=swap" rel="stylesheet">
    <!-- CSS Stylesheet -->
    <link rel="stylesheet" href="css/styles.css">
    
    <!-- JavaScript para botón de copiar -->
    <script>
        function copyToClipboard(elementId) {
            var element = document.getElementById(elementId);
            var copyText = element.getAttribute('data-url') || element.innerText || element.textContent;
            
            // API moderna del portapapeles (preferida)
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(copyText).then(function() {
                    alert("¡Enlace copiado!: " + copyText);
                }).catch(function(err) {
                    // Alternativa en caso de error
                    fallbackCopy(copyText);
                });
            } else {
                // Alternativa para navegadores antiguos
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
            tempInput.setSelectionRange(0, 99999); // Para dispositivos móviles
            try {
                document.execCommand("copy");
                alert("¡Enlace copiado!: " + text);
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
    <header>
        <img src="images/logo.png" alt="Logo de Wichteln">
    </header>
    <div class="container">
        <h1>Área de administración - <?php echo htmlspecialchars($group['name']); ?></h1>
        
        <?php if (isset($update_error)): ?>
            <div class="notification error">
                <?php echo htmlspecialchars($update_error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($update_success)): ?>
            <div class="notification success">
                <?php echo htmlspecialchars($update_success); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($draw_error)): ?>
            <div class="notification error">
                <?php echo htmlspecialchars($draw_error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($exclusion_success)): ?>
            <div class="notification success">
                <?php echo htmlspecialchars($exclusion_success); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($exclusion_error)): ?>
            <div class="notification error">
                <?php echo htmlspecialchars($exclusion_error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($reset_success)): ?>
            <div class="notification success">
                <?php echo htmlspecialchars($reset_success); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($reset_error)): ?>
            <div class="notification error">
                <?php echo htmlspecialchars($reset_error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($delete_error)): ?>
            <div class="notification error">
                <?php echo htmlspecialchars($delete_error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($participant_success)): ?>
            <div class="notification success">
                <?php echo htmlspecialchars($participant_success); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($participant_error)): ?>
            <div class="notification error">
                <?php echo htmlspecialchars($participant_error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($email_success)): ?>
            <div class="notification success">
                <?php echo $email_success; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($email_error)): ?>
            <div class="notification error">
                <?php echo htmlspecialchars($email_error); ?>
            </div>
        <?php endif; ?>

        <!-- Editar detalles del grupo -->
        <h2>Detalles del grupo</h2>
        <form method="POST">
            <div class="form-group">
                <label for="budget">Presupuesto (opcional):</label>
                <input type="number" step="0.01" id="budget" name="budget" value="<?php echo htmlspecialchars($group['budget'] ?? ''); ?>" placeholder="p. ej., 20.00">
            </div>
            <div class="form-group">
                <label for="description">Descripción (opcional):</label>
                <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($group['description'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="gift_exchange_date">Fecha del intercambio de regalos (opcional):</label>
                <input type="date" id="gift_exchange_date" name="gift_exchange_date" value="<?php echo htmlspecialchars($group['gift_exchange_date'] ?? ''); ?>">
            </div>
            <button type="submit" name="update_group" class="button secondary">Actualizar detalles del grupo</button>
        </form>
        
        <hr>
        
        <!-- Enlace de invitación para participantes -->
        <h2>Enlace de invitación para participantes</h2>
        <pre id="participant-link"><?php echo htmlspecialchars(get_display_url('/register.php?token=' . urlencode($group['invite_token']))); ?></pre>
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-top: 1rem;">
            <button class="button secondary small copy-button" onclick="copyToClipboard('participant-link')">Copiar enlace</button>
            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode('¡Hola! Estás invitado a participar en nuestro Wichteln. 🎁') . '%0A%0A' . urlencode('Grupo: ' . $group['name']) . '%0A%0A' . urlencode('Regístrate aquí: ' . get_display_url('/register.php?token=' . urlencode($group['invite_token']))); ?>" 
               target="_blank" 
               class="button secondary small">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 0.25rem;">
                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" fill="#25D366"/>
                </svg>
                Compartir por WhatsApp
            </a>
        </div>
        
        <div class="admin-info-box">
            <div class="admin-info-icon">💡</div>
            <div class="admin-info-content">
                <h3 class="admin-info-title">Hinweis für dich als Administrator</h3>
                <p class="admin-info-text">Wenn du selbst beim Wichteln mitmachen möchtest, musst du dich ebenfalls über den obigen Einladungslink als Teilnehmer registrieren. Der Admin-Link dient nur zur Verwaltung der Gruppe.</p>
            </div>
        </div>
        
        <!-- Mostrar enlace de administrador -->
        <h2>Enlace de administrador</h2>
        <p>Este enlace permite el acceso directo al área de administración:</p>
        <pre id="admin-link"><?php echo htmlspecialchars(get_display_url('/admin.php?token=' . urlencode($admin_token))); ?></pre>
        <button class="button secondary small copy-button" onclick="copyToClipboard('admin-link')">Copiar enlace</button>
        
        <hr>
        
        <!-- Mostrar lista de participantes -->
        <h2>Participantes (<?php echo count($participants); ?>)</h2>
        <?php if ($participants): ?>
            <div class="participants-grid">
                <?php foreach ($participants as $p): ?>
                    <div class="participant-card">
                        <div class="participant-header">
                            <div class="participant-info">
                                <h3 class="participant-name"><?php echo htmlspecialchars($p['name'] ?? ''); ?></h3>
                                <div class="participant-email">
                                    <?php if (!empty($p['email'])): ?>
                                        <span class="email-display">✉️ <?php echo htmlspecialchars($p['email']); ?></span>
                                    <?php else: ?>
                                        <span class="email-missing">⚠️ Sin correo</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="participant-actions">
                            <?php if (!empty($p['participant_token'])): ?>
                                <button type="button"
                                        class="action-btn copy-btn" 
                                        onclick="copyToClipboard('participant-link-<?php echo $p['id']; ?>')"
                                        title="Copiar enlace del participante">
                                    <span class="btn-icon">📋</span>
                                    <span class="btn-text">Copiar enlace</span>
                                </button>
                                <span id="participant-link-<?php echo $p['id']; ?>" 
                                      data-url="<?php echo htmlspecialchars(get_display_url('/participant.php?token=' . urlencode($p['participant_token']))); ?>"
                                      style="display: none;"></span>
                            <?php endif; ?>
                            
                            <?php 
                            $can_send_email = $group['is_drawn'] && !empty($p['email']) && !empty($p['assigned_to']);
                            ?>
                            <form method="POST" class="action-form">
                                <input type="hidden" name="participant_id" value="<?php echo $p['id']; ?>">
                                <button type="submit" 
                                        name="resend_email" 
                                        class="action-btn email-btn <?php echo !$can_send_email ? 'disabled' : ''; ?>"
                                        title="<?php echo $can_send_email ? 'Reenviar correo' : 'No se puede enviar el correo (no hay dirección o el sorteo no se ha realizado)'; ?>"
                                        <?php echo !$can_send_email ? 'disabled' : ''; ?>
                                        <?php echo $can_send_email ? 'onclick="return confirm(\'¿Enviar correo con la persona asignada a ' . htmlspecialchars($p['name']) . '?\');"' : ''; ?>>
                                    <span class="btn-icon">📧</span>
                                    <span class="btn-text">Enviar correo</span>
                                </button>
                            </form>
                            
                            <?php if (!$group['is_drawn']): ?>
                                <a href="admin.php?token=<?php echo urlencode($admin_token); ?>&delete=<?php echo urlencode($p['id']); ?>" 
                                   class="action-btn delete-btn"
                                   onclick="return confirm('¿Seguro que quieres eliminar a <?php echo htmlspecialchars($p['name']); ?>?');">
                                    <span class="btn-icon">🗑️</span>
                                    <span class="btn-text">Eliminar</span>
                                </a>
                            <?php endif; ?>
                        </div>
                        
                        <div class="participant-email-edit">
                            <form method="POST" class="email-edit-form">
                                <input type="hidden" name="participant_id" value="<?php echo $p['id']; ?>">
                                <div class="email-edit-group">
                                    <input type="email" 
                                           name="participant_email" 
                                           value="<?php echo htmlspecialchars($p['email'] ?? ''); ?>" 
                                           placeholder="Añadir correo..."
                                           class="email-edit-input">
                                    <button type="submit" 
                                            name="update_participant_email" 
                                            class="email-edit-btn"
                                            title="Guardar correo">
                                        💾 Guardar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">👥</div>
                <p class="empty-text">Aún no hay participantes registrados.</p>
                <p class="empty-hint">Comparte el enlace de invitación de arriba para que los participantes se registren.</p>
            </div>
        <?php endif; ?>

        <!-- Gestionar exclusiones -->
        <?php if (!$group['is_drawn'] && count($participants) >= 2): ?>
            <hr>
            
            <h2>Gestionar exclusiones</h2>
            <p>Define quién no debería tocarle a quién. Útil, por ejemplo, si las parejas no deben regalarse entre sí.</p>
            
            <form method="POST" class="exclusion-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="participant_id">Persona:</label>
                        <select id="participant_id" name="participant_id" required>
                            <option value="">-- Selecciona una persona --</option>
                            <?php foreach ($participants as $p): ?>
                                <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="excluded_participant_id">no puede tocarle a:</label>
                        <select id="excluded_participant_id" name="excluded_participant_id" required>
                            <option value="">-- Selecciona una persona --</option>
                            <?php foreach ($participants as $p): ?>
                                <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label style="opacity: 0;">Añadir</label>
                        <button type="submit" name="add_exclusion" class="button secondary">Añadir exclusión</button>
                    </div>
                </div>
            </form>
            
            <?php if ($exclusions): ?>
                <h3>Exclusiones activas</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Persona</th>
                            <th>no puede tocarle a</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($exclusions as $ex): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($ex['participant_name']); ?></td>
                                <td><?php echo htmlspecialchars($ex['excluded_name']); ?></td>
                                <td>
                                    <a href="admin.php?token=<?php echo urlencode($admin_token); ?>&delete_exclusion=<?php echo urlencode($ex['id']); ?>" 
                                       class="button error small"
                                       onclick="return confirm('¿Seguro que quieres eliminar esta exclusión?');">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">No hay exclusiones definidas.</p>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Realizar sorteo -->
        <?php if (!$group['is_drawn']): ?>
            <hr>
            <h2>Realizar sorteo</h2>
            <p>Cuando todos los participantes estén registrados y las exclusiones definidas, puedes realizar el sorteo.</p>
            <form method="POST" style="margin-top: 1rem;">
                <button type="submit" name="draw" class="button primary">Sortear ahora</button>
            </form>
        <?php else: ?>
            <hr>
            <h2>Sorteo</h2>
            <div class="notification success">
                ✓ El sorteo ya se realizó. Todos los participantes con correo han sido notificados.
            </div>
            
            <h3>Reiniciar sorteo</h3>
            <p class="text-muted">Puedes reiniciar el sorteo para realizarlo de nuevo. Esto elimina todas las asignaciones actuales y podrás añadir nuevos participantes o cambiar exclusiones.</p>
            <form method="POST" style="margin-top: 1rem;" onsubmit="return confirm('¿Seguro que quieres reiniciar el sorteo? Se borrarán todas las asignaciones actuales.');">
                <button type="submit" name="reset_draw" class="button error">Reiniciar sorteo</button>
            </form>
        <?php endif; ?>
        
        <!-- Eliminar grupo -->
        <hr>
        <h2 style="color: var(--error);">⚠️ Zona de peligro</h2>
        <p class="text-muted">Eliminar el grupo no se puede deshacer. Todos los participantes, exclusiones y el sorteo se eliminarán permanentemente.</p>
        <form method="POST" style="margin-top: 1rem;" onsubmit="return confirm('⚠️ ATENCIÓN: ¿Seguro que quieres eliminar PERMANENTEMENTE el grupo \"<?php echo htmlspecialchars($group['name']); ?>\"?\n\n¡Todos los participantes, exclusiones y el sorteo se borrarán de forma irreversible!\n\nEsta acción NO se puede deshacer.');">
            <button type="submit" name="delete_group" class="button error" style="background: linear-gradient(135deg, #dc3545, #c82333);">
                🗑️ Eliminar grupo permanentemente
            </button>
        </form>
    </div>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>