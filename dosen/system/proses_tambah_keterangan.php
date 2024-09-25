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

        $keterangan = $_POST['keterangan'];

        $cekdulu = "SELECT * FROM pendaftaran WHERE keterangan='$keterangan'";
        $prosescek = mysqli_query($con, $cekdulu);
        if (mysqli_num_rows($prosescek) > 0) {
            header("location:../pendaftaran?error=true");
        } else {

            $query = "INSERT INTO pendaftaran (keterangan) VALUES ('$keterangan')";
            $result = mysqli_query($con, $query);
            if (!$result) {
                die("Query gagal dijalankan: " . mysqli_errno($con) .
                    " - " . mysqli_error($con));
            }
            header("location:../pendaftaran?proses=tambah");
        }
    }
    ?>

</body>

</html>