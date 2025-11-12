# Google Ads Integration - Dokumentation

## Übersicht

Die Wichteln-Plattform unterstützt Google AdSense Integration mit **3 verschiedenen Anzeigepositionen** auf der Teilnehmer-Seite (`participant.php`). Jede Position kann individuell ein- oder ausgeschaltet werden.

### 🧪 Test-Modus verfügbar!

Neu: Du kannst das Layout **ohne AdSense Account** testen! Setze `GOOGLE_ADS_TESTING = true` und du siehst weiße Platzhalter-Blöcke anstelle echter Ads. Perfekt zum:
- ✅ Layout-Prüfung auf verschiedenen Geräten
- ✅ UX-Evaluierung vor dem Live-Schalten
- ✅ Entwicklung ohne echte Ad-Impressions

**Test-Modus Beispiel:**
```
┌──────────────────────────────────────┐
│         Test-Anzeige (Position 1)    │
├──────────────────────────────────────┤
│                                      │
│     📊 Google Ad Placeholder         │
│     Position 1: Nach Wichtelpartner  │
│     Responsive Display Ad            │
│                                      │
└──────────────────────────────────────┘
```

## Konfiguration in `config.php`

### 1. Grundeinstellungen

```php
// Google Ads aktivieren/deaktivieren
define('GOOGLE_ADS_ENABLED', true); // true = aktiviert, false = deaktiviert

// Test-Modus aktivieren (zeigt weiße Platzhalter statt echte Ads)
define('GOOGLE_ADS_TESTING', true); // true = Test-Modus, false = Live-Ads

// Deine Google AdSense Publisher ID
define('GOOGLE_ADS_CLIENT', 'ca-pub-XXXXXXXXXXXXXXXXX');
```

**Test-Modus:** Wenn `GOOGLE_ADS_TESTING` auf `true` gesetzt ist, werden anstelle echter Google Ads weiße Platzhalter-Blöcke angezeigt. Dies ist perfekt zum:
- ✅ Testen des Layouts ohne AdSense Account
- ✅ Prüfen der Positionierung auf verschiedenen Geräten
- ✅ Evaluieren der UX bevor echte Ads geschaltet werden
- ✅ Entwicklung ohne echte Ad-Impressions zu verbrauchen

### 2. Ad Slots für die verschiedenen Positionen

Jede Position benötigt eine eigene Ad Slot ID von Google AdSense:

```php
define('GOOGLE_ADS_SLOT_OPTION1', '1234567890'); // Position 1
define('GOOGLE_ADS_SLOT_OPTION2', '0987654321'); // Position 2  
define('GOOGLE_ADS_SLOT_OPTION3', '1122334455'); // Position 3
```

### 3. Positionssteuerung

Schalte einzelne Positionen individuell ein oder aus:

```php
define('GOOGLE_ADS_SHOW_OPTION1', true);  // Position 1 anzeigen
define('GOOGLE_ADS_SHOW_OPTION2', true);  // Position 2 anzeigen
define('GOOGLE_ADS_SHOW_OPTION3', false); // Position 3 NICHT anzeigen
```

## Die 3 Anzeigenpositionen

### Position 1: Nach dem Wichtelpartner-Bereich ⭐ **EMPFOHLEN**

**Wo:** Direkt nach der Anzeige des Wichtelpartners und seiner Wunschliste, vor dem Abschnitt "Deine Wunschliste"

**Vorteile:**
- ✅ Hohe Sichtbarkeit
- ✅ Nutzer sind engagiert (haben gerade wichtige Info erhalten)
- ✅ Natürlicher Break im Content-Flow
- ✅ Funktioniert auf Mobile und Desktop
- ✅ Nicht störend für kritische Funktionen

**Nachteile:**
- ⚠️ Unterbricht den Lesefluss leicht

**Empfehlung:** Dies ist die **beste Position** für maximale Sichtbarkeit bei guter User Experience.

**Aktivierung:**
```php
define('GOOGLE_ADS_SHOW_OPTION1', true);
```

---

### Position 2: Am Ende der Seite

**Wo:** Ganz unten, nach allen Inhalten (Gruppendetails, Link, Gruppenauswahl-Button), vor dem Footer

**Vorteile:**
- ✅ Stört den Hauptcontent überhaupt nicht
- ✅ Nutzer haben alle wichtigen Infos bereits gesehen
- ✅ Sehr unaufdringlich
- ✅ Funktioniert auf Mobile und Desktop

