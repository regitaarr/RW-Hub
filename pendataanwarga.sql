-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 04:16 AM
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
-- Database: `pendataanwarga`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_rw`
--

CREATE TABLE `admin_rw` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(10) NOT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_rw`
--

INSERT INTO `admin_rw` (`id_admin`, `username`, `password`, `email`) VALUES
(1, 'pakrw', '123', 'rw2@xyz.com');

-- --------------------------------------------------------

--
-- Table structure for table `warga_pendatang`
--

CREATE TABLE `warga_pendatang` (
  `nik` varchar(16) NOT NULL,
  `no_kk` varchar(16) DEFAULT NULL,
  `nama` varchar(25) DEFAULT NULL,
  `tempat_lahir` text DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Perempuan','Laki-laki') DEFAULT NULL,
  `agama` varchar(15) NOT NULL,
  `pekerjaan` enum('Tidak Bekerja','Pelajar','Mahasiswa','Wiraswasta','Wirausaha','PNS','Guru','Buruh','Lainnya') DEFAULT NULL,
  `pendidikan` enum('Tidak/Belum Sekolah','Belum Tamat SD/Sederajat','Tamat SD/Sederajat','SLTP/Sederajat','SLTA/Sederajat','Diploma I/II','Akademi/Diploma III/S.Muda','Diploma IV/Strata I','Strata II','Strata III') DEFAULT NULL,
  `alamat_asal` text DEFAULT NULL,
  `alamat_tujuan` text DEFAULT NULL,
  `alasan_pindah` enum('Pekerjaan','Pendidikan','Keamanan','Kesehatan','Perumahan','Keluarga','Lainnya') DEFAULT NULL,
  `tanggal_pindah` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warga_pendatang`
--

INSERT INTO `warga_pendatang` (`nik`, `no_kk`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `pekerjaan`, `pendidikan`, `alamat_asal`, `alamat_tujuan`, `alasan_pindah`, `tanggal_pindah`) VALUES
('2934567890123475', '3934567890123475', 'Lina Septiani', 'Semarang', '1990-06-10', 'Perempuan', 'Islam', 'PNS', 'Strata II', 'Melati RT29/RW01, Semarang Selatan, Semarang, Jawa Tengah', 'Kubangpari RT29/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Kesehatan', '2022-07-19'),
('3034567890123476', '4034567890123476', 'Rian Pratama', 'Surabaya', '1987-05-27', 'Laki-laki', 'Kristen', 'Guru', 'Strata II', 'Kenanga RT30/RW01, Rungkut, Surabaya, Jawa Timur', 'Kubangpari RT30/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pendidikan', '2023-09-10'),
('3134567890123477', '4134567890123477', 'Rina Hartati', 'Jakarta', '1993-02-25', 'Perempuan', 'Islam', 'Pelajar', 'SLTA/Sederajat', 'Bougenville RT31/RW01, Pancoran, Jakarta Selatan, DKI Jakarta', 'Kubangpari RT31/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Keamanan', '2024-01-20'),
('3234567890123478', '4234567890123478', 'Johan Santosa', 'Medan', '1992-03-18', 'Laki-laki', 'Budha', 'Wiraswasta', '', 'Teratai RT32/RW01, Medan Maimun, Medan, Sumatera Utara', 'Kubangpari RT32/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2023-06-30'),
('3334567890123479', '4334567890123479', 'Dewi Santika', 'Makassar', '1990-08-12', 'Perempuan', 'Hindu', 'Guru', '', 'Anggrek RT33/RW01, Panakkukang, Makassar, Sulawesi Selatan', 'Kubangpari RT33/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pendidikan', '2022-12-08'),
('3434567890123480', '4434567890123480', 'Iwan Budianto', 'Bali', '1991-04-02', 'Laki-laki', 'Islam', 'Wiraswasta', 'SLTA/Sederajat', 'Cempaka RT34/RW01, Denpasar Utara, Denpasar, Bali', 'Kubangpari RT34/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2022-09-15'),
('3534567890123481', '4534567890123481', 'Siti Haryanti', 'Padang', '1986-11-03', 'Perempuan', 'Islam', 'Wirausaha', 'Tamat SD/Sederajat', 'Teratai RT35/RW01, Padang Barat, Padang, Sumatera Barat', 'Kubangpari RT35/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Keluarga', '2023-02-19'),
('3634567890123482', '4634567890123482', 'Budi Kurniawan', 'Surakarta', '1992-07-14', 'Laki-laki', 'Kristen', 'PNS', '', 'Bougenville RT36/RW01, Surakarta, Jawa Tengah', 'Kubangpari RT36/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Perumahan', '2023-03-02'),
('3734567890123483', '4734567890123483', 'Putri Cahyani', 'Pontianak', '1993-01-06', 'Perempuan', 'Islam', 'Mahasiswa', '', 'Melati RT37/RW01, Pontianak Selatan, Pontianak, Kalimantan Barat', 'Kubangpari RT37/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Lainnya', '2024-02-14'),
('3834567890123484', '4834567890123484', 'Aditya Prasetya', 'Banjarmasin', '1990-09-25', 'Laki-laki', 'Islam', 'Pelajar', 'SLTA/Sederajat', 'Sakura RT38/RW01, Banjarmasin Utara, Banjarmasin, Kalimantan Selatan', 'Kubangpari RT38/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Keamanan', '2023-07-05'),
('3934567890123485', '4934567890123485', 'Nani Kurniasari', 'Surabaya', '1996-04-17', 'Perempuan', 'Katolik', 'Wiraswasta', '', 'Kenanga RT39/RW01, Taman, Surabaya, Jawa Timur', 'Kubangpari RT39/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2023-08-28'),
('4034567890123486', '5034567890123486', 'Ika Kurniati', 'Jakarta', '1994-03-21', 'Perempuan', 'Islam', 'Wiraswasta', 'Strata II', 'Flamboyan RT40/RW01, Kebayoran Lama, Jakarta Selatan, DKI Jakarta', 'Kubangpari RT40/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pendidikan', '2023-12-06'),
('4134567890123487', '5134567890123487', 'Yosef Wijayanto', 'Medan', '1995-12-03', 'Laki-laki', 'Kristen', 'PNS', '', 'Teratai RT41/RW01, Medan Helvetia, Medan, Sumatera Utara', 'Kubangpari RT41/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Perumahan', '2024-06-25'),
('4234567890123488', '5234567890123488', 'Rina Lestari', 'Makassar', '1989-01-21', 'Perempuan', 'Islam', 'Guru', '', 'Bougenville RT42/RW01, Makassar, Sulawesi Selatan', 'Kubangpari RT42/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pendidikan', '2022-10-10'),
('4334567890123489', '5334567890123489', 'Andi Rudianto', 'Bali', '1985-06-05', 'Laki-laki', 'Hindu', 'Wiraswasta', 'SLTA/Sederajat', 'Cempaka RT43/RW01, Denpasar Selatan, Denpasar, Bali', 'Kubangpari RT43/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2023-03-30'),
('4434567890123490', '5434567890123490', 'Lina Wahyuni', 'Padang', '1994-10-09', 'Perempuan', 'Islam', 'Pelajar', 'SLTA/Sederajat', 'Teratai RT44/RW01, Padang Selatan, Padang, Sumatera Barat', 'Kubangpari RT44/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Keamanan', '2024-04-02'),
('4534567890123491', '5534567890123491', 'Dian Nuraini', 'Surakarta', '1988-11-11', 'Perempuan', 'Kristen', 'Wiraswasta', '', 'Bougenville RT45/RW01, Surakarta, Jawa Tengah', 'Kubangpari RT45/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2023-07-20'),
('4634567890123492', '5634567890123492', 'Sulastri Wulandari', 'Bandung', '1991-07-05', 'Perempuan', 'Islam', 'Tidak Bekerja', '', 'Cempaka RT46/RW01, Buahbatu, Bandung, Jawa Barat', 'Kubangpari RT46/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Keluarga', '2023-10-17'),
('4734567890123493', '5734567890123493', 'Rudi Setiawan', 'Surabaya', '1989-03-21', 'Laki-laki', 'Kristen', 'Wiraswasta', 'Strata II', 'Kenanga RT47/RW01, Surabaya, Jawa Timur', 'Kubangpari RT47/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2022-12-12'),
('4834567890123494', '5834567890123494', 'Maya Hapsari', 'Jakarta', '1992-02-08', 'Perempuan', 'Islam', 'Guru', '', 'Flamboyan RT48/RW01, Jakarta Selatan, DKI Jakarta', 'Kubangpari RT48/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pendidikan', '2023-04-20'),
('4934567890123495', '5934567890123495', 'Hendra Pratama', 'Medan', '1987-11-12', 'Laki-laki', 'Konghucu', 'Tidak Bekerja', 'SLTA/Sederajat', 'Teratai RT49/RW01, Medan, Sumatera Utara', 'Kubangpari RT49/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2023-06-08'),
('5034567890123496', '6034567890123496', 'Halimah Sari', 'Makassar', '1993-01-16', 'Perempuan', 'Islam', 'Mahasiswa', '', 'Bougenville RT50/RW01, Makassar, Sulawesi Selatan', 'Kubangpari RT50/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Lainnya', '2024-01-30'),
('5134567890123497', '6134567890123497', 'Firman Ramadhan', 'Bali', '1994-06-25', 'Laki-laki', 'Hindu', 'Wiraswasta', 'SLTA/Sederajat', 'Cempaka RT51/RW01, Denpasar, Bali', 'Kubangpari RT51/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2023-11-18'),
('5234567890123498', '6234567890123498', 'Ika Nurhaliza', 'Padang', '1995-07-10', 'Perempuan', 'Islam', 'PNS', 'Strata II', 'Teratai RT52/RW01, Padang, Sumatera Barat', 'Kubangpari RT52/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Perumahan', '2023-09-14'),
('5334567890123499', '6334567890123499', 'Arman Fauzi', 'Surakarta', '1990-10-22', 'Laki-laki', 'Kristen', 'Wiraswasta', '', 'Bougenville RT53/RW01, Surakarta, Jawa Tengah', 'Kubangpari RT53/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2022-08-17'),
('5434567890123500', '6434567890123500', 'Desi Marlina', 'Pontianak', '1988-12-28', 'Perempuan', 'Konghucu', 'Tidak Bekerja', 'Strata II', 'Melati RT54/RW01, Pontianak, Kalimantan Barat', 'Kubangpari RT54/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pendidikan', '2024-05-23'),
('5534567890123501', '6534567890123501', 'Budi Rahayu', 'Banjarmasin', '1993-08-09', 'Laki-laki', 'Islam', 'Guru', '', 'Sakura RT55/RW01, Banjarmasin, Kalimantan Selatan', 'Kubangpari RT55/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pendidikan', '2022-11-16'),
('5634567890123502', '6634567890123502', 'Anita Pertiwi', 'Surabaya', '1996-03-04', 'Perempuan', 'Katolik', 'Mahasiswa', '', 'Kenanga RT56/RW01, Surabaya, Jawa Timur', 'Kubangpari RT56/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Lainnya', '2023-10-12'),
('5734567890123503', '6734567890123503', 'Krisna Wijaya', 'Jakarta', '1990-11-18', 'Laki-laki', 'Islam', 'Wiraswasta', 'Strata II', 'Flamboyan RT57/RW01, Jakarta, DKI Jakarta', 'Kubangpari RT57/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2022-12-20'),
('5834567890123504', '6834567890123504', 'Laila Rizki', 'Medan', '1992-05-03', 'Perempuan', 'Buddha', 'PNS', '', 'Teratai RT58/RW01, Medan, Sumatera Utara', 'Kubangpari RT58/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Perumahan', '2023-05-22'),
('5934567890123505', '6934567890123505', 'Irwan Setiawan', 'Makassar', '1985-09-30', 'Laki-laki', 'Hindu', 'Wiraswasta', 'SLTA/Sederajat', 'Bougenville RT59/RW01, Makassar, Sulawesi Selatan', 'Kubangpari RT59/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2023-01-17'),
('6034567890123506', '7034567890123506', 'Ariani Pratiwi', 'Bali', '1996-12-14', 'Perempuan', 'Islam', 'Pelajar', 'SLTA/Sederajat', 'Cempaka RT60/RW01, Denpasar, Bali', 'Kubangpari RT60/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Keamanan', '2024-04-05'),
('6134567890123507', '7134567890123507', 'Heru Setyawan', 'Padang', '1994-01-10', 'Laki-laki', 'Kristen', 'Lainnya', 'Strata II', 'Teratai RT61/RW01, Padang, Sumatera Barat', 'Kubangpari RT61/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Kesehatan', '2023-11-04'),
('6234567890123508', '7234567890123508', 'Rita Handayani', 'Surakarta', '1993-04-22', 'Perempuan', 'Islam', 'Wirausaha', 'SLTA/Sederajat', 'Bougenville RT62/RW01, Surakarta, Jawa Tengah', 'Kubangpari RT62/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2023-07-15'),
('6334567890123509', '7334567890123509', 'Angga Pratama', 'Yogyakarta', '1994-07-01', 'Laki-laki', 'Islam', 'Wiraswasta', '', 'Melati RT63/RW01, Yogyakarta, Daerah Istimewa Yogyakarta', 'Kubangpari RT63/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2023-09-14'),
('6434567890123510', '7434567890123510', 'Siti Fadilah', 'Banda Aceh', '1992-05-10', 'Perempuan', 'Islam', 'Lainnya', '', 'Sakura RT64/RW01, Banda Aceh, Aceh', 'Kubangpari RT64/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Keluarga', '2023-06-25'),
('6534567890123511', '7534567890123511', 'Michael Hendrik', 'Surabaya', '1991-02-22', 'Laki-laki', 'Kristen', 'PNS', 'Strata II', 'Kenanga RT65/RW01, Surabaya, Jawa Timur', 'Kubangpari RT65/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Perumahan', '2024-01-10'),
('6634567890123512', '7634567890123512', 'Rina Puspitasari', 'Bandung', '1990-11-30', 'Perempuan', 'Budha', 'PNS', 'Strata II', 'Flamboyan RT66/RW01, Bandung, Jawa Barat', 'Kubangpari RT66/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pendidikan', '2023-11-12'),
('6734567890123513', '7734567890123513', 'Firdaus Mulyana', 'Semarang', '1989-04-08', 'Laki-laki', 'Islam', 'Mahasiswa', '', 'Anggrek RT67/RW01, Semarang, Jawa Tengah', 'Kubangpari RT67/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Lainnya', '2024-03-17'),
('6834567890123514', '7834567890123514', 'Vera Kumalasari', 'Medan', '1996-10-21', 'Perempuan', 'Kristen', 'Wiraswasta', '', 'Teratai RT68/RW01, Medan, Sumatera Utara', 'Kubangpari RT68/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2023-12-01'),
('6934567890123515', '7934567890123515', 'Taufik Ridwan', 'Padang', '1993-12-03', 'Laki-laki', 'Islam', 'PNS', 'SLTA/Sederajat', 'Sakura RT69/RW01, Padang, Sumatera Barat', 'Kubangpari RT69/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2023-11-28'),
('7034567890123516', '8034567890123516', 'Sela Yunita', 'Bali', '1995-02-10', 'Perempuan', 'Hindu', 'Pelajar', 'SLTA/Sederajat', 'Cempaka RT70/RW01, Denpasar, Bali', 'Kubangpari RT70/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Keamanan', '2024-04-22'),
('7134567890123517', '8134567890123517', 'Joko Santoso', 'Makassar', '1988-08-13', 'Laki-laki', 'Islam', 'Wiraswasta', 'SLTA/Sederajat', 'Bougenville RT71/RW01, Makassar, Sulawesi Selatan', 'Kubangpari RT71/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2023-09-08'),
('7234567890123518', '8234567890123518', 'Nina Rahmawati', 'Jakarta', '1994-01-14', 'Perempuan', 'Budha', 'Guru', '', 'Flamboyan RT72/RW01, Jakarta, DKI Jakarta', 'Kubangpari RT72/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pendidikan', '2024-02-02'),
('7334567890123519', '8334567890123519', 'Deni Pramono', 'Yogyakarta', '1992-09-05', 'Laki-laki', 'Islam', 'Wiraswasta', 'Strata II', 'Melati RT73/RW01, Yogyakarta, Daerah Istimewa Yogyakarta', 'Kubangpari RT73/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2023-11-29'),
('7434567890123520', '8434567890123520', 'Rahmawati Sari', 'Medan', '1996-05-20', 'Perempuan', 'Kristen', 'PNS', 'SLTA/Sederajat', 'Teratai RT74/RW01, Medan, Sumatera Utara', 'Kubangpari RT74/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Keluarga', '2024-01-18'),
('7534567890123521', '8534567890123521', 'Yusuf Mulyadi', 'Surabaya', '1987-03-11', 'Laki-laki', 'Hindu', 'Lainnya', 'Strata II', 'Kenanga RT75/RW01, Surabaya, Jawa Timur', 'Kubangpari RT75/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Kesehatan', '2024-02-25'),
('7634567890123522', '8634567890123522', 'Tina Mariana', 'Padang', '1992-12-30', 'Perempuan', 'Islam', 'Wirausaha', '', 'Sakura RT76/RW01, Padang, Sumatera Barat', 'Kubangpari RT76/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Pekerjaan', '2023-10-14'),
('7734567890123523', '8734567890123523', 'Alfredo Liao', 'Pontianak', '1994-06-25', 'Laki-laki', 'Kristen', 'PNS', 'Strata II', 'Dahlia RT77/RW01, Pontianak, Kalimantan Barat', 'Kubangpari RT77/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Perumahan', '2024-03-05'),
('7834567890123524', '8834567890123524', 'Cynthia Widjaja', 'Surakarta', '1989-04-30', 'Perempuan', 'Budha', 'Mahasiswa', '', 'Bougenville RT78/RW01, Surakarta, Jawa Tengah', 'Kubangpari RT78/RW02, Bangunsari, Pamarican, Ciamis, Jawa Barat', 'Lainnya', '2024-01-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_rw`
--
ALTER TABLE `admin_rw`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `warga_pendatang`
--
ALTER TABLE `warga_pendatang`
  ADD PRIMARY KEY (`nik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_rw`
--
ALTER TABLE `admin_rw`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
