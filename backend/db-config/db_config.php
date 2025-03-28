<?php
// 1. Parámetros de conexión
$host     = 'localhost';
$username = 'root';
$password = '';
$database = 'reserver_events'; // Nombre de la BD que queremos crear

// 2. Conexión inicial (sin seleccionar base de datos)
$conn = new mysqli($host, $username, $password);
if ($conn->connect_error) {
    die("Fallo la conexión: " . $conn->connect_error);
}

// 3. Crear la base de datos si no existe
$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $database 
                CHARACTER SET utf8mb4 
                COLLATE utf8mb4_general_ci";
if (!$conn->query($sqlCreateDB)) {
    die("Error creando la base de datos: " . $conn->error);
}

// 4. Seleccionar la base de datos
$conn->select_db($database);

// 5. Crear tablas (multi_query para ejecutar varias sentencias seguidas)
$sql = "
CREATE TABLE IF NOT EXISTS usuarios (
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password VARCHAR(50) NOT NULL
) ;
";

// 6. Ejecutar todas las sentencias de creación de tablas
if ($conn->multi_query($sql)) {
    // Liberar los resultados intermedios
    do {
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->next_result());
    echo "¡Base de datos y tablas creadas correctamente!";
} else {
    die("Error creando tablas: " . $conn->error);
}

?>