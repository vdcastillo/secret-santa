# Wichtlä.ch - Installationsanleitung

Diese Schritt-für-Schritt-Anleitung hilft dir, Wichtlä.ch auf deinem Server zu installieren.

## 📋 Voraussetzungen prüfen

### Server-Anforderungen
- PHP 7.4 oder höher
- MySQL 5.7 oder höher (oder MariaDB 10.2+)
- Webserver (Apache, Nginx, etc.)
- PHP GD Extension
- PHP mbstring Extension
- Zugriff auf E-Mail-Versand (PHP mail() oder SMTP)

### PHP-Extensions prüfen

```bash
php -v                    # PHP Version prüfen
php -m | grep -i gd      # GD Extension prüfen
php -m | grep -i mbstring # mbstring prüfen
php -m | grep -i pdo     # PDO prüfen
php -m | grep -i mysql   # MySQL Extension prüfen
```

Falls Extensions fehlen:

```bash
# Ubuntu/Debian
sudo apt-get install php-gd php-mbstring php-mysql

# CentOS/RHEL
sudo yum install php-gd php-mbstring php-mysql

# macOS (Homebrew)
brew install php
```

## 📦 Installation

### 1. Repository klonen

```bash
cd /var/www/html  # oder dein Webserver-Verzeichnis
git clone https://github.com/yourusername/wichtel-app.git wichtel
cd wichtel
```

### 2. Datenbank einrichten

#### 2.1 Datenbank und Benutzer erstellen

```bash
mysql -u root -p
```

Dann in MySQL:

```sql
-- Datenbank erstellen
CREATE DATABASE wichtel_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Benutzer erstellen
CREATE USER 'wichtel_db_user'@'localhost' IDENTIFIED BY 'IhrSicheresPasswort123!';

-- Rechte vergeben
GRANT ALL PRIVILEGES ON wichtel_db.* TO 'wichtel_db_user'@'localhost';
FLUSH PRIVILEGES;

-- Prüfen
SHOW DATABASES;
SELECT User, Host FROM mysql.user WHERE User = 'wichtel_db_user';

EXIT;
```

#### 2.2 Tabellen erstellen

```bash
mysql -u wichtel_db_user -p wichtel_db
```

Dann die SQL-Befehle ausführen:

```sql
-- Groups Tabelle
CREATE TABLE `groups` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `admin_token` VARCHAR(64) NOT NULL UNIQUE,
  `invite_token` VARCHAR(64) NOT NULL UNIQUE,
  `admin_email` VARCHAR(255) NULL,
  `budget` DECIMAL(10,2) NULL,
  `description` TEXT NULL,
  `gift_exchange_date` DATE NULL,
  `is_drawn` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Participants Tabelle
CREATE TABLE `participants` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `group_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NULL,
  `token` VARCHAR(64) NOT NULL UNIQUE,
  `assigned_to` INT NULL,
  `wishlist` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`group_id`) REFERENCES `groups`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`assigned_to`) REFERENCES `participants`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Exclusions Tabelle
