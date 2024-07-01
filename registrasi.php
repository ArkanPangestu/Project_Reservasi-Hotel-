<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hotel_db");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $password = $_POST["password"];

    $sql = "INSERT INTO pelanggan (nama, alamat, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $nama, $alamat, $password);

    if (mysqli_stmt_execute($stmt)) {
        $success = "Registrasi berhasil. Silakan login.";
    } else {
        $error = "Registrasi gagal: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center mb-0">Registrasi Hotel</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($success)) : ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $success; ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">DAFTAR</button>
                        </form>
                        <div class="mt-3 text-center">
                            <small><a href="login.php" class="text-dark">Sudah Punya Akun? Login di sini</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>