<?php
include 'system/koneksi.php'; // Pastikan kamu sudah membuat koneksi ke database

// Cek jika ada parameter id di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data dari database berdasarkan id
    $query = "SELECT * FROM pendaftaran WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($data = mysqli_fetch_assoc($result)) {
        // Data ditemukan, tampilkan form untuk mengedit
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ambil data dari form
            $program = $_POST['program'];
            $periode = $_POST['periode'];
            $dosen_wali = $_POST['dosen_wali'];
            $nama = $_POST['nama'];
            $nim = $_POST['nim'];
            $ipk = $_POST['ipk'];
            $total_sks = $_POST['total_sks'];
            $status = $_POST['status'];
            

            // Update data ke database
            $update_query = "UPDATE pendaftaran SET program = ?, periode = ?, nama = ?, nim = ?, ipk = ?, total_sks = ?, status = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($update_stmt, 'ssssiiis', $program, $periode, $nama, $nim, $ipk, $total_sks, $status, $id);
            if (mysqli_stmt_execute($update_stmt)) {
                echo '<div class="alert alert-success">Data berhasil diperbarui.</div>';
            } else {
                echo '<div class="alert alert-danger">Gagal memperbarui data.</div>';
            }
        }
    } else {
        echo '<div class="alert alert-danger">Data tidak ditemukan.</div>';
    }
} else {
    echo '<div class="alert alert-danger">ID tidak tersedia.</div>';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
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
                        <a href="pengajuan">
                            <i class="pe pe-7s-note2"></i>
                            <p>Pengajuan</p>
                        </a>
                    </li>
                    <li>
                        <a href="riwayat">
                            <i class="pe pe-7s-timer"></i>
                            <p>Riwayat</p>
                        </a>
                    </li>
                    <li>
                        <a href="notifikasi">
                            <i class="pe pe-7s-bell"></i>

                            <?php
                            $query_notifikasi = " SELECT a.id_riwayat FROM riwayat 
                AS a INNER JOIN pengajuan AS b WHERE a.id_pengajuan = b.id_pengajuan
                AND b.id_user = '$id_login' AND a.notifikasi= '1' ";
                            $result_notifikasi = mysqli_query($con, $query_notifikasi);
                            $banyakdata_notifikasi = $result_notifikasi->num_rows;
                            ?>


                            <p>Notifikasi
                                <?php
                                if ($banyakdata_notifikasi > 0) {
                                    if ($banyakdata_notifikasi <= 10) {
                                        $hasil = $banyakdata_notifikasi;
                                        echo "<span class='new badge'>$hasil</span>";
                                    } else {
                                        $hasil = "10 +";
                                        echo "<span class='new badge'>$hasil</span>";
                                    }
                                } else {
                                }
                                ?>
                            </p>
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
    <div class="container mt-4">
        <h2>Edit Data</h2>
        <form action="edit.php?id=<?php echo $id; ?>" method="post">
            <div class="form-group">
                <label for="program">Program</label>
                <input type="text" class="form-control" id="program" name="program" value="<?php echo htmlspecialchars($data['program']); ?>" required>
            </div>
            <div class="form-group">
                <label for="periode">Periode</label>
                <input type="text" class="form-control" id="periode" name="periode" value="<?php echo htmlspecialchars($data['periode']); ?>" required>
            </div>
            <div class="form-group">
                <label for="dosen_wali">Dosen Wali</label>
                <input type="text" class="form-control" id="dosen_wali" name="dosen_wali" value="<?php echo htmlspecialchars($data['dosen_wali']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" value="<?php echo htmlspecialchars($data['nim']); ?>" required>
            </div>
            <div class="form-group">
                <label for="ipk">IPK</label>
                <input type="text" class="form-control" id="ipk" name="ipk" value="<?php echo htmlspecialchars($data['ipk']); ?>" required>
            </div>
            <div class="form-group">
                <label for="total_sks">Total SKS</label>
                <input type="number" class="form-control" id="total_sks" name="total_sks" value="<?php echo htmlspecialchars($data['total_sks']); ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="menunggu" <?php echo $data['status'] == 'menunggu' ? 'selected' : ''; ?>>Menunggu</option>
                    <option value="proses" <?php echo $data['status'] == 'proses' ? 'selected' : ''; ?>>Proses</option>
                    <option value="selesai" <?php echo $data['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="pendaftaran.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
