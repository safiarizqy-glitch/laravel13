<?php
session_start();
include '../koneksi.php';


if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("Location: ../login.php");
    exit();
}
if ($_SESSION['role'] != 'admin') {
    header("Location: ../customer/menu.php");
    exit();
}

$total_menu     = mysqli_num_rows(mysqli_query($koneksi, "SELECT id_menu FROM menu"));
$total_pesanan  = mysqli_num_rows(mysqli_query($koneksi, "SELECT id_pesanan FROM pesanan"));
$total_user     = mysqli_num_rows(mysqli_query($koneksi, "SELECT id_user FROM users"));

$r_pendapatan   = mysqli_query($koneksi, "SELECT SUM(total) AS jml FROM pesanan WHERE status='selesai'");
$d_pendapatan   = mysqli_fetch_assoc($r_pendapatan);
$pendapatan     = $d_pendapatan['jml'];
if ($pendapatan == null) { $pendapatan = 0; }

$r_menunggu     = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM pesanan WHERE status='menunggu'");
$d_menunggu     = mysqli_fetch_assoc($r_menunggu);
$jml_menunggu   = $d_menunggu['jml'];


$query   = "SELECT pesanan.*, users.nama FROM pesanan 
            JOIN users ON pesanan.id_user = users.id_user 
            ORDER BY tanggal DESC LIMIT 5";
$result  = mysqli_query($koneksi, $query);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - FoodOrder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-merah { background-color: #ec14ae; }
        .card-stat { border-radius: 10px; border-left: 5px solid #ae0977; }
        .card-stat.hijau  { border-left-color: #02bf67; }
        .card-stat.kuning { border-left-color: #ffbf00; }
        .card-stat.biru   { border-left-color: #437dd4; }
        .angka-besar { font-size: 1.8rem; font-weight: bold; }
    </style>
</head>
<body class="bg-light">


<nav class="navbar navbar-merah navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="dashboard.php">FoodOrder Admin</a>
        <div class="d-flex gap-2">
            <a href="menu.php"     class="btn btn-outline-light btn-sm">Menu</a>
            <a href="kategori.php" class="btn btn-outline-light btn-sm">Kategori</a>
            <a href="pesanan.php"  class="btn btn-outline-light btn-sm">Pesanan</a>
            <a href="users.php"    class="btn btn-outline-light btn-sm">Users</a>
            <a href="../logout.php" class="btn btn-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <h4 class="mb-1">Dashboard Admin</h4>
    <p class="text-muted mb-4">Halo, <?php echo $_SESSION['nama']; ?>!</p>

    <!-- Kartu Statistik -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card card-stat p-3">
                <div class="text-muted small">Total Menu</div>
                <div class="angka-besar"><?php echo $total_menu; ?></div>
                <a href="menu.php" class="text-danger small">Menu Disini</a>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-stat hijau p-3">
                <div class="text-muted small">Pendapatan (Selesai)</div>
                <div class="angka-besar" style="font-size:1.2rem; color:#198754;">
                    Rp <?php echo number_format($pendapatan, 0, ',', '.'); ?>
                </div>
                <a href="pesanan.php" class="text-success small">Lihat pesanan →</a>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-stat kuning p-3">
                <div class="text-muted small">Pesanan Menunggu</div>
                <div class="angka-besar" style="color:#ffc107;"><?php echo $jml_menunggu; ?></div>
                <a href="pesanan.php" class="text-warning small">Proses sekarang →</a>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-stat biru p-3">
                <div class="text-muted small">Total Pengguna</div>
                <div class="angka-besar" style="color:#0d6efd;"><?php echo $total_user; ?></div>
                <a href="users.php" class="text-primary small">Lihat users →</a>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">5 Pesanan Terbaru</h6>
                <a href="pesanan.php" class="btn btn-danger btn-sm">Lihat Semua</a>
            </div>

            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Customer</th>
                        <th>Penerima</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    
                    if ($row['status'] == 'menunggu')    { $warna = 'warning text-dark'; }
                    elseif ($row['status'] == 'diproses')  { $warna = 'primary'; }
                    elseif ($row['status'] == 'dikirim')   { $warna = 'purple'; }
                    elseif ($row['status'] == 'selesai')   { $warna = 'success'; }
                    else                                   { $warna = 'danger'; }
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['nama_penerima']; ?></td>
                    <td>Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                    <td><?php echo date('d M Y', strtotime($row['tanggal'])); ?></td>
                    <td><span class="badge bg-<?php echo $warna; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                    <td>
                        <a href="pesanan.php?detail=<?php echo $row['id_pesanan']; ?>" 
                           class="btn btn-sm btn-outline-primary">Detail</a>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="text-center text-muted py-3">
    &copy; <?php echo date('Y'); ?> FoodOrder Admin Panel
</div>

</body>
</html>
