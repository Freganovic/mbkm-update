<?php
include "system/koneksi.php";
session_start();

// Cek jika user belum login
if (empty($_SESSION['email'])) {
    echo "<script type='text/javascript'>document.location='login?proses=error';</script>";
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

// Mengambil data user yang login
$id_login = $data_cek["id_user"];
$dosen_login = $data_cek["dosen"];
$nama_login = $data_cek["nama_depan"];
$nim_login = $data_cek["nim"];
$kelas_login = $data_cek["kelas"];
$no_hp_login = $data_cek["no_hp"];

// Ambil data jenis_pengajuan dari database
$query_program = "SELECT jenis_pengajuan FROM jenis_pengajuan";
$result_program = $con->query($query_program);
$program_options = "";
if ($result_program->num_rows > 0) {
    while ($row = $result_program->fetch_assoc()) {
        $program_options .= "<option value='" . htmlspecialchars($row['jenis_pengajuan'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['jenis_pengajuan'], ENT_QUOTES, 'UTF-8') . "</option>";
    }
} else {
    $program_options = "<option value=''>Data tidak ditemukan</option>";
}

// Ambil data periode dari tabel jenis_pengajuan
$query_periode = "SELECT periode FROM jenis_pengajuan";
$result_periode = mysqli_query($con, $query_periode);
$periode_options = "";
if ($result_program->num_rows > 0) {
    while ($row = $result_program->fetch_assoc()) {
        $periode_options .= "<option value='" . htmlspecialchars($row['jenis_pengajuan'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['periode'], ENT_QUOTES, 'UTF-8') . "</option>";
    }
} else {
    $periode_options = "<option value=''>Data tidak ditemukan</option>";
}

// Periksa jika query berhasil
if (!$result_periode) {
    die("Query gagal dijalankan: " . mysqli_errno($con) . " - " . mysqli_error($con));
}

// Buat opsi untuk dropdown
$periode_options = '';
while ($row = mysqli_fetch_assoc($result_periode)) {
    $periode_options .= '<option value="' . htmlspecialchars($row['periode']) . '">' . htmlspecialchars($row['periode']) . '</option>';
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
                        System Pengajuan<br><small>( Mahasiswa ) - <?php echo htmlspecialchars($nama_login, ENT_QUOTES, 'UTF-8'); ?></small>
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
                                            <h4 class="title">Form Pengajuan</h4>
                                        </div>
                                        <div class="col-md-6" align="right">
                                            <?php echo '<small>' . tanggal_indo(date("Y-m-d")) . '</small>'; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="content">
                                    <form id="form_user" method="post" action="system/proses_tambah_pendaftaran.php" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Dosen Wali</label>
                                                    <input type="text" name="dosen_wali" id="form_dosen_wali" class="form-control" placeholder="Dosen Wali" value="<?php echo htmlspecialchars($dosen_login, ENT_QUOTES, 'UTF-8'); ?>" required
                                                        oninvalid="this.setCustomValidity('Mohon isi form berikut !')"
                                                        oninput="setCustomValidity('')" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="program">Program MBKM</label>
                                                    <select name="program" id="program" class="form-control" required
                                                        oninvalid="this.setCustomValidity('Mohon pilih program MBKM!')"
                                                        oninput="setCustomValidity('')">
                                                        <option value="">Pilih Program MBKM</option>
                                                        <?php echo $program_options; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" name="nama" id="form_nama" class="form-control" placeholder="Nama" value="<?php echo htmlspecialchars($nama_login, ENT_QUOTES, 'UTF-8'); ?>" required
                                                        oninvalid="this.setCustomValidity('Mohon isi form berikut !')"
                                                        oninput="setCustomValidity('')" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NIM</label>
                                                    <input type="text" name="nim" id="form_nim" class="form-control" placeholder="NIM" value="<?php echo htmlspecialchars($nim_login, ENT_QUOTES, 'UTF-8'); ?>" required
                                                        oninvalid="this.setCustomValidity('Mohon isi form berikut !')"
                                                        oninput="setCustomValidity('')" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kelas</label>
                                                    <input type="text" name="kelas" id="form_kelas" class="form-control" placeholder="Kelas" value="<?php echo htmlspecialchars($kelas_login, ENT_QUOTES, 'UTF-8'); ?>" required
                                                        oninvalid="this.setCustomValidity('Mohon isi form berikut !')"
                                                        oninput="setCustomValidity('')" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>No WhatsApp</label>
                                                    <input type="text" name="no_whatsapp" id="form_no_whatsapp" class="form-control" placeholder="No WhatsApp" value="<?php echo htmlspecialchars($no_hp_login, ENT_QUOTES, 'UTF-8'); ?>" required
                                                        oninvalid="this.setCustomValidity('Mohon isi form berikut !')"
                                                        oninput="setCustomValidity('')" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>IPK</label>
                                                    <input type="number" name="ipk" id="form_ipk" class="form-control" placeholder="IPK" min="0" max="4" step="0.01" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Total SKS</label>
                                                    <input type="number" name="total_sks" id="form_total_sks" class="form-control" placeholder="Total SKS" min="0" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="program">Periode</label>
                                                    <select name="periode" id="periode" class="form-control" required
                                                        oninvalid="this.setCustomValidity('Mohon pilih periode!')"
                                                        oninput="setCustomValidity('')">
                                                        <option value="">Pilih Periode</option>
                                                        <?php echo $periode_options; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Curriculum Vitae (CV)</label>
                                                    <input type="file" name="cv" id="form_cv" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Transkrip Nilai (KHS)</label>
                                                    <input type="file" name="khs" id="form_khs" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Portofolio</label>
                                                    <input type="file" name="portofolio" id="form_portofolio" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" align="right">
                                                <button type="submit" name="input" class="btn btn-primary btn-fill">
                                                <i class="fa fa-check"></i> Ajukan</button>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul>
                            <li>
                                <a href="index">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="pendaftaran">
                                    Pendaftaran
                                </a>
                            </li>
                            <li>
                                <a href="pengajuan">
                                    Pengajuan
                                </a>
                            </li>
                            <li>
                                <a href="riwayat">
                                    Riwayat
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </footer>
        </div>
    </div>
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
    if (isset($_GET['proses'])) {
        echo '<script type="text/javascript">';
        $proses = ($_GET["proses"]);
        if ($proses == "edit") {
            echo 'swal({
            title: "Terubah!",
            text: "Profil telah diubah.",
            type: "success",
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
                });
        }

        function confirmSubmit() {
            swal({
                    title: "Konfirmasi?",
                    text: "Apakah Anda yakin ingin mengirim?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#00cc00",
                    confirmButtonText: "Ya, kirim!",
                    cancelButtonText: "Batal",
                    closeOnConfirm: false
                },
                function() {
                    // Ganti 'yourFormId' dengan ID form yang sesuai
                    document.getElementById('Id').submit();
                });
        }
    </script>

</body>

</html>