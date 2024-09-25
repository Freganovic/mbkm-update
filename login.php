<?php
session_start();
include "system/koneksi.php";
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="assets/img/icon.png">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=PT+Sans:400,700'>
    <link href="assets/css/login.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/supersized.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/dist/sweetalert.css">
</head>

<body>
    <div class="page-container">
        <div class="image-container">
            <img src='assets/img/mbkm-137.png' alt="MBKM Image" width='540' height='150'>
            <img src='assets/img/logoupb.png' alt="UPB Logo" width='100' height='100'>
        </div>
        <h1>LOGIN</h1>
        <form action="system/act?op=in" method="POST" style="background-color: white; padding: 10px; border-radius: 10px; box-shadow: 0 14px 8px rgba(0, 0, 0, 0.1);">
        <p></p>
            <label for="email" style="display: block; text-align: center; margin-bottom: 5px; color: black;">Email</label>
            <input type="text" id="email" name="email" placeholder="Email" required
                oninvalid="this.setCustomValidity('Mohon isi Email Anda !')"
                oninput="setCustomValidity('')" style="display: block; margin: 0 auto 10px;">

            <label for="password" style="display: block; text-align: center; margin-bottom: 5px; color: black;">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required
                oninvalid="this.setCustomValidity('Mohon isi Password Anda !')"
                oninput="setCustomValidity('')" style="display: block; margin: 0 auto 10px;">

            <button type="submit" value="Login" name="submit" style="display: block; margin: 0 auto;">Login</button>

            <div class="error"><span>+</span></div>
            <p></p>
            <div class="register-link" style="font-size: 12px; color: black; text-align: center;">
                <span>Don't have an account? <a href="daftar.php" style="color: red; text-decoration: none;">Register</a></span>
            </div>
        </form>

    </div>
    <!--<div id="footer">
            <a href="daftar" class="footer">Daftar Disini!</a>
            &copy;<?php echo date("Y") ?> System Pengajuan
        </div>-->
</body>

</html>
<script src="assets/dist/sweetalert-dev.js"></script>
<?php
if (isset($_GET['proses'])) {
    echo '<script type="text/javascript">';
    $login = ($_GET["proses"]);
    if ($login == "false") {
        echo 'swal({
            title: "Mohon Maaf!",
            text: "Periksa ulang Email atau Password anda !",
            type: "error",
            showConfirmButton: true,
            confirmButtonColor: "#00ff00"
        })';
    } else if ($login == "error") {
        echo 'swal({
            title: "Mohon Maaf!",
            text: "Anda harus login terlebih dahulu !",
            type: "error",
            showConfirmButton: true,
            confirmButtonColor: "#00ff00"
        })';
    } else if ($login == "edit") {
        echo 'swal({
            title: "Terubah!",
            text: "Profil telah diubah! Silakan Login Kembali",
            type: "success",
            showConfirmButton: true,
            confirmButtonColor: "#00ff00"
        })';
    } else if ($login == "new") {
        echo 'swal({
            title: "Terdaftar!",
            text: "Akun anda sudah terdaftar, Silakan Login!",
            type: "success",
            showConfirmButton: true,
            confirmButtonColor: "#00ff00"
        })';
    }
    echo '</script>';
}
?>