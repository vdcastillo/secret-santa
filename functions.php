<?php
require_once 'config.php';
require_once 'phpmailer.php';

// Configurar la ruta correcta de sendmail (ajústala según tu entorno)
ini_set('sendmail_path', '/usr/sbin/sendmail -t -i');

// Mostrar errores (solo para desarrollo; desactívalo en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
function db_connect() {
    $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4';
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        return $pdo;
    } catch (PDOException $e) {
        die('La conexión a la base de datos falló: ' . $e->getMessage());
    }
}

// Generar un token aleatorio
function generate_token($length = 32) {
    return bin2hex(random_bytes($length));
}

// Enviar correo usando la función mail() de PHP
function send_email($to, $subject, $message, $is_html = false) {
    // Encabezados del correo
//    $headers = "From: " . SMTP_FROM_NAME . " <" . SMTP_FROM_EMAIL . ">\r\n";
//    $headers .= "Reply-To: " . SMTP_FROM_EMAIL . "\r\n";
//    $headers .= "MIME-Version: 1.0\r\n";
//
//    if ($is_html) {
//        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
//    } else {
//        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
//    }

    // Usar la función mail()
//    return mail($to, $subject, $message, $headers);

    return sendEmail($to,$subject,$message);

}

// Funktion zum Erstellen einer schönen HTML-E-Mail im Wichtel-Design
function create_html_email($name, $assigned_name, $wishlist, $budget, $description, $gift_date) {
    $html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu persona asignada</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 40px 20px;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0" style="background: #ffffff; border-radius: 16px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12); overflow: hidden; max-width: 100%;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #264653 0%, #2a9d8f 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-family: \'Playfair Display\', Georgia, serif; font-size: 32px; font-weight: 700; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);">Wichteln</h1>
                            <p style="margin: 10px 0 0 0; color: rgba(255, 255, 255, 0.9); font-size: 16px;">¡Tu persona asignada ha sido sorteada!</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            
                            <!-- Greeting -->
                            <p style="margin: 0 0 20px 0; color: #2b2d42; font-size: 16px; line-height: 1.6;">
                                Hola <strong style="color: #e63946;">' . htmlspecialchars($name) . '</strong>,
                            </p>
                            
                            <!-- Partner Info Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, rgba(230, 57, 70, 0.05), rgba(231, 111, 81, 0.05)); border-left: 4px solid #e63946; border-radius: 8px; margin: 20px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 8px 0; color: #5f6368; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Tu persona asignada</p>
                                        <h2 style="margin: 0; color: #e63946; font-family: \'Playfair Display\', Georgia, serif; font-size: 28px; font-weight: 700;">' . htmlspecialchars($assigned_name) . '</h2>
                                    </td>
                                </tr>
                            </table>';
    
    // Wunschliste wenn vorhanden
    if (!empty($wishlist)) {
        $html .= '
                            <!-- Wishlist Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: #f8f9fa; border-left: 4px solid #2a9d8f; border-radius: 8px; margin: 20px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 12px 0; color: #2a9d8f; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">✨ Lista de deseos de ' . htmlspecialchars($assigned_name) . '</p>
                                        <p style="margin: 0; color: #2b2d42; font-size: 15px; line-height: 1.7; white-space: pre-wrap;">' . htmlspecialchars($wishlist) . '</p>
                                    </td>
                                </tr>
                            </table>';
    }
    
    $html .= '
                            <!-- Group Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0 20px 0; border-top: 2px solid #e1e4e8; padding-top: 20px;">
                                <tr>
                                    <td>
                                        <p style="margin: 0 0 15px 0; color: #2a9d8f; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">📋 Detalles del grupo</p>
                                        
                                        <table width="100%" cellpadding="8" cellspacing="0">
                                            <tr>
                                                <td style="color: #5f6368; font-size: 14px; padding: 8px 0;">💰 Budget:</td>
                                                <td style="color: #2b2d42; font-size: 14px; font-weight: 600; padding: 8px 0; text-align: right;">' . htmlspecialchars($budget) . '</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #5f6368; font-size: 14px; padding: 8px 0;">📝 Beschreibung:</td>
                                                <td style="color: #2b2d42; font-size: 14px; font-weight: 600; padding: 8px 0; text-align: right;">' . htmlspecialchars($description) . '</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #5f6368; font-size: 14px; padding: 8px 0;">🎁 Geschenkübergabe:</td>
                                                <td style="color: #2b2d42; font-size: 14px; font-weight: 600; padding: 8px 0; text-align: right;">' . htmlspecialchars($gift_date) . '</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Closing -->
                            <p style="margin: 30px 0 0 0; color: #2b2d42; font-size: 16px; line-height: 1.6;">
                                Viel Spaß beim Wichteln! 🎄
                            </p>
                            
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background: #264653; padding: 25px 30px; text-align: center;">
                            <p style="margin: 0; color: rgba(255, 255, 255, 0.8); font-size: 13px;">
                                Diese E-Mail wurde automatisch von <strong style="color: #ffffff;">wichtlä.ch</strong> versendet
                            </p>
                            <p style="margin: 8px 0 0 0; color: rgba(255, 255, 255, 0.6); font-size: 12px;">
                                © ' . date('Y') . ' wichtlä.ch - Online Wichteln leicht gemacht
                            </p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
    
    return $html;
}

