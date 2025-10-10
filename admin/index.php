<?php
// /admin/index.php

require_once '../functions.php';
require_once '../config.php';

// Überprüfen, ob das master_token korrekt ist
$master_token = $_GET['master_token'] ?? '';

if ($master_token !== MASTER_ADMIN_TOKEN) {
    die('Zugriff verweigert. Ungültiges Master-Token.');
}

$pdo = db_connect();

// Aktionen: Reset oder Löschen einer Gruppe über GET-Parameter
if (isset($_GET['action']) && isset($_GET['group_id'])) {
    $action = $_GET['action'];
    $group_id = intval($_GET['group_id']);

    if ($action === 'reset') {
        // Gruppe zurücksetzen: is_drawn auf 0 setzen und assigned_to in Teilnehmern leeren
        $pdo->beginTransaction();
        try {
            // Setze is_drawn auf 0
            $stmt = $pdo->prepare("UPDATE `groups` SET `is_drawn` = 0 WHERE `id` = ?");
            $stmt->execute([$group_id]);

            // Setze assigned_to auf NULL für alle Teilnehmer der Gruppe
            $stmt = $pdo->prepare("UPDATE `participants` SET `assigned_to` = NULL WHERE `group_id` = ?");
            $stmt->execute([$group_id]);

            $pdo->commit();
            $message = "Gruppe erfolgreich zurückgesetzt.";
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Fehler beim Zurücksetzen der Gruppe: " . $e->getMessage();
        }
    }

    if ($action === 'delete') {
        // Gruppe löschen: Setze assigned_to auf NULL für alle Teilnehmer der Gruppe
        $pdo->beginTransaction();
        try {
            // Setze assigned_to auf NULL für Teilnehmer der Gruppe
            $stmt = $pdo->prepare("UPDATE `participants` SET `assigned_to` = NULL WHERE `group_id` = ?");
            $stmt->execute([$group_id]);

            // Lösche Teilnehmer
            $stmt = $pdo->prepare("DELETE FROM `participants` WHERE `group_id` = ?");
            $stmt->execute([$group_id]);

            // Lösche Gruppe
            $stmt = $pdo->prepare("DELETE FROM `groups` WHERE `id` = ?");
            $stmt->execute([$group_id]);

            $pdo->commit();
            $message = "Gruppe erfolgreich gelöscht.";
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Fehler beim Löschen der Gruppe: " . $e->getMessage();
        }
    }
}

// Alle Gruppen abrufen
$stmt = $pdo->prepare("SELECT * FROM `groups` ORDER BY `name` ASC");
$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Admin Übersicht - Wichtel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto&display=swap" rel="stylesheet">
    <!-- CSS Stylesheet -->
    <link rel="stylesheet" href="https://xn--wichtl-gua.ch/css/styles.css">
</head>
<body>
    <header>
        <img src="https://xn--wichtl-gua.ch/images/logo.png" alt="Wichtel Logo">
    </header>
    <div class="container">
        <h1>Admin Übersicht</h1>

        <?php if (isset($message)): ?>
            <div class="notification success">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="notification error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($groups): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Budget</th>
                        <th>Beschreibung</th>
                        <th>Geschenkübergabe</th>
                        <th>Status</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($groups as $group): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($group['name'] ?? ''); ?></td>
                            <td><?php echo $group['budget'] !== null ? htmlspecialchars(number_format($group['budget'], 2)) . " CHF" : "Nicht festgelegt"; ?></td>
                            <td><?php echo htmlspecialchars($group['description'] ?? 'Keine Beschreibung.'); ?></td>
                            <td><?php echo $group['gift_exchange_date'] ? htmlspecialchars(date('d.m.Y', strtotime($group['gift_exchange_date']))) : "Nicht festgelegt"; ?></td>
                            <td>
                                <?php if ($group['is_drawn']): ?>
                                    <span class="status drawn">Ausgelost</span>
                                <?php else: ?>
                                    <span class="status not-drawn">Nicht ausgelost</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- Reset Link -->
                                <a href="index.php?master_token=<?php echo urlencode($master_token); ?>&action=reset&group_id=<?php echo urlencode($group['id']); ?>" 
                                   class="button secondary action-button" 
                                   onclick="return confirm('Möchtest du die Gruppe \"<?php echo htmlspecialchars($group['name']); ?>\" wirklich zurücksetzen?');">
                                    <img src="https://xn--wichtl-gua.ch/images/icon-reset.svg" alt="Reset" width="16" height="16">
                                    Reset
                                </a>

                                <!-- Delete Link -->
                                <a href="index.php?master_token=<?php echo urlencode($master_token); ?>&action=delete&group_id=<?php echo urlencode($group['id']); ?>" 
                                   class="button error action-button" 
                                   onclick="return confirm('Möchtest du die Gruppe \"<?php echo htmlspecialchars($group['name']); ?>\" wirklich löschen? Diese Aktion kann nicht rückgängig gemacht werden.');">
                                    <img src="https://xn--wichtl-gua.ch/images/icon-delete.svg" alt="Delete" width="16" height="16">
                                    Löschen
                                </a>

                                <!-- Manage Link -->
                                <a href="https://xn--wichtl-gua.ch/admin.php?token=<?php echo urlencode($group['admin_token']); ?>" 
                                   class="button primary action-button">
                                    <img src="https://xn--wichtl-gua.ch/images/icon-admin.svg" alt="Verwalten" width="16" height="16">
                                    Verwalten
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Keine Gruppen vorhanden.</p>
        <?php endif; ?>
    </div>
</body>
</html>
