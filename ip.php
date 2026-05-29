<?php
function obtenerIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // IP desde internet compartido
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // IP pasada por un proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // IP directa del visitante
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

echo "La IP del visitante es: " . obtenerIP();
?>
