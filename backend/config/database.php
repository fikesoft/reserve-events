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


$conn->set_charset("utf8");


$sql_create_table_users = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

if ($conn->query($sql_create_table_users) !== TRUE) {
    die("Error al crear la tabla de usuarios: " . $conn->error);
}


$sql_create_table_events = "
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    event_name VARCHAR(150) NOT NULL,
    description TEXT,
    event_date DATE,
    event_time TIME,
    image_url VARCHAR(255),
    location VARCHAR(255),
    price DECIMAL(10, 2),
    ticket_type ENUM('General', 'VIP', 'Premium') DEFAULT 'General',
    number_of_tickets INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

if ($conn->query($sql_create_table_events) !== TRUE) {
    die("Error al crear la tabla de eventos: " . $conn->error);
}

?>
