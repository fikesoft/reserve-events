<?php
include './db_config.php';

// Verificar que la conexión a la base de datos está abierta
if (!$conn) {
    die("Error: No se pudo conectar a la base de datos.");
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT * FROM usuarios");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            // Fetch and display the data
            while ($row = $result->fetch_assoc()) {
                echo  " - Name: " . $row['name'] . " - Email: " . $row['email'] . "<br>";
            }
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}    
?>
