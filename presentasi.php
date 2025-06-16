<?php
include 'system/koneksi.php';
session_start();
$logged_in = false;
if (empty($_SESSION['email'])) {
    echo "<script type='text/javascript'>document.location='../login?proses=error ';</script>";
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

function tanggal_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

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
                    <li>
                        <a href="kegiatan">
                            <i class="fa fa-file-alt"></i>
                            <p>kegiatanku</p>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="title">JADWAL PRESENTASI MBKM</h4>
                                </div>
                            </div>
                            <br>
                            <div class="content">
                                <div class="tab-content">
                                    <div id="semua" class="tab-pane active">
                                        <?php
                                        $query_getnama = "SELECT u.nama_depan FROM user as u WHERE u.email = '$_SESSION[email]'";
                                        $result = mysqli_query($con, $query_getnama);
                                        $data_nama = mysqli_fetch_assoc($result);

                                        // Cek apakah filter pencarian telah digunakan
                                        if (isset($_GET['judul'])) {
                                            $pengajuan = ($_GET["judul"]);
                                            $first = date_create(($_GET["tanggal_awal"]));
                                            $last = date_create(($_GET["tanggal_akhir"]));
                                            $awal = date_format($first, "Y-m-d");
                                            $akhir = date_format($last, "Y-m-d");
                                            $sts = ($_GET["status"]);
                                            $status = $sts == "semua" ? "" : $sts;

                                            if ($pengajuan == "") {
                                                $query_semua = "SELECT id, program, periode, dosen_wali, nama, nim, ipk, keterangan, total_sks, pembimbing, jadwal, jenis, lokasi, nilai, nilai_lapangan, status 
                                            FROM pendaftaran 
                                            WHERE (tanggal BETWEEN '$awal' AND '$akhir') 
                                            AND status LIKE '%$status%' 
                                            ORDER BY id DESC";
                                            } else {
                                                $query_semua = "SELECT id, program, periode, dosen_wali, nama, nim, ipk, keterangan, total_sks, pembimbing, jadwal, jenis, lokasi, nilai, nilai_lapangan, status 
                                            FROM pendaftaran 
                                            WHERE program LIKE '%$pengajuan%' 
                                            AND (tanggal BETWEEN '$awal' AND '$akhir') 
                                            AND status LIKE '%$status%' 
                                            ORDER BY id DESC";
                                            }
                                        } else {
                                            $query_semua = "SELECT id, program, periode, dosen_wali, nama, nim, ipk, total_sks, keterangan, pembimbing, jadwal, jenis, lokasi, nilai, nilai_lapangan, status 
                                        FROM pendaftaran WHERE nama = '$data_nama[nama_depan]' ORDER BY id DESC";
                                        }

                                        $result_semua = mysqli_query($con, $query_semua);

                                        if (mysqli_num_rows($result_semua) > 0) {
                                            echo '<div class="table-responsive">
                                        <table class="table table-hover table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>PERIODE</th>
                                                    <th>NAMA</th>
                                                    <th>NIM</th>
                                                    <th>Dosen Wali</th>
                                                    <th>DOSEN PEMBIMBING</th>
                                                    <th>JADWAL PRESENTASI</th>
                                                    <th>JENIS PRESENTASI</th>
                                                    <th>LOKASI PRESENTASI</th>
                                                    <th>Nilai Akademik</th>
                                                    <th>Nilai Lapangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>';

                                            $no_semua = 1;
                                            while ($data_semua = mysqli_fetch_assoc($result_semua)) {
                                                echo '<tr>
                                                <td>' . $no_semua . '</td>
                                                <td>' . $data_semua['periode'] . '</td>
                                                <td>' . $data_semua['nama'] . '</td>
                                                <td>' . $data_semua['nim'] . '</td>
                                                <td>' . $data_semua['dosen_wali'] . '</td>
                                                <td>' . $data_semua['pembimbing'] . '</td>
                                                <td>' . $data_semua['jadwal'] . '</td>
                                                <td>' . $data_semua['jenis'] . '</td>
                                                <td>' . $data_semua['lokasi'] . '</td>
                                                <td>' . $data_semua['nilai'] . '</td>
                                                <td>' . $data_semua['nilai_lapangan'] . '</td>
                                            </tr>';
                                                $no_semua++;
                                            }

                                            echo '</tbody>
                                        </table>
                                    </div>';
                                        } else {
                                            echo '<p>No data available.</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
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
<script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" language="javascript" src="http:////cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="http://cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>
<script src="assets/js/chartist.min.js"></script>
<script src="assets/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="assets/js/light-bootstrap-dashboard.js"></script>
<script src="assets/js/demo.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="assets/dist/sweetalert-dev.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('.table-paginate').dataTable({
            "searching": false,
            "paging": false,
            "info": false,
            "lengthChange": false
        });
    });
</script>
<?php
echo '<script type="text/javascript">';
if (isset($_GET['proses'])) {
    $proses = ($_GET["proses"]);
    if ($proses == "hapus") {
        echo 'swal({
                    title: "Terhapus!",
                    text: "program mbkm telah terhapus.",
                    type: "success",
                    showConfirmButton: true,
                    confirmButtonColor: "#00ff00"
                })';
    } else if ($proses == "ubah") {
        echo 'swal({
                    title: "Terubah!",
                    text: "program mbkm telah diubah.",
                    type: "success",
                    showConfirmButton: true,
                    confirmButtonColor: "#00ff00"
                })';
    } else if ($proses == "tambah") {
        echo 'swal({
                    title: "Tertambah!",
                    text: "program mbkm telah ditambah.",
                    type: "success", 
                    showConfirmButton: true,
                    confirmButtonColor: "#00ff00"
                })';
    }
}
echo '</script>'
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