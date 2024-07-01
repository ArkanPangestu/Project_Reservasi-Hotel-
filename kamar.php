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
                        <a class="nav-link active" aria-current="page" href="home.php"><b>Home</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="Transaksi.php"><b>Pesan</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="logout.php"><b>Log-out</b></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="row">
    <div class="col">
        <div class="col mp-5 text-center" style="font-family: Inter;">
            <h2>PILIH KAMAR</h2>
                </div>
        </div>
    </div>

    <!-- card -->
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card" style="width: 18rem;">
            <img src="img/standar.jpg" class="card-img-top" alt="...">
            <div class="card-body text-center">
                <h5 class="card-title">Standard Room</h5>
                <p class="card-text">Kamar yang nyaman dan fungsional, dirancang untuk memenuhi kebutuhan dasar penginapan dengan perhatian pada detail dan nilai yang tak terbantahkan.</p>
                <a href="transaksi.php" class="btn btn-primary">Pesan Sekarang</a>
            </div>
            </div>
            </div>

            <div class="col-md-3">
            <div class="card" style="width: 18rem;">
            <img src="img/deluxe.jpg" class="card-img-top" alt="...">
            <div class="card-body text-center">
                <h5 class="card-title">Deluxe Room</h5>
                <p class="card-text">Pengalaman istirahat sempurna dengan kombinasi kemewahan dan kenyamanan. Didesain dengan furnitur bergaya dan fasilitas modern untuk menciptakan suasana yang elegan dan nyaman.</p>
                <a href="transaksi.php" class="btn btn-primary">Pesan Sekarang</a>
            </div>
            </div>
            </div>

            <div class="col-md-3">
            <div class="card" style="width: 18rem;">
            <img src="img/suite.jpg" class="card-img-top" alt="...">
            <div class="card-body text-center">
                <h5 class="card-title">Suite Room</h5>
                <p class="card-text"> Kamar dengan ruang yang luas dan fasilitas eksklusif, ideal untuk mereka yang menghargai kemewahan. Menawarkan desain elegan, ruang pribadi yang luas, dan fasilitas modern .</p>
                <a href="transaksi.php" class="btn btn-primary">Pesan Sekarang</a>
            </div>
            </div>
            </div>

            </div>
            </div>

    </body>
    </html>