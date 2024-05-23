<?php
// Habilitar el reporte de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Parámetros de conexión a la base de datos
$servername = "localhost";
$username = "root"; // Reemplaza con tu nombre de usuario de MySQL
$password = ""; // Reemplaza con tu contraseña de MySQL
$database = "webkeyman"; // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Preparar y vincular la declaración INSERT
$stmt = $conn->prepare("INSERT INTO waitlist (id, name, email, phone, country, password) VALUES (?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    die("Error en la preparación de la declaración: " . $conn->error);
}
$stmt->bind_param("ssssss", $id, $name, $email, $phone, $country, $password);

// Generar un ID único
$id = uniqid();

// Generar una contraseña aleatoria
$password = bin2hex(random_bytes(8)); // Genera una contraseña aleatoria de 8 caracteres

// Establecer los parámetros y ejecutar
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$country = $_POST['country'];

if ($stmt->execute()) {
    echo "¡Gracias! Se ha añadido a la lista de espera.";
} else {
    echo "Error en la ejecución de la declaración: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>