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
                        System Pengajuan MBKM<br><small>( DOSEN ) - <?php echo $username ?></small>
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
                                    <h4 class="title">Dosen Wali Edit MBKM</h4>
                                </div>
                                <div class="content">
                                    <form id="form_edit_jenispengajuan" method="post" action="system/proses_edit_jenispengajuan">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>NAMA PROGRAM MBKM</label>
                                                    <input type="hidden" name="id" value="<?php echo $id ?>">
                                                    <input type="text" name="program" id="program" class="form-control" placeholder="program" value="<?php echo $program ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
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
                                                    <label>DOSEN WALI</label>
                                                    <input type="text" name="dosen_wali" id="dosen_wali" class="form-control" placeholder="dosen wali" value="<?php echo $dosen_wali ?>" readonly>
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
                                                    <label>NO WHATSAPP</label>
                                                    <input type="text" name="no_whatsapp" id="no_whatsapp" class="form-control" placeholder="nomor whatsapp" value="<?php echo $nomor_whatsapp ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>IPK</label>
                                                    <input type="text" name="ipk" id="ipk" class="form-control" placeholder="ipk" value="<?php echo $ipk ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>TOTAL SKS</label>
                                                    <input type="text" name="total_sks" id="total_sks" class="form-control" placeholder="total sks" value="<?php echo $total_sks ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>CV</label>
                                                    <?php if (!empty($cv)): ?>
                                                        <!-- Tampilkan link untuk melihat file yang telah di-upload -->
                                                        <a href="../system/uploads/<?php echo $cv ?>" target="_blank" class="form-control" style="text-decoration: none;">Lihat CV</a>
                                                    <?php else: ?>
                                                        <!-- Jika file belum di-upload -->
                                                        <p class="form-control" readonly>Tidak ada file CV yang diunggah</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>KHS</label>
                                                    <?php if (!empty($khs)): ?>
                                                        <!-- Tampilkan link untuk melihat file yang telah di-upload -->
                                                        <a href="../system/uploads/<?php echo $khs ?>" target="_blank" class="form-control" style="text-decoration: none;">Lihat KHS</a>
                                                    <?php else: ?>
                                                        <!-- Jika file belum di-upload -->
                                                        <p class="form-control" readonly>Tidak ada file CV yang diunggah</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>PORTOFOLIO</label>
                                                    <?php if (!empty($portofolio)): ?>
                                                        <!-- Tampilkan link untuk melihat file yang telah di-upload -->
                                                        <a href="../system/uploads/<?php echo $portofolio ?>" target="_blank" class="form-control" style="text-decoration: none;">Lihat PORTOFOLIO</a>
                                                    <?php else: ?>
                                                        <!-- Jika file belum di-upload -->
                                                        <p class="form-control" readonly>Tidak ada file CV yang diunggah</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="DIPROSES" <?php if ($status == 'DIPROSES') echo 'selected'; ?>>DIPROSES</option>
                                                        <option value="DITERIMA" <?php if ($status == 'DITERIMA') echo 'selected'; ?>>DITERIMA</option>
                                                        <option value="DITOLAK" <?php if ($status == 'DITOLAK') echo 'selected'; ?>>DITOLAK</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>CATATAN</label>
                                                    <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="tambah catatan" required
                                                        oninvalid="this.setCustomValidity('Mohon isi form berikut!')"
                                                        oninput="setCustomValidity('')">
                                                </div>
                                            </div>
                                        </div>

                                        <div align="right">
                                            <a href="pendaftaran">
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
                    title: "berhasil!",
                    text: "Data berhasil diperbarui.",
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
</script>

</html>