<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Estilos Header-->
    <link rel="stylesheet" href="../assets/style/header.css">
    <!-- Estilos footer-->
    <link rel="stylesheet" href="../assets/style/footer.css">
    <!-- Cargar Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <a href="login.html" class="icons mx-3"><i class="fa-solid fa-user"></i></a>
            </div>
            
        </div>
    </header>
    <main class="mb-5">
        <div class="container mt-4">
            <h1 class="text-left">BEACH PLEASE</h1>

            <div class="row mt-4">
                <!-- Columna de la imagen -->
                <div class="col-md-4" style="position: relative;">
                    <img src="../assets/img/463743448_533852642723671_4469179848621438781_n 3.png" class="img-fluid"
                        alt="Imagen del evento">
                    <div
                        style="background-color: black; border-radius: 40px; max-width: 25px; display: flex;padding: 7px; justify-content: center; align-items: center; height: 25px; position: absolute; top: 8px; left: 24px;">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M3.72692 1C2.22077 1 1 2.29358 1 3.88889C1 6.2963 3.27308 8.22222 6 10.6296C8.72769 8.22222 11 6.2963 11 3.88889C11 2.29358 9.77923 1 8.27231 1C7.32385 1 6.48846 1.51358 6 2.29197C5.75419 1.89622 5.41753 1.57076 5.02059 1.34514C4.62364 1.11952 4.17896 1.00089 3.72692 1Z"
                                stroke="white" />
                        </svg>
                    </div>
                </div>

                <!-- Columna de las entradas -->
                <div class="col-md-8" style="max-width: 600px;">
                    <div class="d-flex flex-column gap-3">


                        <div class="d-flex align-items-stretch border rounded">
                            <div class="text-white text-center px-3 py-4 d-flex flex-column justify-content-center rounded-start"
                                style="background-color:#4d194d;">
                                <p class="mb-2 fw-bold">03 June</p>
                                <p class="mb-2">SUN</p>
                                <p class="mb-0">08:00 PM</p>
                            </div>
                            <div class="ms-3 w-100 d-flex flex-column justify-content-around">

                                <div class="d-flex flex-column gap-2">
                                    <p class="fw-bold mb-1">Beach Please Festival 4 days pass</p>
                                    <p class="mb-1">Madrid - Plaza de Sol</p>
                                </div>
                                <div class="d-flex justify-content-between ">
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex gap-2">
                                            <img src="../assets/iconos/mapaa.svg" alt="icono del mapa">
                                            <p class="mb-1 text-primary fw-bold">Plaza Sol</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <img src="../assets/iconos/entrada.svg" alt="">
                                            <p class="mb-1 text-primary fw-bold">Class Normal</p>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column align-items-center gap-2 mx-2">
                                        <p class="mb-0">From 100$ / person</p>
                                        <div class="d-flex align-items-center justify-content-between rounded-pill px-3 py-1"
                                            style="background-color: #4d194d; width: 120px;">
                                            <button
                                                class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                style="background-color: transparent; width: 30px; height: 30px; font-size: 18px;">-</button>
                                            <span class="text-white fs-6">0</span>
                                            <button
                                                class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                style="background-color: transparent; width: 30px; height: 30px; font-size: 18px;">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-stretch border rounded">
                            <div class="text-white text-center px-3 py-4 d-flex flex-column justify-content-center rounded-start"
                                style="background-color:#b44cb4;">
                                <p class="mb-2 fw-bold">03 June</p>
                                <p class="mb-2">SUN</p>
                                <p class="mb-0">08:00 PM</p>
                            </div>
                            <div class="ms-3 w-100 d-flex flex-column justify-content-around">

                                <div class="d-flex flex-column gap-2">
                                    <p class="fw-bold mb-1">Beach Please Festival 4 days pass</p>
                                    <p class="mb-1">Madrid - Plaza de Sol</p>
                                </div>
                                <div class="d-flex justify-content-between ">
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex gap-2">
                                            <img src="../assets/iconos/mapaa.svg" alt="icono del mapa">
                                            <p class="mb-1 text-primary fw-bold">Plaza Sol</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <img src="../assets/iconos/entrada.svg" alt="">
                                            <p class="mb-1 text-primary fw-bold">Class Normal</p>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column align-items-center gap-2 mx-2">
                                        <p class="mb-0">From 100$ / person</p>
                                        <div class="d-flex align-items-center justify-content-between rounded-pill px-3 py-1"
                                            style="background-color: #b44cb4; width: 120px;">
                                            <button
                                                class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                style="background-color: transparent; width: 30px; height: 30px; font-size: 18px;">-</button>
                                            <span class="text-white fs-6">0</span>
                                            <button
                                                class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                style="background-color: transparent; width: 30px; height: 30px; font-size: 18px;">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-stretch border rounded">
                            <div class="text-white text-center px-3 py-4 d-flex flex-column justify-content-center rounded-start"
                                style="background-color:#f5a6f5;">
                                <p class="mb-2 fw-bold">03 June</p>
                                <p class="mb-2">SUN</p>
                                <p class="mb-0">08:00 PM</p>
                            </div>
                            <div class="ms-3 w-100 d-flex flex-column justify-content-around">

                                <div class="d-flex flex-column gap-2">
                                    <p class="fw-bold mb-1">Beach Please Festival 4 days pass</p>
                                    <p class="mb-1">Madrid - Plaza de Sol</p>
                                </div>
                                <div class="d-flex justify-content-between ">
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex gap-2">
                                            <img src="../assets/iconos/mapaa.svg" alt="icono del mapa">
                                            <p class="mb-1 text-primary fw-bold">Plaza Sol</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <img src="../assets/iconos/entrada.svg" alt="">
                                            <p class="mb-1 text-primary fw-bold">Class Normal</p>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column align-items-center gap-2 mx-2 ">
                                        <p class="mb-0">From 100$ / person</p>
                                        <div class="d-flex align-items-center justify-content-between rounded-pill px-3 py-1"
                                            style="background-color: #f5a6f5; width: 120px;">
                                            <button
                                                class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                style="background-color: transparent; width: 30px; height: 30px; font-size: 18px;">-</button>
                                            <span class="text-white fs-6">0</span>
                                            <button
                                                class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                style="background-color: transparent; width: 30px; height: 30px; font-size: 18px;">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec laoreet, orci sit amet porta lobortis, velit felis mattis purus, at gravida urna nulla non ligula. Sed pretium placerat accumsan. Sed urna felis, sodales vitae bibendum a, sodales at est. Quisque rhoncus ultrices ipsum, in blandit nibh convallis sed. Suspendisse vitae velit vitae mi pulvinar varius at vitae augue. Etiam finibus eu leo a tempus. Proin dictum odio eu pharetra porttitor.</p>
                </div>
                <div class="d-flex justify-content-around mt-5">
                    <button class="border rounded p-3" style="background-color: white; border: 2px solid black !important; ">Go back</button>
                    <button class="border rounded p-3 text-white" style="background-color: #4d194d;">Añadir al carrito</button>
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
</body>

</html>