-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2025 at 05:27 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tpi_lelang`
--

-- --------------------------------------------------------

--
-- Table structure for table `karcis_bakul`
--

CREATE TABLE `karcis_bakul` (
  `id_bakul` int(11) NOT NULL,
  `nama_bakul` varchar(100) NOT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `berat_ikan` decimal(10,2) NOT NULL,
  `jumlah_karcis` int(11) NOT NULL,
  `jumlah_pembelian` decimal(12,2) NOT NULL,
  `jasa_lelang` decimal(12,2) DEFAULT NULL,
  `lain_lain` decimal(12,2) DEFAULT NULL,
  `total` decimal(12,2) NOT NULL,
  `jumlah_bayar` decimal(12,2) NOT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_verifikasi` enum('pending','approved','rejected') DEFAULT 'pending',
  `verified_by` int(11) DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karcis_bakul`
--

INSERT INTO `karcis_bakul` (`id_bakul`, `nama_bakul`, `alamat`, `berat_ikan`, `jumlah_karcis`, `jumlah_pembelian`, `jasa_lelang`, `lain_lain`, `total`, `jumlah_bayar`, `tanggal_input`, `status_verifikasi`, `verified_by`, `verified_at`) VALUES
(1, 'Test Manual', 'Alamat Test', 100.50, 2, 2500000.00, 125000.00, 0.00, 2625000.00, 2625000.00, '2025-09-28 15:02:14', 'rejected', NULL, NULL),
(2, 'Test Manual Insert', 'Test Alamat Manual', 50.50, 1, 1000000.00, 50000.00, 0.00, 1050000.00, 1050000.00, '2025-09-28 16:03:38', 'rejected', NULL, NULL),
(3, 'Test Native PHP', 'Alamat Test Native', 77.50, 1, 234567000.00, 75000.00, 0.00, 234567000.00, 1575000.00, '2025-09-28 17:36:59', 'pending', NULL, NULL),
(4, 'Siti Aminah', 'Jl. Merdeka No. 123, Kendari', 150.50, 3, 4500000.00, 225000.00, 50000.00, 477500000.00, 4775000.00, '2025-09-28 17:53:30', '', NULL, NULL),
(5, 'Siti Aminah', 'Jl. Merdeka No. 123, Kendari', 150.50, 3, 4500000.00, 225000.00, 50000.00, 0.00, 4775000.00, '2025-09-28 17:54:18', '', NULL, NULL),
(6, 'Siti Aminah', 'Jl. Merdeka No. 123, Kendari', 150.50, 3, 4500000.00, 225000.00, 50000.00, 0.00, 4775000.00, '2025-09-28 17:54:28', 'approved', NULL, NULL),
(7, 'Budi Santoso', 'Jl. Sudirman No. 45, Ambon\r\n', 85.75, 2, 2145000.00, 107250.00, 25000.00, 227725000.00, 2277250.00, '2025-09-28 18:08:59', 'approved', NULL, NULL),
(8, 'Budi Santoso', 'Jl. Sudirman No. 45, Ambon\r\n', 85.75, 2, 2145000.00, 107250.00, 25000.00, 227725000.00, 2277250.00, '2025-09-28 19:54:43', 'approved', NULL, NULL),
(9, 'Rina Melati', 'Jl. Diponegoro No. 67, Bitung\r\n', 210.25, 5, 6825000.00, 341250.00, 75000.00, 724125000.00, 7241250.00, '2025-09-28 19:56:31', 'approved', NULL, NULL),
(10, 'Ahmad Santoso', 'Jl. Merdeka No. 123, Jakarta', 150.50, 1, 3762500.00, 188125.00, 0.00, 395062500.00, 3950625.00, '2025-10-29 07:00:24', 'approved', NULL, NULL),
(11, 'Siti Rahma', 'Jl. Bahari No. 45, Batang', 85.20, 1, 2130000.00, 106500.00, 0.00, 223650000.00, 2236500.00, '2025-10-29 07:04:18', 'approved', NULL, NULL),
(12, 'Rudi Hermawan', 'Jl. Samudra No. 67, Batang', 120.80, 1, 3020000.00, 151000.00, 0.00, 317100000.00, 3171000.00, '2025-10-29 07:05:57', 'approved', NULL, NULL),
(13, 'Mujiatus', 'Jl. Kimangunsarkoro No. 25 Batang', 56.80, 1, 750000.00, 16800.00, 0.00, 76680000.00, 76680000.00, '2025-10-29 07:19:53', 'approved', NULL, NULL),
(14, 'aziz', 'Jl. RE Martadinata No. 23 Batang', 123.80, 2, 2349890.00, 132900.00, 0.00, 248279000.00, 2482790001.00, '2025-10-29 14:38:22', 'approved', NULL, NULL),
(15, 'aziz', 'Jl. RE Martadinata No. 23 Batang', 123.80, 2, 2349890.00, 132900.00, 0.00, 2482790.00, 2482790001.00, '2025-10-29 15:05:04', 'approved', NULL, NULL),
(16, 'aziz', 'Jl. RE Martadinata No. 23 Batang', 123.80, 2, 2349890.00, 132900.00, 0.00, 2482790.00, 2482790001.00, '2025-10-29 15:05:21', '', NULL, NULL),
(17, 'aziz', 'Jl. RE Martadinata No. 23 Batang', 123.80, 2, 2349890.00, 132900.00, 0.00, 2482790.00, 2482790001.00, '2025-10-29 15:05:38', '', NULL, NULL),
(18, 'aziz', 'Jl. RE Martadinata No. 23 Batang', 123.80, 2, 2349890.00, 132900.00, 0.00, 2482790.00, 2482790001.00, '2025-10-29 15:06:07', '', NULL, NULL),
(19, 'aziz', 'Jl. RE Martadinata No. 23 Batang', 123.80, 2, 2349890.00, 132900.00, 0.00, 2482790.00, 2482790001.00, '2025-10-29 15:06:20', '', NULL, NULL),
(20, 'aziz', 'Jl. RE Martadinata No. 23 Batang', 123.80, 2, 2349890.00, 132900.00, 0.00, 2482790.00, 2482790001.00, '2025-10-29 15:08:22', '', NULL, NULL),
(21, 'aziz', 'Jl. RE Martadinata No. 23 Batang', 123.80, 2, 2349890.00, 132900.00, 0.00, 2482790.00, 2482790001.00, '2025-10-29 15:15:31', '', NULL, NULL),
(22, 'aziz', 'Jl. RE Martadinata No. 23 Batang', 123.80, 2, 2349890.00, 132900.00, 0.00, 2482790.00, 2482790001.00, '2025-10-29 15:15:41', '', NULL, NULL),
(23, 'Rudi', 'Jl. sudarso No. 45 Batang', 134.50, 2, 213450.00, 134890.00, 0.00, 34834000.00, 34824000.00, '2025-10-30 01:37:48', '', NULL, NULL),
(24, 'Ahmad Supriyadi', 'Jl. Pasar Ikan No. 15, Kendari', 85.50, 2, 2137500.00, 106875.00, 0.00, 2244375.00, 2244375.00, '2025-11-03 09:20:32', 'rejected', NULL, NULL),
(25, 'Ahmad Supriyadi', 'Jl. Pasar Ikan No. 15, Kendari', 85.50, 2, 2137500.00, 106875.00, 0.00, 2244375.00, 2244375.00, '2025-11-03 09:23:37', 'pending', NULL, NULL),
(26, 'Ahmad Santoso', 'Jl. Pasar Ikan No. 15, Kendari', 150.75, 3, 3750000.00, 187500.00, 50000.00, 3987500.00, 3987500.00, '2025-11-03 09:32:48', 'pending', NULL, NULL),
(27, 'Siti Rahayu', 'Desa Mangunharjo, Kec. Moramo', 85.25, 2, 2131250.00, 106562.00, 0.00, 2237812.00, 2237812.00, '2025-11-03 09:35:37', 'pending', NULL, NULL),
(28, 'Budi Prasetyo', 'Jl. Samudra No. 10, Soropia', 45.50, 1, 1137500.00, 56875.00, 25000.00, 1219375.00, 1219375.00, '2025-11-03 09:37:46', 'pending', NULL, NULL),
(29, 'Ahmad Santoso', 'Jl. Pasar Ikan No. 25, Kendari', 150.75, 3, 3750000.00, 187500.00, 50000.00, 398750000.00, 3987500.00, '2025-11-06 01:01:56', 'approved', NULL, NULL),
(30, 'Budi Fisherman', 'Desa Tanjung Batu, Konawe', 85.50, 3, 1137500.00, 56000.00, 50000.00, 124350000.00, 1243500.00, '2025-11-06 01:07:12', 'approved', NULL, NULL),
(31, 'anton', 'Jalan patriot', 27.34, 1, 134500.00, 56000.00, 0.00, 19050000.00, 19050000.00, '2025-11-27 01:22:42', 'pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `karcis_kapal`
--

CREATE TABLE `karcis_kapal` (
  `id_kapal` int(11) NOT NULL,
  `nama_nelayan` varchar(100) NOT NULL,
  `nama_kapal` varchar(100) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `berat_ikan` decimal(10,2) NOT NULL,
  `jumlah_karcis` int(11) NOT NULL,
  `jumlah_penjualan` decimal(12,2) NOT NULL,
  `jasa_lelang` decimal(12,2) DEFAULT NULL,
  `lain_lain` decimal(12,2) DEFAULT NULL,
  `total` decimal(12,2) NOT NULL,
  `jumlah_bayar` decimal(12,2) NOT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `karcis_pemilik_kapal`
--

CREATE TABLE `karcis_pemilik_kapal` (
  `id` int(11) NOT NULL,
  `no_karcis` varchar(20) DEFAULT NULL,
  `nama_pemilik` varchar(100) DEFAULT NULL,
  `nama_kapal` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jenis_ikan` varchar(50) DEFAULT NULL,
  `berat` decimal(10,2) DEFAULT NULL,
  `harga` decimal(15,2) DEFAULT NULL,
  `status_verifikasi` enum('pending','approved','rejected') DEFAULT 'pending',
  `petugas_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karcis_pemilik_kapal`
