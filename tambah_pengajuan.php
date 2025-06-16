<?php
include "system/koneksi.php";
session_start();

if (empty($_SESSION['email'])) {
    echo "<script type='text/javascript'>document.location='login?proses=error';</script>";
    exit();
}

$logged_in = true;
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

function tanggal_indo($tanggal)
{
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/icon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Pengajuan</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet" />
    <link href="assets/css/demo.css" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/dist/sweetalert.css">
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="blue" data-image="assets/img/sidebar.jpg">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="index" class="simple-text">
                        <?php
                        $query_login = "SELECT * FROM user WHERE email = ?";
                        $stmt = $con->prepare($query_login);
                        $stmt->bind_param("s", $email);
                        $stmt->execute();
                        $result_login = $stmt->get_result();
                        $data_login = $result_login->fetch_assoc();
                        $id_login = $data_login["id_user"];
                        $username_login = $data_login["username"];
                        ?>
                        System MBKM<br><small>( TIM ) - <?php echo htmlspecialchars($username_login, ENT_QUOTES, 'UTF-8'); ?></small>
                    </a>
                </div>
                <ul class="nav">
                    <li>
                        <a href="index">
                            <i class="pe pe-7s-home"></i>
                            <p>Home</p>
                        </a>
                    </li>
                    <li class="active">
                        <a href="pengajuan">
                            <i class="pe pe-7s-note2"></i>
                            <p>Pengajuan</p>
                        </a>
                    </li>
                    <li>
                        <a href="riwayat">
                            <i class="pe pe-7s-timer"></i>
                            <p>Riwayat</p>
                        </a>
                    </li>
                    <li>
                        <a href="notifikasi">
                            <i class="pe pe-7s-bell"></i>
                            <?php
                            $query_notifikasi = "SELECT a.id_riwayat FROM riwayat AS a
                                                INNER JOIN pengajuan AS b ON a.id_pengajuan = b.id_pengajuan
                                                WHERE b.id_user = ? AND a.notifikasi = '1'";
                            $stmt = $con->prepare($query_notifikasi);
                            $stmt->bind_param("i", $id_login);
                            $stmt->execute();
                            $result_notifikasi = $stmt->get_result();
                            $banyakdata_notifikasi = $result_notifikasi->num_rows;
                            ?>
                            <p>Notifikasi
                                <?php
                                if ($banyakdata_notifikasi > 0) {
                                    $hasil = $banyakdata_notifikasi <= 10 ? $banyakdata_notifikasi : "10 +";
                                    echo "<span class='new badge'>$hasil</span>";
                                }
                                ?>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="profil">
                            <i class="pe pe-7s-user"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="logout()">
                            <i class="pe pe-7s-back"></i>
                            <p>Log out</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="title">Pengajuan</h4>
                                        </div>
                                        <div class="col-md-6" align="right">
                                            <?php echo '<small>' . tanggal_indo(date("Y-m-d")) . '</small>'; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="content">
                                    <form id="form_user" method="post" action="system/proses_tambah_pengajuan" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Pengajuan</label>
                                                    <input type="text" name="pengajuan" id="form_pengajuan" class="form-control" placeholder="Pengajuan" required
                                                        oninvalid="this.setCustomValidity('Mohon isi form berikut !')"
                                                        oninput="setCustomValidity('')">
                                                    <input type="hidden" name="id_pengaju" value="<?php echo htmlspecialchars($id_login, ENT_QUOTES, 'UTF-8'); ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jenis Pengajuan</label>
                                                    <br>
                                                    <div class="col-md-12">
                                                        <select name="id_jenis_pengajuan" class="form-control" required
                                                            oninvalid="this.setCustomValidity('Mohon isi form berikut !')"
                                                            oninput="setCustomValidity('')">
                                                            <?php
                                                            $query = "SELECT * FROM jenis_pengajuan";
                                                            $result = mysqli_query($con, $query);
                                                            if (!$result) {
                                                                die("Query Error: " . mysqli_errno($con) . " - " . mysqli_error($con));
                                                            }
                                                            while ($data = mysqli_fetch_assoc($result)) {
                                                                echo '<option value="' . htmlspecialchars($data['id_jenis_pengajuan'], ENT_QUOTES, 'UTF-8') . '" title="Diskripsi : ' . htmlspecialchars($data['deskripsi'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($data['jenis_pengajuan'], ENT_QUOTES, 'UTF-8') . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Biaya</label>
                                                    <br>
                                                    <div class="col-md-1">
                                                        Rp.
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="number" name="biaya" class="form-control" placeholder="Biaya" required
                                                            oninvalid="this.setCustomValidity('Mohon isi form berikut !')"
                                                            oninput="setCustomValidity('')">
                                                    </div>
                                                    <div class="col-md-1">
                                                        ,00,-
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Gambar</label>
                                                    <input id="preview" style="visibility:hidden;" accept="image/png, image/jpeg, image/jpg" type="file" name="gambar" onchange="readURL(this);" />
                                                    <label for="preview" class="btn btn-primary btn-fill">Pilih Gambar</label>
                                                    <label>Ukuran Maksimal : 1MB</label>
                                                    <br>
                                                    <img id="preview_gambar" src="#" alt="Preview" style="display:none;" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <textarea rows="5" name="keterangan" class="form-control" placeholder="Silakan Tulis Keterangan Anda Disini"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alasan</label>
                                                    <textarea rows="5" name="alasan" class="form-control" placeholder="Silakan Tulis Alasan Anda Disini"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div align="right">
                                            <a href="pengajuan">
                                                <button type="button" class="btn btn-info btn-fill">
                                                    <i class="fa fa-arrow-left"></i> Batal
                                                </button>
                                            </a>
                                            <button type="submit" name="input" class="btn btn-primary btn-fill">
                                                <i class="fa fa-check"></i> Ajukan
                                            </button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/dist/sweetalert-dev.js"></script>
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>
    <script src="assets/js/chartist.min.js"></script>
    <script src="assets/js/bootstrap-notify.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="assets/js/light-bootstrap-dashboard.js"></script>
    <script src="assets/js/demo.js"></script>
    <?php
    if (isset($_GET['proses'])) {
        echo '<script type="text/javascript">';
        $proses = $_GET["proses"];
        switch ($proses) {
            case "error":
                echo 'swal({
                    title: "Mohon Maaf!",
                    text: "Terjadi kesalahan !",
                    type: "error",
                    showConfirmButton: true,
                    confirmButtonColor: "#00ff00"
                });';
                break;
            case "size":
                echo 'swal({
                    title: "Mohon Maaf!",
                    text: "Ukuran gambar terlalu besar !",
                    type: "error",
                    showConfirmButton: true,
                    confirmButtonColor: "#00ff00"
                });';
                break;
            case "format":
                echo 'swal({
                    title: "Mohon Maaf!",
                    text: "Format gambar tidak sesuai !",
                    type: "error",
                    showConfirmButton: true,
                    confirmButtonColor: "#00ff00"
                });';
                break;
        }
        echo '</script>';
    }
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            demo.initChartist();
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview_gambar')
                        .attr('src', e.target.result)
                        .show()
                        .width(250);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function logout() {
            swal({
                    title: "Konfirmasi ?",
                    text: "Apakah anda ingin keluar ",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#00cc00",
                    confirmButtonText: "Logout",
                    cancelButtonText: "Batal",
                    closeOnConfirm: false
                },
                function() {
                    document.location = "logout";
                });
        }
    </script>
</body>

</html>