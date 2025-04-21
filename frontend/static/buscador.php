<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/style/buscador.css">
    <!-- Cargar Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <!-- Encabezado -->
    <?php
        include "../static/header.php";
    ?>

    <?php
        // Incluir la conexión a la base de datos
        require_once '../../backend/config/database.php';

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
        SELECT * FROM events WHERE event_name LIKE ? OR location LIKE ?
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
    ?>

    <main>
        <div class="container mt-4">
            <h1 class="text-left"><?= htmlspecialchars($row['event_name']) ?></h1>

            <div class="row mt-4">
                <!-- Imagen del evento -->
                <div class="col-md-4 event-image-container">
                    <img src="<?= $row['image_url'] ?>" class="img-fluid" alt="Imagen del evento">
                    <div class="event-fav-icon">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M3.72692 1C2.22077 1 1 2.29358 1 3.88889C1 6.2963 3.27308 8.22222 6 10.6296C8.72769 8.22222 11 6.2963 11 3.88889C11 2.29358 9.77923 1 8.27231 1C7.32385 1 6.48846 1.51358 6 2.29197C5.75419 1.89622 5.41753 1.57076 5.02059 1.34514C4.62364 1.11952 4.17896 1.00089 3.72692 1Z"
                                stroke="white" />
                        </svg>
                    </div>
                </div>

                <!-- Tarjeta del evento -->
                <div class="col-md-8">
                    <div class="d-flex flex-column gap-3">
                        <!-- Tarjeta 1 -->
                        <div class="d-flex align-items-stretch border rounded">
                            <div class="text-white text-center px-3 py-4 d-flex flex-column justify-content-center rounded-start" style="background-color:#4d194d;">
                                <p class="mb-2 fw-bold"><?= date("d M", strtotime($row['event_date'])) ?></p>
                                <p class="mb-2"><?= strtoupper(date("D", strtotime($row['event_date']))) ?></p>
                                <p class="mb-0"><?= date("h:i A", strtotime($row['event_time'])) ?></p>
                            </div>
                            
                            <div class="ms-3 w-100 d-flex flex-column justify-content-around">
                                <div class="d-flex flex-column gap-2">
                                    <p class="fw-bold mb-1"><?= htmlspecialchars($row['event_name']) ?></p>
                                    <p class="mb-1"><?= htmlspecialchars($row['location']) ?></p>
                                </div>
                                <div class="d-flex justify-content-between ">
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex gap-2">
                                            <img src="../assets/iconos/mapaa.svg" alt="icono del mapa">
                                            <p class="mb-1 text-primary fw-bold"><?= htmlspecialchars($row['location']) ?></p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <img src="../assets/iconos/entrada.svg" alt="">
                                            <p class="mb-1 text-primary fw-bold">Class Normal</p>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column align-items-center gap-2 mx-2">
                                        <p class="mb-0"><?= htmlspecialchars($row['price']) ?>$/person</p>
                                        <button class="btn w-100 btn-event-card">Book Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta 2 -->
                        <div class="d-flex align-items-stretch border rounded">
                            <div class="text-white text-center px-3 py-4 d-flex flex-column justify-content-center rounded-start" style="background-color:#b44cb4;">
                                <p class="mb-2 fw-bold"><?= date("d M", strtotime($row['event_date'])) ?></p>
                                <p class="mb-2"><?= strtoupper(date("D", strtotime($row['event_date']))) ?></p>
                                <p class="mb-0"><?= date("h:i A", strtotime($row['event_time'])) ?></p>
                            </div>
                            
                            <div class="ms-3 w-100 d-flex flex-column justify-content-around">
                                <div class="d-flex flex-column gap-2">
                                    <p class="fw-bold mb-1"><?= htmlspecialchars($row['event_name']) ?></p>
                                    <p class="mb-1"><?= htmlspecialchars($row['location']) ?></p>
                                </div>
                                <div class="d-flex justify-content-between ">
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex gap-2">
                                            <img src="../assets/iconos/mapaa.svg" alt="icono del mapa">
                                            <p class="mb-1 text-primary fw-bold"><?= htmlspecialchars($row['location']) ?></p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <img src="../assets/iconos/entrada.svg" alt="">
                                            <p class="mb-1 text-primary fw-bold">Class Normal</p>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column align-items-center gap-2 mx-2">
                                        <p class="mb-0"><?= htmlspecialchars($row['price']) ?>$/person</p>
                                        <button class="btn w-100 btn-event-card">Book Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tarjeta 3 -->
                        <div class="d-flex align-items-stretch border rounded">
                            <div class="text-white text-center px-3 py-4 d-flex flex-column justify-content-center rounded-start" style="background-color:#f5a6f5;">
                                <p class="mb-2 fw-bold"><?= date("d M", strtotime($row['event_date'])) ?></p>
                                <p class="mb-2"><?= strtoupper(date("D", strtotime($row['event_date']))) ?></p>
                                <p class="mb-0"><?= date("h:i A", strtotime($row['event_time'])) ?></p>
                            </div>
                            
                            <div class="ms-3 w-100 d-flex flex-column justify-content-around">
                                <div class="d-flex flex-column gap-2">
                                    <p class="fw-bold mb-1"><?= htmlspecialchars($row['event_name']) ?></p>
                                    <p class="mb-1"><?= htmlspecialchars($row['location']) ?></p>
                                </div>
                                <div class="d-flex justify-content-between ">
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex gap-2">
                                            <img src="../assets/iconos/mapaa.svg" alt="icono del mapa">
                                            <p class="mb-1 text-primary fw-bold"><?= htmlspecialchars($row['location']) ?></p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <img src="../assets/iconos/entrada.svg" alt="">
                                            <p class="mb-1 text-primary fw-bold">Class Normal</p>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column align-items-center gap-2 mx-2">
                                        <p class="mb-0"><?= htmlspecialchars($row['price']) ?>$/person</p>
                                        <button class="btn w-100 btn-event-card">Book Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>  
            </div>
        </div>

        <!--Separador-->
        <hr class="my-4 me-4 ms-4 border-4 custom-separador">
    </main>

<?php
        }
    } else {
        echo "No se encontraron eventos que coincidan con '$search_query'.";
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
?>

    <!-- Footer -->
    <?php
        include '../static/footer.php';
    ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
