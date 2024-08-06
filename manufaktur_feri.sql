-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2024 at 04:38 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manufaktur_feri`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun_admin`
--

CREATE TABLE `akun_admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(255) NOT NULL,
  `kode_admin` int(12) NOT NULL,
  `password` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun_admin`
--

INSERT INTO `akun_admin` (`id_admin`, `nama_admin`, `kode_admin`, `password`) VALUES
(1, 'admin', 123, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `beli_produk`
--

CREATE TABLE `beli_produk` (
  `id_beli` int(12) NOT NULL,
  `id_produk` varchar(20) NOT NULL,
  `username_member` varchar(30) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `tanggal_beli` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beli_produk`
--

INSERT INTO `beli_produk` (`id_beli`, `id_produk`, `username_member`, `id_admin`, `tanggal_beli`) VALUES
(15, 'bak1', 'febri12@gmail.com', 1, '2024-07-18');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_produk`
--

CREATE TABLE `kategori_produk` (
  `kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_produk`
--

INSERT INTO `kategori_produk` (`kategori`) VALUES
('Bahan Kimia'),
('elektronik\r\n'),
('kaca'),
('kayu'),
('kertas'),
('logam'),
('minuman'),
('semen');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `username_member` varchar(30) NOT NULL,
  `nama_member` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `pekerjaan` varchar(50) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `no_telepon` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`username_member`, `nama_member`, `password`, `jenis_kelamin`, `pekerjaan`, `jabatan`, `no_telepon`) VALUES
('febri12@gmail.com', 'dwi febri riyanto', '$2y$10$6BlR/Yajf5QVs9MUIhvHsunr6WsKhB9eCIGtqUcjsYyIJU4tPNJBu', 'male', 'joki', 'mahasiswa', '0822765898');

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id_produk` varchar(20) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `produk` varchar(255) NOT NULL,
  `produsen` varchar(255) NOT NULL,
  `produksi` varchar(255) NOT NULL,
  `tahun_produksi` date NOT NULL,
  `jumlah_produk` int(11) NOT NULL,
  `deskripsi_produk` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`id_produk`, `cover`, `kategori`, `produk`, `produsen`, `produksi`, `tahun_produksi`, `jumlah_produk`, `deskripsi_produk`) VALUES
('bak1', '6697a3f470e55.jpg', 'Bahan Kimia', 'kipas', 'konoha', 'pt. kimia', '2022-01-03', 4, 'tidak ada');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun_admin`
--
ALTER TABLE `akun_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `beli_produk`
--
ALTER TABLE `beli_produk`
  ADD PRIMARY KEY (`id_beli`),
  ADD KEY `pinjam_buku_ibfk_1` (`id_admin`),
  ADD KEY `pinjam_buku_ibfk_2` (`id_produk`),
  ADD KEY `pinjam_buku_ibfk_3` (`username_member`);

--
-- Indexes for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`kategori`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`username_member`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `kategori` (`kategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beli_produk`
--
ALTER TABLE `beli_produk`
  MODIFY `id_beli` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `beli_produk`
--
ALTER TABLE `beli_produk`
  ADD CONSTRAINT `beli_produk_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `akun_admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `beli_produk_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `tb_produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `beli_produk_ibfk_3` FOREIGN KEY (`username_member`) REFERENCES `member` (`username_member`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD CONSTRAINT `tb_produk_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `kategori_produk` (`kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
