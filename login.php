<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hotel_db");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $error = "Username dan password harus diisi";
    } else {
        // Check admin in user table
        $sql_admin = "SELECT * FROM user WHERE username = ? AND role = 'admin'";
        $stmt_admin = mysqli_prepare($conn, $sql_admin);
        mysqli_stmt_bind_param($stmt_admin, "s", $username);
        mysqli_stmt_execute($stmt_admin);
        $result_admin = mysqli_stmt_get_result($stmt_admin);

        if ($row_admin = mysqli_fetch_assoc($result_admin)) {
            if ($password == $row_admin["password"]) {
                $_SESSION["user_id"] = $row_admin["id"];
                $_SESSION["role"] = "admin";
                header("Location: admin.php");
                exit();
            } else {
                $error = "Password salah";
            }
        } else {
            // Check pelanggan in pelanggan table
            $sql_pelanggan = "SELECT * FROM pelanggan WHERE nama = ?";
            $stmt_pelanggan = mysqli_prepare($conn, $sql_pelanggan);
            mysqli_stmt_bind_param($stmt_pelanggan, "s", $username);
            mysqli_stmt_execute($stmt_pelanggan);
            $result_pelanggan = mysqli_stmt_get_result($stmt_pelanggan);

            if ($row_pelanggan = mysqli_fetch_assoc($result_pelanggan)) {
                if ($password == $row_pelanggan["password"]) {
                    $_SESSION["user_id"] = $row_pelanggan["id_pelanggan"];
                    $_SESSION["role"] = "pelanggan";
                    header("Location: home.php");
                    exit();
                } else {
                    $error = "Password salah";
                }
            } else {
                $error = "Username tidak ditemukan";
            }
        }
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center mb-0">Login Hotel</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <small><a href="registrasi.php" class="text-dark">Belum Punya Akun? Buat Akun Anda!</a></small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">LOGIN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>