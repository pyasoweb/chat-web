<?php
/**
 * Procesar registro de usuario
 * Includes: validación, seguridad y almacenamiento en base de datos
 */

header('Content-Type: application/json; charset=utf-8');

// Iniciar sesión para usar CSRF tokens
session_start();

// CONFIGURACIÓN
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'mi_registro');

// Permitir solo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['error' => 'Método no permitido']));
}

// Respuesta en JSON
class Respuesta {
    public static function exito($mensaje, $data = null) {
        http_response_code(200);
        die(json_encode([
            'success' => true,
            'mensaje' => $mensaje,
            'data' => $data
        ]));
    }

    public static function error($mensaje, $codigo = 400) {
        http_response_code($codigo);
        die(json_encode([
            'success' => false,
            'error' => $mensaje
        ]));
    }
}

// VALIDAR ENTRADA
function validarEntrada($datos) {
    $errores = [];

    // Nombre
    if (empty($datos['nombre']) || strlen($datos['nombre']) < 3) {
        $errores['nombre'] = 'El nombre debe tener al menos 3 caracteres';
    }
    if (!preg_match('/^[a-záéíóúñ\s]+$/i', $datos['nombre'])) {
        $errores['nombre'] = 'El nombre solo puede contener letras y espacios';
    }

    // Email
    if (empty($datos['email']) || !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'Correo electrónico inválido';
    }

    // Usuario
    if (empty($datos['usuario']) || !preg_match('/^[a-zA-Z0-9_-]{4,20}$/', $datos['usuario'])) {
        $errores['usuario'] = 'Usuario debe tener 4-20 caracteres (letras, números, guiones)';
    }

    // Teléfono (opcional)
    if (!empty($datos['telefono'])) {
        if (!preg_match('/^[\d\s+()-]{7,}$/', $datos['telefono'])) {
            $errores['telefono'] = 'Teléfono inválido';
        }
    }

    // País
    if (empty($datos['pais'])) {
        $errores['pais'] = 'Debe seleccionar un país';
    }

    // Contraseña
    if (empty($datos['contrasena']) || strlen($datos['contrasena']) < 8) {
        $errores['contrasena'] = 'La contraseña debe tener al menos 8 caracteres';
    }

    // Confirmación de contraseña
    if ($datos['contrasena'] !== $datos['confirmar_contrasena']) {
        $errores['confirmar_contrasena'] = 'Las contraseñas no coinciden';
    }

    // Términos
    if (empty($datos['terminos'])) {
        $errores['terminos'] = 'Debe aceptar los términos y condiciones';
    }

    return $errores;
}

// OBTENER Y LIMPIAR DATOS
$datos = [
    'nombre' => trim($_POST['nombre'] ?? ''),
    'email' => trim(strtolower($_POST['email'] ?? '')),
    'usuario' => trim(strtolower($_POST['usuario'] ?? '')),
    'telefono' => trim($_POST['telefono'] ?? ''),
    'pais' => trim($_POST['pais'] ?? ''),
    'contrasena' => $_POST['contrasena'] ?? '',
    'confirmar_contrasena' => $_POST['confirmar_contrasena'] ?? '',
    'terminos' => $_POST['terminos'] ?? ''
];

// Validar entrada
$errores = validarEntrada($datos);
if (!empty($errores)) {
    Respuesta::error('Errores de validación: ' . implode(', ', $errores));
}

// CONEXIÓN A BASE DE DATOS
try {
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conexion->connect_error) {
        throw new Exception('Error de conexión: ' . $conexion->connect_error);
    }
    
    $conexion->set_charset('utf8mb4');
} catch (Exception $e) {
    Respuesta::error('Error en la base de datos: ' . $e->getMessage(), 500);
}

// VERIFICAR DUPLICADOS
$stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ? OR usuario = ? LIMIT 1");
$stmt->bind_param("ss", $datos['email'], $datos['usuario']);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    Respuesta::error('El email o usuario ya está registrado');
}
$stmt->close();

// HASH DE CONTRASEÑA
$hashContrasena = password_hash($datos['contrasena'], PASSWORD_BCRYPT, ['cost' => 12]);

// INSERTAR USUARIO
$stmt = $conexion->prepare(
    "INSERT INTO usuarios (nombre, email, usuario, telefono, pais, contrasena, fecha_registro, ip_registro) 
     VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)"
);

$ip_registro = $_SERVER['REMOTE_ADDR'] ?? 'Desconocida';

$stmt->bind_param(
    "sssssss",
    $datos['nombre'],
    $datos['email'],
    $datos['usuario'],
    $datos['telefono'],
    $datos['pais'],
    $hashContrasena,
    $ip_registro
);

if (!$stmt->execute()) {
    Respuesta::error('Error al registrar usuario: ' . $stmt->error, 500);
}

$usuario_id = $stmt->insert_id;
$stmt->close();

// ENVIAR EMAIL DE CONFIRMACIÓN
$asunto = "Bienvenido a nuestro sitio - Confirma tu email";
$mensaje = "
<html>
<head>
    <title>Confirmación de email</title>
</head>
<body>
    <h2>¡Bienvenido " . htmlspecialchars($datos['nombre']) . "!</h2>
    <p>Tu cuenta ha sido registrada exitosamente.</p>
    <p><strong>Datos de tu cuenta:</strong></p>
    <ul>
        <li>Usuario: " . htmlspecialchars($datos['usuario']) . "</li>
        <li>Email: " . htmlspecialchars($datos['email']) . "</li>
    </ul>
    <p>Ya puedes iniciar sesión en nuestro sitio.</p>
    <br>
    <p>Saludos,<br>El equipo</p>
</body>
</html>
";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
$headers .= "From: pyasowe@gmail.com" . "\r\n";

// Descomentar cuando tengas un servidor de emails configurado
// mail($datos['email'], $asunto, $mensaje, $headers);

$conexion->close();

// RESPUESTA EXITOSA
Respuesta::exito('Registro exitoso. Bienvenido ' . $datos['nombre'], [
    'usuario_id' => $usuario_id,
    'usuario' => $datos['usuario'],
    'email' => $datos['email']
]);
?>
