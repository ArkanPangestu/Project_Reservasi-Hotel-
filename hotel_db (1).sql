-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Jul 2024 pada 20.57
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kamar`
--

CREATE TABLE `kamar` (
  `id` int(11) NOT NULL,
  `jenis` enum('standar','deluxe','suite') NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `status` enum('tersedia','terisi') NOT NULL DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kamar`
--

INSERT INTO `kamar` (`id`, `jenis`, `harga`, `status`) VALUES
(2, 'deluxe', 750000.00, 'terisi'),
(3, 'suite', 1000000.00, 'terisi'),
(6, 'standar', 300000.00, 'terisi'),
(9, 'deluxe', 8.00, 'terisi'),
(10, 'deluxe', 700000.00, 'terisi'),
(11, 'standar', 500000.00, 'terisi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `alamat`, `password`) VALUES
(1, 'dodi', 'palembang', '1'),
(2, 'adi', 'medan', '1'),
(3, 'wawan', 'kono', '1'),
(4, 'asep', 'surakarta', '1'),
(5, 'coba1', 'coba-coba', '1'),
(6, 'arkan', 'sukoharjo', '1'),
(7, 'semisal', 'semisal di sana', '1'),
(8, 'arkan', 'sukoharjo', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `kamar_id` int(11) DEFAULT NULL,
  `tanggal_checkin` date DEFAULT NULL,
  `tanggal_checkout` date DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `id_pelanggan`, `kamar_id`, `tanggal_checkin`, `tanggal_checkout`, `total_harga`, `status`, `created_at`) VALUES
(2, 2, 2, '2024-06-24', '2024-06-25', 750000.00, 'pending', '2024-06-24 03:47:37'),
(13, 5, 6, '2024-06-25', '2024-06-26', 300000.00, 'pending', '2024-06-25 03:59:18'),
(14, 1, 9, '2024-06-10', '2024-06-26', 128.00, 'pending', '2024-06-25 04:03:51'),
(15, 1, 3, '2024-06-27', '2024-06-30', 3000000.00, 'pending', '2024-06-25 04:10:37'),
(16, 7, 10, '2024-06-26', '2024-06-28', 1400000.00, 'pending', '2024-06-25 04:31:36'),
(17, 1, 11, '2035-06-25', '2039-06-25', 99999999.99, 'pending', '2024-06-25 04:33:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pelanggan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '123', 'admin'),
(2, 'pelanggan', 'p1', 'pelanggan'),
(3, 'cust', 'c1', 'pelanggan');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kamar_id` (`kamar_id`),
  ADD KEY `transaksi_ibfk_1` (`id_pelanggan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`kamar_id`) REFERENCES `kamar` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
