-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 08:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stock_barang`
--

-- --------------------------------------------------------

--
-- Table structure for table `keluar`
--

CREATE TABLE `keluar` (
  `idkeluar` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `penerima` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keluar`
--

INSERT INTO `keluar` (`idkeluar`, `idbarang`, `tanggal`, `penerima`, `qty`) VALUES
(5, 1, '2024-11-05 15:55:51', 'Pembeli', 100),
(7, 1, '2024-11-05 16:17:49', 'pengepul', 20),
(10, 12, '2024-11-09 08:00:28', 'Pembeli', 55),
(11, 14, '2024-11-10 07:34:48', 'Pasar', 25),
(12, 17, '2024-11-12 04:55:13', 'Pembeli', 16),
(13, 17, '2024-11-12 04:56:07', 'Toko', 50),
(14, 18, '2024-11-12 05:02:11', 'Toko', 25),
(15, 17, '2024-11-21 12:46:23', 'toko', 50),
(16, 20, '2024-11-28 17:00:43', 'toko', 12);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`iduser`, `email`, `password`) VALUES
(2, 'admin@gmail.com', '12345'),
(4, 'alfin@gmail.com', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `keterangan` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idbarang`, `tanggal`, `keterangan`, `qty`) VALUES
(11, 1, '2024-11-05 14:56:37', 'made', 255),
(13, 6, '2024-11-05 15:53:44', 'gading', 25),
(15, 12, '2024-11-09 07:56:57', 'toko', 55),
(16, 14, '2024-11-10 07:34:23', 'made', 50),
(17, 17, '2024-11-12 04:54:22', 'alfian', 55),
(18, 18, '2024-11-12 04:54:46', 'Made', 22),
(19, 18, '2024-11-21 12:44:54', 'made', 12),
(20, 20, '2024-11-28 17:00:08', 'Toko', 12),
(21, 17, '2024-12-02 16:09:59', 'Pasar B', 250),
(22, 21, '2024-12-03 04:54:41', 'TokoA', 12);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `idpeminjaman` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggalpinjam` timestamp NOT NULL DEFAULT current_timestamp(),
  `qty` int(11) NOT NULL,
  `peminjam` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`idpeminjaman`, `idbarang`, `tanggalpinjam`, `qty`, `peminjam`, `status`) VALUES
(1, 17, '2024-11-13 16:48:25', 55, 'hery', 'Kembali'),
(2, 18, '2024-11-14 05:40:31', 25, 'tokoA', 'Kembali'),
(5, 17, '2024-11-14 05:42:44', 25, 'toko a', 'Kembali'),
(7, 17, '2024-11-14 05:44:08', 10, 'toko', 'Kembali'),
(8, 17, '2024-11-14 05:54:00', 10, 'pak hery', 'Kembali'),
(9, 17, '2024-11-19 10:03:40', 12, 'tokoc', 'Kembali'),
(10, 17, '2024-11-21 13:03:32', 12, 'toko a', 'Kembali'),
(11, 21, '2024-12-03 04:56:05', 12, 'Made', 'Kembali');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `idbarang` int(11) NOT NULL,
  `namabarang` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`idbarang`, `namabarang`, `deskripsi`, `stock`, `image`) VALUES
(17, 'Mangga', 'Buah', 250, '5a731902c6ebd181ea8889cea5870b53.jpg'),
(18, 'Jambu Air Dalhari', 'Buah', 64, '2c8ae5a49d0a1e40b499d5b1a828b2cb.jpg'),
(20, 'Jambu Klutuk', 'Buah Lokal', 25, '20294e1b6b7a29c3897a728c67d69d0c.jpg'),
(21, 'Kelengkeng', 'Buah', 132, '34dda751447eee97566f05198e2fca4a.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keluar`
--
ALTER TABLE `keluar`
  ADD PRIMARY KEY (`idkeluar`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`);

--
-- Indexes for table `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`idpeminjaman`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idbarang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keluar`
--
ALTER TABLE `keluar`
  MODIFY `idkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `idpeminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
