<?php
session_start();
include '../koneksi.php';


if (!isset($_SESSION['login']) || $_SESSION['login'] != true || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}


if (isset($_POST['update_status'])) {
    $id_pesanan = $_POST['id_pesanan'];
    $status     = $_POST['status'];
    mysqli_query($koneksi, "UPDATE pesanan SET status='$status' WHERE id_pesanan=$id_pesanan");
    echo "<script>alert('Status pesanan berhasil diperbarui!'); window.location='pesanan.php';</script>";
    exit();
}


$pesanan_detail = null;
$item_detail    = array();
if (isset($_GET['detail'])) {
    $id = $_GET['detail'];
    $r  = mysqli_query($koneksi, "SELECT pesanan.*, users.nama FROM pesanan 
                                   JOIN users ON pesanan.id_user = users.id_user 
                                   WHERE id_pesanan=$id");
    $pesanan_detail = mysqli_fetch_assoc($r);

    $r_item = mysqli_query($koneksi, "SELECT * FROM detail_pesanan WHERE id_pesanan=$id");
    while ($item = mysqli_fetch_assoc($r_item)) {
        $item_detail[] = $item;
    }
}


$query  = "SELECT pesanan.*, users.nama FROM pesanan 
           JOIN users ON pesanan.id_user = users.id_user 
           ORDER BY tanggal DESC";
$result = mysqli_query($koneksi, $query);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-merah { background-color: #dc3545; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-merah navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="dashboard.php">FoodOrder Admin</a>
        <div class="d-flex gap-2">
            <a href="dashboard.php" class="btn btn-outline-light btn-sm">Dashboard</a>
            <a href="menu.php"      class="btn btn-outline-light btn-sm">Menu</a>
            <a href="kategori.php"  class="btn btn-outline-light btn-sm">Kategori</a>
            <a href="users.php"     class="btn btn-outline-light btn-sm">Users</a>
            <a href="../logout.php" class="btn btn-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <h4 class="mb-4">Kelola Pesanan</h4>


    <?php if ($pesanan_detail != null) { ?>
    <div class="card mb-4 border-danger">
        <div class="card-header bg-danger text-white d-flex justify-content-between">
            <span>Detail Pesanan #<?php echo $pesanan_detail['id_pesanan']; ?></span>
            <a href="pesanan.php" class="text-white">Tutup</a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><b>Customer:</b> <?php echo $pesanan_detail['nama']; ?></p>
                    <p><b>Penerima:</b> <?php echo $pesanan_detail['nama_penerima']; ?></p>
                    <p><b>Telepon:</b>  <?php echo $pesanan_detail['telepon']; ?></p>
                    <p><b>Alamat:</b>   <?php echo $pesanan_detail['alamat']; ?></p>
                </div>
                <div class="col-md-6">
                    <p><b>Tanggal:</b> <?php echo date('d M Y H:i', strtotime($pesanan_detail['tanggal'])); ?></p>
                    <p><b>Status:</b>  <?php echo ucfirst($pesanan_detail['status']); ?></p>
                    <p><b>Total:</b>   Rp <?php echo number_format($pesanan_detail['total'], 0, ',', '.'); ?></p>
                </div>
            </div>

           
            <table class="table table-bordered mb-3">
                <thead class="table-secondary">
                    <tr><th>Nama Menu</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr>
                </thead>
                <tbody>
                <?php foreach ($item_detail as $item) { ?>
                <tr>
                    <td><?php echo $item['nama_menu']; ?></td>
                    <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo $item['jumlah']; ?> pcs</td>
                    <td>Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>

            
            <form action="" method="POST" class="d-flex align-items-center gap-2">
                <input type="hidden" name="id_pesanan" value="<?php echo $pesanan_detail['id_pesanan']; ?>">
                <label class="fw-bold mb-0">Ubah Status:</label>
                <select name="status" class="form-select" style="width: auto;">
                    <option value="menunggu"   <?php if ($pesanan_detail['status'] == 'menunggu')   echo 'selected'; ?>>Menunggu</option>
                    <option value="diproses"   <?php if ($pesanan_detail['status'] == 'diproses')   echo 'selected'; ?>>Diproses</option>
                    <option value="dikirim"    <?php if ($pesanan_detail['status'] == 'dikirim')    echo 'selected'; ?>>Dikirim</option>
                    <option value="selesai"    <?php if ($pesanan_detail['status'] == 'selesai')    echo 'selected'; ?>>Selesai</option>
                    <option value="dibatalkan" <?php if ($pesanan_detail['status'] == 'dibatalkan') echo 'selected'; ?>>Dibatalkan</option>
                </select>
                <button type="submit" name="update_status" class="btn btn-danger">Simpan</button>
            </form>
        </div>
    </div>
    <?php } ?>

    
    <div class="card">
        <div class="card-body">
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
                    elseif ($row['status'] == 'dikirim')   { $warna = 'info text-dark'; }
                    elseif ($row['status'] == 'selesai')   { $warna = 'success'; }
                    else                                   { $warna = 'danger'; }
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['nama_penerima']; ?></td>
                    <td>Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                    <td><?php echo date('d M Y H:i', strtotime($row['tanggal'])); ?></td>
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
    &copy; <?php echo date('Y'); ?> FoodOrder Admin
</div>

</body>
</html>
