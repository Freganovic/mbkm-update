<!DOCTYPE html>
<html>

<head>
  <link href="../../assets/css/loader.css" rel="stylesheet" />
</head>

<body onload="myFunction()" style="margin:0;">

  <div id="loader"></div>

  <?php
  include '../../system/koneksi.php';

  if (isset($_POST['input'])) {

    $jenis_pengajuan         = $_POST['jenis_pengajuan'];
    $deskripsi               = $_POST['deskripsi'];
    $periode           = $_POST['periode'];
    $tgl_mulai               = $_POST['tgl_mulai'];
    $tgl_selesai             = $_POST['tgl_selesai'];

    $cekdulu = "SELECT * FROM jenis_pengajuan WHERE jenis_pengajuan='$jenis_pengajuan'";
    $prosescek = mysqli_query($con, $cekdulu);
    if (mysqli_num_rows($prosescek) > 0) {
      header("location:../tambah_jenispengajuan?error=true");
    } else {

      $query = "INSERT INTO jenis_pengajuan SET jenis_pengajuan='$jenis_pengajuan', deskripsi='$deskripsi', periode='$periode', tgl_mulai='$tgl_mulai', tgl_selesai='$tgl_selesai'";
      $result = mysqli_query($con, $query);
      if (!$result) {
        die("Query gagal dijalankan: " . mysqli_errno($con) .
          " - " . mysqli_error($con));
      }
      header("location:../jenis_pengajuan?proses=tambah");
    }
  }
  ?>

</body>

</html>