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
    <link rel="icon" type="image/png" href="../assets/img/icon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Dashboard</title>
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
        <div class="sidebar" data-color="green" data-image="assets/img/sidebar.jpg">
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
                        System MBKM UPB<br><small>( Kaprodi ) - <?php echo $username_login ?></small>
                    </a>
                </div>
                <ul class="nav">
                    <li>
                        <a href="index">
                            <i class="pe pe-7s-graph"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="active">
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
                    <li>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="title">Data Pendaftaran MBKM</h4>
                                </div>
                            </div>
                            <br>
                            <div class="content table-responsive">
                                <div class="tab-content">
                                    <div id="semua" class="tab-pane active">
                                        <?php
                                        $query_getnama = "SELECT u.nama_depan FROM user as u WHERE u.email = '$_SESSION[email]'";
                                        $result = mysqli_query($con, $query_getnama);
                                        $data_nama = mysqli_fetch_assoc($result);

                                        // Cek apakah filter pencarian telah digunakan
                                        if (isset($_GET['judul'])) {
                                            // Ambil data dari form pencarian
                                            $pengajuan = ($_GET["judul"]);
                                            $first = date_create(($_GET["tanggal_awal"]));
                                            $last = date_create(($_GET["tanggal_akhir"]));
                                            $awal = date_format($first, "Y-m-d");
                                            $akhir = date_format($last, "Y-m-d");
                                            $sts = ($_GET["status"]);

                                            // Jika status 'semua', maka query tidak memfilter status
                                            $status = $sts == "semua" ? "" : $sts;

                                            // Jika judul pengajuan tidak diisi, query mengambil semua data berdasarkan tanggal dan status
                                            if ($pengajuan == "") {
                                                $query_semua = "SELECT id, program, periode, dosen_wali, nama, nim, ipk, keterangan, total_sks, status 
                                    FROM pendaftaran 
                                    WHERE (tanggal BETWEEN '$awal' AND '$akhir') 
                                    AND status LIKE '%$status%' 
                                    ORDER BY id DESC";
                                            } else {
                                                // Jika judul pengajuan diisi, query mengambil data yang sesuai dengan judul, tanggal, dan status
                                                $query_semua = "SELECT id, program, periode, dosen_wali, nama, nim, ipk, keterangan, total_sks, status 
                                    FROM pendaftaran 
                                    WHERE program LIKE '%$pengajuan%' 
                                    AND (tanggal BETWEEN '$awal' AND '$akhir') 
                                    AND status LIKE '%$status%' 
                                    ORDER BY id DESC";
                                            }
                                        } else {
                                            $query_semua = "SELECT id, program, periode, dosen_wali, nama, nim, ipk, keterangan, total_sks, status 
                                FROM pendaftaran 
                                ORDER BY id DESC";
                                            $result_semua = mysqli_query($con, $query_semua);
                                        }

                                        // Jalankan query
                                        $result_semua = mysqli_query($con, $query_semua);

                                        // Cek apakah ada data yang ditemukan
                                        if (mysqli_num_rows($result_semua) > 0) {
                                            // Jika data ditemukan, tampilkan dalam tabel
                                            echo '<div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>PROGRAM</th>
                                <th>PERIODE</th>
                                <th>Dosen Wali</th>
                                <th>NAMA</th>
                                <th>NIM</th>
                                <th>IPK</th>
                                <th>TOTAL SKS</th>
                                <th>STATUS</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';

                                            // Looping untuk menampilkan setiap data
                                            $no_semua = 1;
                                            while ($data_semua = mysqli_fetch_assoc($result_semua)) {
                                                echo '<tr>
                        <td>' . $no_semua . '</td>
                        <td>' . $data_semua['program'] . '</td>
                        <td>' . $data_semua['periode'] . '</td>
                        <td>' . $data_semua['dosen_wali'] . '</td>
                        <td>' . $data_semua['nama'] . '</td>
                        <td>' . $data_semua['nim'] . '</td>
                        <td>' . $data_semua['ipk'] . '</td>
                        <td>' . $data_semua['total_sks'] . '</td>
                        <td style="background-color: ' .
                                                    ($data_semua['status'] == 'DITOLAK' ? '#e74c3c' : ($data_semua['status'] == 'DIPROSES' ? '#3498db' : ($data_semua['status'] == 'DITERIMA' ? '#2ecc71' : ''))) . '; color: white;">
                            ' . htmlspecialchars($data_semua['status'], ENT_QUOTES, 'UTF-8') . '</td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete(' . $data_semua['id'] . ')"> <i class="fa fa-trash"></i></button>
                        </td>
                    </tr>';
                                                $no_semua++;
                                            }

                                            echo '</tbody>
                    </table>
                </div>';
                                        } else {
                                            // Jika tidak ada data ditemukan, tampilkan pesan
                                            echo '<p>No data available.</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <script type="text/javascript">
                                function confirmDelete(id) {
                                    swal({
                                        title: "Apakah Anda yakin?",
                                        text: "Data ini akan dihapus secara permanen!",
                                        type: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "#DD6B55",
                                        confirmButtonText: "Ya, Hapus!",
                                        cancelButtonText: "Batal",
                                        closeOnConfirm: false
                                    }, function() {
                                        // Redirect ke halaman penghapusan atau kirim permintaan untuk menghapus data
                                        window.location.href = 'system/hapus_pendaftaran.php?id=' + id;
                                    });
                                }
                            </script>

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
if (isset($_GET['proses'])) {
    echo '<script type="text/javascript">';
    $proses = ($_GET["proses"]);
    if ($proses == "delete") {
        echo 'swal({
                    title: "Terhapus!",
                    text: "Pengajuan telah dihapus.",
                    type: "success",
                    showConfirmButton: true,
                    confirmButtonColor: "#00ff00"
            })';
    } else if ($proses == "tambah") {
        echo 'swal({
                    title: "Tertambah!",
                    text: "Pengajuan telah ditambah.",
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
                document.location = "../logout";
            })
    }

    function batal(id) {
        swal({
                title: "Konfirmasi ?",
                text: "Apakah anda ingin membatalkan pengajuan",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00cc00",
                confirmButtonText: "Iya",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            },
            function() {
                document.location = "system/hapus_pengajuan?id=" + id;
            })
    }

    function hapus(id) {
        swal({
                title: "Konfirmasi ?",
                text: "Apakah anda ingin menghapus pengajuan",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00cc00",
                confirmButtonText: "Iya",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            },
            function() {
                document.location = "system/hapus_pengajuan?id=" + id;
            })
    }

    $(function() {
        $("#datepicker1").datepicker({
            dateFormat: "dd-mm-yy",
            monthNames: ["Januari", "Febuari", "Maret",
                "April", "Mei", "Juni",
                "Juli", "Agustus", "September",
                "Oktober", "November", "December"
            ],
            dayNamesMin: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"]

        });
        $("#datepicker2").datepicker({
            dateFormat: "dd-mm-yy",
            monthNames: ["Januari", "Febuari", "Maret",
                "April", "Mei", "Juni",
                "Juli", "Agustus", "September",
                "Oktober", "November", "December"
            ],
            dayNamesMin: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"]

        });
    });
</script>

</html>