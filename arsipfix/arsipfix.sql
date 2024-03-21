-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Jul 2023 pada 15.04
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `arsip_dokumen`
--

CREATE TABLE `arsip_dokumen` (
  `id_arsip_dokumen` int(11) NOT NULL,
  `kode_rekening` varchar(30) NOT NULL,
  `kegiatan` varchar(100) NOT NULL,
  `sub_kegiatan` varchar(100) NOT NULL,
  `Tanggal_kegiatan` varchar(50) NOT NULL,
  `Target_lokasi` varchar(100) NOT NULL,
  `Keterangan` varchar(100) NOT NULL,
  `file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `arsip_dokumen`
--

INSERT INTO `arsip_dokumen` (`id_arsip_dokumen`, `kode_rekening`, `kegiatan`, `sub_kegiatan`, `Tanggal_kegiatan`, `Target_lokasi`, `Keterangan`, `file`) VALUES
(122, '1.2.3.4.5.6.7.8', 'Penyuluhan Sosial Media Elektronik', 'Belanja Makanan dan Minuman Rapat', '2023-07-20', 'Yogyakarta', 'Success', '124200011_124200017_124200066_Kelompok TCC.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `kegiatan` varchar(100) NOT NULL,
  `sub_kegiatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kegiatan`
--

INSERT INTO `kegiatan` (`id_kegiatan`, `kegiatan`, `sub_kegiatan`) VALUES
(1, 'Penyuluhan Sosial Media Elektronik', 'Belanja Jasa Iklan/Reklame, Film, dan Pemotretan'),
(2, 'Penyuluahan Sosial Media Cetak', 'Belanja Makanan dan Minuman Rapat\r\n'),
(3, 'Penyuluahan Sosial Media Peraga', 'abcdef'),
(4, 'Penyuluahan Sosial Tingkat Desa', 'abcdef'),
(5, 'Penyuluahan Sosial Penguatan Kapasitas Pensosmas', 'abdef\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kode_rekening`
--

CREATE TABLE `kode_rekening` (
  `id_kode_rekening` int(11) NOT NULL,
  `kode_rekening` varchar(100) NOT NULL,
  `deskripsi_rekening` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kode_rekening`
--

INSERT INTO `kode_rekening` (`id_kode_rekening`, `kode_rekening`, `deskripsi_rekening`) VALUES
(1, '1.2.3.4.5.6.7.8', 'aaaaaaaaa'),
(2, '44.00', 'sssssss'),
(3, '223.00.00', 'qqqqqqqqq');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pdf_data`
--

CREATE TABLE `pdf_data` (
  `id` int(50) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pdf_data`
--

INSERT INTO `pdf_data` (`id`, `filename`) VALUES
(11, '124200011_124200017_124200066_Kelompok TCC.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(350) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `akses` enum('administrator','pegawai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `akses` ) VALUES
(1, 'adminarsip', '$2y$10$7sXsRJsIzSNyNPADmEK7KeXWijuVaytZaBPtnu4oYrRdeZQBHwuaG', 'Yuwan', 'administrator');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `arsip_dokumen`
--
ALTER TABLE `arsip_dokumen`
  ADD PRIMARY KEY (`id_arsip_dokumen`);

--
-- Indeks untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indeks untuk tabel `kode_rekening`
--
ALTER TABLE `kode_rekening`
  ADD PRIMARY KEY (`id_kode_rekening`);

--
-- Indeks untuk tabel `pdf_data`
--
ALTER TABLE `pdf_data`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `arsip_dokumen`
--
ALTER TABLE `arsip_dokumen`
  MODIFY `id_arsip_dokumen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `kode_rekening`
--
ALTER TABLE `kode_rekening`
  MODIFY `id_kode_rekening` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=384;

--
-- AUTO_INCREMENT untuk tabel `pdf_data`
--
ALTER TABLE `pdf_data`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
