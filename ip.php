<?php
// Nombre del archivo donde se guardarán las visitas
$archivo = "visitas.txt";

// Obtener la IP del visitante
$ip = $_SERVER['REMOTE_ADDR'];

// Obtener la fecha y hora actual
$fecha = date("Y-m-d H:i:s");

// Crear la línea a guardar
$linea = $ip . " - " . $fecha . "\n";

// Guardar la línea en el archivo (modo append)
file_put_contents($archivo, $linea, FILE_APPEND);

echo "Bienvenido a mi sitio";
?>
