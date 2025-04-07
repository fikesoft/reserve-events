<?php

$host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'random_events_db';

// Crear la conexión inicial sin seleccionar una base de datos
$conn = new mysqli($host, $db_user, $db_pass);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Crear la base de datos si no existe
$sql_create_database = "CREATE DATABASE IF NOT EXISTS $db_name";

if ($conn->query($sql_create_database) === TRUE) {
    // La base de datos se creó correctamente o ya existía
} else {
    die("Error al crear la base de datos: " . $conn->error);
}

// Seleccionar la base de datos creada
$conn->select_db($db_name);

// Establecer el conjunto de caracteres a UTF-8
$conn->set_charset("utf8");

// Crear la tabla `users` si no existe
$sql_create_table = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

// Ejecutar la consulta para crear la tabla
if ($conn->query($sql_create_table) === TRUE) {
    // La tabla se creó correctamente o ya existía
} else {
    die("Error al crear la tabla: " . $conn->error);
}

?>