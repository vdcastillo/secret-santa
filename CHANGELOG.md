# Wichtlä.ch - Changelog

Alle wichtigen Änderungen an diesem Projekt werden in dieser Datei dokumentiert.

## [1.0.0] - 2025-10-10

### Hinzugefügt
- 🎯 Gruppenerstellung mit Admin-Token-System
- 📧 Admin-E-Mail mit automatischem Versand des Admin-Links
- 👥 Teilnehmerverwaltung (Hinzufügen, Bearbeiten, Löschen)
- 🚫 Ausschlüsse-System für Paarungen
- 🎲 Intelligente Wichtel-Auslosung mit Ausschluss-Berücksichtigung
- 🔄 Auslosung zurücksetzen
- 🗑️ Gruppe permanent löschen mit Sicherheitswarnungen
- 📱 WhatsApp-Share-Button für Einladungslinks
- 🎁 Wunschlisten-Feature für Teilnehmer
- 📬 HTML-E-Mail-Templates für alle Benachrichtigungen:
  - Partner-Benachrichtigung mit Wunschliste
  - Registrierungsbestätigung
  - Admin-Willkommens-E-Mail
- 🎨 Modernes, responsives Design
- ❄️ Weihnachtliche Animationen (Schneefall)
- 🌐 Internationalisierte Domain-Unterstützung (wichtlä.ch)
- 🤖 Bildbasierter Captcha-Schutz
- 🔐 Token-basierte Authentifizierung
- 📋 Interaktive Landing Page mit FAQ
- 🎨 Glassmorphism-Design-Elemente
- 📱 Mobile-First responsive Design

### Sicherheit
- SQL-Injection-Schutz durch Prepared Statements
- Token-basierte Zugriffskontrolle
- Captcha gegen Spam
- Input-Validierung für alle Formulare
- Sichere Passwort-Speicherung in Konfiguration

### Design
- Custom CSS mit CSS-Variablen
- Gradient-Hintergründe
- Smooth Scroll-Animationen
- Interaktive FAQ-Akkordeons
- Moderne Button-Styles mit Hover-Effekten
- Responsive Tabellen
- Mobile-optimierte Navigation

### E-Mail-Features
- HTML-Templates mit Inline-CSS
- Professionelles Design passend zur Website
- Gruppendetails in E-Mails
- Wunschlisten-Anzeige
- Persönliche Links für jeden Teilnehmer
- Admin-Links mit Sicherheitshinweisen

### Technisch
- PHP 7.4+ Unterstützung
- MySQL mit UTF8MB4
- PDO für Datenbankzugriffe
- Session-Management
- GD Library für Captcha
- Mobile-First CSS
- SVG-Icons
- Google Fonts Integration

## [Geplant für zukünftige Versionen]

### Features
- [ ] SMTP-Unterstützung (PHPMailer)
- [ ] Multi-Language-Support (DE/EN/FR)
- [ ] Geschenke-Tracking
- [ ] Erinnerungs-E-Mails
- [ ] Gruppen-Chat
- [ ] Datei-Upload für Geschenkideen
- [ ] QR-Code für Teilnehmer-Links
- [ ] Dark Mode
- [ ] Export-Funktionen (PDF, CSV)
- [ ] Statistiken und Auswertungen

### Verbesserungen
- [ ] OAuth-Login (Google, Facebook)
- [ ] Two-Factor-Authentifizierung
- [ ] Admin-Dashboard mit Übersicht
- [ ] Automatische Backup-Funktion
- [ ] API für mobile Apps
- [ ] Progressive Web App (PWA)
- [ ] Offline-Support
- [ ] Push-Benachrichtigungen

---

Format basiert auf [Keep a Changelog](https://keepachangelog.com/de/1.0.0/)
