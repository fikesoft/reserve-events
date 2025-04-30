<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style/about-us-page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/footer.css">

    <title>About Us</title>
</head>

<body>
    <!-- Encabezado -->
    <?php
    include "../static/header.php";
    ?>

    <div class="d-flex flex-column align-items-center gap-5 text-center p-2 customContainer mt-5">
        <div>
            <h1 class="headerAboutUs">THIS IS RANDOM</h1>
        </div>
        <div>
            <p style="max-width: 500px;"> We’ve always believed that an event can change lives. At Random Events, we’ve built a
                platform that lets fans experience shows they love effortlessly and without hassle.</p>
        </div>
        <div class="d-flex flex-column flex-lg-row align-items-center gap-4">
            <div class="d-flex flex-column gap-4 text-start" style=" max-width: 600px ">
                <h2 class="display-3">Going out invigorates us.</h2>
                <div class="d-flex flex-column gap-4">
                    <p>Whether you’re into intimate basement gigs, energetic club nights, sprawling festivals,
                        wild raves, comedy shows, or dazzling drag cabarets, live events are where we forge
                        unforgettable memories, discover our communities, and explore the hidden corners of our cities.</p>
                    <p>We understand the significance of these moments, which is why we’ve created an app
                        that makes it effortless to dive into the events you love.</p>
                    <p>Since 2025, Random Events has been revolutionizing the ticketing experience for
                        fans, artists, and venues—removing barriers to a great time and fostering a fairer, more inclusive industry.</p>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <img
                    class="img-fluid rounded-3"
                    src="../assets/img/aboutUs-img.png"
                    alt="about-us-ER"
                    style="max-width: 100%; height: auto" />
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php
    include '../static/footer.php';
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>