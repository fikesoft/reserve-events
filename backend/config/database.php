<?php


$host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'random_events_db';


//Crear la conexion
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

//Y verificarla

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


$conn->set_charset("utf8");

?>