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

// Cek jika user bukan mahasiswa
if ($data_cek['role'] !== "mahasiswa") {
    echo "<script type='text/javascript'>window.location=history.go(-1);</script>";
    exit();
}

// Mendapatkan nilai lapangan dari form input (misalnya)
$nilai_lapangan = isset($_POST['file_nilai_lapangan']) ? $_POST['file_nilai_lapangan'] : 0;

// Memperbarui nilai_lapangan di tabel pendaftaran dengan join berdasarkan email user
$query_update_nilai = "UPDATE pendaftaran p 
    JOIN user u ON p.nim = u.nim 
    SET p.file_nilai_lapangan = ? 
    WHERE u.email = ?";

$stmt_update = $con->prepare($query_update_nilai);
$stmt_update->bind_param("is", $file_nilai_lapangan, $email);

if ($stmt_update->execute()) {
    echo "<script type='text/javascript'>alert('Pengajuan berhasil!'); window.location='../presentasi';</script>";
} else {
    echo "<script type='text/javascript'>alert('Terjadi kesalahan, nilai lapangan gagal diperbarui.'); window.location='dashboard';</script>";
}

$stmt_update->close();
$con->close();
?>
