-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 15 Agu 2019 pada 21.42
-- Versi server: 10.2.26-MariaDB-cll-lve
-- Versi PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dvlprstudio_facereco`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `reco_admin`
--

CREATE TABLE `reco_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reco_kehadiran`
--

CREATE TABLE `reco_kehadiran` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jam_in` varchar(100) NOT NULL,
  `jam_out` varchar(100) DEFAULT NULL,
  `foto_in` varchar(100) NOT NULL,
  `foto_out` varchar(100) DEFAULT NULL,
  `tanggal` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reco_user`
--

CREATE TABLE `reco_user` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `person_id` varchar(100) NOT NULL,
  `face_id` varchar(100) NOT NULL,
  `wajah` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `reco_admin`
--
ALTER TABLE `reco_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `reco_kehadiran`
--
ALTER TABLE `reco_kehadiran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `reco_user`
--
ALTER TABLE `reco_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_id` (`person_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `reco_admin`
--
ALTER TABLE `reco_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reco_kehadiran`
--
ALTER TABLE `reco_kehadiran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reco_user`
--
ALTER TABLE `reco_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
