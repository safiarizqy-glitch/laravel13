<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("Location: ../login.php");
    exit();
}

if (empty($_SESSION['keranjang'])) {
    echo "<script>alert('Keranjang masih kosong!'); window.location='menu.php';</script>";
    exit();
}

$pesan = "";

$total_belanja = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $total_belanja += $item['subtotal'];
}

if (isset($_POST['pesan'])) {
    $nama_penerima = $_POST['nama_penerima'];
    $alamat        = $_POST['alamat'];
    $telepon       = $_POST['telepon'];

    if (empty($nama_penerima) || empty($alamat) || empty($telepon)) {
        $pesan = "Nama penerima, alamat, dan telepon wajib diisi!";
    } else {
        $id_user       = $_SESSION['id_user'];
        $nama_penerima = mysqli_real_escape_string($koneksi, $nama_penerima);
        $alamat        = mysqli_real_escape_string($koneksi, $alamat);
        $telepon       = mysqli_real_escape_string($koneksi, $telepon);


        $query = "INSERT INTO pesanan (id_user, nama_penerima, alamat, telepon, total, status) 
                  VALUES ('$id_user', '$nama_penerima', '$alamat', '$telepon', '$total_belanja', 'menunggu')";

        $result = mysqli_query($koneksi, $query);

        if ($result) {
            $id_pesanan_baru = mysqli_insert_id($koneksi);

            foreach ($_SESSION['keranjang'] as $id_menu => $item) {
                $nama_m   = $item['nama_menu'];
                $harga_m  = $item['harga'];
                $jumlah   = $item['jumlah'];
                $subtotal = $item['subtotal'];

                mysqli_query($koneksi, "INSERT INTO detail_pesanan (id_pesanan, id_menu, nama_menu, harga, jumlah, subtotal) 
                                        VALUES ('$id_pesanan_baru', '$id_menu', '$nama_m', '$harga_m', '$jumlah', '$subtotal')");
            }

            unset($_SESSION['keranjang']);
            echo "<script>alert('Pesanan Berhasil!'); window.location='pesanan_saya.php';</script>";
            exit();
        } else {
            $pesan = "Gagal simpan pesanan: " . mysqli_error($koneksi);
        }
    }
}

$id_user = $_SESSION['id_user'];
$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id_user=$id_user"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - FoodOrder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-merah { background-color: #dc3545; }
        .btn-merah { background-color: #dc3545; color: white; border: none; }
        .btn-merah:hover { background-color: #bb2d3b; color: white; }
        .harga { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-merah">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="menu.php">FoodOrder</a>
        <a href="keranjang.php" class="btn btn-outline-light btn-sm">← Kembali</a>
    </div>
</nav>

<div class="container py-4">
    <h4 class="mb-4">Checkout</h4>

    <?php if ($pesan != "") { ?>
        <div class="alert alert-danger"><?php echo $pesan; ?></div>
    <?php } ?>

    <div class="row">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Data Pengiriman</h6>
                    <form action="" method="POST" id="formCheckout">
                        <div class="mb-3">
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" name="nama_penerima" class="form-control" value="<?php echo $data_user['nama']; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="telepon" class="form-control" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Pengiriman</label>
                            <textarea name="alamat" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="pesan" class="btn btn-merah w-100">Konfirmasi Pesanan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Ringkasan Pesanan</h6>
                    <?php foreach ($_SESSION['keranjang'] as $item) { ?>
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <div class="small fw-bold"><?php echo $item['nama_menu']; ?></div>
                                <div class="text-muted small"><?php echo $item['jumlah']; ?> x Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></div>
                            </div>
                            <div class="small">Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></div>
                        </div>
                    <?php } ?>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total Bayar</span>
                        <span class="harga">Rp <?php echo number_format($total_belanja, 0, ',', '.'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
