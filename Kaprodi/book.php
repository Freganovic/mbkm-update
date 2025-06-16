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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="title">Log-Book</h4>
                                        </div>
                                        <div class="col-md-6" align="right">
                                            <a href="data_book">
                                                <button type="button" class="btn btn-primary btn-fill">
                                                    <i></i> Laporan Harian
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <form id="form_user" action="" method="get">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Pencarian : </label>
                                                    <input type="text" name="cari" id="cari" class="form-control" placeholder="Nama" value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <label><br></label>
                                                <button type="submit" class="btn btn-primary btn-fill">
                                                    <i class="fa fa-search"></i> Cari
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="content table-responsive table-full-width">
                                    <?php
                                    $cari = isset($_GET['cari']) ? mysqli_real_escape_string($con, $_GET['cari']) : '';
                                    if ($cari) {
                                        $query = "SELECT nama, nim, kelas FROM pendaftaran WHERE nama LIKE '%$cari%' ORDER BY nim";
                                    } else {
                                        $query = "SELECT nama, nim, kelas FROM pendaftaran ORDER BY nim";
                                    }

                                    $result = mysqli_query($con, $query);

                                    if (mysqli_num_rows($result) == 0) {
                                        echo '
                                <div class="content table-responsive table-full-width">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIM</th>
                                            <th>Kelas</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" align="center">
                                                    Tidak ada data pendaftaran
                                                    <br>
                                                    <a href="user">
                                                        <button type="button" class="btn btn-primary btn-fill btn-sm">
                                                            <i class="fa fa-refresh"></i> Refresh data
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>';
                                    } else {
                                        echo '
                                <div class="content table-responsive table-full-width">
                                    <table class="table table-hover table-striped table-paginate">
                                        <thead>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIM</th>
                                            <th>Kelas</th>
                                        </thead>
                                        <tbody>';
                                        $no = 1;
                                        while ($data = mysqli_fetch_assoc($result)) {
                                            $nama_url = urlencode($data['nama']);
                                            echo '
                                        <tr onclick="window.location.href=\'http://localhost/system_pengajuan-mbkm/kaprodi/data_book?mahasiswa=' . $nama_url . '\'" style="cursor: pointer;">
                                            <td>' . $no . '</td>
                                            <td>' . htmlspecialchars($data['nama']) . '</td>
                                            <td>' . htmlspecialchars($data['nim']) . '</td>
                                            <td>' . htmlspecialchars($data['kelas']) . '</td>
                                        </tr>';
                                            $no++;
                                        }
                                        echo '
                                        </tbody>
                                    </table>
                                </div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tambahan CSS opsional -->
        <style>
            table tr:hover {
                background-color: #f5f5f5;
            }
        </style>


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