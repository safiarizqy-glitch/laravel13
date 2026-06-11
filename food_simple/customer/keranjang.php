<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("Location: ../login.php");
    exit();
}


if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    unset($_SESSION['keranjang'][$id_hapus]);
    header("Location: keranjang.php");
    exit();
}

if (isset($_GET['kosong'])) {
    $_SESSION['keranjang'] = array();
    header("Location: keranjang.php");
    exit();
}

if (isset($_POST['update'])) {
    $qty_baru = $_POST['qty'];

    foreach ($qty_baru as $id_menu => $jumlah) {
        $jumlah = (int)$jumlah;
        if ($jumlah <= 0) {
            
            unset($_SESSION['keranjang'][$id_menu]);
        } else {
            $_SESSION['keranjang'][$id_menu]['jumlah']  = $jumlah;
            $_SESSION['keranjang'][$id_menu]['subtotal'] = $jumlah * $_SESSION['keranjang'][$id_menu]['harga'];
        }
    }
    header("Location: keranjang.php");
    exit();
}

$total_belanja = 0;
if (isset($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $item) {
        $total_belanja = $total_belanja + $item['subtotal'];
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - FoodOrder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-merah { background-color: #dc3545; }
        .btn-merah { background-color: #dc3545; color: white; border: none; }
        .btn-merah:hover { background-color: #bb2d3b; color: white; }
        .harga { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-merah navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="menu.php">FoodOrder</a>
        <div class="d-flex gap-2">
            <a href="menu.php" class="btn btn-outline-light btn-sm">Menu</a>
            <a href="../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <h4 class="mb-4">Keranjang Belanja</h4>

    <?php if (empty($_SESSION['keranjang'])) { ?>
        <div class="text-center py-5">
            <h5 class="text-muted">Keranjang masih kosong</h5>
            <a href="menu.php" class="btn btn-merah mt-3">Lihat Menu</a>
        </div>

    <?php } else { ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                        <?php foreach ($_SESSION['keranjang'] as $id_menu => $item) { ?>
                            <div class="d-flex align-items-center border-bottom py-3 gap-3">
                        
                                <img src="../images/<?php echo $item['foto']; ?>"
                                     width="80" height="65"
                                     style="object-fit:cover; border-radius:8px;"
                                     onerror="this.src='https://via.placeholder.com/80x65?text=No+Img'">

                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><?php echo $item['nama_menu']; ?></h6>
                                    <small class="text-muted">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?> / porsi</small>
                                </div>

                                <input type="number" name="qty[<?php echo $id_menu; ?>]"
                                       value="<?php echo $item['jumlah']; ?>"
                                       min="0" class="form-control" style="width: 70px;">

                                <div class="harga" style="min-width: 110px; text-align:right;">
                                    Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?>
                                </div>

                                
                                <a href="keranjang.php?hapus=<?php echo $id_menu; ?>"
                                   onclick="return confirm('Hapus item ini?')"   
                            </div>
                        <?php } ?>

                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" name="update" class="btn btn-warning btn-sm">Update</button>
                                <a href="keranjang.php?kosong=1"
                                   onclick="return confirm('Kosongkan semua keranjang?')"
                                   class="btn btn-outline-secondary btn-sm">Kosongkan</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

         
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Ringkasan</h6>

                        <?php foreach ($_SESSION['keranjang'] as $item) { ?>
                            <div class="d-flex justify-content-between small mb-1">
                                <span><?php echo $item['nama_menu']; ?> x<?php echo $item['jumlah']; ?></span>
                                <span>Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></span>
                            </div>
                        <?php } ?>

                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span class="harga">Rp <?php echo number_format($total_belanja, 0, ',', '.'); ?></span>
                        </div>
                        <div class="d-grid mt-3">
                            <a href="checkout.php" class="btn btn-merah">Lanjut Checkout →</a>
                        </div>
                        <div class="d-grid mt-2">
                            <a href="menu.php" class="btn btn-outline-secondary btn-sm">Tambah Menu Lagi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
</div>

<div class="text-center text-muted py-3">
    &copy; <?php echo date('Y'); ?> FoodOrder
</div>

</body>
</html>
