<?php
$host = 'localhost';
$username = 'root';
$password = '';  // XAMPP default
$database = 'test_db';

// Create connection
$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS $database");

// Select the database
$conn->select_db($database);

// Create the table if it doesn't exist
$tableQuery = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL
)";

if ($conn->query($tableQuery) === FALSE) {
    die("Error creating table: " . $conn->error);
}