CREATE TABLE `exclusions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `group_id` INT NOT NULL,
  `participant_id` INT NOT NULL,
  `excluded_participant_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`group_id`) REFERENCES `groups`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`participant_id`) REFERENCES `participants`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`excluded_participant_id`) REFERENCES `participants`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `unique_exclusion` (`group_id`, `participant_id`, `excluded_participant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Indices für bessere Performance
CREATE INDEX idx_admin_token ON `groups`(`admin_token`);
CREATE INDEX idx_invite_token ON `groups`(`invite_token`);
CREATE INDEX idx_participant_token ON `participants`(`token`);
CREATE INDEX idx_group_participants ON `participants`(`group_id`);

-- Tabellen anzeigen
SHOW TABLES;

-- Struktur prüfen
DESCRIBE `groups`;
DESCRIBE `participants`;
DESCRIBE `exclusions`;

EXIT;
```

### 3. Konfiguration

#### 3.1 config.php erstellen

```bash
cp config.example.php config.php
```

#### 3.2 config.php bearbeiten

```bash
nano config.php  # oder vim, vi, etc.
```

Anpassen:

```php
<?php
// Datenbankeinstellungen
define('DB_HOST', 'localhost');
define('DB_NAME', 'wichtel_db');
define('DB_USER', 'wichtel_db_user');
define('DB_PASS', 'IhrSicheresPasswort123!');  // Dein DB-Passwort

// E-Mail-Einstellungen
define('SMTP_FROM_EMAIL', 'noreply@wichtlä.ch');  // Deine Absender-E-Mail
define('SMTP_FROM_NAME', 'Wichtel Webseite');

// Cookie-Einstellungen für automatisches Login (optional anpassen)
define('COOKIE_NAME', 'wichteln_tokens'); // Name des Cookies
define('COOKIE_LIFETIME', 60 * 60 * 24 * 90); // 90 Tage
define('COOKIE_MAX_TOKENS', 10); // Max. 10 Gruppen pro Benutzer

// Master Admin Token generieren
define('MASTER_ADMIN_TOKEN', 'GENERIERTES_TOKEN_HIER');
?>
```

**Cookie-Einstellungen (optional):**
- `COOKIE_LIFETIME`: Wie lange Benutzer eingeloggt bleiben (Standard: 90 Tage)
- `COOKIE_MAX_TOKENS`: Maximale Anzahl Gruppen pro Benutzer (Standard: 10)
- Siehe [COOKIE_FEATURE.md](COOKIE_FEATURE.md) für mehr Details

#### 3.3 Sicheres Admin-Token generieren

```bash
php -r "echo bin2hex(random_bytes(32)) . PHP_EOL;"
```

Kopiere die Ausgabe und setze sie als `MASTER_ADMIN_TOKEN` in `config.php`.

### 4. Berechtigungen setzen

```bash
# Besitzer setzen (Webserver-Benutzer)
sudo chown -R www-data:www-data /var/www/html/wichtel

# Ordner-Berechtigungen
find /var/www/html/wichtel -type d -exec chmod 755 {} \;

# Datei-Berechtigungen
find /var/www/html/wichtel -type f -exec chmod 644 {} \;

# config.php schützen
chmod 600 config.php
```

### 5. Webserver konfigurieren

#### Apache

```bash
sudo nano /etc/apache2/sites-available/wichtel.conf
```

```apache
<VirtualHost *:80>
    ServerName wichtlä.ch
    ServerAlias www.wichtlä.ch xn--wichtl-gua.ch
    DocumentRoot /var/www/html/wichtel
    
    <Directory /var/www/html/wichtel>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/wichtel_error.log
    CustomLog ${APACHE_LOG_DIR}/wichtel_access.log combined
</VirtualHost>
```

```bash
# Site aktivieren
sudo a2ensite wichtel.conf

# mod_rewrite aktivieren (falls nötig)
sudo a2enmod rewrite

# Apache neu starten
sudo systemctl restart apache2
```

#### Nginx

```bash
sudo nano /etc/nginx/sites-available/wichtel
```

```nginx
server {
    listen 80;
    server_name wichtlä.ch www.wichtlä.ch xn--wichtl-gua.ch;
    root /var/www/html/wichtel;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# Symlink erstellen
sudo ln -s /etc/nginx/sites-available/wichtel /etc/nginx/sites-enabled/

# Nginx testen und neu laden
sudo nginx -t
sudo systemctl reload nginx
```

### 6. SSL/HTTPS einrichten (Let's Encrypt)

```bash
# Certbot installieren
sudo apt-get install certbot python3-certbot-apache  # Apache
# oder
sudo apt-get install certbot python3-certbot-nginx   # Nginx

# Zertifikat erstellen
sudo certbot --apache -d wichtlä.ch -d www.wichtlä.ch  # Apache
# oder
sudo certbot --nginx -d wichtlä.ch -d www.wichtlä.ch   # Nginx

# Automatische Erneuerung testen
sudo certbot renew --dry-run
```

### 7. E-Mail-Konfiguration

#### PHP mail() prüfen

```bash
php -r "mail('test@example.com', 'Test Subject', 'Test Message', 'From: noreply@wichtlä.ch');"
```

Prüfe dein Postfach (auch Spam-Ordner).

#### Sendmail-Pfad anpassen (falls nötig)

In `functions.php`:

```php
ini_set('sendmail_path', '/usr/sbin/sendmail -t -i');
```

Sendmail-Pfad finden:

```bash
which sendmail
```

### 8. Finale Tests

#### 8.1 Datenbankverbindung testen

```bash
cd /var/www/html/wichtel
php -r "
require_once 'config.php';
try {
    \$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    echo 'Datenbankverbindung erfolgreich!' . PHP_EOL;
} catch (PDOException \$e) {
    echo 'Fehler: ' . \$e->getMessage() . PHP_EOL;
}
"
```

#### 8.2 Website testen

1. Öffne `http://wichtlä.ch` (oder deine Domain)
2. Erstelle eine Test-Gruppe
3. Prüfe ob E-Mail ankommt
4. Registriere 2-3 Teilnehmer
5. Teste die Auslosung

## 🔧 Fehlerbehebung

### Problem: "Can't connect to MySQL server"

```bash
# MySQL Status prüfen
sudo systemctl status mysql

# MySQL starten
sudo systemctl start mysql

# MySQL beim Booten aktivieren
sudo systemctl enable mysql
```

### Problem: "Permission denied"

```bash
# Berechtigungen korrigieren
sudo chown -R www-data:www-data /var/www/html/wichtel
```

### Problem: Captcha wird nicht angezeigt

```bash
# GD Extension prüfen
php -m | grep -i gd

# Falls nicht vorhanden
sudo apt-get install php-gd
sudo systemctl restart apache2  # oder nginx
```

### Problem: E-Mails kommen nicht an

1. PHP mail() testen:
```bash
php -r "var_dump(mail('test@example.com', 'Test', 'Test'));"
```

2. Logs prüfen:
```bash
sudo tail -f /var/log/mail.log
sudo tail -f /var/log/apache2/error.log
```

3. SPF/DKIM konfigurieren (für bessere Zustellbarkeit)

## 🚀 Produktions-Checkliste

- [ ] `config.php` ist nicht im Git-Repository
- [ ] SSL/HTTPS ist aktiviert
- [ ] Error-Reporting ist deaktiviert (in `functions.php`)
- [ ] Starke Passwörter verwendet
- [ ] Firewall konfiguriert
- [ ] Regelmäßige Backups eingerichtet
- [ ] E-Mail-Zustellung getestet
- [ ] SPF/DKIM/DMARC konfiguriert
- [ ] Logs werden rotiert
- [ ] Monitoring aktiviert

## 📚 Weitere Ressourcen

- [PHP Dokumentation](https://www.php.net/docs.php)
- [MySQL Dokumentation](https://dev.mysql.com/doc/)
- [Apache Dokumentation](https://httpd.apache.org/docs/)
- [Nginx Dokumentation](https://nginx.org/en/docs/)
- [Let's Encrypt](https://letsencrypt.org/)

## 💡 Tipps

- Teste zuerst in einer Entwicklungsumgebung
- Erstelle regelmäßig Datenbank-Backups
- Überwache die Server-Logs
- Halte PHP und MySQL aktuell
- Verwende starke Passwörter
- Aktiviere HTTPS

---

**Bei Fragen: [Issues auf GitHub](https://github.com/yourusername/wichtel-app/issues)**
