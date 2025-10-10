# Contributor's Guide

Danke, dass du an Wichtlä.ch mitarbeiten möchtest! 🎁

## 📋 Code of Conduct

- Sei respektvoll und konstruktiv
- Hilf anderen bei Fragen
- Dokumentiere deinen Code
- Teste deine Änderungen

## 🚀 Wie du beitragen kannst

### Bug Reports

Hast du einen Bug gefunden? [Erstelle ein Issue](https://github.com/yourusername/wichtel-app/issues/new) mit:

- **Titel:** Kurze Beschreibung des Problems
- **Beschreibung:** Detaillierte Erklärung
- **Schritte zum Reproduzieren:** 1. Gehe zu... 2. Klicke auf... 3. Siehe Fehler
- **Erwartetes Verhalten:** Was sollte passieren
- **Tatsächliches Verhalten:** Was passiert stattdessen
- **Screenshots:** Falls möglich
- **Umgebung:** Browser, PHP-Version, MySQL-Version

### Feature Requests

Hast du eine Idee? [Erstelle ein Issue](https://github.com/yourusername/wichtel-app/issues/new) mit:

- **Titel:** Feature-Name
- **Problem:** Welches Problem löst es?
- **Lösung:** Wie könnte es funktionieren?
- **Alternativen:** Welche Alternativen gibt es?

### Code beitragen

1. **Fork das Repository**
2. **Clone deinen Fork**
   ```bash
   git clone https://github.com/DEIN-USERNAME/wichtel-app.git
   cd wichtel-app
   ```

3. **Branch erstellen**
   ```bash
   git checkout -b feature/mein-neues-feature
   # oder
   git checkout -b bugfix/mein-bugfix
   ```

4. **Entwicklungsumgebung einrichten**
   - Folge der [INSTALL.md](INSTALL.md)
   - Erstelle eine Test-Datenbank

5. **Änderungen machen**
   - Schreibe sauberen, dokumentierten Code
   - Folge dem bestehenden Code-Stil
   - Teste deine Änderungen

6. **Commit mit klarer Message**
   ```bash
   git add .
   git commit -m "feat: Neue Feature-Beschreibung
   
   - Detaillierte Änderung 1
   - Detaillierte Änderung 2"
   ```

7. **Push zum Fork**
   ```bash
   git push origin feature/mein-neues-feature
   ```

8. **Pull Request erstellen**
   - Gehe zu GitHub
   - Klicke "New Pull Request"
   - Beschreibe deine Änderungen
   - Verlinke relevante Issues

## 📝 Coding Standards

### PHP

```php
// ✅ Gut
function send_email($to, $subject, $message, $is_html = false) {
    // Klare Variablennamen
    $headers = "From: " . SMTP_FROM_EMAIL . "\r\n";
    
    // Kommentare für komplexe Logik
    if ($is_html) {
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    }
    
    return mail($to, $subject, $message, $headers);
}

// ❌ Schlecht
function se($t,$s,$m,$h=0){
    $hdr="From:".SMTP_FROM_EMAIL."\r\n";
    if($h)$hdr.="Content-Type:text/html;charset=UTF-8\r\n";
    return mail($t,$s,$m,$hdr);
}
```

### SQL

```sql
-- ✅ Gut: Prepared Statements verwenden
$stmt = $pdo->prepare("SELECT * FROM `participants` WHERE `group_id` = ?");
$stmt->execute([$group_id]);

-- ❌ Schlecht: String-Konkatenation (SQL-Injection-Gefahr!)
$query = "SELECT * FROM participants WHERE group_id = " . $group_id;
```

### HTML

```html
<!-- ✅ Gut: Proper escaping -->
<h1><?php echo htmlspecialchars($group['name']); ?></h1>

<!-- ❌ Schlecht: XSS-Gefahr -->
<h1><?php echo $group['name']; ?></h1>
```

### CSS

```css
/* ✅ Gut: BEM-ähnliche Namenskonvention */
.form-group { }
.form-group__label { }
.form-group__input--error { }

/* ❌ Schlecht: Generische Namen */
.box { }
.text { }
.red { }
```

## 🧪 Testing

Vor jedem Pull Request:

1. **Manuelle Tests:**
   - Gruppe erstellen
   - Teilnehmer hinzufügen
   - Ausschlüsse definieren
   - Auslosung durchführen
   - E-Mails prüfen

2. **Browser-Tests:**
   - Chrome
   - Firefox
   - Safari
   - Mobile Browser

3. **PHP Syntax Check:**
   ```bash
   find . -name "*.php" -exec php -l {} \;
   ```

## 📦 Commit Message Format

Wir verwenden [Conventional Commits](https://www.conventionalcommits.org/):

```
<type>: <subject>

<body>

<footer>
```

### Types:

- `feat`: Neues Feature
- `fix`: Bug-Fix
- `docs`: Dokumentation
- `style`: Code-Formatierung (keine funktionale Änderung)
- `refactor`: Code-Refactoring
- `test`: Tests hinzufügen
- `chore`: Build-Prozess, Dependencies

### Beispiele:

```bash
feat: Add WhatsApp share button for invite links

- Added SVG icon
- Implemented URL encoding for message
- Added responsive styling

Closes #42
```

```bash
fix: Correct email template rendering in Outlook

- Changed table layout for better compatibility
- Added inline styles
- Tested in Outlook 2016, 2019

Fixes #38
```

## 🎨 Design Guidelines

- **Farben:** Verwende CSS-Variablen aus `styles.css`
- **Spacing:** 8px-Grid-System (8px, 16px, 24px, 32px, etc.)
- **Mobile-First:** Erst mobile, dann desktop
- **Accessibility:** WCAG 2.1 AA Standards

## 🔒 Sicherheit

- **Niemals** Passwörter oder Secrets committen
- **Immer** Input validieren und escapen
- **Immer** Prepared Statements für SQL
- **Immer** HTTPS in Produktion

## 📚 Ressourcen

- [PHP Best Practices](https://www.php-fig.org/psr/)
- [MySQL Best Practices](https://dev.mysql.com/doc/refman/8.0/en/writing-sql.html)
- [Web Accessibility](https://www.w3.org/WAI/WCAG21/quickref/)

## ❓ Fragen?

- Erstelle ein [Issue](https://github.com/yourusername/wichtel-app/issues)
- Schreibe eine E-Mail: support@yourdomain.com

## 🎉 Danke!

Jeder Beitrag macht Wichtlä.ch besser! 🙏

---

**Happy Coding! 🎁**
