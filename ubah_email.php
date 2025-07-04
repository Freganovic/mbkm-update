<?php
include 'system/koneksi.php';
session_start();
$logged_in = false;
if (empty($_SESSION['email'])) {
    echo "<script type='text/javascript'>document.location='login?proses=error ';</script>";
} else {
    $logged_in = true;

    $query_cek = "SELECT * FROM user WHERE email ='$_SESSION[email]'";
    $result_cek = mysqli_query($con, $query_cek);
    $data_cek = mysqli_fetch_assoc($result_cek);

    if ($data_cek['role'] == "mahasiswa") {
    } else {
        echo "<script type='text/javascript'>window.location=history.go(-1);</script>";
    }
}

$query_login = "SELECT * FROM user WHERE email ='$_SESSION[email]'";
$result_login = mysqli_query($con, $query_login);
if (!$result_login) {
    die("Query Error: " . mysqli_errno($con) .
        " - " . mysqli_error($con));
}
$data = mysqli_fetch_assoc($result_login);
$id = $data["id_user"];
$username = $data["username"];
$email = $data["email"];
$namadepan = $data["nama_depan"];
$namabelakang = $data["nama_belakang"];
$jk = $data["jk"];
$nohp = $data["no_hp"];
$alamat = $data["alamat"];
$role = $data["role"];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/icon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Profil</title>
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
                        System Pengajuan<br><small>( TIM ) - <?php echo $username ?></small>
                    </a>
                </div>

                <ul class="nav">
                    <li>
                        <a href="index">
                            <i class="pe pe-7s-home"></i>
                            <p>Home</p>
                        </a>
                    </li>
                    <li>
                        <a href="pendaftaran">
                            <i class="fa fa-check-square"></i>
                            <p>Pendaftaran MBKM</p>
                        </a>
                    </li>
                    <li>
                        <a href="presentasi">
                            <i class="pe-7s-display1"></i> <!-- Ikon layar presentasi -->
                            <p>Presentasi dan Input Nilai</p>
                        </a>
                    </li>
                    <li class="active">
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
                                    <h4 class="title">Ubah Email</h4>
                                </div>
                                <div class="content">
                                    <form id="form_edit_user" method="post" action="system/proses_ubah_email">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Email Lama Anda</label>
                                                    <input type="email" name="email" id="form_edit_user" class="form-control" placeholder="Email" disabled value="<?php echo $email ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="hidden" name="id" value="<?php echo $id ?>">
                                                    <label>Email</label>
                                                    <input type="email" name="email" id="form_edit_user" class="form-control" placeholder="Email" required
                                                        oninvalid="this.setCustomValidity('Mohon sesuikan form berikut !')"
                                                        oninput="setCustomValidity('')">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Konfirmasi Password</label>
                                                    <input type="password" name="password" id="form_edit_user" class="form-control" placeholder="Password anda" required
                                                        oninvalid="this.setCustomValidity('Mohon isi form berikut !')"
                                                        oninput="setCustomValidity('')">
                                                </div>
                                            </div>
                                        </div>
                                        <div align="right">
                                            <a href="profil">
                                                <button type="button" name="input" rel="tooltip" title="Konfirmasi" class="btn btn-info btn-fill">
                                                    <i class="fa fa-arrow-left"></i> Kembali
                                                </button>
                                            </a>
                                            <button type="submit" name="input" rel="tooltip" title="Konfirmasi" class="btn btn-primary btn-fill">
                                                <i class="fa fa-edit"></i> Konfirmasi
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


</body>
<script src="assets/dist/sweetalert-dev.js"></script>
<script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>
<script src="assets/js/chartist.min.js"></script>
<script src="assets/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="assets/js/light-bootstrap-dashboard.js"></script>
<script src="assets/js/demo.js"></script>

<?php
if (isset($_GET['error'])) {
    echo '<script type="text/javascript">';
    $error = ($_GET["error"]);
    if ($error == "true1") {
        echo 'swal({
                title: "Mohon Maaf!",
                text: "Email Sudah ada yang menggunakan ",
                type: "error",
                showConfirmButton: true,
                confirmButtonColor: "#00ff00"
            })';
    }
    if ($error == "true2") {
        echo 'swal({
                title: "Mohon Maaf!",
                text: "Password lama anda salah",
                type: "error",
                showConfirmButton: true,
                confirmButtonColor: "#00ff00"
            })';
    }
    echo '</script>';
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        demo.initChartist();
    });

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
            })
    }
</script>

</html>