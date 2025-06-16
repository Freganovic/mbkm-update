<?php
session_start();
include "system/koneksi.php";

// Pastikan pengguna sudah login
if (empty($_SESSION['email'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='../login.php';</script>";
    exit();
}

// Ambil data pengguna yang sedang login
$email = $_SESSION['email'];
$query_user = "SELECT nama_depan FROM user WHERE email = ?";
$stmt_user = $con->prepare($query_user);
$stmt_user->bind_param("s", $email);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$data_user = $result_user->fetch_assoc();
$nama_depan = $data_user['nama_depan'];
$stmt_user->close();

// Pastikan ada file yang diunggah
if (!isset($_FILES['laporan_file']) || $_FILES['laporan_file']['error'] != UPLOAD_ERR_OK) {
    echo "<script>alert('Gagal mengunggah file!'); window.history.back();</script>";
    exit();
}

// Konfigurasi upload file
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$file_name = basename($_FILES["laporan_file"]["name"]);
$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
$file_size = $_FILES["laporan_file"]["size"];
$file_tmp = $_FILES["laporan_file"]["tmp_name"];
$file_new_name = $nama_depan . "_" . time() . "." . $file_ext;
$target_file = $target_dir . $file_new_name;
$allowed_ext = ["pdf", "doc", "docx"];

// Validasi file
if (!in_array(strtolower($file_ext), $allowed_ext)) {
    echo "<script>alert('Format file tidak diizinkan! Hanya PDF, DOC, atau DOCX.'); window.history.back();</script>";
    exit();
}

if ($file_size > 2 * 1024 * 1024) { // Maksimal 2MB
    echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.'); window.history.back();</script>";
    exit();
}

// Simpan file ke folder uploads
if (move_uploaded_file($file_tmp, $target_file)) {
    // Simpan informasi ke database
    $query_upload = "INSERT INTO laporan_akhir (nama_depan, file_laporan, tanggal_upload) VALUES (?, ?, NOW())";
    $stmt_upload = $con->prepare($query_upload);
    $stmt_upload->bind_param("ss", $nama_depan, $file_new_name);

    if ($stmt_upload->execute()) {
        echo "<script>alert('Laporan berhasil diunggah!'); window.location.href='kegiatan.php?proses=simpan1';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan ke database!'); window.history.back();</script>";
    }

    $stmt_upload->close();
} else {
    echo "<script>alert('Gagal mengunggah file! Coba lagi.'); window.history.back();</script>";
}

// Tutup koneksi
$con->close();
?>
