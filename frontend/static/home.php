<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style/style_home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/style/header.css">
    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <!-- Encabezado -->
    <header class="d-flex justify-content-center justify-content-md-between p-3 flex-md-row flex-column">
        <div class="d-flex flex-md-row flex-column align-items-center gap-4">
            <img class="logo-header" src="../assets/img/logo.png" alt="Logo de la empresa">
            <nav class="d-flex flex-grow-1 justify-content-center justify-content-md-start">
                <ul class="d-flex gap-4 m-0 p-0 list-unstyled align-items-center justify-content-start">
                    <li><a href="home.php" class="nav-header">Home</a></li>
                    <li><a href="#Eventos" class="nav-header">Events</a></li>
                    <li><a href="about-us.html" class="nav-header">About us</a></li>
                </ul>
            </nav>
        </div>

        <!-- Buscador e Iconos -->
        <div class="d-flex align-items-center gap-4 mt-3 mt-md-0 flex-md-row flex-column">
            <div class="d-flex align-items-center search-box">
                <input class="search-box-input" type="text" placeholder="Search...">
                <button class="search-box-button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="d-flex">
                <a href="carrito.php" class="icons mx-3"><i class="fa-solid fa-cart-shopping"></i></a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="#" class="icons mx-3"><?= $_SESSION['user_name'] ?></a>
                    <?php if ($_SESSION["user_role"] === "admin"): ?>
                        <a><?php echo $_SESSION["user_role"]; ?></a>
                    <?php endif; ?>

                <?php else: ?>
                    <a href="login.php" class="icons mx-3"><i class="fa-solid fa-user"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="d-flex flex-column">
        <div class="container d-flex flex-column align-items-center mt-5">
            <section class="row d-flex justify-content-center gap-3 g-2 mb-4">
                <div class="col-lg-4 d-flex flex-column align-items-lg-start align-items-center justify-content-center gap-3 contentHome">
                    <h1 class="text-lg-start">FIND MORE OF THE RANDOM EVENTS</h1>

                    <p class="text-start">Incredible live shows. Upfront pricing. Relevant recommendations. We make going out easy.</p>
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
                                                <a href="edit_event.php?id=<?= $event['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a class="text-danger" href="delete_event.php?id=<?= $event['id'] ?>"><i class="fa-solid fa-trash"></i></a>
                                            </div>
                                        <?php endif; ?>
                                        <img class="img-fluid" src="<?= htmlspecialchars($event['image_url']) ?>" alt="Event Photo" style="aspect-ratio: 1/1;">
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
</body>

</html>