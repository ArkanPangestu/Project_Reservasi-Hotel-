<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hotel_db");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Fungsi untuk mengambil data kamar
function getKamarData($conn) {
    $query = "SELECT * FROM kamar";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fungsi untuk mengambil data transaksi
function getTransaksiData($conn, $jenis_kamar = null) {
    $query = "SELECT t.id, p.nama AS username, k.jenis, t.tanggal_checkin, t.tanggal_checkout, t.total_harga, t.status 
              FROM transaksi t
              INNER JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
              INNER JOIN kamar k ON t.kamar_id = k.id";
    
    if ($jenis_kamar) {
        $query .= " WHERE k.jenis = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $jenis_kamar);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } else {
        $result = mysqli_query($conn, $query);
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fungsi untuk menambah kamar
if (isset($_POST['tambah_kamar'])) {
    $jenis = $_POST['jenis'];
    $harga = $_POST['harga'];
    $query = "INSERT INTO kamar (jenis, harga, status) VALUES (?, ?, 'tersedia')";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sd", $jenis, $harga);
    mysqli_stmt_execute($stmt);
}

// Fungsi untuk menghapus kamar
if (isset($_POST['hapus_kamar'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM kamar WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

// Fungsi untuk mengubah harga kamar
if (isset($_POST['ubah_harga'])) {
    $id = $_POST['id'];
    $harga_baru = $_POST['harga_baru'];
    $query = "UPDATE kamar SET harga = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "di", $harga_baru, $id);
    mysqli_stmt_execute($stmt);
}

$kamar_data = getKamarData($conn);

$jenis_kamar_filter = isset($_POST['filter_jenis_kamar']) ? $_POST['filter_jenis_kamar'] : null;
$transaksi_data = getTransaksiData($conn, $jenis_kamar_filter);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .bg-custom {
            background-color: #E7BD2A;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-custom">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Panel Hotel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-4">Manajemen Hotel</h2>
        
        <!-- Tab navigation -->
        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="kamar-tab" data-bs-toggle="tab" data-bs-target="#kamar" type="button" role="tab" aria-controls="kamar" aria-selected="true">Manajemen Kamar</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="transaksi-tab" data-bs-toggle="tab" data-bs-target="#transaksi" type="button" role="tab" aria-controls="transaksi" aria-selected="false">Data Transaksi</button>
            </li>
        </ul>
        
        <!-- Tab content -->
        <div class="tab-content" id="myTabContent">
            <!-- Tab Manajemen Kamar -->
            <div class="tab-pane fade show active" id="kamar" role="tabpanel" aria-labelledby="kamar-tab">
                <!-- Tabel Kamar -->
                <div class="card mb-4">
                    <div class="card-header bg-custom text-white">
                        <h5 class="mb-0">Daftar Kamar</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Jenis Kamar</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($kamar_data as $kamar) : ?>
                                <tr>
                                    <td><?php echo $kamar['id']; ?></td>
                                    <td><?php echo ucfirst($kamar['jenis']); ?></td>
                                    <td>Rp <?php echo number_format($kamar['harga'], 0, ',', '.'); ?></td>
                                    <td><?php echo $kamar['status']; ?></td>
                                    <td>
                                        <form method="post" action="" class="d-inline">
                                            <input type="hidden" name="id" value="<?php echo $kamar['id']; ?>">
                                            <button type="submit" name="hapus_kamar" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ubahHargaModal<?php echo $kamar['id']; ?>">
                                            <i class="fas fa-edit"></i> Ubah Harga
                                        </button>
                                    </td>
                                </tr>
                                <!-- Modal Ubah Harga -->
                                <div class="modal fade" id="ubahHargaModal<?php echo $kamar['id']; ?>" tabindex="-1" aria-labelledby="ubahHargaModalLabel<?php echo $kamar['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ubahHargaModalLabel<?php echo $kamar['id']; ?>">Ubah Harga Kamar</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?php echo $kamar['id']; ?>">
                                                    <div class="mb-3">
                                                        <label for="harga_baru" class="form-label">Harga Baru</label>
                                                        <input type="number" class="form-control" id="harga_baru" name="harga_baru" value="<?php echo $kamar['harga']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" name="ubah_harga" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Form Tambah Kamar -->
                <div class="card mb-4">
                    <div class="card-header bg-custom text-white">
                        <h5 class="mb-0">Tambah Kamar Baru</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Kamar</label>
                                <select class="form-select" id="jenis" name="jenis" required>
                                    <option value="standar">Standar</option>
                                    <option value="deluxe">Deluxe</option>
                                    <option value="suite">Suite</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="harga" name="harga" required min="0">
                            </div>
                            <button type="submit" name="tambah_kamar" class="btn btn-success">Tambah Kamar</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Tab Data Transaksi -->
            <div class="tab-pane fade" id="transaksi" role="tabpanel" aria-labelledby="transaksi-tab">
                <div class="card mb-4">
                    <div class="card-header bg-custom text-white">
                        <h5 class="mb-0">Data Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <!-- Form Pencarian -->
                        <form method="post" action="" class="mb-4">
                            <div class="row g-3">
                                <div class="col-auto">
                                    <select class="form-select" name="filter_jenis_kamar" required>
                                        <option value="" selected disabled>Pilih Jenis Kamar</option>
                                        <option value="standar">Standar</option>
                                        <option value="deluxe">Deluxe</option>
                                        <option value="suite">Suite</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </form>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Jenis Kamar</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transaksi_data as $transaksi) : ?>
                                <tr>
                                    <td><?php echo $transaksi['id']; ?></td>
                                    <td><?php echo $transaksi['username']; ?></td>
                                    <td><?php echo ucfirst($transaksi['jenis']); ?></td>
                                    <td><?php echo $transaksi['tanggal_checkin']; ?></td>
                                    <td><?php echo $transaksi['tanggal_checkout']; ?></td>
                                    <td>Rp <?php echo number_format($transaksi['total_harga'], 0, ',', '.'); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