--

INSERT INTO `karcis_pemilik_kapal` (`id`, `no_karcis`, `nama_pemilik`, `nama_kapal`, `tanggal`, `jenis_ikan`, `berat`, `harga`, `status_verifikasi`, `petugas_id`, `admin_id`, `created_at`) VALUES
(1, 'KPL-001-2401', 'Ahmad Fauzi', 'Ahmad Fauzi - Kapal', '2025-09-29', 'Campuran', 350.80, 8770000.00, 'pending', 3, NULL, '2025-09-29 07:07:15'),
(2, 'KPL-001-2401', 'Ahmad Fauzi', 'Ahmad Fauzi - Kapal', '2025-09-29', 'Campuran', 350.80, 8770000.00, 'pending', 3, NULL, '2025-09-29 07:59:52'),
(3, 'KPL-2024-001', 'Budi Fisherman', 'Budi Fisherman - Kapal', '2025-10-29', 'Campuran', 250.75, 6268750.00, 'pending', 2, NULL, '2025-10-29 07:07:25'),
(4, 'KPL-2024-002', 'Joko Susilo', 'Joko Susilo - Kapal', '2025-10-29', 'Campuran', 180.50, 4512500.00, 'pending', 2, NULL, '2025-10-29 07:08:37'),
(5, 'KPL-2025-003', 'Dewi Lestari', 'Dewi Lestari - Kapal', '2025-10-29', 'Campuran', 95.30, 2382500.00, 'pending', 2, NULL, '2025-10-29 07:09:29'),
(6, 'KPL-2025-001', 'Ahmad Santoso', 'Ahmad Santoso - Kapal', '2025-11-06', 'Campuran', 150.75, 3750000.00, 'pending', 1, NULL, '2025-11-06 01:10:48');

