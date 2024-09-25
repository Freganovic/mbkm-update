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
                    <li class="active">
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
                                    <h4 class="title">Pemberitauan</h4>
                                    <?php
                                    $query_catatan = "SELECT * FROM catatan";
                                    $result_catatan = mysqli_query($con, $query_catatan);
                                    if (!$result_catatan) {
                                        die("Query Error: " . mysqli_errno($con) .
                                            " - " . mysqli_error($con));
                                    }
                                    $data_catatan = mysqli_fetch_assoc($result_catatan);
                                    $update = $data_catatan['update_catatan'];
                                    ?>
                                    <p class="category">Update Terakhir : <b><?php echo tanggal_indo($update) ?></b></p>
                                </div>
                                <div class="content">
                                    <p>
                                        <?php
                                        if ($data_catatan['catatan'] == '') {
                                            echo "<small style='color:#bfbfbf'>- Tidak ada catatan -</small>";
                                        } else {
                                            echo $data_catatan['catatan'];
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">
                                        Jadwal Presentasi Terbaru <br>
                                    </h4>
                                </div>
                                <div class="content">
                                    <div class="table-full-width">
                                        <table class="table">
                                            <tbody>
                                                <?php
                                                // Ambil nama pengguna yang sedang login
                                                $email = $_SESSION['email'];
                                                $query_user = "SELECT nama_depan FROM user WHERE email = '$email'";
                                                $result_user = mysqli_query($con, $query_user);
                                                $data_user = mysqli_fetch_assoc($result_user);

                                                // Query untuk mengambil 1 jadwal presentasi terbaru berdasarkan nama pengguna yang login
                                                $query_jadwal = "SELECT p.id, p.jadwal, p.status 
                                         FROM pendaftaran AS p 
                                         WHERE p.nama = '" . $data_user['nama_depan'] . "' 
                                         ORDER BY p.jadwal DESC LIMIT 1";
                                                $result_jadwal = mysqli_query($con, $query_jadwal);

                                                if (!$result_jadwal) {
                                                    die("Query Error: " . mysqli_errno($con) . " - " . mysqli_error($con));
                                                }
                                                if ($result_jadwal->num_rows == 0) {
                                                    echo "<tr>
                                    <td colspan='3'>Tidak ada jadwal presentasi</td>
                                  </tr>";
                                                } else {
                                                    // Menampilkan satu data jadwal presentasi
                                                    $data_jadwal = mysqli_fetch_assoc($result_jadwal);
                                                    echo '<tr>
                                    <td> ' . date('d M Y H:i', strtotime($data_jadwal['jadwal'])) . ' - ';

                                                    // Menampilkan status dengan badge warna berbeda
                                                    if ($data_jadwal['status'] == "menunggu") {
                                                        echo '<span class="badge menunggu upper">' . $data_jadwal['status'] . '</span>';
                                                    } else if ($data_jadwal['status'] == "proses") {
                                                        echo '<span class="badge proses upper">' . $data_jadwal['status'] . '</span>';
                                                    } else {
                                                        echo '<span class="badge selesai upper">' . $data_jadwal['status'] . '</span>';
                                                    }

                                                    echo '</td>
                                  <td class="td-actions text-right">
                                    <a href="detail_pendaftaran?id=' . $data_jadwal['id'] . '">
                                        <button type="button" rel="tooltip" title="Lihat Detail" class="btn btn-info btn-simple btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </a>
                                  </td>
                              </tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="footer">
                                        <hr>
                                        <div class="stats">
                                            <a href="presentasi"><i class="fa fa-link"></i> Lihat Semua Jadwal Presentasi </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">
                                        Jenis dan Lokasi Presentasi <br>
                                    </h4>
                                </div>
                                <div class="content">
                                    <div class="table-full-width">
                                        <table class="table">
                                            <tbody>
                                                <?php
                                                // Ambil nama pengguna yang sedang login
                                                $email = $_SESSION['email'];
                                                $query_user = "SELECT nama_depan FROM user WHERE email = '$email'";
                                                $result_user = mysqli_query($con, $query_user);
                                                $data_user = mysqli_fetch_assoc($result_user);

                                                // Query untuk mengambil jenis dan lokasi presentasi terbaru berdasarkan nama pengguna yang login
                                                $query_jadwal = "SELECT p.jenis, p.lokasi 
                                         FROM pendaftaran AS p 
                                         WHERE p.nama = '" . $data_user['nama_depan'] . "' 
                                         ORDER BY p.jadwal DESC LIMIT 1";
                                                $result_jadwal = mysqli_query($con, $query_jadwal);

                                                if (!$result_jadwal) {
                                                    die("Query Error: " . mysqli_errno($con) . " - " . mysqli_error($con));
                                                }
                                                if ($result_jadwal->num_rows == 0) {
                                                    echo "<tr>
                                    <td colspan='2'>Tidak ada data presentasi</td>
                                  </tr>";
                                                } else {
                                                    // Menampilkan data jenis dan lokasi presentasi
                                                    $data_jadwal = mysqli_fetch_assoc($result_jadwal);
                                                    echo '<tr>
                                    <td> Jenis: ' . htmlspecialchars($data_jadwal['jenis'], ENT_QUOTES, 'UTF-8') . '</td>
                                  </tr>
                                  <tr>
                                    <td> Lokasi: ' . htmlspecialchars($data_jadwal['lokasi'], ENT_QUOTES, 'UTF-8') . '</td>
                                  </tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
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

</html>