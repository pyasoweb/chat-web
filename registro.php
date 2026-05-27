<?php
$nombre = $_POST['nombre'];
$mensaje = $_POST['mensaje'];
$para = 'pyasowe@gmail.com';
$titulo = 'ASUNTO DEL MENSAJE';
$header = 'From: ' . $email;
$msjCorreo = "Nombre: $nombre\n Mensaje:\n $mensaje";
  
if ($_POST['submit']) {
if (mail($para, $titulo, $msjCorreo, $header)) {
echo "<script language='javascript'>
alert('Mensaje enviado, muchas gracias.');
window.location.href = 'http://tokyo-zona-zero.esy.es';
</script>";
} else {
echo 'Falló el envio';
}
}
?>
