<?php
include 'db_config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h1>Connected to the database successfully!</h1>";

// Close the connection
$conn->close();
?>