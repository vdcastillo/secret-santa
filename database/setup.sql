-- ====================================
-- Wichtlä.ch - Datenbank Setup
-- ====================================
-- 
-- Dieses Skript erstellt alle notwendigen Tabellen
-- für die Wichtlä.ch Applikation
--
-- Voraussetzung: Datenbank wurde bereits erstellt
-- CREATE DATABASE wichtel_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- ====================================

USE wichtel_db;

-- ====================================
-- 1. GROUPS TABELLE
-- ====================================
-- Speichert alle Wichtel-Gruppen

CREATE TABLE IF NOT EXISTS `groups` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL COMMENT 'Name of the Secret Santa group',
  `admin_token` VARCHAR(64) NOT NULL UNIQUE COMMENT 'Token for admin access',
  `invite_token` VARCHAR(64) NOT NULL UNIQUE COMMENT 'Token for participant invitation',
  `admin_email` VARCHAR(255) NULL COMMENT 'Email of the group administrator',
  `budget` DECIMAL(10,2) NULL COMMENT 'Budget for gifts (optional)',
  `description` TEXT NULL COMMENT 'Description of the group (optional)',
  `gift_exchange_date` DATE NULL COMMENT 'Date of gift exchange (optional)',
  `is_drawn` TINYINT(1) DEFAULT 0 COMMENT 'Has the draw already been made? (0=No, 1=Yes)',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation timestamp',
  
  INDEX idx_admin_token (`admin_token`),
  INDEX idx_invite_token (`invite_token`),
  INDEX idx_created_at (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Wichtel-Gruppen';

-- ====================================
-- 2. PARTICIPANTS TABELLE
-- ====================================
-- Speichert alle Teilnehmer

CREATE TABLE IF NOT EXISTS `participants` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `group_id` INT NOT NULL COMMENT 'Reference to the group',
  `name` VARCHAR(255) NOT NULL COMMENT 'Participant name',
  `email` VARCHAR(255) NULL COMMENT 'Participant email (optional)',
  `participant_token` VARCHAR(64) NOT NULL UNIQUE COMMENT 'Personal access token',
  `assigned_to` INT NULL COMMENT 'ID of the assigned Secret Santa partner',
  `wishlist` TEXT NULL COMMENT 'Participant wishlist',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Registration timestamp',
  
  FOREIGN KEY (`group_id`) REFERENCES `groups`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`assigned_to`) REFERENCES `participants`(`id`) ON DELETE SET NULL,
  
  INDEX idx_participant_token (`token`),
  INDEX idx_group_participants (`group_id`),
  INDEX idx_assigned_to (`assigned_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Wichtel-Teilnehmer';

-- ====================================
-- 3. EXCLUSIONS TABELLE
-- ====================================
-- Speichert Ausschlüsse (wer darf wem nicht wichteln)

CREATE TABLE IF NOT EXISTS `exclusions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `group_id` INT NOT NULL COMMENT 'Reference to the group',
  `participant_id` INT NOT NULL COMMENT 'Participant who excludes',
  `excluded_participant_id` INT NOT NULL COMMENT 'Excluded participant',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation timestamp',
  
  FOREIGN KEY (`group_id`) REFERENCES `groups`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`participant_id`) REFERENCES `participants`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`excluded_participant_id`) REFERENCES `participants`(`id`) ON DELETE CASCADE,
  
  UNIQUE KEY `unique_exclusion` (`group_id`, `participant_id`, `excluded_participant_id`),
  INDEX idx_group_exclusions (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Wichtel-Ausschlüsse';

-- ====================================
-- TABELLEN ANZEIGEN
-- ====================================

SHOW TABLES;

-- ====================================
-- STRUKTUR PRÜFEN
-- ====================================

DESCRIBE `groups`;
DESCRIBE `participants`;
DESCRIBE `exclusions`;

-- ====================================
-- TEST-DATEN (Optional - für Entwicklung)
-- ====================================
-- Auskommentieren für Produktions-Setup!

/*
-- Test-Gruppe erstellen
INSERT INTO `groups` (`name`, `admin_token`, `invite_token`, `admin_email`, `budget`, `description`, `gift_exchange_date`) 
VALUES (
    'Test Wichtelgruppe',
    'test_admin_token_12345',
    'test_invite_token_67890',
    'admin@test.ch',
    25.00,
    'Dies ist eine Test-Gruppe',
    '2025-12-24'
);

-- Test-Teilnehmer erstellen
INSERT INTO `participants` (`group_id`, `name`, `email`, `token`, `wishlist`) VALUES
(1, 'Max Mustermann', 'max@test.ch', 'token_max_123', 'Bücher, Schokolade'),
(1, 'Anna Beispiel', 'anna@test.ch', 'token_anna_456', 'Tee, Kerzen'),
(1, 'Peter Test', 'peter@test.ch', 'token_peter_789', 'Socken, Kaffee');

-- Test-Ausschluss erstellen (Max kann nicht Anna wichteln)
INSERT INTO `exclusions` (`group_id`, `participant_id`, `excluded_participant_id`) 
VALUES (1, 1, 2);
*/

-- ====================================
-- ERFOLGSMELDUNG
-- ====================================

SELECT 'Datenbank-Setup erfolgreich abgeschlossen!' AS Status;
SELECT COUNT(*) AS Anzahl_Gruppen FROM `groups`;
SELECT COUNT(*) AS Anzahl_Teilnehmer FROM `participants`;
SELECT COUNT(*) AS Anzahl_Ausschluesse FROM `exclusions`;