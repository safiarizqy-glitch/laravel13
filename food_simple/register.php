<?php
session_start();
include 'koneksi.php';

$pesan  = "";
$sukses = "";

if (isset($_POST['daftar'])) {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $konfirm  = $_POST['konfirm'];

  
    if (empty($nama) || empty($username) || empty($password)) {
        $pesan = "Semua kolom wajib diisi!";

    } elseif ($password != $konfirm) {
        $pesan = "Konfirmasi password tidak cocok!";

    } elseif (strlen($password) < 6) {
        $pesan = "Password minimal 6 karakter!";

    } else {
        
        $username = mysqli_real_escape_string($koneksi, $username);
        $cek      = mysqli_query($koneksi, "SELECT id_user FROM users WHERE username='$username'");

        if (mysqli_num_rows($cek) > 0) {
            $pesan = "Username sudah dipakai, coba username lain!";

        } else {
            
            $nama     = mysqli_real_escape_string($koneksi, $nama);
            $password = mysqli_real_escape_string($koneksi, $password);

            $query  = "INSERT INTO users (nama, username, password, role) VALUES ('$nama', '$username', '$password', 'customer')";
            $result = mysqli_query($koneksi, $query);

            if ($result) {
                $sukses = "Pendaftaran berhasil! Silakan login.";
            } else {
                $pesan = "Gagal mendaftar, coba lagi.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - FoodOrder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card-daftar { margin-top: 60px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .btn-merah { background-color: #dc3545; color: white; }
        .btn-merah:hover { background-color: #bb2d3b; color: white; }
        .judul { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-daftar">
                <div class="card-body p-4">

                    <h3 class="text-center judul mb-1">Daftar Akun</h3>
                    <p class="text-center text-muted mb-4">Buat akun baru untuk mulai pesan</p>

                    <?php if ($pesan != "") { ?>
                        <div class="alert alert-danger"><?php echo $pesan; ?></div>
                    <?php } ?>

                    <?php if ($sukses != "") { ?>
                        <div class="alert alert-success"><?php echo $sukses; ?></div>
                    <?php } ?>

                    <form action="" method="POST" id="formDaftar">

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama kamu"
                                   value="<?php if(isset($_POST['nama'])) echo $_POST['nama']; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Buat username"
                                   value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" id="pass1" class="form-control" placeholder="Min. 6 karakter">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="konfirm" id="pass2" class="form-control" placeholder="Ulangi password">
                            <div class="text-danger small" id="errKonfirm" style="display:none;">Password tidak cocok!</div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" name="daftar" class="btn btn-merah">Daftar Sekarang</button>
                        </div>
                    </form>

                    <p class="text-center mt-3 text-muted small">
                        Sudah punya akun? <a href="login.php">Login di sini</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>

<script>

document.getElementById('formDaftar').addEventListener('submit', function(e) {
    var pass1 = document.getElementById('pass1').value;
    var pass2 = document.getElementById('pass2').value;

    document.getElementById('errKonfirm').style.display = 'none';

    if (pass1 != pass2) {
        document.getElementById('errKonfirm').style.display = 'block';
        e.preventDefault();
    }
});
</script>

</body>
</html>
