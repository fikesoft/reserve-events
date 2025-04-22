<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>catalog-events</title>
    <!-- Importar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!--CSS-->
    <link rel="stylesheet" href="../assets/style/style-catalog-events.css">
    
</head>
<body>
    <!-- Encabezado -->
    <?php
        include "../static/header.php";
    ?>

    <main>
        <!--Catalog Section-->
        <div class="container mt-5">

        <!--Título de sección-->

        <h2 class="fw-bold text-uppercase">Catalog</h2>
        <div class="row g-4">
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="c-e-card shadow-sm">
                    <img src="../assets/img/imagen-evento.png" alt="evento" class="card-img-top">
                    <div class="c-e-card-body text-center">
                        <h6 class="fw-bold">Beach Please Festival</h6>
                        <p class="text-muted">4 days pass</p>
                        <button class="c-e-btn-card btn btn-primary w-100 custom"><a href="filter_events.php"></a>Book Now</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="c-e-card shadow-sm">
                    <img src="../assets/img/imagen-evento.png" alt="evento" class="card-img-top">
                    <div class="c-e-card-body text-center">
                        <h6 class="fw-bold">Beach Please Festival</h6>
                        <p class="text-muted">4 days pass</p>
                        <button class="c-e-btn-card btn btn-primary w-100">Book Now</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="c-e-card shadow-sm">
                    <img src="../assets/img/imagen-evento.png" alt="evento" class="card-img-top">
                    <div class="c-e-card-body text-center">
                        <h6 class="fw-bold">Beach Please Festival</h6>
                        <p class="text-muted">4 days pass</p>
                        <button class="c-e-btn-card btn btn-primary w-100">Book Now</button>
                    </div>
                </div>
            </div>
            <div class="row g-4"></div>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="c-e-card shadow-sm">
                    <img src="../assets/img/imagen-evento.png" alt="evento" class="card-img-top">
                    <div class="c-e-card-body text-center">
                        <h6 class="fw-bold">Beach Please Festival</h6>
                        <p class="text-muted">4 days pass</p>
                        <button class="c-e-btn-card btn btn-primary w-100">Book Now</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="c-e-card shadow-sm">
                    <img src="../assets/img/imagen-evento.png" alt="evento" class="card-img-top">
                    <div class="c-e-card-body text-center">
                        <h6 class="fw-bold">Beach Please Festival</h6>
                        <p class="text-muted">4 days pass</p>
                        <button class="c-e-btn-card btn btn-primary w-100">Book Now</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="c-e-card shadow-sm">
                    <img src="../assets/img/imagen-evento.png" alt="evento" class="card-img-top">
                    <div class="c-e-card-body text-center">
                        <h6 class="fw-bold">Beach Please Festival</h6>
                        <p class="text-muted">4 days pass</p>
                        <button class="c-e-btn-card btn btn-primary w-100">Book Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<!-- Footer -->
<?php
    include 'footer.php';
?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>