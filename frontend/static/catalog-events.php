<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>catalog-events</title>
    <!-- Importar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!--CSS-->
    <link rel="stylesheet" href="../assets/style/style-catalog-events.css">

</head>

<body>
    <!-- Encabezado -->
    <?php include 'header.php'; ?>

    <main class="vh-100">

        <div class="container mt-5">



            <h2 class="fw-bold text-uppercase">Catalog</h2>
            <div class="row g-4">

                <div class="row row-cols-md-4 row-cols-sm-2 row-cols-1 g-4 mt-5">
                    <?php

                    require_once '../../backend/config/database.php';

                    try {

                        $sql = "SELECT * FROM events";
                        $result = $conn->query($sql);


                        if ($result->num_rows > 0) {

                            while ($event = $result->fetch_assoc()) {
                    ?>
                                <div class="col">
                                    <div class="c-e-card h-100 shadow-sm">

                                        <img src="<?= htmlspecialchars($event['image_url']) ?>"
                                            alt="<?= htmlspecialchars($event['event_name']) ?>"
                                            class="card-img-top"
                                            style="aspect-ratio: 16/9; object-fit: cover;">


                                        <div class="c-e-card-body text-center p-3">
                                            <h6 class="fw-bold"><?= htmlspecialchars($event['event_name']) ?></h6>
                                            <p class="text-muted mb-0"><?= htmlspecialchars($event['location']) ?></p>
                                            <p class="text-muted mb-0"><?= htmlspecialchars($event['event_date']) ?></p>
                                            <p class="text-muted">From <?= htmlspecialchars($event['price']) ?> $</p>


                                            <a href="pagina-evento.php?id=<?= $event['id'] ?>"
                                                class="c-e-btn-card btn btn-primary w-100 d-block text-decoration-none text-white">
                                                Book Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                    <?php
                            }
                        } else {

                            echo '<div class="col-12 text-center"><p>No events found.</p></div>';
                        }
                    } catch (Exception $e) {

                        echo '<div class="col-12 text-center"><p>Error loading events: ' . htmlspecialchars($e->getMessage()) . '</p></div>';
                    }
                    ?>
                </div>


            </div>
        </div>


    </main>
    <?php
    include '../static/footer.php';
    ?>
    <!--Script Bootstrap-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>