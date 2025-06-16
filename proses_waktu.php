<?php
include 'system/koneksi.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login?proses=error");
    exit();
}

// Ambil ID user yang login
$email = $_SESSION['email'];
$query_user = mysqli_query($con, "SELECT * FROM user WHERE email = '$email'");
$data_user = mysqli_fetch_assoc($query_user);
$id_user = $data_user['id_user'];

if (isset($_POST['waktu_mulai']) && isset($_POST['waktu_selesai'])) {
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];

    // Cek apakah user sudah punya data waktu
    $cek = mysqli_query($con, "SELECT * FROM waktu WHERE id_user = '$id_user'");
    if (mysqli_num_rows($cek) > 0) {
        // Update
        $query = "UPDATE waktu SET waktu_mulai='$waktu_mulai', waktu_selesai='$waktu_selesai' WHERE id_user='$id_user'";
    } else {
        // Insert
        $query = "INSERT INTO waktu (id_user, waktu_mulai, waktu_selesai) VALUES ('$id_user', '$waktu_mulai', '$waktu_selesai')";
    }

    if (mysqli_query($con, $query)) {
        header("Location: kegiatan.php?proses=simpan");
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
