<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("Location: ../login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

$query  = "SELECT * FROM pesanan WHERE id_user=$id_user ORDER BY tanggal DESC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - FoodOrder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-merah { background-color: #dc3545; }
        .status-menunggu  { background: #ffc107; color: #333; }
        .status-diproses  { background: #0d6efd; color: white; }
        .status-dikirim   { background: #6f42c1; color: white; }
        .status-selesai   { background: #198754; color: white; }
        .status-dibatalkan{ background: #dc3545; color: white; }
    </style>
</head>
<body class="bg-light">


<nav class="navbar navbar-merah">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="menu.php">FoodOrder</a>
        <div class="d-flex gap-2">
            <a href="menu.php" class="btn btn-outline-light btn-sm">Menu</a>
            <a href="keranjang.php" class="btn btn-warning btn-sm">Keranjang</a>
            <a href="../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <h4 class="mb-4">Pesanan Saya</h4>

    <?php if (mysqli_num_rows($result) == 0) { ?>
        
        <div class="text-center py-5">
            <h1>📭</h1>
            <h5 class="text-muted">Belum ada pesanan</h5>
            <a href="menu.php" class="btn btn-danger mt-3">Mulai Pesan</a>
        </div>

    <?php } else { ?>

        <?php while ($pesanan = mysqli_fetch_assoc($result)) { ?>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h6 class="mb-0">Pesanan #<?php echo $pesanan['id_pesanan']; ?></h6>
                            <small class="text-muted"><?php echo date('d M Y H:i', strtotime($pesanan['tanggal'])); ?></small>
                        </div>
                        <span class="badge status-<?php echo $pesanan['status']; ?>">
                            <?php echo ucfirst($pesanan['status']); ?>
                        </span>
                    </div>

                    
                    <?php
                    $id_pes    = $pesanan['id_pesanan'];
                    $q_detail  = "SELECT * FROM detail_pesanan WHERE id_pesanan=$id_pes";
                    $r_detail  = mysqli_query($koneksi, $q_detail);
                    while ($item = mysqli_fetch_assoc($r_detail)) {
                    ?>
                        <div class="d-flex justify-content-between text-muted small">
                            <span>🍜 <?php echo $item['nama_menu']; ?> x<?php echo $item['jumlah']; ?></span>
                            <span>Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></span>
                        </div>
                    <?php } ?>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">📍 <?php echo $pesanan['alamat']; ?></small><br>
                            <b>Total: Rp <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></b>
                        </div>
                        <a href="struk.php?id=<?php echo $pesanan['id_pesanan']; ?>"
                           class="btn btn-outline-danger btn-sm">
                             Lihat Struk
                        </a>
                    </div>
                </div>
            </div>

        <?php } ?>

    <?php } ?>

</div>

<div class="text-center text-muted py-3">
    &copy; <?php echo date('Y'); ?> FoodOrder
</div>

</body>
</html>
