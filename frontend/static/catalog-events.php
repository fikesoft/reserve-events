<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>catalog-events</title>
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Icons Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!--CSS-->
    <link rel="stylesheet" href="../assets/style/style-catalog-events.css">
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/footer.css">
</head>

<body>
    <!-- Encabezado -->
    <header class="d-flex justify-content-center justify-content-md-between p-3 flex-md-row flex-column">
        <div class="d-flex flex-md-row flex-column align-items-center gap-4">
            <img class="logo-header" src="../assets/img/logo.png" alt="Logo de la empresa">
            <nav class="d-flex flex-grow-1 justify-content-center justify-content-md-start">
                <ul class="d-flex gap-4 m-0 p-0 list-unstyled align-items-center justify-content-start">
                    <li><a href="home.php" class="nav-header">Home</a></li>
                    <li><a href="catalog-events.php" class="nav-header">Events</a></li>
                    <li><a href="about-us.php" class="nav-header">About us</a></li>
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
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="icons mx-3"><i class="fa-solid fa-user"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <main>
        
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

                                            
                                            <a href="event_details.php?id=<?= $event['id'] ?>" 
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
    <!-- Footer -->
    <footer class="container-fluid p-5">
        <div class="d-flex flex-column align-items-center">
            <div class="row">
                <!-- Menú de navegación -->
                <nav class=" col-12 col-md-6 mt-3">
                    <ul class="list-unstyled">
                        <li><a href="home.php" class="nav-footer">Home</a></li>
                        <li><a href="catalog-events.html" class="nav-footer">Events</a></li>
                        <li><a href="about-us.html" class="nav-footer">About us</a></li>
                    </ul>
                </nav>

                <!-- Información de contacto -->
                <div class="footer-contact col-12 col-md-6 mt-3">
                    <p class="text-nowrap m-1"><i class="fa-solid fa-phone me-2"></i> +34 123 456 789</p>
                    <p class="text-nowrap m-1"><i class="fa-solid fa-envelope me-2"></i> contacto@empresa.com</p>
                    <p class="text-nowrap m-1"><i class="fa-solid fa-map-marker-alt me-2"></i> Calle Falsa 123, Madrid, España</p>
                </div>
            </div>
        </div>

        <!-- Redes Sociales -->
        <div class="d-flex justify-content-center align-items-center gap-3 mt-3 col-12">
            <a href="#" class="footer-social"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" class="footer-social"><i class="fa-brands fa-twitter"></i></a>
            <a href="#" class="footer-social"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="footer-social"><i class="fa-brands fa-linkedin"></i></a>
        </div>


        <!-- Derechos de autor -->
        <div class="footer-bottom text-center pt-4 col-12">
            <p>&copy; 2025 Random Events. All rights reserved.</p>
        </div>

    </footer>
    <!--Script Bootstrap-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>