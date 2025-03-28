<?php
include './db-config/db_config.php';

// Verificar que la conexión a la base de datos está abierta
if (!$conn) {
    die("Error: No se pudo conectar a la base de datos.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si los datos han sido enviados correctamente
    if (!isset($_POST['name'], $_POST['email'], $_POST['password'])) {
        die("Error: Faltan datos en el formulario.");
    }

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = ($_POST['password']); 

    // Verificar que los datos no estén vacíos
    if (empty($name) || empty($email) || empty($password)) {
        die("Error: No puedes dejar campos vacíos.");
    }

    // Preparar la consulta SQL
    $stmt = $conn->prepare("INSERT INTO usuarios (name, email, password ) VALUES (?, ?, ?)");
    
    if ($stmt) {
        $stmt->bind_param('sss', $name, $email, $password);
        
        if ($stmt->execute()) {
            echo "Data saved successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        die("Error en la consulta: " . $conn->error);
    }
}

// Cerrar la conexión a la base de datos solo al final
if ($conn) {
    $conn->close();
}
?>
