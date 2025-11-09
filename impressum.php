<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Impressum - Wichtlä.ch</title>
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
            <h1>Impressum</h1>
            
            <h2>Betreiber</h2>
            <p>
                Patrick Raths<br>
                wichtlä.ch<br>
                Schweiz
            </p>
            
            <h2>Kontakt</h2>
            <p>
                <strong>E-Mail:</strong> <span id="email-address"></span>
            </p>
            
            <script>
                // E-Mail-Adresse vor Spambots schützen
                const user = 'kontakt';
                const domain = 'wichtlä.ch';
                const email = user + '@' + domain;
                const emailElement = document.getElementById('email-address');
                const link = document.createElement('a');
                link.href = 'mailto:' + email;
                link.textContent = email;
                emailElement.appendChild(link);
            </script>
            
            <h2>Haftungsausschluss</h2>
            
            <h3>Haftung für Inhalte</h3>
            <p>
                Die Inhalte dieser Website wurden mit grösstmöglicher Sorgfalt erstellt. Für die Richtigkeit, Vollständigkeit und Aktualität der Inhalte können wir jedoch keine Gewähr übernehmen.
            </p>
            
            <h3>Haftung für Links</h3>
            <p>
                Unser Angebot enthält Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss haben. Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich.
            </p>
            
            <h3>Urheberrecht</h3>
            <p>
                Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem schweizerischen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung ausserhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers.
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
