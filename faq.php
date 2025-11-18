<?php
if (file_exists('config.php')) {
    require_once 'config.php';
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>FAQ - Häufig gestellte Fragen zum Online Wichteln | Wichtlä.ch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Alle Antworten zu Wichtlä.ch: Kosten, Datenschutz, Funktionen, Probleme und Tipps. Finde schnell Hilfe für dein Wichtel-Event!">
    <meta name="keywords" content="Wichteln FAQ, Wichteln Hilfe, Online Wichteln Fragen, Wichteln Anleitung, Wichteln Support">
    <link rel="canonical" href="https://wichtlä.ch/faq.php">
    
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://wichtlä.ch/faq.php">
    <meta property="og:title" content="FAQ - Häufig gestellte Fragen zum Online Wichteln">
    <meta property="og:description" content="Alle Antworten zu Wichtlä.ch: Kosten, Datenschutz, Funktionen und mehr.">
    
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    
    <!-- Matomo -->
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
    
</head>
<body>
    <?php include 'includes/navigation.php'; ?>
    
    <div class="content-page">
        <div class="breadcrumb">
            <a href="index.php">Home</a> / FAQ
        </div>
        
        <header class="page-header">
            <h1 class="page-title">Häufig gestellte Fragen ?</h1>
            <p class="page-subtitle">Alle Antworten zu Wichtlä.ch, Funktionen, Datenschutz und Tipps für erfolgreiches Wichteln</p>
        </header>
        
        <article>
            <!-- Allgemeine Fragen -->
            <section class="faq-section">
                <h2>🎁 Allgemeine Fragen</h2>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Was ist Wichtlä.ch?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            Wichtlä.ch ist ein <strong>kostenloses Online-Tool</strong> zum Organisieren von Wichtel-Events. Du kannst damit ganz einfach:
                        </p>
                        <ul>
                            <li>Wichtel-Gruppen erstellen</li>
                            <li>Teilnehmer hinzufügen</li>
                            <li>Automatisch und fair Namen ziehen lassen</li>
                            <li>Lose per E-Mail verschicken</li>
                            <li>Ausschlüsse definieren (z.B. Paare ziehen sich nicht)</li>
                        </ul>
                        <p>
                            Alles ohne Registrierung, ohne App-Download – einfach im Browser!
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Kostet Wichtlä.ch etwas?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            <strong>Nein, Wichtlä.ch ist 100% kostenlos!</strong>
                        </p>
                        <p>
                            Es gibt keine versteckten Kosten, keine Premium-Accounts und keine Einschränkungen. Der Service wird durch kleine Werbeanzeigen finanziert, die dezent platziert sind und nicht stören.
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Muss ich mich registrieren?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            <strong>Nein!</strong> Es ist keine Registrierung erforderlich. Du erstellst einfach eine Gruppe, fügst Teilnehmer hinzu und erhältst einen Admin-Link per E-Mail. Fertig!
                        </p>
                        <p>
                            Das macht Wichtlä.ch besonders einfach und schnell in der Nutzung.
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Wie viele Personen können mitmachen?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            <strong>Mindestens 3 Personen</strong> werden empfohlen für ein funktionierendes Wichteln. Nach oben gibt es praktisch keine Grenze – ob 5, 20 oder 100 Teilnehmer, das System funktioniert für alle Gruppengrößen.
                        </p>
                        <p>
                            Besonders beliebt sind Gruppen von 5-30 Personen (z.B. für Familien, Freundeskreise oder Teams).
                        </p>
                    </div>
                </div>
            </section>
            
            <!-- Funktionen -->
            <section class="faq-section">
                <h2>⚙️ Funktionen & Nutzung</h2>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Wie funktioniert das Losziehen?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            Der Algorithmus stellt sicher, dass:
                        </p>
                        <ul>
                            <li>✅ Niemand sich selbst zieht</li>
                            <li>✅ Jede Person genau eine andere Person beschenkt</li>
                            <li>✅ Jede Person genau ein Geschenk erhält</li>
                            <li>✅ Definierte Ausschlüsse eingehalten werden</li>
                        </ul>
                        <p>
                            Das Los wird per E-Mail verschickt und bleibt geheim – du siehst nur, wen DU beschenken sollst.
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Was sind Ausschlüsse und wofür brauche ich sie?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            <strong>Ausschlüsse</strong> verhindern, dass bestimmte Personen einander ziehen. Das ist sinnvoll bei:
                        </p>
                        <ul>
                            <li>Paaren oder Ehepartner (kennen die Wünsche meist schon)</li>
                            <li>Enge Freunde, die sich sowieso beschenken</li>
                            <li>Geschwistern in Familien-Wichteln</li>
                            <li>Vorgesetzte/Mitarbeiter im Firmenwichteln</li>
                        </ul>
                        <p>
                            Beispiel: Du gibst an "Anna ↔ Peter" – dann kann Anna nicht Peter ziehen und Peter nicht Anna.
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Kann ich später noch Teilnehmer hinzufügen?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            <strong>Ja!</strong> Als Admin kannst du über deinen Admin-Link jederzeit:
                        </p>
                        <ul>
                            <li>Neue Teilnehmer hinzufügen</li>
                            <li>Wunschlisten ergänzen oder ändern</li>
                            <li>Weitere Ausschlüsse definieren</li>
                        </ul>
                        <p>
                            <strong>Wichtig:</strong> Sobald die Namen gezogen wurden, können keine Teilnehmer mehr hinzugefügt werden. Die Ziehung müsste neu durchgeführt werden.
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Kann ich die Ziehung wiederholen?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            <strong>Ja</strong>, als Admin kannst du die Ziehung zurücksetzen und neu durchführen lassen. Das ist nützlich, wenn:
                        </p>
                        <ul>
                            <li>Du Ausschlüsse vergessen hast</li>
                            <li>Neue Teilnehmer hinzugekommen sind</li>
                            <li>Ein Fehler passiert ist</li>
                        </ul>
                        <p>
                            <strong>Achtung:</strong> Bei einer neuen Ziehung werden alle bisherigen Zuordnungen gelöscht!
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Was passiert, wenn jemand sein Los verliert?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            Kein Problem! Jeder Teilnehmer kann sein Los jederzeit wieder abrufen:
                        </p>
                        <ul>
                            <li>Auf der Startseite gibt es den Link "Los abrufen"</li>
                            <li>E-Mail-Adresse eingeben → Los wird erneut zugeschickt</li>
                            <li>Oder: Der Admin kann über den Admin-Bereich die Los-Links einsehen</li>
                        </ul>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Kann ich mehrere Wichtel-Gruppen erstellen?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            <strong>Ja, absolut!</strong> Du kannst beliebig viele Gruppen erstellen, z.B.:
                        </p>
                        <ul>
                            <li>Eine für die Familie</li>
                            <li>Eine für Freunde</li>
                            <li>Eine für die Arbeit</li>
                        </ul>
                        <p>
                            Jede Gruppe hat ihren eigenen Admin-Link, den du per E-Mail erhältst.
                        </p>
                    </div>
                </div>
            </section>
            
            <!-- Datenschutz & Sicherheit -->
            <section class="faq-section">
                <h2>🔒 Datenschutz & Sicherheit</h2>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Sind meine Daten sicher?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            <strong>Ja!</strong> Wir nehmen Datenschutz sehr ernst:
                        </p>
                        <ul>
                            <li>🔐 SSL-Verschlüsselung für alle Verbindungen</li>
                            <li>🇨🇭 Server-Standort in der Schweiz</li>
                            <li>📜 Einhaltung des Schweizer Datenschutzgesetzes (DSG)</li>
                            <li>🗑️ Automatische Löschung nach Ablauf der Gruppe</li>
                            <li>🚫 Keine Weitergabe an Dritte (ausser Google AdSense für Werbung)</li>
                        </ul>
                        <p>
                            Mehr Details in unserer <a href="datenschutz.php">Datenschutzerklärung</a>.
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Welche Daten werden gespeichert?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            Wir speichern nur das Nötigste:
                        </p>
                        <ul>
                            <li>Namen der Teilnehmer</li>
                            <li>E-Mail-Adressen (für Benachrichtigungen)</li>
                            <li>Wunschlisten (optional, falls angegeben)</li>
                            <li>Ausschlüsse</li>
                            <li>Ziehungsergebnisse</li>
                        </ul>
                        <p>
                            <strong>Nicht gespeichert werden:</strong> Telefonnummern, Adressen, Zahlungsdaten oder sonstige persönliche Informationen.
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Wie lange werden meine Daten aufbewahrt?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            Gruppen und alle zugehörigen Daten werden <strong>automatisch nach 90 Tagen gelöscht</strong>.
                        </p>
                        <p>
                            Als Admin kannst du deine Gruppe auch jederzeit manuell löschen – alle Daten werden dann sofort entfernt.
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Kann jemand anders mein Los sehen?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            <strong>Nein!</strong> Jedes Los ist durch einen einzigartigen, geheimen Link geschützt. Niemand kann dein Los sehen – auch nicht der Admin –, es sei denn, du teilst deinen Los-Link.
                        </p>
                        <p>
                            Der Admin sieht nur, wer bereits sein Los abgerufen hat, aber nicht den Inhalt.
                        </p>
                    </div>
                </div>
            </section>
            
            <!-- Probleme & Support -->
            <section class="faq-section">
                <h2>🆘 Probleme & Support</h2>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Ich habe keine E-Mail erhalten – was tun?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            Wenn du keine E-Mail erhalten hast, prüfe bitte:
                        </p>
                        <ul>
                            <li>📧 <strong>Spam-Ordner:</strong> Manchmal landen unsere E-Mails im Spam</li>
                            <li>✉️ <strong>E-Mail-Adresse:</strong> Hast du dich vielleicht vertippt?</li>
                            <li>⏱️ <strong>Wartezeit:</strong> E-Mails können 1-2 Minuten dauern</li>
                            <li>🚫 <strong>E-Mail-Filter:</strong> Firmen-E-Mails blockieren manchmal externe Absender</li>
                        </ul>
                        <p>
                            <strong>Lösung:</strong> Nutze die "Los erneut zusenden"-Funktion auf der Startseite oder kontaktiere den Admin.
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Ich habe meinen Admin-Link verloren!</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            Der Admin-Link wurde dir per E-Mail zugeschickt. Schau in deinem Posteingang (und Spam-Ordner) nach E-Mails von Wichtlä.ch.
                        </p>
                        <p>
                            Falls du die E-Mail nicht mehr findest, gibt es leider keine Wiederherstellungsmöglichkeit (keine Registrierung = keine Passwort-Reset-Funktion). Du musst eine neue Gruppe erstellen.
                        </p>
                        <div class="highlight-box">
                            <strong>💡 Tipp:</strong> Speichere den Admin-Link als Lesezeichen im Browser!
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Die Ziehung funktioniert nicht – warum?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            Mögliche Gründe:
                        </p>
                        <ul>
                            <li><strong>Zu viele Ausschlüsse:</strong> Bei zu vielen Ausschlüssen ist eine gültige Ziehung mathematisch unmöglich</li>
                            <li><strong>Zu wenige Teilnehmer:</strong> Mindestens 3 Personen erforderlich</li>
                            <li><strong>Technisches Problem:</strong> Browser-Cache leeren und erneut versuchen</li>
                        </ul>
                        <p>
                            <strong>Tipp:</strong> Reduziere die Anzahl der Ausschlüsse oder füge mehr Teilnehmer hinzu.
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Kann ich eine Gruppe löschen?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            <strong>Ja!</strong> Als Admin findest du im Admin-Bereich eine "Gruppe löschen"-Option. Alle Daten werden sofort und unwiderruflich gelöscht.
                        </p>
                        <p>
                            <strong>Achtung:</strong> Dies kann nicht rückgängig gemacht werden!
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Funktioniert Wichtlä.ch auf dem Smartphone?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            <strong>Ja, vollständig!</strong> Wichtlä.ch ist komplett responsive und funktioniert auf allen Geräten:
                        </p>
                        <ul>
                            <li>📱 Smartphones (iOS & Android)</li>
                            <li>💻 Desktop-Computer</li>
                            <li>🖥️ Tablets</li>
                        </ul>
                        <p>
                            Keine App nötig – einfach im Browser öffnen!
                        </p>
                    </div>
                </div>
            </section>
            
            <!-- Tipps & Best Practices -->
            <section class="faq-section">
                <h2>💡 Tipps & Best Practices</h2>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Wann ist der beste Zeitpunkt, um zu starten?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            <strong>3-4 Wochen vor dem Event</strong> ist ideal:
                        </p>
                        <ul>
                            <li>Genug Zeit zum Geschenke-Besorgen</li>
                            <li>Teilnehmer können in Ruhe überlegen</li>
                            <li>Bei Problemen bleibt Zeit für Korrekturen</li>
                        </ul>
                        <p>
                            Für spontane Wichtel-Aktionen reicht auch 1-2 Wochen Vorlauf.
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Welches Budget empfehlt ihr?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            Das hängt von eurer Gruppe ab:
                        </p>
                        <ul>
                            <li><strong>10-15 CHF:</strong> Freunde, Studenten, große Gruppen</li>
                            <li><strong>15-25 CHF:</strong> Standard für die meisten Wichtel-Events</li>
                            <li><strong>25-50 CHF:</strong> Firmen, kleinere Gruppen, engere Kreise</li>
                        </ul>
                        <p>
                            <strong>Wichtig:</strong> Wählt ein Budget, das für alle bezahlbar ist!
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Soll das Wichteln anonym bleiben?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            Das ist Geschmackssache:
                        </p>
                        <ul>
                            <li><strong>Anonym:</strong> Spannender, mehr Rätselraten, klassische Variante</li>
                            <li><strong>Offen:</strong> Persönlicher, einfacher bei der Geschenkauswahl</li>
                        </ul>
                        <p>
                            Viele Gruppen machen es so: Geschenke anonym verpacken, aber nach dem Auspacken verrät sich der Schenker. Das Beste aus beiden Welten!
                        </p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Was tun, wenn jemand nicht mitmachen will?</span>
                        <span class="faq-icon">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>
                            <strong>Wichteln sollte immer freiwillig sein!</strong> Niemand sollte sich gezwungen fühlen.
                        </p>
                        <p>
                            Bei Firmenwichteln: Macht eine Umfrage vorher und organisiert das Event nur, wenn genug Leute mitmachen wollen. Nicht-Teilnehmer sollten sich nicht ausgeschlossen fühlen.
                        </p>
                    </div>
                </div>
            </section>
            
            <div class="cta-section">
                <h2>Noch Fragen?</h2>
                <p>Schreib uns eine E-Mail oder starte einfach dein erstes Wichteln – es ist kinderleicht!</p>
                <a href="create_group.php" class="cta-button-white">Jetzt Gruppe erstellen →</a>
            </div>
        </article>
    </div>
    
    <script>
        function toggleFaq(element) {
            const faqItem = element.parentElement;
            const wasActive = faqItem.classList.contains('active');
            
            // Optional: Close all other FAQ items
            // document.querySelectorAll('.faq-item').forEach(item => {
            //     item.classList.remove('active');
            // });
            
            if (wasActive) {
                faqItem.classList.remove('active');
            } else {
                faqItem.classList.add('active');
            }
        }
    </script>
    
    <!-- Simple Footer -->
    <footer style="background: var(--secondary-dark); color: white; text-align: center; padding: 2rem;">
        <p style="margin: 0; color: white; opacity: 1;">
            © <?php echo date('Y'); ?> wichtlä.ch • 
            <a href="impressum.php" style="color: white; text-decoration: underline;">Impressum</a> • 
            <a href="datenschutz.php" style="color: white; text-decoration: underline;">Datenschutz</a>
        </p>
    </footer>
    
    <?php include 'cookie-banner.php'; ?>
</body>
</html>
