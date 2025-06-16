<?php
// Masukkan koneksi database
include 'koneksi.php';
session_start();

// Pastikan pengguna sudah login
if (empty($_SESSION['email'])) {
    echo "<script type='text/javascript'>document.location='../login?proses=error';</script>";
    exit();
}

$email = $_SESSION['email'];
$query_cek = "SELECT * FROM user WHERE email = ?";
$stmt = $con->prepare($query_cek);
$stmt->bind_param("s", $email);
$stmt->execute();
$result_cek = $stmt->get_result();
$data_cek = $result_cek->fetch_assoc();

// Cek apakah user yang login adalah mahasiswa
if ($data_cek['role'] !== "mahasiswa") {
    echo "<script type='text/javascript'>window.location=history.go(-1);</script>";
    exit();
}

// Ambil data yang dikirimkan dari form
$nama_depan = $_POST['nama']; // Nama yang sudah terisi dari form
$tanggal = $_POST['tanggal'];
$laporan_harian = $_POST['laporan_harian'];

// Pastikan data yang dibutuhkan tidak kosong
if (empty($nama_depan) || empty($tanggal) || empty($laporan_harian)) {
    echo "<script type='text/javascript'>
            alert('Harap lengkapi semua data!');
            window.history.back();
          </script>";
    exit();
}

// Query untuk menyimpan laporan ke database
$query_simpan = "INSERT INTO laporan_harian (nama_depan, tanggal, laporan_harian) VALUES (?, ?, ?)";
$stmt_simpan = $con->prepare($query_simpan);

if ($stmt_simpan) {
    // Bind parameter untuk query, pastikan nilai tidak NULL
    $stmt_simpan->bind_param("sss", $nama_depan, $tanggal, $laporan_harian); // 's' untuk string

    // Eksekusi query
    if ($stmt_simpan->execute()) {
        echo "<script type='text/javascript'>
                    alert('Laporan berhasil disimpan!');
                    window.location.href = '../kegiatan.php?proses=simpan1'; 
                  </script>";
    } else {
        echo "<script type='text/javascript'>
                    alert('Gagal menyimpan laporan. Coba lagi.');
                    window.history.back();
                  </script>";
    }

    // Tutup prepared statement
    $stmt_simpan->close();
} else {
    echo "<script type='text/javascript'>
                alert('Terjadi kesalahan. Coba lagi nanti.');
                window.history.back();
              </script>";
}

// Tutup koneksi
$con->close();
?>
