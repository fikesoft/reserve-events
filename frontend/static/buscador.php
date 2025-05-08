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

<body class="d-flex flex-column min-vh-100">
    <!-- Encabezado -->
    <?php
    include "../static/header.php";
    ?>

    <main class='font-family_buscador flex-grow-1'>
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
            echo 
            "<div class='alert alert-warning text-center m-4 fs-5 font-family_buscador'>
                Please enter a search term
            </div>
            <img src='/frontend/assets/img/searchEmpty.png' alt='Imagen de busqueda vacia' class='img-fluid mx-auto d-block mt-3 w-25'>";
        } else {

            // Consulta SQL para buscar eventos que coincidan con el término de búsqueda
            $sql_search_events = "
                SELECT * FROM events WHERE event_name LIKE ? OR location LIKE ? OR city LIKE ?
                ";
            $stmt = $conn->prepare($sql_search_events);

            // Usamos % para permitir búsqueda parcial
            $search_term = "%" . $search_query . "%";

            // Vinculamos el parámetro de búsqueda
            $stmt->bind_param("sss", $search_term, $search_term, $search_term);

            // Ejecutamos la consulta
            $stmt->execute();

            // Obtenemos los resultados
            $result = $stmt->get_result();

            // Verificar si se encontraron resultados
            if ($result->num_rows > 0) {
                echo
                "<h2 class='mb-4 font-family_buscador num-resultados-custom'>
                        <span class='text-muted'>" . $result->num_rows . " Results for </span>" . htmlspecialchars($search_query) .
                "</h2>";

                while ($row = $result->fetch_assoc()) {
        ?>

                    <!-- Tarjeta del evento -->
                    <div class="container my-4">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8">
                                <div class="d-flex flex-column flex-lg-row align-items-stretch border rounded overflow-hidden">
                                    <div class="text-white text-center p-4 d-flex flex-column justify-content-center tarjeta-event_buscador">
                                        <p class="mb-2 fw-bold"><?= date("d M", strtotime($row['event_date'])) ?></p>
                                        <p class="mb-2"><?= strtoupper(date("D", strtotime($row['event_date']))) ?></p>
                                        <p class="mb-0"><?= date("h:i A", strtotime($row['event_time'])) ?></p>
                                    </div>

                                    <div class="ms-lg-3 mt-3 mt-lg-0 w-100 d-flex flex-column justify-content-around">
                                        <div class="d-flex flex-column mb-2">
                                            <p class="fw-bold mb-1 text-center text-lg-start"><?= htmlspecialchars($row['event_name']) ?></p>
                                        </div>
                                        <div class="d-flex flex-column flex-lg-row justify-content-between text-center text-lg-start gap-3">
                                            <div class="d-flex flex-column align-items-center align-items-lg-start">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="fa-solid fa-map-location"></i>
                                                    <p class="mb-1 text-tarjeta-event_buscador fw-bold"><?= htmlspecialchars($row['location']) ?></p>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="fa-solid fa-city"></i>
                                                    <p class="mb-1 text-tarjeta-event_buscador fw-bold"><?= htmlspecialchars($row['city']) ?></p>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column align-items-center gap-2 mx-2">
                                                <p class="mb-0"><?= htmlspecialchars($row['price']) ?>$/person</p>
                                                <!-- Botón para acceder al evento -->
                                                <button class="btn w-100 btn-event-card" onclick="window.location.href='./Pagina-evento.php?id=<?= $row['id'] ?>'">
                                                    Find Tickets
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Separador-->
                    <hr class="my-4 me-4 ms-4 border-4 custom-separador">

        <?php
                }
            } else {
                echo
                "<div class='alert alert-danger text-center m-4 fs-5 font-family_buscador'>
                    No results for <strong>" . htmlspecialchars($search_query) . "</strong>
                </div>
                <img src='/frontend/assets/img/noResults.png' alt='Imagen sin resultados' class='img-fluid mx-auto d-block mt-3 w-25'>";
            }

            // Cerrar la conexión
            $stmt->close();
            $conn->close();
        }
        ?>

    </main>

    <!-- Footer -->
    <?php
    include '../static/footer.php';
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>