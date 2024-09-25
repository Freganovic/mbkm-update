<?php
include '../system/koneksi.php';
session_start();
$logged_in = false;
if (empty($_SESSION['email'])) {
    echo "<script type='text/javascript'>document.location='../login?proses=error ';</script>";
} else {
    $logged_in = true;

    $query_cek = "SELECT * FROM user WHERE email ='$_SESSION[email]'";
    $result_cek = mysqli_query($con, $query_cek);
    $data_cek = mysqli_fetch_assoc($result_cek);

    if ($data_cek['role'] == "dosen") {
    } else {
        echo "<script type='text/javascript'>window.location=history.go(-1);</script>";
    }
}
if (isset($_GET['id'])) {
    $id = ($_GET["id"]);
    $query = "SELECT * FROM pendaftaran WHERE id ='$id'";
    $result = mysqli_query($con, $query);
    if (!$result) {
        die("Query Error: " . mysqli_errno($con) .
            " - " . mysqli_error($con));
    }
    $data = mysqli_fetch_assoc($result);
    $id = $data["id"];
    $periode       = $data["periode"];
    $program = $data["program"];
    $dosen_wali = $data["dosen_wali"];
    $nama = $data["nama"];
    $nim = $data["nim"];
    $kelas = $data["kelas"];
    $nomor_whatsapp = $data["nomor_whatsapp"];
    $ipk = $data["ipk"];
    $total_sks = $data["total_sks"];
    $cv  = $data["cv"];
    $khs = $data["khs"];
    $portofolio = $data["portofolio"];
    $status = $data["status"];
    $keterangan = $data["keterangan"];
    $nilai = $data["nilai"];
    $jadwal = $data["jadwal"];
    $pembimbing = $data["pembimbing"];
    $jenis = $data["jenis"];
    $jadwal = $data["jadwal"];
    $lokasi = $data["lokasi"];
    $nilai = $data["nilai"];
}
// Ambil data dosen dari database
$query_dosen = "SELECT nama_depan FROM user WHERE role = 'dosen'";
$result_dosen = mysqli_query($con, $query_dosen);

if (!$result_dosen) {
    die("Query Error: " . mysqli_errno($con) . " - " . mysqli_error($con));
}

$dosen_options = '';
while ($data_dosen = mysqli_fetch_assoc($result_dosen)) {
    $dosen_options .= '<option value="' . htmlspecialchars($data_dosen['nama_depan']) . '">' . htmlspecialchars($data_dosen['nama_depan']) . '</option>';
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../assets/img/icon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Jenis Pengajuan</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/animate.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css" rel="stylesheet" />
    <link href="../assets/css/demo.css" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/dist/sweetalert.css">
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="green" data-image="../assets/img/sidebar.jpg">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="index" class="simple-text">
                        <?php
                        $query_login = "SELECT * FROM user WHERE email ='$_SESSION[email]'";
                        $result_login = mysqli_query($con, $query_login);
                        if (!$result_login) {
                            die("Query Error: " . mysqli_errno($con) .
                                " - " . mysqli_error($con));
                        }
                        $data_login = mysqli_fetch_assoc($result_login);
                        $username = $data_login["username"];
                        ?>
                        System MBKM UPB<br><small>( DOSEN ) - <?php echo $username ?></small>
                    </a>
                </div>
                <ul class="nav">
                    <li>
                        <a href="index">
                            <i class="pe pe-7s-graph"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="pendaftaran">
                            <i class="fa fa-check-square"></i>
                            <p>Pendaftaran MBKM</p>
                        </a>
                    </li>
                    <li class="active">
                        <a href="presentasi">
                            <i class="pe-7s-display1"></i> <!-- Ikon layar presentasi -->
                            <p>Presentasi dan Input Nilai</p>
                        </a>
                    </li>
                    <li>
                        <a href="profil">
                            <i class="pe pe-7s-user"></i>
                            <p>Profil</p>
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
                                    <h4 class="title">EDIT PRESENTASI MBKM</h4>
                                </div>
                                <div class="content">
                                    <form id="form_edit_jenispengajuan" method="post" action="system/edit_presentasi">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>PERIODE MBKM</label>
                                                    <input type="hidden" name="id" value="<?php echo $id ?>">
                                                    <input type="text" name="periode" id="periode" class="form-control" placeholder="periode" value="<?php echo $periode ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>NAMA</label>
                                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="nama" value="<?php echo $nama ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>NIM</label>
                                                    <input type="text" name="nim" id="nim" class="form-control" placeholder="nim" value="<?php echo $nim ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>KELAS</label>
                                                    <input type="text" name="kelas" id="kelas" class="form-control" placeholder="kelas" value="<?php echo $kelas ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>DOSEN WALI</label>
                                                    <input type="text" name="dosen_wali" id="dosen_wali" class="form-control" placeholder="dosen wali" value="<?php echo $dosen_wali ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>DOSEN PEMBIMBING</label>
                                                    <input type="text" name="pembimbing" id="pembimbing" class="form-control" placeholder="PEMBIMBING" value="<?php echo $pembimbing ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>JADWAL PRESENTASI</label>
                                                    <input type="datetime-local" name="jadwal" id="jadwal" class="form-control"
                                                        value="<?php echo isset($jadwal) && !empty($jadwal) ? date('Y-m-d\TH:i', strtotime($jadwal)) : ''; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>JENIS PRESENTASI</label>
                                                    <select name="jenis" id="jenis" class="form-control" required>
                                                        <option value="offline">Offline</option>
                                                        <option value="online">Online</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>LOKASI PRESENTASI</label>
                                                    <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Masukkan lokasi" value="<?php echo htmlspecialchars($lokasi, ENT_QUOTES, 'UTF-8'); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>NILAI AKADEMIK</label>
                                                    <input type="number" name="nilai" id="nilai" class="form-control" value="<?php echo $nilai ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div align="right">
                                            <a href="presentasi">
                                                <button type="button" rel="tooltip" class="btn btn-info btn-fill">
                                                    <i class="fa fa-arrow-left"></i> Kembali
                                                </button>
                                            </a>
                                            <button type="submit" name="input" rel="tooltip" title="Konfirmasi" class="btn btn-primary btn-fill">
                                                <i class="fa fa-edit"></i> Simpan
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
<script src="../assets/dist/sweetalert-dev.js"></script>
<script src="../assets/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../assets/js/bootstrap-checkbox-radio-switch.js"></script>
<script src="../assets/js/chartist.min.js"></script>
<script src="../assets/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="../assets/js/light-bootstrap-dashboard.js"></script>
<script src="../assets/js/demo.js"></script>
<?php
if (isset($_GET['error'])) {
    echo '<script type="text/javascript">';
    $error = ($_GET["error"]);
    if ($error == "true") {
        echo 'swal({
                title: "Mohon Maaf!",
                text: "Jenis pengajuan yang anda masukan sudah ada!",
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
                document.location = "../logout";
            })
    }
</script>

</html>