-- --------------------------------------------------------

--
-- Table structure for table `lelang`
--

CREATE TABLE `lelang` (
  `id_lelang` int(11) NOT NULL,
  `nama_lelang` varchar(255) NOT NULL,
  `tanggal_lelang` date NOT NULL,
  `harga_awal` decimal(15,2) NOT NULL,
  `harga_akhir` decimal(15,2) DEFAULT NULL,
  `pemenang` varchar(255) DEFAULT NULL,
  `status_lelang` enum('draft','berlangsung','selesai') DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lelang_ikan`
--

CREATE TABLE `lelang_ikan` (
  `id_lelang` int(11) NOT NULL,
  `jenis_ikan` varchar(100) NOT NULL,
  `tanggal_lelang` date NOT NULL,
  `lokasi_pelelangan` varchar(100) NOT NULL,
  `berat_total` decimal(10,2) NOT NULL,
  `harga_awal_per_kg` decimal(15,2) NOT NULL,
  `harga_akhir_per_kg` decimal(15,2) DEFAULT NULL,
  `total_nilai_lelang` decimal(15,2) DEFAULT NULL,
  `pemenang_lelang` varchar(255) DEFAULT NULL,
  `status_lelang` enum('draft','berlangsung','selesai') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lelang_ikan`
--

INSERT INTO `lelang_ikan` (`id_lelang`, `jenis_ikan`, `tanggal_lelang`, `lokasi_pelelangan`, `berat_total`, `harga_awal_per_kg`, `harga_akhir_per_kg`, `total_nilai_lelang`, `pemenang_lelang`, `status_lelang`, `created_at`) VALUES
(1, 'Tuna Sirip Kuning', '2024-01-15', 'PPI Kendari', 5000.50, 25000.00, 32000.00, 160016000.00, 'PT Sumber Laut Jaya', 'selesai', '2025-09-27 14:28:04'),
(2, 'Cakalang', '2024-01-18', 'TPI Ambon', 3000.75, 18000.00, 22000.00, 66016500.00, 'CV Mina Sejahtera', 'selesai', '2025-09-27 14:28:04'),
(3, 'Tongkol', '2024-01-20', 'PPI Bitung', 2000.25, 15000.00, 19000.00, 38004750.00, 'PT Hasil Laut Indonesia', 'selesai', '2025-09-27 14:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `log_verifikasi`
--

CREATE TABLE `log_verifikasi` (
  `id_log` int(11) NOT NULL,
  `id_karcis` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `verified_by` int(11) NOT NULL,
  `verified_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_verifikasi`
--

INSERT INTO `log_verifikasi` (`id_log`, `id_karcis`, `status`, `verified_by`, `verified_at`) VALUES
(1, 23, 'verified', 1, '2025-10-31 16:14:44'),
(2, 23, 'verified', 1, '2025-10-31 16:14:53'),
(3, 23, 'verified', 1, '2025-10-31 23:41:48'),
(4, 22, 'verified', 1, '2025-10-31 23:42:04'),
(5, 21, 'verified', 1, '2025-10-31 23:42:13'),
(6, 4, 'verified', 1, '2025-10-31 23:42:29'),
(7, 5, 'verified', 1, '2025-10-31 23:42:51'),
(8, 20, 'verified', 1, '2025-11-01 00:49:49'),
(9, 19, 'verified', 1, '2025-11-01 01:16:41'),
(10, 18, 'verified', 1, '2025-11-01 05:47:44'),
(11, 17, 'verified', 1, '2025-11-01 07:37:42'),
(12, 16, 'verified', 1, '2025-11-01 07:37:56'),
(13, 15, 'approved', 1, '2025-11-01 07:43:40'),
(14, 14, 'approved', 1, '2025-11-01 07:53:37'),
(15, 13, 'approved', 1, '2025-11-01 07:53:46'),
(16, 12, 'approved', 1, '2025-11-01 08:01:15'),
(17, 11, 'approved', 1, '2025-11-01 08:01:25'),
(18, 10, 'approved', 1, '2025-11-01 08:11:33'),
(19, 9, 'approved', 1, '2025-11-01 08:11:38'),
(20, 8, 'approved', 1, '2025-11-01 08:11:43'),
(21, 7, 'approved', 1, '2025-11-01 08:11:48'),
(22, 6, 'approved', 1, '2025-11-01 08:11:53'),
(23, 3, 'rejected', 1, '2025-11-01 08:12:13'),
(24, 2, 'rejected', 1, '2025-11-01 08:13:16'),
(25, 1, 'rejected', 1, '2025-11-01 08:13:22'),
(26, 3, 'rejected', 1, '2025-11-01 08:38:14'),
(27, 2, 'rejected', 1, '2025-11-01 08:38:24'),
(28, 1, 'rejected', 1, '2025-11-01 08:38:29'),
(29, 24, 'rejected', 1, '2025-11-03 16:39:14'),
(30, 29, 'approved', 1, '2025-11-06 01:02:54'),
(31, 30, 'approved', 1, '2025-11-06 01:09:08');

-- --------------------------------------------------------

--
-- Table structure for table `peserta_lelang`
--

CREATE TABLE `peserta_lelang` (
  `id_peserta` int(11) NOT NULL,
  `id_lelang` int(11) DEFAULT NULL,
  `nama_peserta` varchar(255) NOT NULL,
  `harga_penawaran` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peserta_lelang_ikan`
--

CREATE TABLE `peserta_lelang_ikan` (
  `id_peserta` int(11) NOT NULL,
  `id_lelang` int(11) DEFAULT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `harga_penawaran_per_kg` decimal(15,2) NOT NULL,
  `jumlah_penawaran_kg` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peserta_lelang_ikan`
--

INSERT INTO `peserta_lelang_ikan` (`id_peserta`, `id_lelang`, `nama_perusahaan`, `harga_penawaran_per_kg`, `jumlah_penawaran_kg`) VALUES
(1, 1, 'PT Sumber Laut Jaya', 32000.00, 5000.50),
(2, 1, 'CV Lautan Mas', 30000.00, 5000.50),
(3, 1, 'PT Perikanan Nusantara', 28000.00, 5000.50),
(4, 2, 'CV Mina Sejahtera', 22000.00, 3000.75),
(5, 2, 'PT Fish Processing', 20000.00, 3000.75);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('petugas','admin') DEFAULT 'petugas',
  `tpi_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `tpi_id`) VALUES
(1, 'admin', '$2a$12$4txTYOYM2Z3GzeWX9gzYT.KYUG/FMtzyBvRKzJVkwiAKwgLnpiSlW', 'admin', NULL),
(2, 'petugas1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'petugas', NULL),
(3, 'petugas', '$2y$10$iDmlYYap4aKlXss8hKl/2uz05TSr6HKVTf6DTwJlFc0D9i/9mjjEC', 'petugas', NULL),
(5, 'test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'petugas', 1),
(7, 'demo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'petugas', 1);

-- --------------------------------------------------------

--
-- Table structure for table `verifikasi_history`
--

CREATE TABLE `verifikasi_history` (
  `id` int(11) NOT NULL,
  `karcis_id` int(11) NOT NULL,
  `karcis_type` enum('bakul','pemilik_kapal') NOT NULL,
  `admin_id` int(11) NOT NULL,
  `action` enum('approved','rejected') NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `karcis_bakul`
--
ALTER TABLE `karcis_bakul`
  ADD PRIMARY KEY (`id_bakul`);

--
-- Indexes for table `karcis_kapal`
--
ALTER TABLE `karcis_kapal`
  ADD PRIMARY KEY (`id_kapal`);

--
-- Indexes for table `karcis_pemilik_kapal`
--
ALTER TABLE `karcis_pemilik_kapal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lelang`
--
ALTER TABLE `lelang`
  ADD PRIMARY KEY (`id_lelang`);

--
-- Indexes for table `lelang_ikan`
--
ALTER TABLE `lelang_ikan`
  ADD PRIMARY KEY (`id_lelang`);

--
-- Indexes for table `log_verifikasi`
--
ALTER TABLE `log_verifikasi`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `peserta_lelang`
--
ALTER TABLE `peserta_lelang`
  ADD PRIMARY KEY (`id_peserta`),
  ADD KEY `id_lelang` (`id_lelang`);

--
-- Indexes for table `peserta_lelang_ikan`
--
ALTER TABLE `peserta_lelang_ikan`
  ADD PRIMARY KEY (`id_peserta`),
  ADD KEY `id_lelang` (`id_lelang`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `verifikasi_history`
--
ALTER TABLE `verifikasi_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `karcis_bakul`
--
ALTER TABLE `karcis_bakul`
  MODIFY `id_bakul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `karcis_kapal`
--
ALTER TABLE `karcis_kapal`
  MODIFY `id_kapal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karcis_pemilik_kapal`
--
ALTER TABLE `karcis_pemilik_kapal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lelang`
--
ALTER TABLE `lelang`
  MODIFY `id_lelang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lelang_ikan`
--
ALTER TABLE `lelang_ikan`
  MODIFY `id_lelang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `log_verifikasi`
--
ALTER TABLE `log_verifikasi`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `peserta_lelang`
--
ALTER TABLE `peserta_lelang`
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peserta_lelang_ikan`
--
ALTER TABLE `peserta_lelang_ikan`
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `verifikasi_history`
--
ALTER TABLE `verifikasi_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peserta_lelang`
--
ALTER TABLE `peserta_lelang`
  ADD CONSTRAINT `peserta_lelang_ibfk_1` FOREIGN KEY (`id_lelang`) REFERENCES `lelang` (`id_lelang`);

--
-- Constraints for table `peserta_lelang_ikan`
--
ALTER TABLE `peserta_lelang_ikan`
  ADD CONSTRAINT `peserta_lelang_ikan_ibfk_1` FOREIGN KEY (`id_lelang`) REFERENCES `lelang_ikan` (`id_lelang`);

--
-- Constraints for table `verifikasi_history`
--
ALTER TABLE `verifikasi_history`
  ADD CONSTRAINT `verifikasi_history_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
