-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2021 at 06:59 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `k_means`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_hasil_cluster`
--

CREATE TABLE `data_hasil_cluster` (
  `id` int(11) NOT NULL,
  `id_keluarga` varchar(28) NOT NULL,
  `cluster` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_hasil_cluster`
--

INSERT INTO `data_hasil_cluster` (`id`, `id_keluarga`, `cluster`) VALUES
(1, '1174020002000005', 'Cluster2'),
(2, '1174020002000006', 'Cluster3'),
(3, '1174020002000029', 'Cluster1'),
(4, '1174020002000087', 'Cluster1'),
(5, '1174020002000106', 'Cluster1');

-- --------------------------------------------------------

--
-- Table structure for table `data_keluarga`
--

CREATE TABLE `data_keluarga` (
  `id_keluarga` varchar(20) NOT NULL,
  `nama_keluarga` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `kota` varchar(128) NOT NULL,
  `provinsi` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_keluarga`
--

INSERT INTO `data_keluarga` (`id_keluarga`, `nama_keluarga`, `alamat`, `kota`, `provinsi`) VALUES
('1174020002000005', 'MAWARDI A. RANI', 'DSN A', 'PALOH BATE', 'MUARA DUA'),
('1174020002000006', 'M RUSLI AHMAD', 'DSN A', 'PALOH BATE', 'MUARA DUA'),
('1174020002000029', 'M ISA MUSA', 'DSN A', 'PALOH BATE', 'MUARA DUA'),
('1174020002000087', 'NURMA PUTEH', 'DSN A', 'PALOH BATE', 'MUARA DUA'),
('1174020002000106', 'ABDUL MANAN ISHAQ', 'DSN A', 'PALOH BATE', 'MUARA DUA');

-- --------------------------------------------------------

--
-- Table structure for table `data_keluarga_kriteria`
--

CREATE TABLE `data_keluarga_kriteria` (
  `id` int(11) NOT NULL,
  `nama_kriteria` varchar(20) NOT NULL,
  `id_keluarga` varchar(25) NOT NULL,
  `id_kriteria` varchar(25) NOT NULL,
  `nilai` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_keluarga_kriteria`
--

INSERT INTO `data_keluarga_kriteria` (`id`, `nama_kriteria`, `id_keluarga`, `id_kriteria`, `nilai`) VALUES
(1, 'Luas Lantai', '1174020002000029', 'KTR001', '100.0'),
(2, 'Lantai', '1174020002000029', 'KTR004', '2'),
(3, 'Dinding', '1174020002000029', 'KTR002', '1'),
(4, 'Atap', '1174020002000029', 'KTR003', '6'),
(5, 'Kloset', '1174020002000029', 'KTR005', '1'),
(6, 'Luas Lantai', '1174020002000005', 'KTR001', '50.0'),
(7, 'Lantai', '1174020002000005', 'KTR004', '1'),
(8, 'Dinding', '1174020002000005', 'KTR002', '1'),
(9, 'Atap', '1174020002000005', 'KTR003', '1'),
(10, 'Kloset', '1174020002000005', 'KTR005', '1'),
(11, 'Luas Lantai', '1174020002000006', 'KTR001', '100.0'),
(12, 'Lantai', '1174020002000006', 'KTR004', '3'),
(13, 'Dinding', '1174020002000006', 'KTR002', '6'),
(14, 'Atap', '1174020002000006', 'KTR003', '6'),
(15, 'Kloset', '1174020002000006', 'KTR005', '3'),
(16, 'Luas Lantai', '1174020002000087', 'KTR001', '100.0'),
(17, 'Lantai', '1174020002000087', 'KTR004', '3'),
(18, 'Dinding', '1174020002000087', 'KTR002', '1'),
(19, 'Atap', '1174020002000087', 'KTR003', '6'),
(20, 'Kloset', '1174020002000087', 'KTR005', '1'),
(21, 'Luas Lantai', '1174020002000106', 'KTR001', '100.0'),
(22, 'Lantai', '1174020002000106', 'KTR004', '3'),
(23, 'Dinding', '1174020002000106', 'KTR002', '1'),
(24, 'Atap', '1174020002000106', 'KTR003', '6'),
(25, 'Kloset', '1174020002000106', 'KTR005', '1');

-- --------------------------------------------------------

--
-- Table structure for table `data_kriteria`
--

CREATE TABLE `data_kriteria` (
  `id_kriteria` varchar(20) NOT NULL,
  `nama_kriteria` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_kriteria`
--

INSERT INTO `data_kriteria` (`id_kriteria`, `nama_kriteria`) VALUES
('KTR001', 'Luas Lantai'),
('KTR002', 'Dinding'),
('KTR003', 'atap'),
('KTR004', 'Lantai'),
('KTR005', 'Kloset');

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id` int(11) NOT NULL,
  `id_kriteria` varchar(128) NOT NULL,
  `nama_sub` varchar(128) NOT NULL,
  `nilai` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id`, `id_kriteria`, `nama_sub`, `nilai`) VALUES
(19, 'KTR002', 'Tembok', '1'),
(20, 'KTR002', 'Plasteran anyaman bambu/kawat', '2'),
(21, 'KTR002', 'Kayu', '3'),
(22, 'KTR002', 'Ayaman Bambu', '4'),
(23, 'KTR002', 'Batang Kayu', '5'),
(24, 'KTR002', 'Bambu', '6');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jk` enum('laki-laki','perempuan') NOT NULL,
  `nik` varchar(16) NOT NULL,
  `password` text NOT NULL,
  `level` enum('1','2','3','4') NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `jk`, `nik`, `password`, `level`, `status`) VALUES
(2, 'Admin Fuzzy', 'laki-laki', 'admin', '$2y$10$4r14fo5.rUigL6qIGn9laOr63eW1J9yYF30ApB3CXdJBjWV.DdXy6', '1', '1'),
(9, 'NAMA PETUGAS', 'laki-laki', '117012910990002', '$2y$10$efJGWcN44BmticSQ5BGh..9b.yHpWl8JBHfpz.x05Dsq0Y1L5l4vu', '2', '1'),
(10, 'NAMA PETUGAS CAMAT', 'laki-laki', '1108041208980001', '$2y$10$MvsY25jPbdwNEOE0V/PI3OU772ZIIZ2CHYLt5dphF1zsp8P/AhK4S', '3', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_hasil_cluster`
--
ALTER TABLE `data_hasil_cluster`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_keluarga`
--
ALTER TABLE `data_keluarga`
  ADD PRIMARY KEY (`id_keluarga`);

--
-- Indexes for table `data_keluarga_kriteria`
--
ALTER TABLE `data_keluarga_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_kriteria`
--
ALTER TABLE `data_kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_hasil_cluster`
--
ALTER TABLE `data_hasil_cluster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `data_keluarga_kriteria`
--
ALTER TABLE `data_keluarga_kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
