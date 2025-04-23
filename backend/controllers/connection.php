<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "random_events_db";

//Conexión 
$conn = new mysqli($servername, $username, $password, $db);

//Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


?>