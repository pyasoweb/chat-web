<?php


$nombre_archivo = 'prueba.txt';
if($_SERVER["HTTP_X_FORWARDED_FOR"]){
$contenido = $_SERVER["HTTP_X_FORWARDED_FOR"]."\n";
}else{
$contenido = $_SERVER["REMOTE_ADDR"]."\n";
}



// Asegurarse primero de que el archivo existe y puede escribirse sobre el.
if (is_writable($prueba.txt)) {

    // En nuestro ejemplo estamos abriendo $nombre_archivo en modo de adicion.
    // El apuntador de archivo se encuentra al final del archivo, asi que
    // alli es donde ira $contenido cuando llamemos fwrite().
    if (!$gestor = fopen($prueba.txt, 'a')) {
         echo "No se puede abrir el archivo ($prueba.txt)";
         exit;
    }

    // Escribir $contenido a nuestro arcivo abierto.
    if (fwrite($gestor, $contenido) === FALSE) {
        echo "No se puede escribir al archivo ($prueba.txt)";
        exit;
    }
    
    echo "&Eacute;xito, se escribi&oacute; ($contenido) al archivo ($prueba.txt)";
    
    fclose($gestor);

} else {
    echo "No se puede escribir sobre el archivo $prueba.txt";
}
?>
