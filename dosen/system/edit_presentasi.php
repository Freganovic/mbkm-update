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
$nama = $_POST['nama'];
$nim = $_POST['nim'];
$kelas = $_POST['kelas'];
$pembimbing = $_POST['pembimbing'];
$jenis = $_POST['jenis'];
$jadwal = $_POST['jadwal'];
$lokasi = $_POST['lokasi'];
$nilai = $_POST['nilai'];

$tanggal= mktime(date("m"),date("d"),date("Y"));
$tgl = date("Y-m-d", $tanggal);

$query = "UPDATE pendaftaran SET periode='$periode', pembimbing='$pembimbing', jenis='$jenis' , jadwal='$jadwal' , nilai='$nilai' , lokasi='$lokasi' WHERE id ='$id'";
  $result = mysqli_query($con, $query);
  // periska query apakah ada error
  if(!$result){
      die ("Query gagal dijalankan: ".mysqli_errno($con).
           " - ".mysqli_error($con));

  }
header("location:../presentasi?proses=ubah"); 
?>
</body>
</html>