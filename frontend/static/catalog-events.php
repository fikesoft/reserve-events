<?php
include __DIR__ . '/../../backend/controllers/connection.php';
include(__DIR__ . '/../../backend/controllers/filters.php');

session_start();

//Limpiar los filtros anteriores
if (isset($_POST['clear_filters'])) {
    $_SESSION['city'] = '';
    $_SESSION['event_date'] = '';
    $_SESSION['price'] = '';
    $_SESSION['style'] = '';
}



//Almacena los filtros en la sesión cuando el formulario se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['city'] = $_POST['city'] ?? '';
    $_SESSION['event_date'] = $_POST['event_date'] ?? '';
    $_SESSION['price'] = $_POST['price'] ?? '';
    $_SESSION['style'] = $_POST['style'] ?? '';
}

//Capturar los filtros desde la sesión
$city = $_SESSION['city'] ?? '';
$event_date = $_SESSION['event_date'] ?? '';
$price = $_SESSION['price'] ?? '';
$style = $_SESSION['style'] ?? '';

//Verificar los valores de los filtros antes de hacer la consulta
//var_dump($city, $event_date, $price, $style);

//Construir la consulta SQL con los filtros
$sql = "SELECT * FROM events WHERE 1";
$params = [];
$types = '';

if ($city && $city !== "City" && $city !== "") {
    $sql .= " AND city = ?";
    $params[] = $city;
    $types .= 's';
}

if ($event_date) {
    $sql .= " AND event_date = ?";
    $params[] = $event_date;
    $types .= 's';
}

if ($price !== '') {
    $sql .= " AND price <= ?";
    $params[] = $price;
    $types .= 'd';
}

if ($style && $style !== "") {
    $sql .= " AND LOWER(style)= LOWER(?)";
    $params[] = $style;
    $types .= 's';
}

//Preparar la consulta SQL
$stmt = $conn->prepare($sql);

//Verificar si la preparación fue exitosa
if ($stmt === false) {
    die('Error en la preparación de la consulta: ' . $conn->error);
}

//Vincular los parámetros a la consulta
if ($types) {
    $stmt->bind_param($types, ...$params);
}

//var_dump($_SESSION);

$stmt->execute();

$result_events = $stmt->get_result();


?>

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
        <!-- Menú desplegable de usuario -->
        <div class="dropdown">
                        <a class="btn dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= htmlspecialchars($_SESSION['user_name']) ?>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <?php if ($_SESSION["user_role"] === "admin"): ?>
                                <li>
                                    <span class="dropdown-item-text">
                                        <span class="badge badge-custom">Admin</span>
                                    </span>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item text-danger" href="../../backend/controllers/logout.php">Sign out</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- Enlace al login -->
                    <a href="login.php" class="icons" aria-label="Iniciar sesión">
                        <i class="fa-solid fa-user"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <main class="mb-5">

        <!--Filtros-->
        <div class="container">
            <div class="row">
                <div class="col" id="all-filters">
                    <div class="container mt-4 d-flex c-e-container-filters">

                        <!--Filtro ciudad-->


                        <form method="POST" action="/backend/controllers/consulta_filtros.php"
                            class="d-flex c-e-form-filters">
                            <select name="city" id="city" class="c-e-location">
                                <option value="" selected> City </option>
                                <?php
                                while ($row = $result_city->fetch_assoc()) {
                                    $city = htmlspecialchars($row['city']);
                                    echo "<option value=\"$city\">$city</option>";
                                }
                                ?>
                            </select>

                            <!--Filtro fecha-->
                            <div class="c-e-filter-date">
                                <button type="button" class="c-e-btn" name="btn-date"
                                    onclick="toggleDate()">Date</button>

                                <input type="date" class="c-e-input-date" id="date" name="event_date" hidden>
                            </div>



                            <!--Filtro precio-->
                            <div>
                                <button type="button" class="c-e-btn" id="toggleFilterBtn" type="buton" name="btnprice"
                                    onclick="togglePrice()">Price </button>
                                <div class="c-e-filter-container d-flex flex-column c-e-price-container"
                                    id="priceFilter">
                                    <input type="range" id="priceRange" class="c-e-range-price" name="price" min="0"
                                        max="1000" step="5" value="" hidden><br>
                                </div>
                            </div>

                            <!--Filtro estilo-->

                            <select name="style" id="style" class="c-e-style">
                                <option value="" selected> Style </option>
                                <?php
                                while ($row = $result_style->fetch_assoc()) {
                                    $style_option = htmlspecialchars($row['style']);
                                    echo "<option value=\"$style_option\">$style_option</option>";
                                }
                                ?>
                            </select>

                           
                            <!--Botón aceptar filtros-->

                            <button type="submit" class="ms-4 c-e-btn-aceptar-filtros" id="aceptar-filtros"
                                name="aceptar-filtros">Filter</button>

                        </form>
                    </div>
                </div>
            </div>

        </div>

        <!--Catalog Section-->
        <div class="container mt-5">

            <!--Título de sección-->

            <h2 class="fw-bold text-uppercase">Catalog</h2>

            <?php if ($result_events->num_rows > 0): ?>
                <div class="row g-4">
                    <?php while ($event = $result_events->fetch_assoc()): ?>
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="c-e-card shadow-sm">
                                <img src="<?= htmlspecialchars($event['image_url']) ?>" alt="evento"
                                    class="card-img-top c-e-img-catalog">
                                <div class="c-e-card-body text-center">
                                    <h6 class="fw-bold"><?= htmlspecialchars($event['event_name']) ?></h6>
                                    <p class="text-muted"><?= htmlspecialchars($event['event_date']) ?></p>
                                    <p class="text-muted"><?= htmlspecialchars($event['city']) ?> -
                                        <?= htmlspecialchars($event['style']) ?></p>
                                    <button class="c-e-btn-card btn btn-primary w-100 custom"><a
                                            href="filter_events.php"></a>Book Now</button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No se han encontrado eventos con los filtros seleccionados</p>
            <?php endif; ?>
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
                    <p class="text-nowrap m-1"><i class="fa-solid fa-map-marker-alt me-2"></i> Calle Falsa 123, Madrid,
                        España</p>
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById("toggleFilterBtn");
            const priceFilter = document.getElementById("priceFilter");
            const priceRange = document.getElementById("priceRange");
            const priceValue = document.getElementById("priceValue");


            // Mostrar/ocultar el filtro de precio al hacer clic en el botón    
            toggleBtn.addEventListener("click", function () {
                if (priceFilter.hasAttribute("hidden")) {
                    priceFilter.removeAttribute("hidden");
                } else {
                    priceFilter.setAttribute("hidden", "");
                }
            });

            priceRange.addEventListener("input", function () {
                priceValue.textContent = priceRange.value;
            });
        });


        function toggleDate() {
            const inputDate = document.getElementById('date');

            if (inputDate.hidden) {
                inputDate.hidden = false;
            } else {
                inputDate.hidden = true;
            };
        };
        function togglePrice() {
            const inputPrice = document.getElementById('priceRange');

            if (inputPrice.hidden) {
                inputPrice.hidden = false;
            } else {
                inputPrice.hidden = true;
            }
        };

        
    </script>
</body>

</html>