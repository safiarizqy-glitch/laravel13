<?php
session_start();
include 'koneksi.php';


if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: customer/menu.php");
    }
    exit();
}

$pesan = "";


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    if (empty($username) || empty($password)) {
        $pesan = "Username dan password wajib diisi!";
    } else {
        
        $username = mysqli_real_escape_string($koneksi, $username);
        $password = mysqli_real_escape_string($koneksi, $password);

        $query  = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($koneksi, $query);

        if (mysqli_num_rows($result) > 0) {

            $data = mysqli_fetch_assoc($result);

            $_SESSION['login']   = true;
            $_SESSION['id_user'] = $data['id_user'];
            $_SESSION['nama']    = $data['nama'];
            $_SESSION['username']= $data['username'];
            $_SESSION['role']    = $data['role'];

            if ($data['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: customer/menu.php");
            }
            exit();

        } else {
            $pesan = "Username atau password salah!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FoodOrder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-login {
            margin-top: 80px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .btn-merah {
            background-color: #dc3545;
            color: white;
        }
        .btn-merah:hover {
            background-color: #bb2d3b;
            color: white;
        }
        .judul {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-login">
                <div class="card-body p-4">

                    <h3 class="text-center judul mb-1">FoodOrder</h3>
                    <p class="text-center text-muted mb-4">Masuk ke akun kamu</p>

                    <?php if ($pesan != "") { ?>
                        <div class="alert alert-danger"><?php echo $pesan; ?></div>
                    <?php } ?>

                    <form action="" method="POST" id="formLogin">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan username">
                            <div class="text-danger small" id="errUsername" style="display:none;">Username wajib diisi yaa</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password">
                            <div class="text-danger small" id="errPassword" style="display:none;">Password wajib diisi yaa</div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" name="login" class="btn btn-merah">Masuk</button>
                        </div>
                    </form>

                    <p class="text-center mt-3 text-muted small">
                        Belum punya akun yaaa? <a href="register.php">Daftar di sini</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>

<script>

document.getElementById('formLogin').addEventListener('submit', function(e) {

    var username = document.querySelector('[name=username]').value;
    var password = document.querySelector('[name=password]').value;
    var valid    = true;

    
    document.getElementById('errUsername').style.display = 'none';
    document.getElementById('errPassword').style.display = 'none';

    if (username == '') {
        document.getElementById('errUsername').style.display = 'block';
        valid = false;
    }

    if (password == '') {
        document.getElementById('errPassword').style.display = 'block';
        valid = false;
    }

    if (valid == false) {
        e.preventDefault(); 
    }

});
</script>

</body>
</html>