// Funktion zum Erstellen einer Registrierungs-Bestätigungs-E-Mail
function create_registration_email($name, $group_name, $participant_link, $budget, $description, $gift_date) {
    $html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido al Wichteln</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background: #ffffff; border-radius: 16px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12); overflow: hidden; max-width: 100%;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #264653 0%, #2a9d8f 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-family: \'Playfair Display\', Georgia, serif; font-size: 32px; font-weight: 700; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);">🎁 Wichteln</h1>
                            <p style="margin: 10px 0 0 0; color: rgba(255, 255, 255, 0.9); font-size: 16px;">¡Bienvenido al Wichteln!</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            
                            <p style="margin: 0 0 20px 0; color: #2b2d42; font-size: 16px; line-height: 1.6;">
                                Hola <strong style="color: #e63946;">' . htmlspecialchars($name) . '</strong>,
                            </p>
                            
                            <p style="margin: 0 0 25px 0; color: #2b2d42; font-size: 16px; line-height: 1.6;">
                                ¡Te has registrado correctamente en el grupo de Wichteln <strong>"' . htmlspecialchars($group_name) . '"</strong>! 🎉
                            </p>
                            
                            <!-- Personal Link Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, rgba(42, 157, 143, 0.08), rgba(38, 70, 83, 0.08)); border-left: 4px solid #2a9d8f; border-radius: 8px; margin: 20px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 12px 0; color: #2a9d8f; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">🔗 Tu enlace personal</p>
                                        <p style="margin: 0 0 8px 0; color: #5f6368; font-size: 13px; line-height: 1.5;">
                                            Guarda este enlace para editar tu lista de deseos más tarde y ver a tu persona asignada:
                                        </p>
                                        <a href="' . htmlspecialchars($participant_link) . '" style="display: inline-block; margin-top: 10px; padding: 12px 24px; background: linear-gradient(135deg, #2a9d8f, #264653); color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px;">Ir al área de participantes →</a>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Group Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0 20px 0; border-top: 2px solid #e1e4e8; padding-top: 20px;">
                                <tr>
                                    <td>
                                        <p style="margin: 0 0 15px 0; color: #2a9d8f; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">📋 Detalles del grupo</p>
                                        
                                        <table width="100%" cellpadding="8" cellspacing="0">
                                            <tr>
                                                <td style="color: #5f6368; font-size: 14px; padding: 8px 0;">💰 Presupuesto:</td>
                                                <td style="color: #2b2d42; font-size: 14px; font-weight: 600; padding: 8px 0; text-align: right;">' . htmlspecialchars($budget) . '</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #5f6368; font-size: 14px; padding: 8px 0;">📝 Descripción:</td>
                                                <td style="color: #2b2d42; font-size: 14px; font-weight: 600; padding: 8px 0; text-align: right;">' . htmlspecialchars($description) . '</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #5f6368; font-size: 14px; padding: 8px 0;">🎁 Entrega de regalos:</td>
                                                <td style="color: #2b2d42; font-size: 14px; font-weight: 600; padding: 8px 0; text-align: right;">' . htmlspecialchars($gift_date) . '</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Tip Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: #fff8e1; border-left: 4px solid #f4a261; border-radius: 8px; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 15px 20px;">
                                        <p style="margin: 0; color: #2b2d42; font-size: 14px; line-height: 1.6;">
                                            <strong style="color: #f4a261;">💡 Consejo:</strong> Añade tu lista de deseos ahora desde tu enlace personal. ¡Tras el sorteo, tu persona asignada podrá verla!
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 25px 0 0 0; color: #2b2d42; font-size: 16px; line-height: 1.6;">
                                ¡Que disfrutes del Wichteln! 🎄
                            </p>
                            
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background: #264653; padding: 25px 30px; text-align: center;">
                            <p style="margin: 0; color: rgba(255, 255, 255, 0.8); font-size: 13px;">
                                Este correo fue enviado automáticamente por <strong style="color: #ffffff;">wichtlä.ch</strong>
                            </p>
                            <p style="margin: 8px 0 0 0; color: rgba(255, 255, 255, 0.6); font-size: 12px;">
                                © ' . date('Y') . ' wichtlä.ch - Wichteln en línea, así de fácil
                            </p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
    
    return $html;
}

