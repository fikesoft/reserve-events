<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    
    <!-- Cargar Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/style/footer.css">
    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <!-- Footer -->
    <footer class="container-fluid p-5">
        <div class="d-flex flex-column align-items-center">
            <div class="row">
                <!-- Menú de navegación -->
                <nav class=" col-12 col-md-6 mt-3">    
                    <ul class="list-unstyled">
                        <li><a href="home.php" class="nav-footer">Home</a></li>
                        <li><a href="catalog-events.php" class="nav-footer">Events</a></li>
                        <li><a href="about-us.php" class="nav-footer">About us</a></li>
                        <li><a href="contact.php" class="nav-footer">Contact us</a></li>
                    </ul>
                </nav>
            
                <!-- Información de contacto -->
                <div class="footer-contact col-12 col-md-6 mt-3">
                    <p class="text-nowrap m-1"><i class="fa-solid fa-phone me-2"></i> +34 123 456 789</p>
                    <p class="text-nowrap m-1"><i class="fa-solid fa-envelope me-2"></i> randomeventsinfo@gmail.com</p>
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