$archivo = "ips.txt"; // Nombre del archivo donde se guardará la IP
$ip = $_SERVER['REMOTE_ADDR']; // Obtener la IP del usuario
if (!file_exists($archivo)) {
echo "El archivo no existe";
} else {
$file = fopen($archivo, "a"); // Abrir el archivo en modo escritura
fwrite($file, $ip . "
"); // Guardar la IP en el archivo
fclose($file); // Cerrar el archivo
} // Si el archivo existe, no se guarda la IP
