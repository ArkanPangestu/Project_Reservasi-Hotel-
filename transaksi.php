<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hotel_db");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$id_pelanggan = $_SESSION["user_id"];

// Ambil nama pelanggan berdasarkan id_pelanggan
$pelanggan_query = "SELECT nama FROM pelanggan WHERE id_pelanggan = ?";
$stmt = mysqli_prepare($conn, $pelanggan_query);
mysqli_stmt_bind_param($stmt, "i", $id_pelanggan);
mysqli_stmt_execute($stmt);
$pelanggan_result = mysqli_stmt_get_result($stmt);
$pelanggan_row = mysqli_fetch_assoc($pelanggan_result);

if (!$pelanggan_row) {
    die("Pelanggan dengan ID tersebut tidak ditemukan.");
}

$nama_pelanggan = $pelanggan_row['nama'];

$kamar_query = "SELECT * FROM kamar WHERE status = 'tersedia'";
$kamar_result = mysqli_query($conn, $kamar_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kamar_id = $_POST["kamar_id"];
    $tanggal_checkin = $_POST["tanggal_checkin"];
    $tanggal_checkout = $_POST["tanggal_checkout"];

    // Validasi tanggal
    $today = new DateTime();
    $checkin = new DateTime($tanggal_checkin);
    $checkout = new DateTime($tanggal_checkout);

    if ($checkin < $today) {
        $error = "Tanggal check-in tidak boleh kurang dari hari ini.";
    } elseif ($checkout <= $checkin) {
        $error = "Tanggal check-out harus lebih besar dari tanggal check-in.";
    } else {
        // Hitung total harga berdasarkan durasi menginap
        $harga_query = "SELECT harga FROM kamar WHERE id = ?";
        $stmt = mysqli_prepare($conn, $harga_query);
        mysqli_stmt_bind_param($stmt, "i", $kamar_id);
        mysqli_stmt_execute($stmt);
        $harga_result = mysqli_stmt_get_result($stmt);
        $harga_row = mysqli_fetch_assoc($harga_result);
        $harga_per_malam = $harga_row["harga"];

        $durasi = $checkin->diff($checkout)->days;
        $total_harga = $harga_per_malam * $durasi;

        $insert_transaksi_query = "INSERT INTO transaksi (id_pelanggan, kamar_id, tanggal_checkin, tanggal_checkout, total_harga, status) VALUES (?, ?, ?, ?, ?, 'pending')";
        $stmt = mysqli_prepare($conn, $insert_transaksi_query);
        mysqli_stmt_bind_param($stmt, "iissd", $id_pelanggan, $kamar_id, $tanggal_checkin, $tanggal_checkout, $total_harga);
        
        if (mysqli_stmt_execute($stmt)) {
            $success = "Transaksi berhasil disimpan!";
        
            // Update status kamar menjadi terisi
            $update_kamar_query = "UPDATE kamar SET status = 'terisi' WHERE id = ?";
            $stmt_update = mysqli_prepare($conn, $update_kamar_query);
            mysqli_stmt_bind_param($stmt_update, "i", $kamar_id);
            mysqli_stmt_execute($stmt_update);
        } else {
            $error = "Terjadi kesalahan saat menyimpan transaksi: " . mysqli_stmt_error($stmt);
        }
        
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
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
                    <a class="nav-link active" aria-current="page" href="kamar.php"><b>Kamar</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="logout.php"><b>Log-out</b></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-black" style="background-color: #E7BD2A;">
                    <h2 class="mb-0">Buat Pesanan</h2>
                </div>
                <div class="card-body">
                    <?php if (isset($success)) : ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="nama_pelanggan" class="form-label">
                                <i class="fas fa-user me-2"></i>Nama Pelanggan
                            </label>
                            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="<?php echo htmlspecialchars($nama_pelanggan); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="kamar_id" class="form-label">
                                <i class="fas fa-bed me-2"></i>Pilih Kamar
                            </label>
                            <select class="form-select" id="kamar_id" name="kamar_id" required>
                                <option value="" selected disabled>Pilih kamar</option>
                                <?php while ($row = mysqli_fetch_assoc($kamar_result)) : ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo ucfirst($row['jenis']) . ' - Rp ' . number_format($row['harga'], 0, ',', '.'); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_checkin" class="form-label">
                                <i class="fas fa-calendar-check me-2"></i>Tanggal Check-in
                            </label>
                            <input type="date" class="form-control" id="tanggal_checkin" name="tanggal_checkin" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_checkout" class="form-label">
                                <i class="fas fa-calendar-times me-2"></i>Tanggal Check-out
                            </label>
                            <input type="date" class="form-control" id="tanggal_checkout" name="tanggal_checkout" required>
                        </div>
                        <button type="submit" class="btn w-100" style="background-color: #E7BD2A; color: black;">
                            <i class="fas fa-check me-2"></i>Buat Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>