// Funktion zum Erstellen einer Admin-Willkommens-E-Mail
function create_admin_email($group_name, $admin_link, $invite_link, $budget, $description, $gift_date) {
    $html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu grupo de Wichteln ha sido creado</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background: #ffffff; border-radius: 16px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12); overflow: hidden; max-width: 100%;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #264653 0%, #2a9d8f 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-family: \'Playfair Display\', Georgia, serif; font-size: 32px; font-weight: 700; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);">🎁 Wichteln</h1>
                            <p style="margin: 10px 0 0 0; color: rgba(255, 255, 255, 0.9); font-size: 16px;">¡Tu grupo se ha creado correctamente!</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            
                            <p style="margin: 0 0 20px 0; color: #2b2d42; font-size: 16px; line-height: 1.6;">
                                Hola <strong style="color: #e63946;">Admin</strong>,
                            </p>
                            
                            <p style="margin: 0 0 25px 0; color: #2b2d42; font-size: 16px; line-height: 1.6;">
                                ¡Tu grupo de Wichteln <strong>"' . htmlspecialchars($group_name) . '"</strong> se ha creado correctamente! 🎉
                            </p>
                            
                            <!-- Admin Link Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, rgba(230, 57, 70, 0.08), rgba(231, 111, 81, 0.08)); border-left: 4px solid #e63946; border-radius: 8px; margin: 20px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 12px 0; color: #e63946; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">🔐 Área de administración</p>
                                        <p style="margin: 0 0 8px 0; color: #5f6368; font-size: 13px; line-height: 1.5;">
                                            Con este enlace administras tu grupo, agregas participantes y realizas el sorteo:
                                        </p>
                                        <a href="' . htmlspecialchars($admin_link) . '" style="display: inline-block; margin-top: 10px; padding: 12px 24px; background: linear-gradient(135deg, #e63946, #d62828); color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px;">Ir al área de administración →</a>
                                        <p style="margin: 12px 0 0 0; color: #5f6368; font-size: 12px; line-height: 1.5;">
                                            ⚠️ <strong>Importante:</strong> ¡Guarda este enlace de forma segura! Es tu acceso para administrar el grupo.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Invite Link Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, rgba(42, 157, 143, 0.08), rgba(38, 70, 83, 0.08)); border-left: 4px solid #2a9d8f; border-radius: 8px; margin: 20px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 12px 0; color: #2a9d8f; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">👥 Enlace de invitación para participantes</p>
                                        <p style="margin: 0 0 8px 0; color: #5f6368; font-size: 13px; line-height: 1.5;">
                                            Comparte este enlace con todos los que participarán en el Wichteln:
                                        </p>
                                        <p style="margin: 10px 0 0 0; padding: 12px; background: #ffffff; border: 1px solid #e1e4e8; border-radius: 6px; color: #2a9d8f; font-size: 13px; font-family: monospace; word-break: break-all;">
                                            ' . htmlspecialchars($invite_link) . '
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Group Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0 20px 0; border-top: 2px solid #e1e4e8; padding-top: 20px;">
                                <tr>
                                    <td>
                                        <p style="margin: 0 0 15px 0; color: #2a9d8f; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">📋 Detalles del grupo</p>
                                        
                                        <table width="100%" cellpadding="8" cellspacing="0">
                                            <tr>
                                                <td style="color: #5f6368; font-size: 14px; padding: 8px 0;">💰 Presupuesto:</td>
                                                <td style="color: #2b2d42; font-size: 14px; font-weight: 600; padding: 8px 0; text-align: right;">' . htmlspecialchars($budget) . '</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #5f6368; font-size: 14px; padding: 8px 0;">📝 Descripción:</td>
                                                <td style="color: #2b2d42; font-size: 14px; font-weight: 600; padding: 8px 0; text-align: right;">' . htmlspecialchars($description) . '</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #5f6368; font-size: 14px; padding: 8px 0;">🎁 Entrega de regalos:</td>
                                                <td style="color: #2b2d42; font-size: 14px; font-weight: 600; padding: 8px 0; text-align: right;">' . htmlspecialchars($gift_date) . '</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Next Steps -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: #f8f9fa; border-left: 4px solid #f4a261; border-radius: 8px; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 12px 0; color: #f4a261; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">📝 Nächste Schritte</p>
                                        <ol style="margin: 0; padding-left: 20px; color: #2b2d42; font-size: 14px; line-height: 1.8;">
                                            <li>Teile den Einladungslink mit allen Teilnehmern</li>
                                            <li>Warte, bis sich alle registriert haben</li>
                                            <li>Lege optional Ausschlüsse fest (z.B. Paare)</li>
                                            <li>Führe die Auslosung im Admin-Bereich durch</li>
                                        </ol>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 25px 0 0 0; color: #2b2d42; font-size: 16px; line-height: 1.6;">
                                Viel Spaß beim Wichteln! 🎄
                            </p>
                            
                        </td>
                    </tr>
                    
                    <!-- Pie -->
                    <tr>
                        <td style="background: #264653; padding: 25px 30px; text-align: center;">
                            <p style="margin: 0; color: rgba(255, 255, 255, 0.8); font-size: 13px;">
                                Este correo fue enviado automáticamente por <strong style="color: #ffffff;">wichtlä.ch</strong>
                            </p>
                            <p style="margin: 8px 0 0 0; color: rgba(255, 255, 255, 0.6); font-size: 12px;">
                                © ' . date('Y') . ' wichtlä.ch - Wichteln en línea, así de fácil
                            </p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
    
    return $html;
}

// Funktion zur Generierung der Basis-URL
function get_base_url() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || 
                $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/');
}

// Funktion zur Generierung einer lesbaren Display-URL (ohne https:// und mit wichtlä.ch statt Punycode)
function get_display_url($path = '') {
    // Konvertiere Punycode zurück zu IDN (internationalisierte Domain)
    $host = $_SERVER['HTTP_HOST'];
    
    // Wenn es xn--wichtl-gua.ch ist, zeige wichtlä.ch
    if (strpos($host, 'xn--wichtl-gua.ch') !== false) {
        $host = str_replace('xn--wichtl-gua.ch', 'wichtlä.ch', $host);
    }
    
    // Entferne führenden Slash vom Pfad
    $path = ltrim($path, '/');
    
    // Baue die Display-URL zusammen (mit https://)
    return 'https://' . $host . ($path ? '/' . $path : '');
}

?>