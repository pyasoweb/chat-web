<?php
/**
 * Script para registrar la IP del visitante en un archivo TXT
 * Guarda: Fecha y hora (Y-m-d H:i:s) + IP
 * Maneja proxies y cabeceras comunes para obtener la IP real
 */

// Ruta del archivo de log (fuera de la carpeta pública por seguridad)
$logFile = __DIR__ . '/logs/visitas.txt';

// Función para obtener la IP real del cliente
function getClientIP() {
    $keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];
    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            // En caso de múltiples IPs (proxies), tomar la primera
            $ipList = explode(',', $_SERVER[$key]);
            $ip = trim($ipList[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
    return 'UNKNOWN';
}

// Obtener IP y fecha actual
$ip = getClientIP();
$fecha = date('Y-m-d H:i:s');

// Crear carpeta si no existe
$dir = dirname($logFile);
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

// Registrar en el archivo
$linea = $fecha . " - " . $ip . PHP_EOL;
try {
    file_put_contents($logFile, $linea, FILE_APPEND | LOCK_EX);
} catch (Exception $e) {
    error_log("Error al escribir en el log: " . $e->getMessage());
}

// (Opcional) Mostrar IP al visitante
echo "Tu IP es: " . htmlspecialchars($ip);
?>
