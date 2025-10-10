# 🚀 Quick Start - GitHub Upload

## Dateien für GitHub vorbereitet

Folgende Dateien wurden erstellt/aktualisiert:

### Neue Dateien:
- ✅ `.gitignore` - Schützt config.php und andere sensible Dateien
- ✅ `config.example.php` - Beispiel-Konfiguration für andere Entwickler
- ✅ `README.md` - Umfassende Projektdokumentation
- ✅ `LICENSE` - MIT-Lizenz
- ✅ `CHANGELOG.md` - Versionshistorie
- ✅ `INSTALL.md` - Detaillierte Installationsanleitung

### Geschützte Datei:
- 🔒 `config.php` - Wird NICHT hochgeladen (in .gitignore)

## GitHub Upload - Schritt für Schritt

### 1. Git Repository initialisieren

```bash
cd /Volumes/Daten/Daten/Website/Wichtel.ch

# Git initialisieren (falls noch nicht geschehen)
git init

# Alle Dateien zum Staging hinzufügen
git add .

# Prüfen, was committet wird (config.php sollte NICHT erscheinen!)
git status

# Ersten Commit erstellen
git commit -m "Initial commit: Wichtlä.ch - Online Wichteln App v1.0.0

Features:
- Gruppenerstellung mit Admin-System
- Teilnehmerverwaltung mit Ausschlüssen
- Intelligente Wichtel-Auslosung
- Wunschlisten-Feature
- HTML-E-Mail-Templates
- Modernes responsive Design
- Captcha-Schutz
- WhatsApp-Share-Funktion"
```

### 2. GitHub Repository erstellen

1. Gehe zu [GitHub](https://github.com)
2. Klicke auf "+" → "New repository"
3. Repository-Name: `wichtel-app` (oder dein Wunschname)
4. Beschreibung: "🎁 Online Wichteln leicht gemacht - Secret Santa Web App"
5. Wähle: **Public** oder **Private**
6. ❌ **NICHT** "Initialize with README" anklicken (wir haben schon eins)
7. Klicke "Create repository"

### 3. Repository mit GitHub verbinden

```bash
# Remote hinzufügen (ersetze USERNAME und REPO)
git remote add origin https://github.com/USERNAME/wichtel-app.git

# Oder mit SSH (empfohlen):
git remote add origin git@github.com:USERNAME/wichtel-app.git

# Remote prüfen
git remote -v
```

### 4. Zu GitHub pushen

```bash
# Haupt-Branch umbenennen zu main (falls nötig)
git branch -M main

# Push zu GitHub
git push -u origin main
```

### 5. GitHub Actions einrichten (Optional)

Erstelle `.github/workflows/ci.yml` für automatische Tests:

```yaml
name: CI

on:
  push:
    branches: [ main ]
  pull_request:
    branches: [ main ]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '7.4'
        extensions: gd, mbstring, pdo, mysql
    
    - name: Check PHP Syntax
      run: |
        find . -name "*.php" -exec php -l {} \;
```

## 📝 Nach dem Upload

### Repository-Einstellungen auf GitHub

1. **About bearbeiten:**
   - Website: `https://wichtlä.ch`
   - Topics: `php`, `mysql`, `secret-santa`, `wichteln`, `christmas`, `web-app`

2. **README aktualisieren:**
   - Ersetze `yourusername` mit deinem GitHub-Username
   - Ersetze `yourdomain.com` mit deiner Domain

3. **GitHub Pages aktivieren** (für Dokumentation):
   - Settings → Pages → Source: `main` branch

### Weitere Commits

```bash
# Änderungen machen
# ...

# Dateien hinzufügen
git add .

# Commit erstellen
git commit -m "Beschreibung der Änderung"

# Push zu GitHub
git push
```

## 🔒 Sicherheitsprüfung vor Upload

Prüfe, dass folgende Dateien NICHT committed werden:

```bash
# Prüfen was committed wird
git status

# config.php sollte nicht erscheinen!
# Falls doch:
git rm --cached config.php
git commit -m "Remove config.php from tracking"
```

## 🎯 Wichtige Links nach Upload

- Repository: `https://github.com/USERNAME/wichtel-app`
- Issues: `https://github.com/USERNAME/wichtel-app/issues`
- Releases: `https://github.com/USERNAME/wichtel-app/releases`

## 📦 Release erstellen

```bash
# Tag erstellen
git tag -a v1.0.0 -m "Release v1.0.0 - Initial Release"

# Tag pushen
git push origin v1.0.0
```

Dann auf GitHub:
1. Gehe zu "Releases"
2. Klicke "Create a new release"
3. Wähle Tag `v1.0.0`
4. Titel: "Version 1.0.0 - Initial Release"
5. Beschreibung aus CHANGELOG.md kopieren
6. "Publish release" klicken

## ✅ Fertig!

Dein Projekt ist jetzt auf GitHub! 🎉

**Nächste Schritte:**
- [ ] README.md personalisieren
- [ ] Repository-URL in Dateien aktualisieren
- [ ] Contributors Guide erstellen
- [ ] Issues-Template erstellen
- [ ] Wiki-Seiten erstellen

---

**Viel Erfolg mit deinem Open-Source-Projekt! 🎁**
