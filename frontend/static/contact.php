<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/footer.css">
    <link rel="stylesheet" href="../assets/style/contact.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
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

        <div class="d-flex align-items-center gap-4 mt-3 mt-md-0 flex-md-row flex-column">
            <div class="d-flex align-items-center search-box">
                <input class="search-box-input" type="text" placeholder="Search...">
                <button class="search-box-button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="d-flex">
                <a href="cart.html" class="icons mx-3"><i class="fa-solid fa-cart-shopping"></i></a>
                <a href="login.php" class="icons mx-3"><i class="fa-solid fa-user"></i></a>
            </div>

        </div>
    </header>

    <main class="d-flex align-items-center justify-content-center font-family_contact mt-5 mb-5 min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow rounded-3 border-custom_register p-4">
                        <h2 class="text-center mb-4">CONTACT US</h2>
                        <form action="../../backend/controllers/contact.php" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user-pen"></i></span>
                                    <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your name">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number (Optional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Comment</label>
                                <textarea class="form-control" id="comment" name="comment" rows="5" required placeholder="Write your comment"></textarea>
                            </div>
                            <button type="submit" class="button_register btn w-100 mt-3">
                            <i class="fa-solid fa-paper-plane me-2"></i>Send Message</button>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
                <img 
                    class="img-fluid rounded-3" 
                    src="../assets/img/aboutUs-img.png" 
                    alt="about-us-ER" 
                    style= "max-width: 100%; height: auto" 
                />
            </div>
    </main>

    <footer class="container-fluid p-5">
        <div class="d-flex flex-column align-items-center">
            <div class="row">
                <nav class=" col-12 col-md-6 mt-3">
                    <ul class="list-unstyled">
                        <li><a href="home.php" class="nav-footer">Home</a></li>
                        <li><a href="#" class="nav-footer">Events</a></li>
                        <li><a href="about-us.html" class="nav-footer">About us</a></li>
                    </ul>
                </nav>

                <div class="footer-contact col-12 col-md-6 mt-3">
                    <p class="text-nowrap m-1"><i class="fa-solid fa-phone me-2"></i> +34 123 456 789</p>
                    <p class="text-nowrap m-1"><i class="fa-solid fa-envelope me-2"></i> contacto@empresa.com</p>
                    <p class="text-nowrap m-1"><i class="fa-solid fa-map-marker-alt me-2"></i> Calle Falsa 123, Madrid, España</p>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center align-items-center gap-3 mt-3 col-12">
            <a href="#" class="footer-social"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" class="footer-social"><i class="fa-brands fa-twitter"></i></a>
            <a href="#" class="footer-social"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="footer-social"><i class="fa-brands fa-linkedin"></i></a>
        </div>


        <div class="footer-bottom text-center pt-4 col-12">
            <p>&copy; 2025 Random Events. All rights reserved.</p>
        </div>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>