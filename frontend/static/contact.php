<?php
require_once '../../backend/controllers/init.php';
?>
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
    <!-- Encabezado -->
    <?php
    include "../static/header.php";
    ?>

    <main class="d-flex align-items-center justify-content-center font-family_contact mt-5 mb-5 min-vh-100">
        <div class="d-flex flex-column flex-lg-row container">
            <div class="col-lg-8 row justify-content-center">
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
                            <div id="mensaje-contenedor" class="mensaje-contenedor">
                                <?php
                                if (isset($_SESSION['message'])) {
                                    $mensaje = $_SESSION['message'];
                                    $tipo_mensaje = $_SESSION['message_type'];
                                    echo '<div class="alerta-' . htmlspecialchars($tipo_mensaje) . '">' . htmlspecialchars($mensaje) . '</div>';
                                    unset($_SESSION['message']);
                                    unset($_SESSION['message_type']);
                                }
                                ?>
                            </div>
                        </form>
                    </div>
            </div>
            <div class="d-flex justify-content-center">
                <img 
                    class="img-fluid rounded-3" 
                    src="../assets/img/contact.png" 
                    alt="about-us-ER" 
                    style= "max-width: 100%; height: auto; object-fit: contain;" 
                />
            </div>
        </div>
        
    </main>

    <!-- Footer -->
    <?php
    include '../static/footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Restar form
            const mensajeContenedor = document.getElementById('mensaje-contenedor');
            const formularioContacto = document.getElementById('contactForm');
            if (mensajeContenedor && mensajeContenedor.innerHTML.trim() !== '') {
                if (formularioContacto) {
                    formularioContacto.reset();
                }
            }
        });
    </script>
</body>

</html>