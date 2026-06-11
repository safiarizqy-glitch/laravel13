<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] == 'admin') {
    header("Location: ../admin/dashboard.php");
    exit();
}

if (isset($_POST['tambah_keranjang'])) {
    $id_menu = $_POST['id_menu'];
    $jumlah  = $_POST['jumlah'];

    $query  = "SELECT * FROM menu WHERE id_menu=$id_menu";
    $result = mysqli_query($koneksi, $query);
    $menu   = mysqli_fetch_assoc($result);

    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = array();
    }

    if (isset($_SESSION['keranjang'][$id_menu])) {
        $_SESSION['keranjang'][$id_menu]['jumlah']  += $jumlah;
        $_SESSION['keranjang'][$id_menu]['subtotal']  = $_SESSION['keranjang'][$id_menu]['jumlah'] * $menu['harga'];
    } else {
        $_SESSION['keranjang'][$id_menu] = array(
            'id_menu'   => $id_menu,
            'nama_menu' => $menu['nama_menu'],
            'harga'     => $menu['harga'],
            'foto'      => $menu['foto'],
            'jumlah'    => $jumlah,
            'subtotal'  => $jumlah * $menu['harga']
        );
    }

    echo "<script>alert('Menu berhasil ditambahkan ke keranjang!'); window.location='menu.php';</script>";
    exit();
}


$filter_jenis = isset($_GET['jenis']) ? mysqli_real_escape_string($koneksi, $_GET['jenis']) : '';

if ($filter_jenis != '') {
    $query = "SELECT menu.*, kategori.nama_kategori, kategori.jenis FROM menu 
              JOIN kategori ON menu.id_kategori = kategori.id_kategori 
              WHERE kategori.jenis='$filter_jenis'
              ORDER BY menu.id_menu";
} else {
    $query = "SELECT menu.*, kategori.nama_kategori, kategori.jenis FROM menu 
              JOIN kategori ON menu.id_kategori = kategori.id_kategori 
              ORDER BY menu.id_menu";
}
$result = mysqli_query($koneksi, $query);


$result_jenis = mysqli_query($koneksi, "SELECT DISTINCT jenis FROM kategori WHERE jenis != '' ORDER BY jenis");

$total_keranjang = 0;
if (isset($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $item) {
        $total_keranjang += $item['jumlah'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - FoodOrder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-merah { background-color: #dc3545; }
        .card-menu { border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); height: 100%; }
        .card-menu img { height: 180px; object-fit: cover; border-radius: 10px 10px 0 0; }
        .harga { color: #dc3545; font-weight: bold; font-size: 1.1rem; }
        .btn-merah { background-color: #dc3545; color: white; border: none; }
        .btn-merah:hover { background-color: #bb2d3b; color: white; }
        .badge-keranjang { background-color: #ffc107; color: #333; font-weight: bold; }
        .btn-jenis { border-radius: 20px; font-size: 0.8rem; }
        .btn-jenis.active { background-color: white !important; color: #dc3545 !important; font-weight: bold; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-merah navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="menu.php">FoodOrder</a>
        <div class="d-flex align-items-center gap-2 flex-wrap">

            <a href="menu.php" class="btn btn-outline-light btn-sm btn-jenis <?php echo $filter_jenis == '' ? 'active' : ''; ?>">Semua</a>
            <?php while ($j = mysqli_fetch_assoc($result_jenis)) {
                $active = ($filter_jenis == $j['jenis']) ? 'active' : '';
                echo "<a href='menu.php?jenis=" . urlencode($j['jenis']) . "' class='btn btn-outline-light btn-sm btn-jenis $active'>" . htmlspecialchars($j['jenis']) . "</a>";
            } ?>

            <span class="text-white small ms-2">Halo, <?php echo $_SESSION['nama']; ?>!</span>
            <a href="keranjang.php" class="btn btn-warning btn-sm">
                Keranjang
                <?php if ($total_keranjang > 0) { ?>
                    <span class="badge badge-keranjang"><?php echo $total_keranjang; ?></span>
                <?php } ?>
            </a>
            <a href="pesanan_saya.php" class="btn btn-light btn-sm">Pesanan Saya</a>
            <a href="../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="bg-danger text-white text-center py-4">
    <h2>Pilih Makananmu</h2>
    <p class="mb-0">Pesan sekarang, diantar ke rumahmu!</p>
</div>

<div class="container py-4">
    <?php if ($filter_jenis != '') { ?>
        <p class="text-muted mb-3">Menampilkan jenis: <strong><?php echo htmlspecialchars($filter_jenis); ?></strong> — <a href="menu.php">Lihat Semua</a></p>
    <?php } ?>

    <div class="row">
    <?php
    $ada_menu = false;
    while ($menu = mysqli_fetch_assoc($result)) {
        $ada_menu = true;
    ?>
        <div class="col-md-3 mb-4">
            <div class="card card-menu">
                <img src="../images/<?php echo $menu['foto']; ?>"
                     class="card-img-top"
                     alt="<?php echo $menu['nama_menu']; ?>"
                     onerror="this.src='https://via.placeholder.com/300x180?text=No+Image'">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center gap-1 mb-1">
                        <small class="text-muted">📂 <?php echo $menu['nama_kategori']; ?></small>
                        <span class="badge bg-warning text-dark" style="font-size:0.7rem;"><?php echo htmlspecialchars($menu['jenis']); ?></span>
                    </div>
                    <h6 class="card-title mt-1"><?php echo $menu['nama_menu']; ?></h6>
                    <p class="card-text text-muted small"><?php echo $menu['deskripsi']; ?></p>

                    <div class="mt-auto">
                        <p class="harga mb-2">Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></p>

                        <?php if ($menu['stok'] > 0) { ?>
                            <form action="" method="POST">
                                <input type="hidden" name="id_menu" value="<?php echo $menu['id_menu']; ?>">
                                <div class="d-flex gap-2">
                                    <input type="number" name="jumlah" value="1" min="1" max="<?php echo $menu['stok']; ?>"
                                           class="form-control form-control-sm" style="width: 65px;">
                                    <button type="submit" name="tambah_keranjang" class="btn btn-merah btn-sm flex-grow-1">
                                        + Keranjang
                                    </button>
                                </div>
                            </form>
                        <?php } else { ?>
                            <span class="text-danger small fw-bold">Stok Habis</span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php }

    if (!$ada_menu) { ?>
        <div class="col-12 text-center text-muted py-5">
            <h5>Tidak ada menu untuk jenis ini.</h5>
            <a href="menu.php" class="btn btn-danger mt-2">Lihat Semua Menu</a>
        </div>
    <?php } ?>
    </div>
</div>

<div class="text-center text-muted py-3">
    &copy; <?php echo date('Y'); ?> FoodOrder - Sistem Pemesanan Makanan Online
</div>

</body>
</html>
