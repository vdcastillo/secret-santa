# Google AdSense - Komplette Checkliste ✅

## 📋 Was du noch brauchst/machen musst:

### 1. ✅ ERLEDIGT: Technische Integration
- ✅ Code in `participant.php` implementiert
- ✅ Config-System eingerichtet (`config.example.php`)
- ✅ Test-Modus verfügbar
- ✅ Responsive Design für alle Geräte
- ✅ 3 Positionen wählbar

### 2. ✅ ERLEDIGT: Datenschutz
- ✅ Datenschutzerklärung aktualisiert (`datenschutz.php`)
- ✅ Google AdSense Abschnitt hinzugefügt
- ✅ Cookie-Informationen dokumentiert
- ✅ Widerspruchsrechte erklärt
- ✅ Link zu Google Datenschutzerklärung

### 3. ⚠️ TO-DO: Google AdSense Account

#### A) Account erstellen/prüfen
- [ ] Gehe zu: https://www.google.com/adsense/
- [ ] Melde dich mit Google-Konto an
- [ ] Füge deine Website hinzu: `wichtlä.ch` (oder `xn--wichtl-gua.ch`)
- [ ] Warte auf Genehmigung (1-2 Tage)

#### B) Ad Units erstellen
Für jede Position eine Ad Unit erstellen:

**Position 1 (Nach Wichtelpartner):**
- [ ] AdSense → Ads → Ad units → New ad unit
- [ ] Type: Display ads
- [ ] Name: "Wichteln - Participant Position 1"
- [ ] Ad size: Responsive
- [ ] Kopiere die **Slot ID** (z.B. `4349989330`)

**Position 2 (Am Ende der Seite):**
- [ ] Wiederhole Schritte für Position 2
- [ ] Name: "Wichteln - Participant Position 2"
- [ ] Kopiere die **Slot ID**

**Position 3 (Sidebar - Optional):**
- [ ] Wiederhole Schritte für Position 3
- [ ] Name: "Wichteln - Participant Sidebar"
- [ ] Kopiere die **Slot ID**

#### C) Publisher ID notieren
- [ ] AdSense → Account → Account Information
- [ ] Kopiere deine **Publisher ID** (Format: `ca-pub-XXXXXXXXXXXXXXXXX`)

### 4. ⚠️ TO-DO: Config-Datei einrichten

```bash
# Im Terminal:
cd /Users/patrick/git/wichteln
cp config.example.php config.php
nano config.php  # oder mit VSCode öffnen
```

Dann in `config.php` eintragen:

```php
// Google Ads Einstellungen
define('GOOGLE_ADS_ENABLED', true);
define('GOOGLE_ADS_TESTING', false);  // false für Live-Ads!

// HIER DEINE ECHTEN WERTE EINTRAGEN:
define('GOOGLE_ADS_CLIENT', 'ca-pub-2981657866275117');  // Deine Publisher ID
define('GOOGLE_ADS_SLOT_OPTION1', '4349989330');  // Deine Slot ID Position 1
define('GOOGLE_ADS_SLOT_OPTION2', 'XXXXXXXXXX');  // Deine Slot ID Position 2
define('GOOGLE_ADS_SLOT_OPTION3', 'XXXXXXXXXX');  // Deine Slot ID Position 3

// Welche Positionen nutzen?
define('GOOGLE_ADS_SHOW_OPTION1', false);  // Position 1
define('GOOGLE_ADS_SHOW_OPTION2', true);   // Position 2 (wie du testest)
define('GOOGLE_ADS_SHOW_OPTION3', false);  // Position 3
```

### 5. ⚠️ OPTIONAL: Cookie-Banner

**In der Schweiz aktuell NICHT Pflicht, aber empfohlen!**

Google AdSense setzt Cookies für personalisierte Werbung. Ein Cookie-Banner wäre professionell, ist aber in der Schweiz (noch) nicht gesetzlich vorgeschrieben wie in der EU (DSGVO).

**Wenn du einen Cookie-Banner möchtest:**
- Option A: Tarteaucitron.js (kostenlos, Open Source)
- Option B: Cookiebot (kostenpflichtig ab 100+ Seitenaufrufe/Monat)
- Option C: Einfacher eigener Banner (kann ich dir bauen)

**Aktuell reicht:**
- ✅ Datenschutzerklärung (hast du schon)
- ✅ Link zu Google Ads-Einstellungen (hast du schon)

### 6. ⚠️ TO-DO: Andere Seiten erweitern (Optional)

