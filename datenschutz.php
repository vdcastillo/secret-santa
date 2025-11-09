<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Datenschutzerklärung - Wichtlä.ch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto&display=swap" rel="stylesheet">
    <!-- CSS Stylesheet -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <a href="index.php">
            <img src="images/logo.png" alt="Wichtel Logo">
        </a>
    </header>
    <div class="container">
        <div class="content-card">
            <h1>Datenschutzerklärung</h1>
            
            <p><strong>Stand: <?php echo date('d.m.Y'); ?></strong></p>
            
            <h2>1. Datenschutz auf einen Blick</h2>
            
            <h3>Allgemeine Hinweise</h3>
            <p>
                Die folgenden Hinweise geben einen einfachen Überblick darüber, was mit Ihren personenbezogenen Daten passiert, wenn Sie diese Website besuchen. Personenbezogene Daten sind alle Daten, mit denen Sie persönlich identifiziert werden können.
            </p>
            
            <h3>Unsere Datenschutzphilosophie</h3>
            <div class="privacy-highlight">
                <p><strong>Wir teilen Ihre Daten niemals mit Dritten.</strong> Ihre Privatsphäre ist uns wichtig, und wir verwenden Ihre Daten ausschliesslich für die Funktionalität des Wichtel-Systems.</p>
            </div>
            
            <h2>2. Datenerfassung auf dieser Website</h2>
            
            <h3>Wer ist verantwortlich für die Datenerfassung auf dieser Website?</h3>
            <p>
                Die Datenverarbeitung auf dieser Website erfolgt durch den Websitebetreiber wichtlä.ch. Kontaktdaten finden Sie im Impressum dieser Website.
            </p>
            
            <h3>Wie erfassen wir Ihre Daten?</h3>
            <p>
                Ihre Daten werden zum einen dadurch erhoben, dass Sie uns diese mitteilen. Hierbei kann es sich z.B. um Daten handeln, die Sie in ein Kontaktformular eingeben oder bei der Anmeldung zu einer Wichtel-Gruppe angeben.
            </p>
            
            <h2>3. Welche Daten erheben wir?</h2>
            
            <h3>Bei der Gruppenerstellung</h3>
            <ul>
                <li><strong>Gruppenname:</strong> Der Name Ihrer Wichtel-Gruppe</li>
                <li><strong>Budget:</strong> Das festgelegte Geschenkebudget (optional)</li>
                <li><strong>Beschreibung:</strong> Zusätzliche Informationen zur Gruppe (optional)</li>
                <li><strong>Datum:</strong> Datum der Geschenkübergabe (optional)</li>
            </ul>
            
            <h3>Bei der Teilnehmeranmeldung</h3>
            <ul>
                <li><strong>Name:</strong> Ihr Vor- und Nachname</li>
                <li><strong>E-Mail-Adresse:</strong> Ihre E-Mail-Adresse (optional, aber empfohlen für Benachrichtigungen)</li>
                <li><strong>Wunschliste:</strong> Ihre Geschenkwünsche (optional)</li>
            </ul>
            
            <h2>4. Cookies und automatisches Login</h2>
            
            <h3>Was sind Cookies?</h3>
            <p>
                Cookies sind kleine Textdateien, die auf Ihrem Computer gespeichert werden und die Ihr Browser speichert. Cookies richten auf Ihrem Rechner keinen Schaden an und enthalten keine Viren.
            </p>
            
            <h3>Unsere Cookie-Verwendung</h3>
            <div class="privacy-highlight">
                <p><strong>Funktionale Cookies für automatisches Login:</strong> Wir verwenden Cookies ausschliesslich, um Ihre Teilnahme an Wichtel-Gruppen zu speichern. Dies ermöglicht Ihnen ein automatisches Login, ohne dass Sie Ihren Teilnehmer-Link jedes Mal eingeben müssen.</p>
            </div>
            
            <h3>Welche Informationen speichern wir im Cookie?</h3>
            <ul>
                <li><strong>Teilnehmer-Tokens:</strong> Eindeutige Identifikationsnummern für Ihre Gruppenteilnahmen</li>
                <li><strong>Anzahl:</strong> Maximal 10 Gruppen werden gespeichert</li>
                <li><strong>Dauer:</strong> 180 Tage</li>
            </ul>
            
            <h3>Cookie-Details</h3>
            <table>
                <thead>
                    <tr>
                        <th>Eigenschaft</th>
                        <th>Wert</th>
                        <th>Zweck</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Name</strong></td>
                        <td>wichteln_tokens</td>
                        <td>Identifikation des Cookies</td>
                    </tr>
                    <tr>
                        <td><strong>Typ</strong></td>
                        <td>Funktional</td>
                        <td>Für Webseitenfunktion erforderlich</td>
                    </tr>
                    <tr>
                        <td><strong>HttpOnly</strong></td>
                        <td>Ja</td>
                        <td>Schutz vor JavaScript-Zugriff (XSS)</td>
                    </tr>
                    <tr>
                        <td><strong>Secure</strong></td>
                        <td>Ja (bei HTTPS)</td>
                        <td>Übertragung nur über sichere Verbindung</td>
                    </tr>
                    <tr>
                        <td><strong>SameSite</strong></td>
                        <td>Lax</td>
                        <td>Schutz vor CSRF-Angriffen</td>
                    </tr>
                    <tr>
                        <td><strong>Lebensdauer</strong></td>
                        <td>180 Tage</td>
                        <td>Automatisches Login für 6 Monate</td>
                    </tr>
                </tbody>
            </table>
            
            <h3>Cookies verwalten und löschen</h3>
            <p>
                Sie können Cookies jederzeit in Ihren Browser-Einstellungen löschen oder blockieren. Beachten Sie jedoch, dass ohne Cookies die automatische Anmeldung nicht funktioniert und Sie Ihren Teilnehmer-Link manuell eingeben müssen.
            </p>
            
            <h2>5. Wie verwenden wir Ihre Daten?</h2>
            
            <h3>Zweck der Datenverarbeitung</h3>
            <ul>
                <li><strong>Wichtel-Auslosung:</strong> Zuordnung von Wichtelpartnern innerhalb Ihrer Gruppe</li>
                <li><strong>E-Mail-Benachrichtigungen:</strong> Versand von Informationen über Ihre Zuteilung (nur mit Ihrer E-Mail-Adresse)</li>
                <li><strong>Wunschlisten:</strong> Anzeige Ihrer Wünsche für Ihren Wichtelpartner</li>
                <li><strong>Gruppenverwaltung:</strong> Verwaltung von Teilnehmern und Ausschlüssen</li>
            </ul>
            
            <h2>6. Datenweitergabe</h2>
            
            <div class="privacy-highlight">
                <span class="privacy-icon">🔒</span>
                <p><strong>Keine Weitergabe an Dritte:</strong> Wir geben Ihre Daten grundsätzlich nicht an Dritte weiter. Die einzige Ausnahme ist der Versand von E-Mails über unseren E-Mail-Provider.</p>
            </div>
            
            <h3>Innerhalb der Wichtel-Gruppe</h3>
            <p> 
                Folgende Informationen sind für andere Gruppenmitglieder sichtbar:
            </p>
            <ul>
                <li>Ihr Name (für alle Gruppenmitglieder)</li>
                <li>Ihre Wunschliste (nur für Ihren Wichtelpartner nach der Auslosung)</li>
            </ul>
            <p>
                Ihre E-Mail-Adresse bleibt <strong>immer privat</strong> und ist für andere Teilnehmer nicht sichtbar.
            </p>
            
            <h2>7. Wie lange speichern wir Ihre Daten?</h2>
            
            <ul>
                <li><strong>Gruppendaten:</strong> Solange die Gruppe existiert</li>
                <li><strong>Teilnehmerdaten:</strong> Solange Sie Mitglied der Gruppe sind</li>
                <li><strong>Cookies:</strong> 180 Tage oder bis zur manuellen Löschung</li>
            </ul>
            
            <h3>Löschung Ihrer Daten</h3>
            <p>
                Der Gruppenadministrator kann die gesamte Gruppe jederzeit löschen. Dabei werden automatisch alle Teilnehmerdaten, Zuordnungen und Wunschlisten permanent gelöscht.
            </p>
            
            <h2>8. Ihre Rechte (gemäss Schweizer Datenschutzgesetz)</h2>
            
            <p>Sie haben folgende Rechte bezüglich Ihrer personenbezogenen Daten:</p>
            
            <ul>
                <li><strong>Auskunftsrecht:</strong> Sie können Auskunft über Ihre gespeicherten Daten verlangen</li>
                <li><strong>Berichtigungsrecht:</strong> Sie können die Korrektur falscher Daten verlangen</li>
                <li><strong>Löschungsrecht:</strong> Sie können die Löschung Ihrer Daten verlangen</li>
                <li><strong>Widerspruchsrecht:</strong> Sie können der Verarbeitung Ihrer Daten widersprechen</li>
                <li><strong>Datenübertragbarkeit:</strong> Sie können Ihre Daten in einem strukturierten Format erhalten</li>
            </ul>
            
            <p>
                Um diese Rechte auszuüben, kontaktieren Sie bitte den Gruppenadministrator oder wenden Sie sich an uns über die im Impressum angegebenen Kontaktdaten.
            </p>
            
            <h2>9. Datensicherheit</h2>
            
            <h3>Unsere Sicherheitsmassnahmen</h3>
            <ul>
                <li><strong>HTTPS-Verschlüsselung:</strong> Alle Datenübertragungen sind verschlüsselt</li>
                <li><strong>Sichere Passwort-Token:</strong> Verwendung kryptographisch sicherer Zufallstokens</li>
                <li><strong>Prepared Statements:</strong> Schutz vor SQL-Injection-Angriffen</li>
                <li><strong>Cookie-Security:</strong> HttpOnly, Secure und SameSite-Flags</li>
                <li><strong>Zugriffskontrolle:</strong> Nur autorisierte Personen können auf Gruppendaten zugreifen</li>
            </ul>
            
            <h2>10. Analyse-Tools und Tracking</h2>
            
            <div class="privacy-highlight">
                <p><strong>Keine Tracking-Tools:</strong> Wir verwenden keine Analyse-Tools oder Tracking-Software wie Google Analytics, Facebook Pixel oder ähnliche Dienste. Ihre Aktivitäten auf dieser Website werden nicht verfolgt oder analysiert.</p>
            </div>
            
            <h2>11. Server-Log-Dateien</h2>
            
            <p>
                Der Provider der Seiten erhebt und speichert automatisch Informationen in sogenannten Server-Log-Dateien, die Ihr Browser automatisch an uns übermittelt. Dies sind:
            </p>
            <ul>
                <li>Browsertyp und Browserversion</li>
                <li>Verwendetes Betriebssystem</li>
                <li>Referrer URL</li>
                <li>Hostname des zugreifenden Rechners</li>
                <li>Uhrzeit der Serveranfrage</li>
                <li>IP-Adresse</li>
            </ul>
            <p>
                Diese Daten werden nicht mit anderen Datenquellen zusammengeführt und dienen ausschliesslich der Systemsicherheit und der Fehleranalyse.
            </p>
            
            <h2>12. Kontaktmöglichkeit</h2>
            
            <p>
                Bei Fragen zum Datenschutz oder zur Ausübung Ihrer Rechte können Sie uns unter den im Impressum angegebenen Kontaktdaten erreichen:
            </p>
            <p>
                <strong>E-Mail:</strong> <a href="mailto:kontakt@wichtlä.ch">kontakt@wichtlä.ch</a>
            </p>
            
            <h2>13. Änderungen dieser Datenschutzerklärung</h2>
            
            <p>
                Wir behalten uns vor, diese Datenschutzerklärung anzupassen, damit sie stets den aktuellen rechtlichen Anforderungen entspricht oder um Änderungen unserer Leistungen in der Datenschutzerklärung umzusetzen. Für Ihren erneuten Besuch gilt dann die neue Datenschutzerklärung.
            </p>
            
            <hr>
            
            <div style="text-align: center; margin-top: 3rem;">
                <a href="index.php" class="button secondary">🏠 Zurück zur Startseite</a>
            </div>
        </div>
    </div>
    
    <footer style="background: var(--secondary-dark); color: white; text-align: center; padding: 2rem; margin-top: 3rem;">
        <p style="margin: 0; color: white; opacity: 1;">
            © <?php echo date('Y'); ?> wichtlä.ch • 
            <a href="impressum.php" style="color: white; text-decoration: underline;">Impressum</a> • 
            <a href="datenschutz.php" style="color: white; text-decoration: underline;">Datenschutz</a>
        </p>
    </footer>
</body>
</html>
