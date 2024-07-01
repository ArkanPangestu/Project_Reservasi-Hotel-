<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LUXURY HOTEL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<!-- navbar -->
<nav class="navbar navbar-expand-lg" style="background-color: #E7BD2A;">
    <div class="container">
        <a class="navbar-brand" href="#"><b>LUXURY HOTEL</b></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="kamar.php"><b>Kamar</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="transaksi.php"><b>Pesan</b></a>
                </li>
                <li class="nav-item">
                <?php
                session_start();
                if (isset($_SESSION['user_id'])) {
                    echo '<a class="nav-link active" aria-current="page" href="logout.php"><b>Log-out</b></a>';
                } else {
                    echo '<a class="nav-link active" aria-current="page" href="login.php"><b>Login</b></a>';
                }
                ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<link href="style.css" rel="hero-image">
<img src="img/bg.jpg" class="img-fluid" alt="Gambar Hotel">
</link>

<div class="container">
    <div class="row">
        <div class="col my-4 text-center" style="font-family: Inter;">
            <h2>WELCOME TO LUXURY HOTEL</h2>
            <p class="mt-2">"Hotel Luxury, istana modern di mana mimpi menjadi kenyataan dan kenyamanan adalah raja."</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <div class="col mb-5 text-center" style="font-family: Inter;">
                <h2>KAMI BERADA DI</h2>
                <p class="mt-2">Jawa Tengah, Sukoharjo, kab Sukoharjo</p>
            </div>
        </div>
    
        <div class="row">
            <div class="col">
                <div class="col mp-5 text-center" style="font-family: Inter;">
                    <h2>GALERI HOTEL</h2>
                </div>
            </div>
        </div>

        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3" aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="4" aria-label="Slide 5"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                    <img src="img/waiting.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="img/kolam.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/gym.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/spa.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/restoran.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>

</body>
</html>
