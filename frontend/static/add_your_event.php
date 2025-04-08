<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add your event</title>
    <!--CSS Header -->
    <link rel="stylesheet" href="../assets/style/header.css">
    <!-- CSS Footer -->
    <link rel="stylesheet" href="../assets/style/footer.css">
    <!-- CSS Login -->
    <link rel="stylesheet" href="../assets/style/add_your_event.css">
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/footer.css">

    <!-- Importar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <li><a href="home.html" class="nav-header">Home</a></li>
                    <li><a href="#Eventos" class="nav-header">Events</a></li>
                    <li><a href="#AboutUs" class="nav-header">About us</a></li>
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
                <a href="carrito.html" class="icons mx-3"><i class="fa-solid fa-cart-shopping"></i></a>
                <a href="login.html" class="icons mx-3"><i class="fa-solid fa-user"></i></a>
            </div>
            
        </div>
    </header>

    <!-- Página principal -->
    <main class="container-fluid p-0 d-flex font-family_addYourEvent mb-3">
        <div class="container-fluid d-flex flex-column align-items-center justify-content-center px-3 px-md-0">
            
            <!-- Container con el título -->
            <div class="d-flex align-items-center justify-content-center p-3 p-md-5">
                <h1>ADD YOUR EVENT</h1>
            </div>
            
            <!-- Formulario -->
            <div class="d-flex justify-content-center align-items-center w-100 bg_addYourEvent">
                <form class="col-12 col-md-8 col-lg-6 p-5 shadow bg-white mt-3 mb-3 rounded-3 custom-form_addYourEvent" action="../../backend/controllers/crear_evento.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-user-pen"></i></span>
                            <input name="name" type="text" class="form-control" id="name" required>
                        </div> 
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input name="email" type="email" class="form-control" id="email" required>
                        </div> 
                    </div>
                    <div class="mb-2">
                        <label for="eventName" class="form-label">Event name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-ticket"></i></span>
                            <input name="event-name" type="text" class="form-control" id="eventName" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-pen-to-square"></i></span>
                            <textarea name="description" class="form-control auto-expand" id="description" rows="3" required></textarea>
                        </div> 
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-calendar"></i></span>
                            <input name="date" type="date" class="form-control" id="date" required>
                        </div> 
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                            <input name="time" type="time" class="form-control" id="time" required>
                        </div> 
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image URL</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-file-image"></i></span>
                            <input name="image" type="text" class="form-control" id="image" required>
                        </div> 
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-map-location"></i></span>
                            <input name="location" type="text" class="form-control" id="location" required>
                        </div> 
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-money-check-dollar"></i></span>
                            <input name="price" type="number" step="0.01" class="form-control" id="price" required>
                        </div> 
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label d-block">Type of tickets</label>
                        <div class="btn-group w-100" role="group" aria-label="Ticket types">
                            <input name="ticket-general" type="checkbox" class="btn-check" id="general" name="ticketType[]" value="general" autocomplete="off">
                            <label class="btn btn-outline-primary" for="general">General</label>
                        
                            <input name="ticket-vip" type="checkbox" class="btn-check" id="vip" name="ticketType[]" value="vip" autocomplete="off">
                            <label class="btn btn-outline-primary" for="vip">VIP</label>
                        
                            <input type="checkbox" class="btn-check" id="premium" name="ticketType[]" value="premium" autocomplete="off">
                            <label name="ticket-premium" class="btn btn-outline-primary" for="premium">Premium</label>
                        </div> 
                    </div>
                    <div class="mb-3">
                        <label for="number_tickets" class="form-label">Number of tickets</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-ticket-simple"></i></span>
                            <input name="ticket-number" type="number" class="form-control" id="number_tickets" required>
                        </div> 
                    </div>
                    <!-- Botón enviar formulario -->
                    <button type="submit" class="button_addYourEvent btn w-100 mt-3">
                        <i class="fa-solid fa-paper-plane me-2"></i> Submit
                    </button>
                </form>
                
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="container-fluid p-5">
        <div class="d-flex flex-column align-items-center">
            <div class="row">
                <!-- Menú de navegación -->
                <nav class=" col-12 col-md-6 mt-3">    
                    <ul class=" list-unstyled">
                        <li><a href="#" class="nav-footer">Home</a></li>
                        <li><a href="#" class="nav-footer">Events</a></li>
                        <li><a href="#" class="nav-footer">About us</a></li>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>