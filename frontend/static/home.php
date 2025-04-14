<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Events</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@100;400;700&display=swap"
        rel="stylesheet">
    <!-- Cargar Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/style/style_home.css">
    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <!-- Encabezado -->
    <?php
        include "../static/header.php";
    ?>

    <main>
        <div class="d-flex flex-column">
            <div class="container d-flex flex-column align-items-center mt-5">
                <section class="row d-flex justify-content-center gap-3 g-2 mb-4">
                    <div
                        class="col-lg-4 d-flex flex-column align-items-lg-start align-items-center justify-content-center gap-3 contentHome">
                        <h1 class="text-lg-start">FIND MORE OF THE RANDOM EVENTS</h1>

                        <p class="text-start">Incredible live shows. Upfront pricing. Relevant recommendations. We make
                            going out easy.</p>
                        <button class="browse-btn">Browse events</button>
                    </div>
                    <div class="row col-lg-7 d-flex justify-content-center">
                        <div class="row col-6 gap-3">
                            <img class="img-fluid" src="../assets//img//firstSmallPhoto.png" alt="photo">
                            <img class="img-fluid" src="../assets/img/secondSmallPhoto.png" alt="photo">
                        </div>
                        <img class="img-fluid col-5" src="../assets/img/bigPhotoHome.png" alt="photo">
                    </div>
                </section>

                <section class="row d-flex flex-column align-items-center mt-5 w-100">
                    <div class="w-100 text-center">
                        <h1 class="titleRandom">RANDOM SELECTION</h1>
                        <?php if ($_SESSION['user_role'] === "admin"): ?>
                            <a href="add_your_event.php">Create Event</a>
                        <?php endif ?>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                        <div class="row d-flex flex-row justify-content-center flex-wrap w-100 gap-3 mt-5">
                            <?php
                            // Conexión a la base de datos
                            require_once '../../backend/config/database.php';

                            try {
                                // Consulta SQL para obtener los eventos
                                $sql = "SELECT * FROM events LIMIT 5";
                                $result = $conn->query($sql);

                                // Verificar si hay resultados
                                if ($result->num_rows > 0) {
                                    // Iterar sobre los resultados
                                    while ($event = $result->fetch_assoc()) {
                                        ?>
                                        <div class="col-lg-2 col-md-4 col-6 event-card">
                                            <?php if ($_SESSION['user_role'] === "admin"): ?>
                                                <div class="d-flex justify-content-end gap-3 fs-5">
                                                    <a href="../../backend/controllers/edit_event.php?id=<?= $event['id'] ?>"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>
                                                    <a class="text-danger"
                                                        href="../../backend/controllers/delete_event.php?id=<?= $event['id'] ?>"><i
                                                            class="fa-solid fa-trash"></i></a>
                                                </div>
                                            <?php endif; ?>
                                            <img class="img-fluid" src="<?= htmlspecialchars($event['image_url']) ?>" alt="Event Photo"
                                                style="aspect-ratio: 1/1;">
                                            <div class="text-start mt-2">
                                                <p><?= htmlspecialchars($event['event_name']) ?></p>
                                                <p><?= htmlspecialchars($event['location']) ?></p>
                                                <p><?= htmlspecialchars($event['event_date']) ?></p>
                                                <p>From <?= htmlspecialchars($event['price']) ?> $</p>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    // Si no hay eventos, mostrar un mensaje
                                    echo '<div class="col-12 text-center"><p>No events found.</p></div>';
                                }
                            } catch (Exception $e) {
                                // Manejar errores
                                echo '<div class="col-12 text-center"><p>Error loading events: ' . htmlspecialchars($e->getMessage()) . '</p></div>';
                            }
                            ?>
                        </div>
                    </div>
                </section>
            </div>

            <section class="aboutUs mt-5">
                <div class="container d-flex flex-column justify-content-center align-items-center text-center gap-3">
                    <h3>RANDOM EVENTS OFFERS BEST EXPERIENCE OF CREATING</h3>
                    <h2>YOUR EVENT RESERVATION EASY</h2>
                    <p>
                        We’ve always believed that random can change lives. So we created a platform for fans to experience
                        more of the shows they love in the most hassle-free way possible.
                    </p>
                    <a href="about-us.html">About us</a>
                </div>
            </section>
        </div>
    </main>
    
    <!-- Footer -->
    <?php
        include '../static/footer.php';
    ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>