<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include __DIR__ . '/../../backend/controllers/connection.php';
include(__DIR__ . '/../../backend/controllers/filters.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Eventos</title>

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

            if(inputPrice.hidden) {
                inputPrice.hidden = false;
            } else {
                inputPrice.hidden = true;
            }
        };
    </script>


    <!-- Encabezado -->
    <header class="d-flex justify-content-center justify-content-md-between p-3 flex-md-row flex-column">
        <div class="d-flex flex-md-row flex-column align-items-center gap-4">
            <img class="logo-header" src="../assets/img/logo.png" alt="Logo de la empresa">
            <nav class="d-flex flex-grow-1 justify-content-center justify-content-md-start">
                <ul class="d-flex gap-4 m-0 p-0 list-unstyled align-items-center justify-content-start">
                    <li><a href="home.php" class="nav-header">Home</a></li>
                    <li><a href="catalog-events.html" class="nav-header">Events</a></li>
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
                <a href="cart.html" class="icons mx-3"><i class="fa-solid fa-cart-shopping"></i></a>
                <a href="login.php" class="icons mx-3"><i class="fa-solid fa-user"></i></a>


                <a href="login.php" class="icons mx-3"><i class="fa-solid fa-user"></i></a>



            </div>

        </div>
    </header>

    <!--Filtros-->
    <main class="mb-5">
        <div class="container">
            <div class="row">
                <div class="col" id="all-filters">
                    <div class="container mt-4 d-flex c-e-container-filters">

                        <!--Filtro ciudad-->



                        <select name="city" id="city" class="c-e-location">
                            <option selected> City </option>
                            <?php
                            while ($row = $result_city->fetch_assoc()) {
                                $city = htmlspecialchars($row['city']);
                                echo "<option value=\"$city\">$city</option>";
                            }
                            ?>
                        </select>

                        <!--Filtro fecha-->
                        <div class="c-e-filter-date">
                            <button class="c-e-btn" name="btn-date" onclick="toggleDate()">Date</button>

                            <input type="date" class="c-e-input-date" id="date" hidden>
                        </div>



                        <!--Filtro precio-->
                        <div>
                            <button class="c-e-btn" id="toggleFilterBtn" type="buton" name="btnprice" onclick="togglePrice()">Price <span
                                    id="priceValue">50</span>€</button>
                            <div class="c-e-filter-container d-flex flex-column c-e-price-container" id="priceFilter">
                                <input type="range" id="priceRange" class="c-e-range-price" name="price" min="0"
                                    max="1000" step="5" value="50" hidden><br>
                            </div>
                        </div>

                        <!--Filtro estilo-->

                        <select name="style" id="style" class="c-e-style">
                            <option selected> Style </option>
                            <?php
                            while ($row = $result_style->fetch_assoc()) {
                                $style = htmlspecialchars($row['style']);
                                echo "<option value=\"$style\">$style</option>";
                            }
                            ?>
                        </select>

                        <!--Botón aceptar filtros-->

                        <button class="ms-4 c-e-btn-aceptar-filtros" id="aceptar-filtros"
                            name="aceptar-filtros">Filter</button>
                    </div>
                </div>
            </div>

        </div>



        <!--Popular Events Section-->

        <div class="container mt-5 mb-5"></div>

        <!--Título sección-->

        <h2 class="fw-lighter ms-5">Popular events in <span class="c-e-custom-text-primary fw-bold">Madrid</span></h2>

        <!--Tarjetas-->

        <!--Tarjeta Uno-->

        <div class="row ms-5 flex-nowrap overflow-auto d-flex flex-nowrap align-items-center ">
            <div class="col-lg-6 col-md-8">
                <div class="c-e-event-card pe-3 border rounded shadow-sm mb-3 overflow-visible">

                    <div class="row flex-nowrap align-items-center">
                        <div class="col-md-2 col-3 c-e-custom-bg-primary text-white p-5 text-center rounded-start">
                            <p class="m-0">Date</p>
                            <p class="m-0">Day</p>
                            <p class="m-0">Hour</p>
                        </div>
                        <div class="col-md-7 col-6 text-md-start">
                            <h6 class="fw-bold">Beach Please Festival</h6>
                            <p>Location</p>
                            <p>Venue</p>
                            <p>Ticket Class</p>
                        </div>
                        <div class="col-md-3 col-3 text-end me-0 pt-5 overflow-visible text-md-start">
                            <p class="text-muted">€XX per person</p>
                            <button class="c-e-btn-event-card btn btn-primary c-e-custom-bg-primary w-100">Book
                                Now</button>
                        </div>
                    </div>

                </div>

                <!--Tarjeta dos-->

                <div class="c-e-event-card pe-3 border rounded shadow-sm mb-3 overflow-visible">
                    <div class="row flex-nowrap align-items-center">
                        <div class="col-md-2 col-3 c-e-custom-bs-dark text-white p-5 text-center rounded-start">
                            <p class="m-0">Date</p>
                            <p class="m-0">Day</p>
                            <p class="m-0">Hour</p>
                        </div>
                        <div class="col-md-7 col-6 text-md-start">
                            <h6 class="fw-bold">Beach Please Festival</h6>
                            <p>Location</p>
                            <p>Venue</p>
                            <p>Ticket Class</p>
                        </div>
                        <div class="col-md-3 col-3 text-end me-0 pt-5 overflow-visible text-md-start">
                            <p class="text-muted">€XX per person</p>
                            <button class="c-e-btn-event-card btn btn-primary c-e-custom-bg-primary w-100">Book
                                Now</button>
                        </div>
                    </div>
                </div>

                <!--Tarjeta tres-->

                <div class="c-e-event-card pe-3 border rounded shadow-sm mb-3 overflow-visible">
                    <div class="row flex-nowrap align-items-center">
                        <div class="col-md-2 col-3 c-e-custom-bs-info text-white p-5 text-center rounded-start">
                            <p class="m-0">Date</p>
                            <p class="m-0">Day</p>
                            <p class="m-0">Hour</p>
                        </div>
                        <div class="col-md-7 col-6 text-md-start">
                            <h6 class="fw-bold">Beach Please Festival</h6>
                            <p>Location</p>
                            <p>Venue</p>
                            <p>Ticket Class</p>
                        </div>
                        <div class="col-md-3 col-3 text-end me-0 pt-5 overflow-visible text-md-start">
                            <p class="text-muted">€XX per person</p>
                            <button class="c-e-btn-event-card btn btn-primary c-e-custom-bg-primary w-100">Book
                                Now</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--Imagen + botón guardar favoritos-->

            <div class="c-e-container-img-btn col-lg-6 order-lg-1 custom-w" id="container-img-btn">
                <img src="../assets/img/imagen-evento.png" alt="imagen evento" class="img-fluid rounded shadow ">
                <div class="c-e-container-btn-fav">
                    <button class="c-e-btn-fav btn btn-fav"><i class="bi bi-heart-fill"></i></button>
                </div>
            </div>
        </div>
        </div>

        <!--Separador-->

        <hr class="my-4 me-4 ms-4 border-4 custom-bg-primary">

        <!--Igual pero al revés-->

        <div class="container mt-5 "></div>
        <div class="row ms-5 me-5">

            <!--Imagen - botón guardar favoritos-->

            <div class="c-e-container-img-btn col-lg-6 order-lg-1 mb-4 mb-lg-0" id="container-img-btn">
                <img src="../assets/img/imagen-evento.png" alt="imagen evento" class="img-fluid rounded shadow">
                <div class="c-e-container-btn-fav">
                    <button class="c-e-btn-fav btn btn-fav"><i class="bi bi-heart-fill"></i></button>
                </div>
            </div>
            <div class="col-lg-6 order-lg-2">

                <!--Tarjeta uno-->

                <div class="c-e-event-card pe-3 border rounded shadow-sm mb-3 overflow-visible">
                    <div class="row flex-nowrap align-items-center">
                        <div class="col-md-2 col-3 c-e-custom-bg-primary text-white p-5 text-center rounded-start">
                            <p class="m-0">Date</p>
                            <p class="m-0">Day</p>
                            <p class="m-0">Hour</p>
                        </div>
                        <div class="col-md-7 col-6 text-md-start">
                            <h6 class="fw-bold">Beach Please Festival</h6>
                            <p>Location</p>
                            <p>Venue</p>
                            <p>Ticket Class</p>
                        </div>
                        <div class="col-md-3 col-3 text-end me-0 pt-5 overflow-visible text-md-start">
                            <p class="text-muted">€XX per person</p>
                            <button class="c-e-btn-event-card btn btn-primary c-e-custom-bg-primary w-100">Book
                                Now</button>
                        </div>
                    </div>
                </div>

                <!--Tarjeta dos-->

                <div class="c-e-event-card pe-3 border rounded shadow-sm mb-3 overflow-visible">
                    <div class="row flex-nowrap align-items-center">
                        <div class="col-md-2 col-3 c-e-custom-bs-dark text-white p-5 text-center rounded-start">
                            <p class="m-0">Date</p>
                            <p class="m-0">Day</p>
                            <p class="m-0">Hour</p>
                        </div>
                        <div class="col-md-7 col-6 text-md-start">
                            <h6 class="fw-bold">Beach Please Festival</h6>
                            <p>Location</p>
                            <p>Venue</p>
                            <p>Ticket Class</p>
                        </div>
                        <div class="col-md-3 col-3 text-end me-0 pt-5 overflow-visible text-md-start">
                            <p class="text-muted">€XX per person</p>
                            <button class="c-e-btn-event-card btn btn-primary c-e-custom-bg-primary w-100">Book
                                Now</button>
                        </div>
                    </div>
                </div>

                <!--Tarjeta tres-->

                <div class="c-e-event-card pe-3 border rounded shadow-sm mb-3 overflow-visible">
                    <div class="row flex-nowrap align-items-center">
                        <div class="col-md-2 col-3 c-e-custom-bs-info text-white p-5 text-center rounded-start">
                            <p class="m-0">Date</p>
                            <p class="m-0">Day</p>
                            <p class="m-0">Hour</p>
                        </div>
                        <div class="col-md-7 col-6 text-md-start">
                            <h6 class="fw-bold">Beach Please Festival</h6>
                            <p>Location</p>
                            <p>Venue</p>
                            <p>Ticket Class</p>
                        </div>
                        <div class="col-md-3 col-3 text-end me-0 pt-5 overflow-visible text-md-start">
                            <p class="text-muted">€XX per person</p>
                            <button class="c-e-btn-event-card btn btn-primary c-e-custom-bg-primary w-100">Book
                                Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>



        <!--Script Bootstrap-->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
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

</body>

</html>