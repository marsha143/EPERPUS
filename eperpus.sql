-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2025 at 10:51 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eperpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `logged_in_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama`, `email`, `role`, `created_at`, `updated_at`, `logged_in_at`) VALUES
(1, 'admin123', '$2y$10$mUKoyIpTolwplqFGbwqjSu13ebP8hEgGNsYa6XiQwiXXW1ZfpRzm6', 'Administrator', 'admin@example.com', 'admin', '2025-11-06 05:00:00', '2025-11-06 05:00:00', '2025-11-06 05:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nim_nidn` varchar(15) NOT NULL,
  `program_studi` varchar(50) NOT NULL,
  `waktu_bergabung` text NOT NULL,
  `alamat` text NOT NULL,
  `noHP` varchar(15) NOT NULL,
  `jenis_kelamin` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `logged_in_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `username`, `password`, `role`, `nama`, `nim_nidn`, `program_studi`, `waktu_bergabung`, `alamat`, `noHP`, `jenis_kelamin`, `created_at`, `updated_at`, `logged_in_at`) VALUES
(24, 'putri', '$2y$10$Gg0jN84hQjbwvUJGeLH.o.aXSCPFHW0ncIU5NCw03RDfUmMH9ky9q', 'anggota', 'Putri Marshanda', '23017894561', 'Sistem Informasi', '2025-11-12', 'Jl. Melati No. 7, Surabaya', '082345678902', 'Perempuan', '2025-11-07 03:48:16', '2025-11-09 16:29:15', '2025-11-07 03:48:16'),
(25, 'rizky', '$2y$10$3oN.buFPwBCsrXhKGo0HeOCUurjdlRNbprmoOTHa.fUrcJobcsF.6', 'anggota', 'Rizky Sabana', '22010100111', 'Desain Komunikasi Visual', '2025-11-10', 'Jl. Melati No.1, Jakarta', '082345678902', 'Laki-laki', '2025-11-07 03:55:22', '2025-11-09 17:33:26', '2025-11-07 03:55:22');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `cover` text NOT NULL,
  `judul_buku` varchar(100) NOT NULL,
  `kode_buku` varchar(5) NOT NULL,
  `isbn` varchar(14) NOT NULL,
  `nama_penulis` varchar(100) NOT NULL,
  `tahun_terbit` int(11) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `cover`, `judul_buku`, `kode_buku`, `isbn`, `nama_penulis`, `tahun_terbit`, `penerbit`, `created_at`, `updated_at`) VALUES
(0, 'https://perpustakaan.anri.go.id/lib/minigalnano/createthumb.php?filename=images/docs/WIN_20230321_11_32_43_Scan.jpg.jpg&width=200', 'KEHORMATAN YANG BERHAK', '05', '97888836252', 'joko widodo', 2006, 'takumi', '2025-11-10 07:21:25', '2025-11-10 07:22:22'),
(3, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRd8Lor6zCNrRvL9vtELSjhufUKqpD4m2Sacg&s', 'Tragedi Pedang Keadilan', '02', '9786020675442', 'Keigo Higashino', 2024, 'Gramedia', '2025-11-04 04:53:12', '2025-11-09 16:31:11'),
(5, 'https://s3-ap-southeast-1.amazonaws.com/ebook-previews/40678/143505/1.jpg', 'Laut Bercerita', '01', '9786024246945', 'Leila S. Chudori', 2017, 'Gramedia', '2025-11-04 05:18:11', '2025-11-09 17:01:25');

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan`
--

CREATE TABLE `kunjungan` (
  `id_kunjungan` int(11) NOT NULL,
  `nim_nidn` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kunjungan`
--

INSERT INTO `kunjungan` (`id_kunjungan`, `nim_nidn`, `created_at`) VALUES
(1, '2201010021', '2025-11-06 08:05:28'),
(3, '2201010021', '2025-11-07 01:36:07'),
(5, '22010100111', '2025-11-07 06:05:44'),
(6, '2301789456', '2025-11-07 06:07:20'),
(7, '2301789456', '2025-11-07 06:10:03'),
(10, '20190010', '2025-11-02 01:22:01'),
(11, '20190001', '2025-11-02 03:10:44'),
(12, '20190002', '2025-11-01 04:48:33'),
(13, '20190003', '2025-11-01 06:05:19'),
(14, '20190004', '2025-10-31 02:44:58'),
(15, '20190005', '2025-10-31 09:23:14'),
(16, '20190006', '2025-10-30 07:37:25'),
(17, '20190007', '2025-10-30 01:59:06'),
(18, '20190008', '2025-10-29 03:17:32'),
(19, '20190009', '2025-10-29 08:42:11'),
(20, '20190010', '2025-10-28 02:30:22'),
(21, '20190001', '2025-10-28 07:19:47'),
(22, '20190002', '2025-10-27 03:11:09'),
(23, '20190003', '2025-10-27 06:52:56'),
(24, '20190004', '2025-10-26 01:41:37'),
(25, '20190005', '2025-10-26 10:27:45'),
(26, '20190006', '2025-10-25 02:53:12'),
(27, '20190007', '2025-10-25 04:38:59'),
(28, '20190008', '2025-10-24 08:07:26'),
(29, '20190009', '2025-10-24 01:12:08'),
(30, '20190010', '2025-10-23 07:46:18'),
(31, '20190001', '2025-10-23 09:25:33'),
(32, '20190002', '2025-10-22 03:13:41'),
(33, '20190003', '2025-10-22 05:44:09'),
(34, '20190004', '2025-10-21 02:09:12'),
(35, '20190005', '2025-10-21 08:27:01'),
(36, '20190006', '2025-10-20 01:51:45'),
(37, '20190007', '2025-10-20 07:18:57'),
(38, '20190008', '2025-10-19 02:10:22'),
(39, '20190009', '2025-10-19 04:33:16'),
(40, '20190010', '2025-10-18 01:57:55'),
(41, '20190001', '2025-10-18 08:14:07'),
(42, '20190002', '2025-10-17 06:23:44'),
(43, '20190003', '2025-10-17 02:05:32'),
(44, '20190004', '2025-10-16 01:47:55'),
(45, '20190005', '2025-10-16 09:12:09'),
(46, '20190006', '2025-10-15 03:25:18'),
(47, '20190007', '2025-10-14 07:58:27'),
(48, '20190008', '2025-10-13 02:40:11'),
(49, '20190009', '2025-10-12 06:19:50'),
(50, '20190010', '2025-10-10 04:02:23'),
(51, '2301789456', '2025-11-07 09:40:08'),
(52, '2301789456', '2025-11-07 10:50:18'),
(53, '23017894561', '2025-11-09 17:05:19'),
(54, '23017894561', '2025-11-10 07:45:13');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `tanggal_dikembalikan` date DEFAULT NULL,
  `denda` varchar(300) NOT NULL DEFAULT '0',
  `status` varchar(15) NOT NULL DEFAULT 'Dipinjam',
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_anggota`, `id_buku`, `tanggal_pinjam`, `tanggal_kembali`, `tanggal_dikembalikan`, `denda`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(12, 25, 5, '2025-11-09', '2025-11-16', NULL, '0', 'Dipinjam', NULL, '2025-11-09 16:28:49', '2025-11-09 16:28:49'),
(13, 25, 3, '2025-11-09', '2025-11-16', '2025-11-09', '0', 'Dikembalikan', NULL, '2025-11-09 17:15:15', '2025-11-09 17:15:15'),
(14, 25, 3, '2025-10-30', '2025-11-06', NULL, '0', 'Dipinjam', NULL, '2025-11-09 17:16:05', '2025-11-09 17:16:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `uesername` (`username`),
  ADD UNIQUE KEY `nim_nidn` (`nim_nidn`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD UNIQUE KEY `kode_buku` (`kode_buku`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD UNIQUE KEY `isbn_3` (`isbn`),
  ADD KEY `isbn_2` (`isbn`);

--
-- Indexes for table `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD PRIMARY KEY (`id_kunjungan`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_anggota` (`id_anggota`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kunjungan`
--
ALTER TABLE `kunjungan`
  MODIFY `id_kunjungan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
