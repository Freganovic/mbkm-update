-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jun 2025 pada 11.04
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
-- Database: `system_pengajuan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `catatan`
--

CREATE TABLE `catatan` (
  `id_catatan` varchar(5) NOT NULL,
  `catatan` text NOT NULL,
  `update_catatan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `catatan`
--

INSERT INTO `catatan` (`id_catatan`, `catatan`, `update_catatan`) VALUES
('C1', 'pendaftaran program MBKM kampus merdeka telah di buka bagi mahasiswa yang ingin mendaftar segera mengisi form pendaftaran', '2024-09-24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_pengajuan`
--

CREATE TABLE `jenis_pengajuan` (
  `id_jenis_pengajuan` int(11) NOT NULL,
  `jenis_pengajuan` varchar(25) NOT NULL,
  `deskripsi` text NOT NULL,
  `periode` varchar(50) DEFAULT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `jenis_pengajuan`
--

INSERT INTO `jenis_pengajuan` (`id_jenis_pengajuan`, `jenis_pengajuan`, `deskripsi`, `periode`, `tgl_mulai`, `tgl_selesai`) VALUES
(2, 'MBKM', 'KAMPUS MERDEKA', 'Batch-1', '2024-09-13', '2024-09-23'),
(5, 'magang', '', 'Batch-2', '2024-09-13', '2024-09-20'),
(7, 'kampus merdeka', '', 'Batch-3', '2024-09-23', '2024-09-30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_akhir`
--

CREATE TABLE `laporan_akhir` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_depan` varchar(100) DEFAULT NULL,
  `judul_laporan` varchar(255) DEFAULT NULL,
  `file_laporan` varchar(255) DEFAULT NULL,
  `tanggal_upload` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_harian`
--

CREATE TABLE `laporan_harian` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_depan` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `laporan_harian` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan_harian`
--

INSERT INTO `laporan_harian` (`id`, `id_user`, `nama_depan`, `tanggal`, `laporan_harian`) VALUES
(1, 0, 'Rangga Aditiya', '2025-06-16', 'membuat halaman login');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` int(11) NOT NULL,
  `dosen_wali` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `nomor_whatsapp` varchar(20) NOT NULL,
  `ipk` decimal(4,2) NOT NULL,
  `total_sks` int(11) NOT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `khs` varchar(255) DEFAULT NULL,
  `portofolio` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `program` varchar(100) DEFAULT NULL,
  `periode` varchar(100) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status` enum('DIPROSES','DITERIMA','DITOLAK') NOT NULL DEFAULT 'DIPROSES',
  `pembimbing` varchar(255) DEFAULT NULL,
  `jadwal` datetime DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `nilai` int(11) DEFAULT 0,
  `jenis` enum('offline','online') NOT NULL DEFAULT 'offline',
  `nilai_lapangan` int(11) DEFAULT 0,
  `file_nilai_lapangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `dosen_wali`, `nama`, `nim`, `kelas`, `nomor_whatsapp`, `ipk`, `total_sks`, `cv`, `khs`, `portofolio`, `created_at`, `updated_at`, `program`, `periode`, `keterangan`, `status`, `pembimbing`, `jadwal`, `lokasi`, `nilai`, `jenis`, `nilai_lapangan`, `file_nilai_lapangan`) VALUES
(15, 'Irfan Afrianto, S.Kom., M.M.', 'Fadli Ramadan', '312110538', 'TI.21.A3', '0501359139', 4.00, 99, 'TUGAS_DATA MINING.pdf', 'TUGAS AGAMA.pdf', 'Proposal Skripsi Alif HT.pdf', '2024-09-18 12:32:36', '2024-09-22 05:41:55', 'magang', 'Batch-1', 'bagus', 'DITERIMA', 'Irfan Afrianto, S.Kom., M.M.', '2024-09-20 12:40:00', 'B324', 0, 'offline', 0, NULL),
(18, 'Sugeng Budi Raharjo STT', 'Alvian saputra', '312110456', 'TI.21A.AI.', '085691231111', 4.00, 99, 'TUGAS_DATA MINING.pdf', 'TUGAS AGAMA.pdf', 'Proposal Skripsi Alif HT.pdf', '2024-09-20 01:45:53', '2024-09-25 12:35:15', 'kampus merdeka', 'Batch-3', 'good', 'DITERIMA', 'Sugeng Budi Raharjo STT', '2024-09-25 12:31:00', 'https://youtu.be/KPfoHL5fzHQ?si=96hUCfic20FMZwbc', 99, 'offline', 90, NULL),
(19, 'Amali, S.T., M.Sc.', 'Bagas Saputra', '312110356', 'TI.21.A.3', '085698774546', 4.00, 88, 'TUGAS PAPER MATA KULIAH PROYEK SISTEM INFORAMASI.pdf', 'PAPER KWN, UAS, VERONIKA YUNI S. 152863.pdf', 'MANAGEMENT PROYEK.pdf', '2024-09-23 03:20:04', '2024-09-23 03:56:08', 'magang', 'Batch-1', 'sudah bagus semua acc', 'DITERIMA', 'Sugeng Budi Raharjo STT', '2024-09-25 10:44:00', 'B314', 90, 'offline', 0, NULL),
(21, 'Sugeng Budi Raharjo STT', 'angga saputra', '312110538', 'TI.21.A.3', '085695334455', 4.00, 99, 'TUGAS PAPER MATA KULIAH PROYEK SISTEM INFORAMASI.pdf', 'PAPER KWN, UAS, VERONIKA YUNI S. 152863.pdf', 'MANAGEMENT PROYEK.pdf', '2024-09-23 14:53:11', '2024-09-25 02:41:08', 'magang', 'Batch-3', 'ok', 'DITERIMA', 'Amali, S.T., M.Sc.', '2024-09-23 22:32:00', 'ruang B412', 90, 'offline', 0, NULL),
(22, 'Amali, S.T., M.Sc.', 'Rangga Aditiya', '312110534', 'TI.21.A.SE', '085695335590', 4.00, 99, 'TUGAS PAPER MATA KULIAH PROYEK SISTEM INFORAMASI.pdf', 'PAPER KWN, UAS, VERONIKA YUNI S. 152863.pdf', 'MANAGEMENT PROYEK.pdf', '2024-09-23 15:39:49', '2024-09-23 15:39:49', 'magang', 'Batch-3', NULL, 'DIPROSES', NULL, NULL, NULL, 0, 'offline', 0, NULL),
(26, 'Amali, S.T., M.Sc.', 'Umar Bin Khattab', '312110576', 'TI.21.A.SE', '086771612222', 4.00, 99, 'TUGAS PAPER MATA KULIAH PROYEK SISTEM INFORAMASI.pdf', 'PAPER KWN, UAS, VERONIKA YUNI S. 152863.pdf', 'MANAGEMENT PROYEK.pdf', '2024-09-23 16:03:20', '2024-09-25 12:22:24', 'magang', 'Batch-3', 'mantab', 'DITERIMA', 'Sugeng Budi Raharjo STT', '2024-09-30 19:22:00', 'ruang B413', 90, 'offline', 99, NULL),
(27, 'Irfan Afrianto, S.Kom., M.M.', 'Wahyu wisnu', '312110987', 'TI.21A.AI.', '085691231111', 3.80, 99, '10 point vidio digital marketing.pdf', 'msieditor,+Journal+editor,+msi+VOL+2+NO+3_10+(noneng+marthiawati).pdf', 'TUGAS PAPER MATA KULIAH PROYEK SISTEM INFORAMASI.pdf', '2024-09-26 07:47:01', '2024-09-26 07:53:04', 'kampus merdeka', 'Batch-2', 'ok bagus', 'DITERIMA', 'Sugeng Budi Raharjo STT', '2024-09-27 14:49:00', 'https://youtu.be/KPfoHL5fzHQ?si=n2M6Vl9QS3fIkv8W', 90, 'offline', 99, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id_pengajuan` int(11) NOT NULL,
  `pengajuan` varchar(225) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_jenis_pengajuan` int(11) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `gambar` varchar(225) NOT NULL,
  `biaya` int(225) NOT NULL,
  `alasan` text NOT NULL,
  `keterangan` text NOT NULL,
  `jadwal_pelaksanaan` date NOT NULL,
  `catatan` text NOT NULL,
  `status` enum('menunggu','proses','selesai') NOT NULL,
  `update_pengajuan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat`
--

CREATE TABLE `riwayat` (
  `id_riwayat` int(11) NOT NULL,
  `kegiatan` varchar(225) NOT NULL,
  `kegiatan2` varchar(225) NOT NULL,
  `kegiatan3` varchar(225) NOT NULL,
  `catatan` text NOT NULL,
  `jenis_riwayat` varchar(225) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `tanggal_kegiatan` date NOT NULL,
  `notifikasi` enum('1','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `riwayat`
--

INSERT INTO `riwayat` (`id_riwayat`, `kegiatan`, `kegiatan2`, `kegiatan3`, `catatan`, `jenis_riwayat`, `id_pengajuan`, `tanggal_kegiatan`, `notifikasi`) VALUES
(4, 'Telah Melakukan Menerima Pengajuan', 'Pengajuan diterima', 'Pengajuan Anda Telah DiTerima Oleh Pihak Manajemen', 'tes', 'Penerimaan', 4, '2017-05-08', '0'),
(7, 'Telah Melakukan Penolakan Pengajuan', 'Pengajuan Ditolak', 'Pengajuan Anda Telah DiTolak Oleh Pihak Manajemen', 'tes', 'Penolakan', 7, '2017-05-10', '0'),
(8, 'Telah Melakukan Menerima Pengajuan', 'Pengajuan diterima', 'Pengajuan Anda Telah DiTerima Oleh Pihak Manajemen', 'Pengajuan ini saya terima\r\n', 'Penerimaan', 6, '2017-05-11', '0'),
(10, 'Telah Melakukan Penolakan Pengajuan', 'Pengajuan Ditolak', 'Pengajuan Anda Telah DiTolak Oleh Pihak Manajemen', 'pengajuan ini terlalu baik buat ku', 'Penolakan', 8, '2017-05-16', '0'),
(15, 'Telah Melakukan Perubahan Pengajuan', 'Pengajuan Diubah', 'Pengajuan Anda Telah Diubah Oleh Pihak Manajemen', 'jadwal saya undur', 'Pengubahan', 4, '2017-05-19', '0'),
(16, 'Telah Melakukan Menyelesaian Pengajuan', 'Pengajuan Diselesaikan', 'Pengajuan Anda Telah Diselesaikan Oleh Pihak Manajemen', '', 'Penyelesaian', 6, '2017-05-19', '1'),
(17, 'Telah Melakukan Menerima Pengajuan', 'Pengajuan diterima', 'Pengajuan Anda Telah DiTerima Oleh Pihak Manajemen', 'pengajuan ini saya terima', 'Penerimaan', 9, '2017-05-23', '1'),
(18, 'Telah Melakukan Menerima Pengajuan', 'Pengajuan diterima', 'Pengajuan Anda Telah DiTerima Oleh Pihak Manajemen', 'acc', 'Penerimaan', 11, '2024-09-11', '0'),
(19, 'Telah Melakukan Menerima Pengajuan', 'Pengajuan diterima', 'Pengajuan Anda Telah DiTerima Oleh Pihak Manajemen', 'ok acc', 'Penerimaan', 13, '2024-09-19', '0'),
(20, 'Telah Melakukan Perubahan Pengajuan', 'Pengajuan Diubah', 'Pengajuan Anda Telah Diubah Oleh Pihak Manajemen', 'ok acc', 'Pengubahan', 13, '2024-09-19', '0'),
(21, 'Telah Melakukan Menyelesaian Pengajuan', 'Pengajuan Diselesaikan', 'Pengajuan Anda Telah Diselesaikan Oleh Pihak Manajemen', '', 'Penyelesaian', 13, '2024-09-19', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `nama_depan` varchar(225) NOT NULL,
  `nama_belakang` varchar(225) NOT NULL,
  `jk` enum('laki-laki','perempuan') NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `role` enum('manajemen','kaprodi','dosen','mahasiswa') NOT NULL,
  `pembuatan_akun` date NOT NULL,
  `update_akun` date NOT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `dosen` varchar(100) DEFAULT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `khs` varchar(255) DEFAULT NULL,
  `portofolio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `email`, `password`, `nama_depan`, `nama_belakang`, `jk`, `no_hp`, `alamat`, `role`, `pembuatan_akun`, `update_akun`, `nim`, `kelas`, `dosen`, `cv`, `khs`, `portofolio`) VALUES
(13, 'admin', 'admin@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin', 'manajemen', 'laki-laki', '45809767', 'Rumah admin', 'manajemen', '2017-04-27', '2024-09-08', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'parno', 'komar123@gmail.com', '202cb962ac59075b964b07152d234b70', 'adni', 'komar', 'laki-laki', '085691231111', 'SGC CIKARANG', 'kaprodi', '2024-09-09', '2024-09-19', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'bagus', 'bagus@gmail.com', '17b38fc02fd7e92f3edeb6318e3066d8', 'bagus', 'putra', 'laki-laki', '0501359139', 'kedondong', 'mahasiswa', '2024-09-09', '2024-09-09', '312110356', 'TI.21.A1', 'parno', NULL, NULL, NULL),
(28, 'rahmat', 'rahmat@gmail.com', 'af2a4c9d4c4956ec9d6ba62213eed568', 'rahmat', 'putra', 'laki-laki', '085695335590', 'Jl jati buniasih cikarang utara', 'mahasiswa', '2024-09-11', '2024-09-11', '312110534', 'TI.21.A3', 'AGUS', NULL, NULL, NULL),
(29, 'sugeng', 'sugeng@gmail.com', '9e28894760bdf11cb2bef7a32c020e3b', 'Sugeng Budi Raharjo STT', '', 'laki-laki', '085695335590', 'Jonggol', 'dosen', '2024-09-11', '2024-09-22', NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'Irfan', 'irfanafrianto@pelitabangsa.ac.id', '24b90bc48a67ac676228385a7c71a119', 'Irfan Afrianto, S.Kom., M.M.', '', 'laki-laki', '081299282020', 'Tambun', 'dosen', '2024-09-13', '2024-09-13', NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'FADLI', 'fadli123@gmail.com', 'd08f7ac7825653d47f66b0d79fcf1780', 'Fadli Ramadan', '', 'laki-laki', '0501359139', 'Jl jati buniasih cikarang utara', 'mahasiswa', '2024-09-18', '2024-09-18', '312110538', 'TI.21.A3', 'Irfan Afrianto, S.Kom., M.M.', NULL, NULL, NULL),
(34, 'alvian', 'alvian@gmail.com', 'e8cb77839eba5ec65525e642c3899b3b', 'Alvian saputra', '', 'laki-laki', '085691231111', 'Setu, kabupaten bekasi', 'mahasiswa', '2024-09-20', '2024-09-20', '312110456', 'TI.21A.AI.', 'Sugeng Budi Raharjo STT', NULL, NULL, NULL),
(35, 'abdul', 'abdul@gmail.com', '82027888c5bb8fc395411cb6804a066c', 'Abdul Halim Anshor, S.Kom., M.Kom.', '', 'laki-laki', '081314112180', 'cikarang timur', 'dosen', '2024-09-23', '2024-09-23', NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'fauzi', 'fauzi@gmail.com', '0bd9897bf12294ce35fdc0e21065c8a7', 'Ahmad Fauzi, S.Pd., M.Pd.', '', 'laki-laki', '08990990002', 'cikarang pusat', 'dosen', '2024-09-23', '2024-09-23', NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'amali', 'amali@gmail.com', '4289672f02464716756479a11ef87eec', 'Amali, S.T., M.Sc.', '', 'laki-laki', '0811911223', 'cibarusah', 'dosen', '2024-09-23', '2024-09-23', NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'bagas', 'bagas@gmail.com', 'ee776a18253721efe8a62e4abd29dc47', 'Bagas Saputra', '', 'laki-laki', '085698774546', 'cibarusah', 'mahasiswa', '2024-09-23', '2024-09-23', '312110356', 'TI.21.A.3', 'Amali, S.T., M.Sc.', NULL, NULL, NULL),
(39, 'tegar', 'tegar@gmail.com', '202cb962ac59075b964b07152d234b70', 'tegar kurniawan', '', 'laki-laki', '85698776546', 'cikarang', 'mahasiswa', '2024-09-23', '2024-09-23', '312110534', 'TI.21A.AI.', 'Irfan Afrianto, S.Kom., M.M.', NULL, NULL, NULL),
(40, 'ANGGA', 'angga@gmail.com', '202cb962ac59075b964b07152d234b70', 'angga saputra', '', 'laki-laki', '085695334455', 'CIKARANG UTARA', 'mahasiswa', '2024-09-23', '2024-09-23', '312110538', 'TI.21.A.3', 'Sugeng Budi Raharjo STT', NULL, NULL, NULL),
(41, 'rangga', 'rangga@gmail.com', '863c2a4b6bff5e22294081e376fc1f51', 'Rangga Aditiya', '', 'laki-laki', '085695335590', 'Jl jati buniasih cikarang utara', 'mahasiswa', '2024-09-23', '2024-09-23', '312110534', 'TI.21.A.SE', 'Amali, S.T., M.Sc.', NULL, NULL, NULL),
(43, 'umar', 'umar@gmail.com', '92deb3f274aaee236194c05729bfa443', 'Umar Bin Khattab', '', 'laki-laki', '086771612222', 'Jl jati buniasih cikarang utara', 'mahasiswa', '2024-09-23', '2024-09-23', '312110576', 'TI.21.A.SE', 'Amali, S.T., M.Sc.', NULL, NULL, NULL),
(44, 'wahyu', 'wahyu@gmail.com', '202cb962ac59075b964b07152d234b70', 'Wahyu wisnu', '', 'laki-laki', '085691231111', 'Setu, kabupaten bekasi', 'mahasiswa', '2024-09-26', '2024-09-26', '312110987', 'TI.21A.AI.', 'Irfan Afrianto, S.Kom., M.M.', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `waktu`
--

CREATE TABLE `waktu` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `waktu_mulai` date DEFAULT NULL,
  `waktu_selesai` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `waktu`
--

INSERT INTO `waktu` (`id`, `id_user`, `waktu_mulai`, `waktu_selesai`) VALUES
(1, 41, '2025-06-01', '2025-06-30');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `catatan`
--
ALTER TABLE `catatan`
  ADD PRIMARY KEY (`id_catatan`);

--
-- Indeks untuk tabel `jenis_pengajuan`
--
ALTER TABLE `jenis_pengajuan`
  ADD PRIMARY KEY (`id_jenis_pengajuan`);

--
-- Indeks untuk tabel `laporan_akhir`
--
ALTER TABLE `laporan_akhir`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan_harian`
--
ALTER TABLE `laporan_harian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`);

--
-- Indeks untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id_riwayat`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD UNIQUE KEY `username_3` (`username`);

--
-- Indeks untuk tabel `waktu`
--
ALTER TABLE `waktu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jenis_pengajuan`
--
ALTER TABLE `jenis_pengajuan`
  MODIFY `id_jenis_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `laporan_akhir`
--
ALTER TABLE `laporan_akhir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `laporan_harian`
--
ALTER TABLE `laporan_harian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `waktu`
--
ALTER TABLE `waktu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `waktu`
--
ALTER TABLE `waktu`
  ADD CONSTRAINT `waktu_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
