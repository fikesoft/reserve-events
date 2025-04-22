<?php
session_start();
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

</head>

<body>   

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleBtn = document.getElementById("toggleFilterBtn");
            const priceFilter = document.getElementById("priceFilter");
            const priceRange = document.getElementById("priceRange");
            const priceValue = document.getElementById("priceValue");


            // Mostrar/ocultar el filtro de precio al hacer clic en el botón    
            toggleBtn.addEventListener("click", function(){
                if (priceFilter.hasAttribute("hidden")) {
                    priceFilter.removeAttribute("hidden");
                }else {
                    priceFilter.setAttribute("hidden", "");
                }
            });

            priceRange.addEventListener("input", function() {
                priceValue.textContent = priceRange.value;
            });
        });
    </script>

    <!-- Encabezado -->
    <?php
        include "../static/header.php";
    ?>

    <!--Filtros-->
    <main class="mb-5">
    <div class="container">
        <div class="row">
            <div class="col" id="all-filters">
                <div class="container mt-4 d-flex">

                    <!--Filtro localización-->

                    <select name="location" id="location" class="c-e-location">
                        <option selected> <i class="bi bi-geo"></i> Ibiza </option>
                        <option value="1">Opción 1</option>
                        <option value="2">Opción 2</option>
                        <option value="3">Opción 3</option>
                    </select>

                    <!--Filtro fecha-->

                    <button class="c-e-btn" name="btn-date">Date</button>
                    
                    <input type="catalog-events-date" class="c-e-input-date" id="date" hidden>
                    


                    <!--Filtro precio-->

                    <button class="c-e-btn" id="toggleFilterBtn" type="buton" name="price">Price <span id="priceValue">50€</span></button>
                    <div class="c-e-filter-container d-flex flex-column" id="priceFilter" hidden>
                    <label for="priceRange">Precio: <span id="priceValue">50</span>€</label><br>
                    <input type="range" id="priceRange" class="c-e-range-price" name="range-price" min="0" max="1000" step="5"
                        value="50"><br>
                    </div>

                    <!--Filtro estilo-->

                    <select name="style" id="style" class="c-e-style">
                        <option selected> Style </option>
                        <option value="Rock">Rock</option>
                        <option value="Style 2">Style 2</option>
                        <option value="Style 3">Style 3</option>
                        <option value="Style 4">Style 4</option>
                    </select>

                    <!--Botón aceptar filtros-->

                    <button class="ms-4 c-e-btn-aceptar-filtros" id="aceptar-filtros" name="aceptar-filtros">Filter</button>
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
                        <button class="c-e-btn-event-card btn btn-primary c-e-custom-bg-primary w-100">Book Now</button>
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
                        <button class="c-e-btn-event-card btn btn-primary c-e-custom-bg-primary w-100">Book Now</button>
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
                        <button class="c-e-btn-event-card btn btn-primary c-e-custom-bg-primary w-100">Book Now</button>
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
                        <button class="c-e-btn-event-card btn btn-primary c-e-custom-bg-primary w-100">Book Now</button>
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
                        <button class="c-e-btn-event-card btn btn-primary c-e-custom-bg-primary w-100">Book Now</button>
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
                        <button class="c-e-btn-event-card btn btn-primary c-e-custom-bg-primary w-100">Book Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
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