Aktuell ist Google Ads **nur** auf `participant.php`.

**Möchtest du auch Ads auf anderen Seiten?**
- [ ] `index.php` (Landing Page) - Hoher Traffic!
- [ ] `create_group.php` (Gruppenerstellung)
- [ ] `register.php` (Teilnehmer-Registrierung)
- [ ] `admin.php` (Admin-Bereich)

Falls ja: Gleicher Code wie in `participant.php`, nur andere Slot IDs erstellen.

### 7. ✅ TESTING: Was funktioniert?

**Debug-Checklist:**

```bash
# 1. Browser DevTools öffnen (F12)
# Console Tab → Suche nach Fehlern

# 2. Network Tab → Filter: "ads"
# Solltest sehen:
# - adsbygoogle.js (Status 200 OK)
# - ads?... Request

# 3. Wenn Ads leer/weiß:
# Normal bei:
# - Neuem Account (Warte 24-48h)
# - Neuer Ad Unit (Warte 1-2h)
# - Kein passender Advertiser für deine Nische

# 4. Test-URL mit Google's Test-Modus:
# https://wichtlä.ch/participant.php?token=XXX&google_adtest=on
```

### 8. ⚠️ RECHTLICHES: Was ist Pflicht?

**✅ Schweiz (wo du bist):**
- ✅ Impressum (hast du: `impressum.php`)
- ✅ Datenschutzerklärung (hast du: `datenschutz.php`)
- ✅ Google AdSense erwähnt (hast du jetzt)
- ❌ Cookie-Banner NICHT Pflicht (aber empfohlen)

**Wenn User aus EU/Deutschland:**
- ⚠️ DSGVO könnte greifen
- ⚠️ Cookie-Banner wäre dann Pflicht
- ⚠️ Opt-In vor Cookies setzen

**Empfehlung:** Füge einen einfachen Cookie-Banner hinzu, der sagt:
> "Diese Website verwendet Cookies für Funktionalität und Werbung. Mit der Nutzung stimmst du zu. [Mehr erfahren]"

## 🚀 Schnellstart für Live-Betrieb:

1. **AdSense Account erstellen** ↑ (siehe Schritt 3)
2. **Ad Units erstellen** ↑ (siehe Schritt 3B)
3. **config.php konfigurieren** ↑ (siehe Schritt 4)
4. **Website deployen**
5. **24-48 Stunden warten** (Google prüft deine Seite)
6. **Erste Ads erscheinen!** 💰

## ❓ Häufige Fragen:

**Q: Warum sind die Ads leer/weiß?**
A: Normal bei neuen Accounts/Ad Units. Warte 24-48 Stunden.

**Q: Wie viel verdiene ich?**
A: Abhängig von Traffic, Klickrate (CTR), Thema. Wichteln-Nische: ca. 0,10-0,50 € pro 1000 Views (grobe Schätzung).

**Q: Brauche ich einen Cookie-Banner?**
A: In der Schweiz nein (aktuell). In EU ja. Empfehlung: Ja, zur Sicherheit.

**Q: Kann ich Google Ads später deaktivieren?**
A: Ja! In config.php: `define('GOOGLE_ADS_ENABLED', false);`

**Q: Position 1, 2 oder 3?**
A: 
- Position 2 (Ende) = Am wenigsten störend, aber niedrigste Klickrate
- Position 1 (Mitte) = Beste Balance, höchste Sichtbarkeit
- Position 3 (Sidebar) = Nur Desktop, experimentell

**Q: Sieht unprofessionell aus?**
A: Nein! Viele kostenlose Dienste nutzen Ads. Ist transparent in Datenschutzerklärung dokumentiert.

## 📞 Support:

- **Google AdSense Help:** https://support.google.com/adsense/
- **Google AdSense Forum:** https://support.google.com/adsense/community
- **Dokumentation:** `GOOGLE_ADS_SETUP.md` in diesem Ordner

## ✨ Zusammenfassung:

**Was fertig ist:**
- ✅ Code implementiert
- ✅ Datenschutz aktualisiert
- ✅ Test-Modus funktioniert
- ✅ Responsive Design

**Was du noch brauchst:**
1. Google AdSense Account erstellen & genehmigen lassen
2. Ad Units erstellen & Slot IDs kopieren
3. config.php mit echten Werten füllen
4. (Optional) Cookie-Banner hinzufügen
5. Warten bis Google deine Seite freigibt (24-48h)

**Dann bist du LIVE! 🎉**
