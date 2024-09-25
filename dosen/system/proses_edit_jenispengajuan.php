<!DOCTYPE html>
<html>
<head>
    <link href="../../assets/css/loader.css" rel="stylesheet" />
</head>
<body onload="myFunction()" style="margin:0;">
 
<div id="loader"></div>

<?php 
include '../../system/koneksi.php';

$id = $_POST['id'];
$periode = $_POST['periode'];
$status = $_POST['status'];
$keterangan = $_POST['keterangan']; // Menambahkan variabel keterangan

$tanggal = mktime(date("m"), date("d"), date("Y"));
$tgl = date("Y-m-d", $tanggal);

// Perbaikan query: menambahkan keterangan
$query = "UPDATE pendaftaran SET periode='$periode', status='$status', keterangan='$keterangan' WHERE id='$id'";
$result = mysqli_query($con, $query);

// Periksa apakah query berhasil dijalankan
if (!$result) {
    die("Query gagal dijalankan: " . mysqli_errno($con) . " - " . mysqli_error($con));
}

// Redirect setelah berhasil update data
header("Location: ../pendaftaran?proses=ubah");
exit();
?>
</body>
</html>