**Nachteile:**
- ⚠️ Niedrigere Sichtbarkeit
- ⚠️ Viele Nutzer scrollen nicht bis ganz unten

**Empfehlung:** Gute **ergänzende Position** zu Option 1, oder alleine für minimal-invasive Werbung.

**Aktivierung:**
```php
define('GOOGLE_ADS_SHOW_OPTION2', true);
```

---

### Position 3: Sidebar (nur Desktop) 🧪 **EXPERIMENTELL**

**Wo:** Rechte Sidebar neben dem Hauptcontent, sticky (bleibt beim Scrollen sichtbar)

**Vorteile:**
- ✅ Nutzt ungenutzten Platz auf großen Bildschirmen
- ✅ Dauerhaft sichtbar beim Scrollen (sticky)
- ✅ Stört Mobile-Nutzer überhaupt nicht (wird ausgeblendet)
- ✅ Keine Unterbrechung des Content-Flows

**Nachteile:**
- ⚠️ Nur auf Bildschirmen > 1200px Breite sichtbar
- ⚠️ Verkleinert Hauptcontent-Bereich leicht
- ⚠️ Layout-Änderung könnte auffallen

**Empfehlung:** **Experimentelle Option** für Desktop-Traffic. Gut kombinierbar mit Option 1 oder 2.

**Technische Details:**
- Wird nur ab 1200px Viewport-Breite angezeigt
- Verwendet CSS `position: sticky` für permanente Sichtbarkeit
- 300px Breite (Standard für AdSense Skyscraper)

**Aktivierung:**
```php
define('GOOGLE_ADS_SHOW_OPTION3', true);
```

## Setup-Anleitung

### Schritt 0: Test-Modus aktivieren (Optional, aber empfohlen)

Bevor du echte Google Ads einrichtest, kannst du das Layout im Test-Modus prüfen:

1. Öffne `config.php`
2. Setze:
```php
define('GOOGLE_ADS_ENABLED', true);
define('GOOGLE_ADS_TESTING', true); // Test-Modus aktivieren
define('GOOGLE_ADS_SHOW_OPTION1', true); // Welche Positionen testen?
```
3. Öffne `participant.php` im Browser
4. Du siehst jetzt weiße Platzhalter-Blöcke mit Text wie "📊 Google Ad Placeholder"
5. Prüfe auf verschiedenen Geräten (Desktop, Tablet, Mobile)
6. Entscheide welche Positionen du nutzen möchtest

**Wenn du mit dem Layout zufrieden bist, fahre mit Schritt 1 fort.**

### Schritt 1: Google AdSense Account einrichten

