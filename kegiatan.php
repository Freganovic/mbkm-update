<?php
include 'system/koneksi.php';
session_start();

// Cek apakah user sudah login
if (empty($_SESSION['email'])) {
    echo "<script>document.location='login?proses=error';</script>";
    exit;
}

// Ambil data user dari email session
$email = $_SESSION['email'];
$query_user = mysqli_query($con, "SELECT * FROM user WHERE email = '$email'");
$data_user = mysqli_fetch_assoc($query_user);

if (!$data_user || $data_user['role'] !== 'mahasiswa') {
    echo "<script>window.history.back();</script>";
    exit;
}

// Variabel user
$id_user = $data_user['id_user'];
$username_login = $data_user['username'];

// Fungsi tanggal Indo
function tanggal_indo($tanggal)
{
    $bulan = array(
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
    );
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}

// Cek data waktu
$query_catatan = mysqli_query($con, "SELECT * FROM waktu WHERE id_user = '$id_user' LIMIT 1");
$data_catatan = mysqli_fetch_assoc($query_catatan);
$waktu_mulai = $waktu_selesai = "";

if ($data_catatan) {
    $waktu_mulai_raw = $data_catatan['waktu_mulai'];
    $waktu_selesai_raw = $data_catatan['waktu_selesai'];

    if (!empty($waktu_mulai_raw) && !empty($waktu_selesai_raw)) {
        $waktu_mulai = date('Y-m-d', strtotime($waktu_mulai_raw));
        $waktu_selesai = date('Y-m-d', strtotime($waktu_selesai_raw));
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Home</title>
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
                        $query_login = "SELECT * FROM user WHERE email ='$_SESSION[email]'";
                        $result_login = mysqli_query($con, $query_login);
                        if (!$result_login) {
                            die("Query Error: " . mysqli_errno($con) .
                                " - " . mysqli_error($con));
                        }
                        $data_login = mysqli_fetch_assoc($result_login);
                        $id_login = $data_login["id_user"];
                        $username_login = $data_login["username"];
                        ?>
                        System MBKM<br><small>( Mahasiswa ) - <?php echo $username_login ?></small>
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
                    <li class="active">
                        <a href="kegiatan">
                            <i class="fa fa-file-alt"></i>
                            <p>kegiatanku</p>
                        </a>
                    </li>
                    <li>
                        <a href="presentasi">
                            <i class="pe-7s-display1"></i> <!-- Ikon layar presentasi -->
                            <p>Presentasi dan Input Nilai</p>
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
                                    <h4 class="title">Waktu/Periode</h4>
                                    <?php
                                    if (!empty($waktu_mulai) && !empty($waktu_selesai)) {
                                        echo "<p class='category'>Waktu Periode: <b>" . tanggal_indo($waktu_mulai) . " - " . tanggal_indo($waktu_selesai) . "</b></p>";
                                    } else {
                                        echo "<p class='category text-danger'><b>Anda belum menentukan waktu magang</b></p>";
                                    }
                                    ?>
                                </div>
                                <div class="content">
                                    <form action="proses_waktu.php" method="POST">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Waktu Mulai:</label>
                                                    <input type="date" name="waktu_mulai" class="form-control" value="<?php echo $waktu_mulai; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Waktu Selesai:</label>
                                                    <input type="date" name="waktu_selesai" class="form-control" value="<?php echo $waktu_selesai; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-fill">
                                            <i class="fa fa-save"></i> Simpan Waktu
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <?php
                        // Pastikan pengguna sudah login
                        if (empty($_SESSION['email'])) {
                            echo "<script type='text/javascript'>document.location='../login?proses=error';</script>";
                            exit();
                        }

                        // Ambil email pengguna yang sedang login
                        $email = $_SESSION['email'];

                        // Query untuk mengambil nama_depan berdasarkan email yang sedang login
                        $query_user = "SELECT nama_depan FROM user WHERE email = ?";
                        $stmt_user = $con->prepare($query_user);
                        $stmt_user->bind_param("s", $email);
                        $stmt_user->execute();
                        $result_user = $stmt_user->get_result();
                        $data_user = $result_user->fetch_assoc();
                        $nama_depan = $data_user['nama_depan'];

                        // Ambil data laporan harian berdasarkan nama_depan yang sesuai dengan pengguna yang login
                        $query_laporan = "SELECT id_user, tanggal, laporan_harian 
                  FROM laporan_harian 
                  WHERE nama_depan = ? 
                  ORDER BY tanggal DESC";

                        $stmt_laporan = $con->prepare($query_laporan);
                        $stmt_laporan->bind_param("s", $nama_depan); // Binding parameter untuk nama_depan
                        $stmt_laporan->execute();
                        $result_laporan = $stmt_laporan->get_result();

                        if (!$result_laporan) {
                            die("Query Error: " . mysqli_errno($con) . " - " . mysqli_error($con));
                        }
                        ?>

                        <div class="col-md-9">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Laporan Harian</h4>
                                    <!-- Tombol Tambah Laporan di pojok kanan atas -->
                                    <button type="button" class="btn btn-success btn-fill" style="float: right;" onclick="window.location.href='tambah_laporan.php'">
                                        <i class="fa fa-plus"></i> Tambah Laporan
                                    </button>
                                </div>
                                <div class="content">
                                    <div class="table-full-width">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Laporan Harian</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (mysqli_num_rows($result_laporan) == 0) {
                                                    echo "<tr><td colspan='3'>belum ada laporan harian</td></tr>";
                                                } else {
                                                    while ($data_laporan = mysqli_fetch_assoc($result_laporan)) {
                                                        echo "<tr>";
                                                        echo "<td>" . date('d M Y', strtotime($data_laporan['tanggal'])) . "</td>";
                                                        echo "<td>" . htmlspecialchars($data_laporan['laporan_harian']) . "</td>";
                                                        echo "</tr>";
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Program</h4>
                                </div>
                                <div class="content">
                                    <div class="table-full-width">
                                        <table class="table">
                                            <tbody>
                                                <?php
                                                // Ambil nama pengguna yang sedang login
                                                $email = $_SESSION['email'];
                                                $query_user = "SELECT nama_depan FROM user WHERE email = ?";
                                                $stmt_user = $con->prepare($query_user);
                                                $stmt_user->bind_param("s", $email);
                                                $stmt_user->execute();
                                                $result_user = $stmt_user->get_result();
                                                $data_user = $result_user->fetch_assoc();
                                                $stmt_user->close();

                                                // Ambil jumlah laporan harian pengguna
                                                $query_laporan = "SELECT COUNT(*) AS total_laporan FROM laporan_harian WHERE nama_depan = ?";
                                                $stmt_laporan = $con->prepare($query_laporan);
                                                $stmt_laporan->bind_param("s", $data_user['nama_depan']);
                                                $stmt_laporan->execute();
                                                $result_laporan = $stmt_laporan->get_result();
                                                $data_laporan = $result_laporan->fetch_assoc();
                                                $stmt_laporan->close();

                                                // Cek apakah pengguna sudah mengupload laporan akhir
                                                $query_laporan_akhir = "SELECT id FROM laporan_akhir WHERE nama_depan = ?";
                                                $stmt_laporan_akhir = $con->prepare($query_laporan_akhir);
                                                $stmt_laporan_akhir->bind_param("s", $data_user['nama_depan']);
                                                $stmt_laporan_akhir->execute();
                                                $result_laporan_akhir = $stmt_laporan_akhir->get_result();
                                                $status_laporan_akhir = ($result_laporan_akhir->num_rows > 0) ? "Selesai" : "Belum";
                                                $status_warna = ($status_laporan_akhir == "Selesai") ? "text-success font-weight-bold" : "text-danger font-weight-bold";
                                                $stmt_laporan_akhir->close();

                                                // Menampilkan data laporan harian dan laporan akhir
                                                echo '<tr>
                                <td>Laporan Harian: <span class="font-weight-bold">' . htmlspecialchars($data_laporan['total_laporan'], ENT_QUOTES, 'UTF-8') . '</span></td>
                              </tr>
                              <tr>
                                <td>Laporan Akhir: <span class="' . $status_warna . '">' . htmlspecialchars($status_laporan_akhir, ENT_QUOTES, 'UTF-8') . '</span></td>
                              </tr>';
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Laporan Akhir</h4>
                                </div>
                                <div class="content">
                                    <form action="upload_laporan.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="file" name="laporan_file" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-info btn-fill">
                                            <i class="fa fa-upload"></i> Upload Laporan
                                        </button>

                                    </form>
                                </div>
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
<!-- Script untuk menampilkan notifikasi -->
<?php
if (isset($_GET['proses'])) {
    echo '<script type="text/javascript">';
    $proses = ($_GET["proses"]);
    if ($proses == "simpan") {
        echo 'swal({
                    title: "Berhasil!",
                    text: "Waktu berhasil disimpan.",
                    type: "success",
                    showConfirmButton: true,
                    confirmButtonColor: "#00ff00"
                })';
    }
    echo '</script>';
}
?>
<!-- Script untuk menampilkan notifikasi -->
<?php
if (isset($_GET['proses'])) {
    echo '<script type="text/javascript">';
    $proses = ($_GET["proses"]);
    if ($proses == "simpan1") {
        echo 'swal({
                    title: "Berhasil!",
                    text: "Laporan berhasil disimpan.",
                    type: "success",
                    showConfirmButton: true,
                    confirmButtonColor: "#00ff00"
                })';
    }
    echo '</script>';
}
?>

</html>