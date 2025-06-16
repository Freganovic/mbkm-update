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

    if ($data_cek['role'] == "kaprodi") {
    } else {
        echo "<script type='text/javascript'>window.location=history.go(-1);</script>";
    }
}
$selected_mahasiswa = isset($_GET['mahasiswa']) ? mysqli_real_escape_string($con, $_GET['mahasiswa']) : '';
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
                        System MBKM UPB<br><small>( KAPRODI ) - <?php echo $username ?></small>
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
                    <li>
                        <a href="jenis_pengajuan">
                            <i class="pe-7s-server"></i>
                            <p>Program MBKM</p>
                        </a>
                    </li>
                    <li class="active">
                        <a href="book">
                            <i class="pe-7s-note2"></i>
                            <p>Log-Book</p>
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
                                    <h4 class="title">Log-Book Mahasiswa</h4>
                                </div>
                                <div class="content">
                                    <form method="get" action="">
                                        <div class="form-group">
                                            <label>Pilih Mahasiswa:</label>
                                            <select name="mahasiswa" class="form-control" onchange="this.form.submit()">
                                                <option value="">-- Pilih --</option>
                                                <?php
                                                $query_mahasiswa = "SELECT DISTINCT nama_depan FROM laporan_harian";
                                                $result_mahasiswa = mysqli_query($con, $query_mahasiswa);
                                                while ($row = mysqli_fetch_assoc($result_mahasiswa)) {
                                                    echo '<option value="' . htmlspecialchars($row['nama_depan']) . '"' . ($selected_mahasiswa == $row['nama_depan'] ? ' selected' : '') . '>' . htmlspecialchars($row['nama_depan']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </form>

                                    <?php
                                    if ($selected_mahasiswa) {
                                        // Menampilkan laporan harian mahasiswa
                                        $query = "SELECT tanggal, nama_depan, laporan_harian FROM laporan_harian WHERE nama_depan = '$selected_mahasiswa' ORDER BY tanggal DESC";
                                        $result = mysqli_query($con, $query);
                                        if (mysqli_num_rows($result) > 0) {
                                            echo '<table class="table table-hover">
                                            <thead><tr><th>No</th><th>Tanggal</th><th>Nama</th><th>Laporan</th></tr></thead>
                                            <tbody>';
                                            $no = 1;
                                            while ($data = mysqli_fetch_assoc($result)) {
                                                echo '<tr>
                                            <td>' . $no++ . '</td>
                                            <td>' . htmlspecialchars($data['tanggal']) . '</td>
                                            <td>' . htmlspecialchars($data['nama_depan']) . '</td>
                                            <td>' . htmlspecialchars($data['laporan_harian']) . '</td>
                                          </tr>';
                                            }
                                            echo '</tbody></table>';
                                        } else {
                                            echo '<p align="center">Tidak ada data laporan untuk mahasiswa ini.</p>';
                                        }

                                        // Menampilkan laporan akhir mahasiswa
                                        $query_laporan = "SELECT file_laporan FROM laporan_akhir WHERE nama_depan = '$selected_mahasiswa'";
                                        $result_laporan = mysqli_query($con, $query_laporan);
                                        if (mysqli_num_rows($result_laporan) > 0) {
                                            $data_laporan = mysqli_fetch_assoc($result_laporan);
                                            // Memastikan path file benar dengan menambahkan folder 'uploads/' di luar folder Kaprodi
                                            $file_path = '../uploads/' . htmlspecialchars($data_laporan['file_laporan']);
                                            echo '<div class="alert alert-success" align="center">
                                            Laporan akhir tersedia:
                                            <a href="' . $file_path . '" target="_blank">
                                                 <button type="button" class="btn btn-warning btn-fill">
                                                    <i></i> Lihat Laporan Akhir
                                                </button>
                                            </a>
                                          </div>';
                                        } else {
                                            echo '<div class="alert alert-danger" align="center">Mahasiswa belum mengumpulkan laporan akhir.</div>';
                                        }
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


</body>
<script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" language="javascript" src="http:////cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="http://cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../assets/js/bootstrap-checkbox-radio-switch.js"></script>
<script src="../assets/js/chartist.min.js"></script>
<script src="../assets/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="../assets/js/light-bootstrap-dashboard.js"></script>
<script src="../assets/js/demo.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="../assets/dist/sweetalert-dev.js"></script>
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
                document.location = "../logout";
            })
    }

    function hapus(id) {
        swal({
                html: true,
                title: "Konfirmasi ?",
                text: "<b>Apakah anda ingin menghapus program mbkm</b><br>data yang memiliki jenis program mbkm terkait akan terhapus",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00cc00",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            },
            function() {
                document.location = "system/hapus_jenispengajuan?id=" + id;
            })
    }
</script>

</html>