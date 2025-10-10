<?php
// participant.php

require_once 'functions.php';

$participant_token = $_GET['token'] ?? '';
$pdo = db_connect();

// Teilnehmer abrufen
$stmt = $pdo->prepare("SELECT * FROM `participants` WHERE `participant_token` = ?");
$stmt->execute([$participant_token]);
$participant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$participant) {
    die('Ungültiger Token.');
}

// Gruppe abrufen
$stmt = $pdo->prepare("SELECT * FROM `groups` WHERE `id` = ?");
$stmt->execute([$participant['group_id']]);
$group = $stmt->fetch(PDO::FETCH_ASSOC);

// Zugewiesenen Teilnehmer abrufen, falls ausgelost
$assigned = null;
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
    
    $wishlist_success = "Deine Wunschliste wurde erfolgreich gespeichert.";
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Teilnehmerbereich - <?php echo htmlspecialchars($participant['name']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto&display=swap" rel="stylesheet">
    <!-- CSS Stylesheet -->
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Zusätzliche Styles spezifisch für participant.php (falls nötig) */
    </style>
    <!-- JavaScript für Kopieren-Button -->
    <script>
        function copyToClipboard(elementId) {
            var copyText = document.getElementById(elementId).innerText;
            var tempInput = document.createElement("textarea");
            tempInput.value = copyText;
            document.body.appendChild(tempInput);
            tempInput.select();
            tempInput.setSelectionRange(0, 99999); // Für mobile Geräte
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            alert("Link kopiert: " + copyText);
        }
    </script>
</head>
<body>
    <header>
        <img src="images/logo.png" alt="Wichtel Logo">
    </header>
    <div class="container">
        <h1>Willkommen, <?php echo htmlspecialchars($participant['name']); ?>!</h1>
        <p>Gruppe: <?php echo htmlspecialchars($group['name']); ?></p>
        
        <?php if (isset($wishlist_success)): ?>
            <div class="notification success">
                <?php echo htmlspecialchars($wishlist_success); ?>
            </div>
        <?php endif; ?>
        
		        <?php if ($group['is_drawn']): ?>
            <?php if ($assigned): ?>
                <h2>Dein Wichtelpartner:</h2>
                <p style="font-size: 1.3rem; font-weight: 600; color: var(--primary-color);"><?php echo htmlspecialchars($assigned['name']); ?></p>
                
                <?php if (!empty($assigned['wishlist'])): ?>
                    <h3>Wunschliste von <?php echo htmlspecialchars($assigned['name']); ?>:</h3>
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; border-left: 4px solid var(--secondary-color); margin-bottom: 1.5rem;">
                        <p style="white-space: pre-wrap; margin: 0;"><?php echo htmlspecialchars($assigned['wishlist']); ?></p>
                    </div>
                <?php else: ?>
                    <p class="text-muted"><?php echo htmlspecialchars($assigned['name']); ?> hat noch keine Wunschliste hinterlegt.</p>
                <?php endif; ?>
            <?php else: ?>
                <div class="notification error">
                    Dein Wichtelpartner konnte nicht gefunden werden.
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p>Die Auslosung wurde noch nicht durchgeführt. Bitte schaue später wieder vorbei.</p>
        <?php endif; ?>
        
        <hr>
        
        <!-- Wunschliste bearbeiten -->
        <h2>Deine Wunschliste</h2>
        <?php if (!$group['is_drawn']): ?>
            <p>Trage hier deine Wünsche ein. Dein Wichtelpartner wird diese nach der Auslosung sehen können.</p>
            <form method="POST">
                <div class="form-group">
                    <label for="wishlist">Wunschliste:</label>
                    <textarea id="wishlist" name="wishlist" rows="6" placeholder="z.B.&#10;- Bücher über...&#10;- Schokolade&#10;- Etwas Selbstgemachtes&#10;- Überraschung!"><?php echo htmlspecialchars($participant['wishlist'] ?? ''); ?></textarea>
                </div>
                <button type="submit" name="update_wishlist" class="button primary">Wunschliste speichern</button>
            </form>
        <?php else: ?>
            <?php if (!empty($participant['wishlist'])): ?>
                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; border-left: 4px solid var(--primary-color);">
                    <p style="white-space: pre-wrap; margin: 0;"><?php echo htmlspecialchars($participant['wishlist']); ?></p>
                </div>
            <?php else: ?>
                <p class="text-muted">Du hast keine Wunschliste hinterlegt.</p>
            <?php endif; ?>
            <p class="text-muted" style="margin-top: 1rem;">Die Wunschliste kann nach der Auslosung nicht mehr geändert werden.</p>
        <?php endif; ?>
		
        <hr>
        
        <h2>Gruppendetails</h2>
        <ul>
            <li><strong>Budget:</strong> <?php echo $group['budget'] !== null ? htmlspecialchars(number_format($group['budget'], 2)) . " CHF" : "Nicht festgelegt"; ?></li>
            <li><strong>Beschreibung:</strong> <?php echo htmlspecialchars($group['description'] ?: "Keine Beschreibung."); ?></li>
            <li><strong>Datum der Geschenkübergabe:</strong> <?php echo $group['gift_exchange_date'] ? htmlspecialchars(date('d.m.Y', strtotime($group['gift_exchange_date']))) : "Nicht festgelegt"; ?></li>
        </ul>

        <!-- Eigener Teilnehmer-Link anzeigen -->
        <h2>Dein Link</h2>
        <p>Du kannst diesen Link verwenden, um deine Teilnahme zu teilen oder für zukünftige Referenz zu speichern:</p>
        <pre id="participant-link"><?php echo htmlspecialchars(get_display_url('/participant.php?token=' . urlencode($participant_token))); ?></pre>
        <button class="button secondary small copy-button" onclick="copyToClipboard('participant-link')">Link kopieren</button>

    </div>
</body>
</html>
