<?php
include "koneksi.php";
session_start();

// Cek jika user belum login
if (empty($_SESSION['email'])) {
    echo "<script type='text/javascript'>document.location='login?proses=error';</script>";
    exit();
}

// Mengambil data user yang login
$email = $_SESSION['email'];
$query_cek = "SELECT * FROM user WHERE email = ?";
$stmt = $con->prepare($query_cek);
$stmt->bind_param("s", $email);
$stmt->execute();
$result_cek = $stmt->get_result();
$data_cek = $result_cek->fetch_assoc();

if ($data_cek['role'] !== "mahasiswa") {
    echo "<script type='text/javascript'>window.location=history.go(-1);</script>";
    exit();
}

// Mendapatkan data dari form
$dosen_wali = $_POST['dosen_wali'];
$nama = $_POST['nama'];
$nim = $_POST['nim'];
$kelas = $_POST['kelas'];
$no_whatsapp = $_POST['no_whatsapp'];
$ipk = $_POST['ipk'];
$total_sks = $_POST['total_sks'];
$program = $_POST['program'];
$periode = $_POST['periode'];

// Proses upload file
$cv = $_FILES['cv']['name'];
$khs = $_FILES['khs']['name'];
$portofolio = $_FILES['portofolio']['name'];

$cv_temp = $_FILES['cv']['tmp_name'];
$khs_temp = $_FILES['khs']['tmp_name'];
$portofolio_temp = $_FILES['portofolio']['tmp_name'];

// Menentukan direktori upload
$upload_dir = 'uploads/';
$cv_path = $upload_dir . basename($cv);
$khs_path = $upload_dir . basename($khs);
$portofolio_path = $upload_dir . basename($portofolio);

// Memindahkan file ke direktori upload jika file di-upload
if (!empty($cv) && !move_uploaded_file($cv_temp, $cv_path)) {
    echo "<script type='text/javascript'>alert('Gagal meng-upload CV.'); window.location='pengajuan';</script>";
    exit();
}
if (!empty($khs) && !move_uploaded_file($khs_temp, $khs_path)) {
    echo "<script type='text/javascript'>alert('Gagal meng-upload KHS.'); window.location='pengajuan';</script>";
    exit();
}
if (!empty($portofolio) && !move_uploaded_file($portofolio_temp, $portofolio_path)) {
    echo "<script type='text/javascript'>alert('Gagal meng-upload Portofolio.'); window.location='pengajuan';</script>";
    exit();
}

// Menyimpan data ke database
$query_insert = "INSERT INTO pendaftaran 
    (dosen_wali, nama, nim, kelas, nomor_whatsapp, ipk, total_sks, cv, program, periode, khs, portofolio) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $con->prepare($query_insert);

// Menyesuaikan tipe data parameter
// 's' untuk string, 'b' untuk binary (file)
$stmt->bind_param("ssssssssssss", $dosen_wali, $nama, $nim, $kelas, $no_whatsapp, $ipk, $total_sks, $cv, $program, $periode, $khs, $portofolio);

if ($stmt->execute()) {
    echo "<script type='text/javascript'>alert('Pengajuan berhasil!'); window.location='../pendaftaran';</script>";
} else {
    echo "<script type='text/javascript'>alert('Terjadi kesalahan. Silakan coba lagi.'); window.location='pengajuan';</script>";
}

$stmt->close();
$con->close();