1. Gehe zu [Google AdSense](https://www.google.com/adsense/)
2. Melde dich an oder erstelle einen Account
3. Füge deine Website hinzu
4. Warte auf die Genehmigung (kann 1-2 Tage dauern)

### Schritt 2: Ad Units erstellen

Für jede Position, die du nutzen möchtest, erstelle eine Ad Unit:

1. In AdSense: **Ads** → **Ad units** → **Display ads**
2. Erstelle 1-3 Ad Units mit folgenden Einstellungen:
   - **Type:** Display ads
   - **Size:** Responsive (empfohlen)
   - **Name:** z.B. "Wichteln - Participant Position 1"
3. Kopiere die **Ad Slot ID** (ca-pub-XXX ist der Client, Slot ist eine andere Nummer)

### Schritt 3: Config-Datei anpassen

1. Öffne `config.php` (oder kopiere `config.example.php` zu `config.php`)
2. Füge die Google Ads Konfiguration hinzu:

```php
// Google Ads aktivieren
define('GOOGLE_ADS_ENABLED', true);

// Test-Modus DEAKTIVIEREN für Live-Ads
define('GOOGLE_ADS_TESTING', false); // false = echte Ads

// Deine Publisher ID (findest du in AdSense unter Account → Account Information)
define('GOOGLE_ADS_CLIENT', 'ca-pub-XXXXXXXXXXXXXXXXX');

// Die Ad Slot IDs deiner erstellten Ad Units
define('GOOGLE_ADS_SLOT_OPTION1', '1234567890'); // Von AdSense kopieren
define('GOOGLE_ADS_SLOT_OPTION2', '0987654321'); // Von AdSense kopieren
define('GOOGLE_ADS_SLOT_OPTION3', '1122334455'); // Von AdSense kopieren

// Welche Positionen sollen angezeigt werden?
define('GOOGLE_ADS_SHOW_OPTION1', true);  // Empfohlen
define('GOOGLE_ADS_SHOW_OPTION2', false); // Optional
define('GOOGLE_ADS_SHOW_OPTION3', false); // Optional/Experimentell
```

### Schritt 4: Testen

1. Öffne `participant.php` im Browser
2. Öffne die Browser DevTools (F12) → Console
3. Suche nach Fehlermeldungen
4. Prüfe ob die Anzeigen geladen werden

**Hinweis:** Bei neuen AdSense-Accounts können Anzeigen anfangs leer sein. Das ist normal und löst sich nach einigen Stunden/Tagen.

## Empfohlene Konfigurationen

### Test-Modus (Layout-Prüfung)
```php
define('GOOGLE_ADS_ENABLED', true);
define('GOOGLE_ADS_TESTING', true);   // Zeigt Platzhalter
define('GOOGLE_ADS_SHOW_OPTION1', true);
define('GOOGLE_ADS_SHOW_OPTION2', true);
define('GOOGLE_ADS_SHOW_OPTION3', true); // Alle Positionen testen
```

### Minimal (unaufdringlich)
```php
define('GOOGLE_ADS_ENABLED', true);
define('GOOGLE_ADS_TESTING', false);  // Live-Ads
define('GOOGLE_ADS_SHOW_OPTION1', false);
define('GOOGLE_ADS_SHOW_OPTION2', true);  // Nur am Ende
define('GOOGLE_ADS_SHOW_OPTION3', false);
```

### Standard (empfohlen)
```php
define('GOOGLE_ADS_ENABLED', true);
define('GOOGLE_ADS_TESTING', false);  // Live-Ads
define('GOOGLE_ADS_SHOW_OPTION1', true);  // Nach Wichtelpartner
define('GOOGLE_ADS_SHOW_OPTION2', false);
define('GOOGLE_ADS_SHOW_OPTION3', false);
```

### Maximal (alle Positionen)
```php
define('GOOGLE_ADS_ENABLED', true);
define('GOOGLE_ADS_TESTING', false);  // Live-Ads
define('GOOGLE_ADS_SHOW_OPTION1', true);  // Nach Wichtelpartner
define('GOOGLE_ADS_SHOW_OPTION2', true);  // Am Ende
define('GOOGLE_ADS_SHOW_OPTION3', true);  // Sidebar Desktop
```

### Desktop + Mobile optimiert
```php
define('GOOGLE_ADS_ENABLED', true);
define('GOOGLE_ADS_TESTING', false);  // Live-Ads
define('GOOGLE_ADS_SHOW_OPTION1', true);  // Mobile + Desktop
define('GOOGLE_ADS_SHOW_OPTION2', false);
define('GOOGLE_ADS_SHOW_OPTION3', true);  // Nur Desktop
```

## Deaktivierung

Um alle Anzeigen komplett zu deaktivieren:

```php
define('GOOGLE_ADS_ENABLED', false);
```

Alle anderen Einstellungen bleiben erhalten, aber keine Anzeigen werden angezeigt.

## Troubleshooting

### Problem: Anzeigen werden nicht angezeigt

**Lösung 1:** Prüfe Test-Modus:
- Ist `GOOGLE_ADS_TESTING` auf `true`? Dann siehst du nur Platzhalter (das ist korrekt!)
- Setze `GOOGLE_ADS_TESTING` auf `false` für echte Ads

**Lösung 2:** Prüfe in `config.php`:
- Ist `GOOGLE_ADS_ENABLED` auf `true` gesetzt?
- Ist die entsprechende Position aktiviert? (z.B. `GOOGLE_ADS_SHOW_OPTION1`)
- Sind `GOOGLE_ADS_CLIENT` und die Slot-IDs korrekt?

**Lösung 3:** AdSense Probleme:
- Neuer Account? Warte 24-48 Stunden
- Account approved? Prüfe in AdSense Dashboard
- Ad Unit erstellt? Mindestens eine Ad Unit muss existieren

**Lösung 4:** Browser-Probleme:
- AdBlocker deaktivieren
- Browser-Cache leeren
- Private/Incognito Mode testen

### Problem: Ich sehe nur weiße Blöcke mit Text

**Lösung:** Das ist der Test-Modus! Setze in `config.php`:
```php
define('GOOGLE_ADS_TESTING', false);
```

### Problem: Layout sieht komisch aus mit Sidebar

**Lösung:** Deaktiviere Option 3:
```php
define('GOOGLE_ADS_SHOW_OPTION3', false);
```

Die Sidebar ist experimentell und funktioniert nur auf großen Bildschirmen gut.

### Problem: Zu viele Anzeigen

**Lösung:** Reduziere auf eine Position:
```php
define('GOOGLE_ADS_SHOW_OPTION1', true);  // Nur diese aktiviert
define('GOOGLE_ADS_SHOW_OPTION2', false);
define('GOOGLE_ADS_SHOW_OPTION3', false);
```

### Problem: Ich möchte das Layout ohne AdSense Account testen

**Lösung:** Nutze den Test-Modus:
```php
define('GOOGLE_ADS_ENABLED', true);
define('GOOGLE_ADS_TESTING', true); // Zeigt Platzhalter statt echte Ads
```

## Performance-Hinweise

- Google Ads werden asynchron geladen (`async`-Attribut)
- Verzögern das Laden der Seite **nicht**
- Responsive Anzeigen passen sich automatisch an Bildschirmgröße an
- `data-full-width-responsive="true"` sorgt für optimale Darstellung
- Test-Modus hat **keine** Performance-Auswirkungen (nur statisches HTML/CSS)

## Quick Reference

### Test-Modus vs. Live-Modus

| Modus | `GOOGLE_ADS_TESTING` | Was wird angezeigt | Wann nutzen? |
|-------|---------------------|-------------------|--------------|
| **Test** | `true` | Weiße Platzhalter mit Text | Layout-Prüfung, Entwicklung |
| **Live** | `false` | Echte Google Ads | Produktion, Monetarisierung |

### Ad-Positionen auf einen Blick

| Position | Config | Sichtbarkeit | Geräte | UX-Impact | Empfehlung |
|----------|--------|--------------|--------|-----------|------------|
| **Position 1** | `GOOGLE_ADS_SHOW_OPTION1` | Hoch | Alle | Mittel | ⭐ Beste Wahl |
| **Position 2** | `GOOGLE_ADS_SHOW_OPTION2` | Mittel | Alle | Niedrig | Ergänzung |
| **Position 3** | `GOOGLE_ADS_SHOW_OPTION3` | Hoch* | Desktop only | Niedrig | 🧪 Experimentell |

*Nur auf Bildschirmen > 1200px Breite

### Konfigurationsübersicht

```php
// Master-Schalter
GOOGLE_ADS_ENABLED      // true/false - Alles ein/aus
GOOGLE_ADS_TESTING      // true/false - Test-Modus ein/aus

// Google AdSense Daten
GOOGLE_ADS_CLIENT       // ca-pub-XXXXX - Deine Publisher ID
GOOGLE_ADS_SLOT_OPTIONx // Slot IDs für jede Position

// Positionssteuerung
GOOGLE_ADS_SHOW_OPTION1 // true/false - Position 1 ein/aus
GOOGLE_ADS_SHOW_OPTION2 // true/false - Position 2 ein/aus  
GOOGLE_ADS_SHOW_OPTION3 // true/false - Position 3 ein/aus
```

## Rechtliche Hinweise

⚠️ **Wichtig:** Wenn du Google Ads einsetzt, musst du:

1. **Datenschutzerklärung aktualisieren** (`datenschutz.php`)
   - Google AdSense als Drittanbieter erwähnen
   - Cookie-Nutzung durch Google erklären
   - Link zu Google's Datenschutzerklärung einfügen

2. **Cookie-Banner** erwägen (in der Schweiz aktuell nicht Pflicht, aber empfohlen)

3. **Impressum prüfen** (ist bereits vorhanden)

## Weitere Seiten

Diese Anleitung gilt aktuell nur für `participant.php`. Du kannst die gleiche Logik auch in andere Seiten integrieren:

- `index.php` (Landing Page)
- `create_group.php` (Gruppenerstellung)
- `register.php` (Registrierung)
- `admin.php` (Admin-Bereich)

Kopiere einfach die entsprechenden Code-Blöcke und passe die Ad Slot IDs an.

## Support

Bei Fragen oder Problemen:
1. Prüfe diese Dokumentation
2. Prüfe [Google AdSense Help](https://support.google.com/adsense/)
3. Prüfe Browser DevTools Console auf Fehler

---

**Viel Erfolg mit der Monetarisierung! 🎄💰**
