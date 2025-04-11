<?php
    session_start();
    // Incluir la conexión a la base de datos
    require_once '../config/database.php';

    //Obtener y filtrar la búsqueda
    if (isset($_GET['query'])) {
        $search_query = mysqli_real_escape_string($conn, $_GET['query']);
    } else {
        $search_query = '';
    }

    // Si la búsqueda está vacía, redirige al inicio
    if (empty($search_query)) {
        echo "Por favor ingrese un término de búsqueda.";
        exit;
    }

    // Consulta SQL para buscar eventos que coincidan con el término de búsqueda
    $sql_search_events = "
    SELECT * FROM events WHERE event_name LIKE ? OR description LIKE ?
    ";
    $stmt = $conn->prepare($sql_search_events);

    // Usamos % para permitir búsqueda parcial
    $search_term = "%" . $search_query . "%";

    // Vinculamos el parámetro de búsqueda
    $stmt->bind_param("ss", $search_term, $search_term);

    // Ejecutamos la consulta
    $stmt->execute();

    // Obtenemos los resultados
    $result = $stmt->get_result();

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        echo "<h2>Resultados de búsqueda para: " . htmlspecialchars($search_query) . "</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='evento'>";
            echo "<h3>" . htmlspecialchars($row['event_name']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
            echo "<p><strong>Fecha:</strong> " . htmlspecialchars($row['event_date']) . "</p>";
            echo "<p><strong>Hora:</strong> " . htmlspecialchars($row['event_time']) . "</p>";
            echo "<p><strong>Ubicación:</strong> " . htmlspecialchars($row['location']) . "</p>";
            echo "<p><strong>Precio:</strong> " . number_format($row['price'], 2) . " USD</p>";
            echo "</div>";
        }
    } else {
        echo "No se encontraron eventos que coincidan con '$search_query'.";
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();

?>