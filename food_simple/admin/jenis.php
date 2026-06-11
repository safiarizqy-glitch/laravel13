<?php
session_start();
include '..jenis.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] != true || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM jenis WHERE id_jenis=$id");
    echo "<script>alert('Jenis berhasil dihapus!'); window.location='jenis.php';</script>";
    exit();
}


if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_jenis']);
    if (empty($nama)) {
        echo "<script>alert('Nama jenis wajib diisi!'); window.location='jenis.php';</script>";
        exit();
    }
    mysqli_query($koneksi, "INSERT INTO jenis (nama_jenis) VALUES ('$nama')");
    echo "<script>alert('Jenis berhasil ditambahkan!'); window.location='jenis.php';</script>";
    exit();
}


if (isset($_POST['edit'])) {
    $id   = $_POST['id_jenis'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_jenis']);
    mysqli_query($koneksi, "UPDATE jenis SET nama_jenis='$nama' WHERE id_jenis=$id");
    echo "<script>alert('Jenis berhasil diperbarui!'); window.location='jenis.php';</script>";
    exit();
}


$data_edit = null;
if (isset($_GET['edit'])) {
    $id        = $_GET['edit'];
    $r_edit    = mysqli_query($koneksi, "SELECT * FROM jenis WHERE id_jenis=$id");
    $data_edit = mysqli_fetch_assoc($r_edit);
}


$query  = "SELECT jenis.id_jenis, jenis.nama_jenis, COUNT(menu.id_menu) AS jml_menu 
           FROM jenis LEFT JOIN menu ON jenis.id_jenis = menu.id_jenis
           GROUP BY jenis.id_jenis, jenis.nama_jenis ORDER BY jenis.id_jenis DESC";
 $result = mysql_query($koneksi, $query)
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenis - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-merah { background-color: #ff011b; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-merah navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="dashboard.php">FoodOrder Admin</a>
        <div class="d-flex gap-2">
            <a href="dashboard.php" class="btn btn-outline-light btn-sm">Dashboard</a>
            <a href="menu.php"      class="btn btn-outline-light btn-sm">Menu</a>
            <a href="pesanan.php"   class="btn btn-outline-light btn-sm">Pesanan</a>
            <a href="users.php"     class="btn btn-outline-light btn-sm">Users</a>
            <a href="kategori.php"     class="btn btn-outline-light btn-sm">Kategori</a>
            <a href="jenis.php"    class="btn btn-outline-light btn-sm">Jenis</a>
            <a href="../logout.php" class="btn btn-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <h4 class="mb-4">Kelola Jenis</h4>

    <div class="row">
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h6><?php if ($data_edit) { echo "Edit Jenis"; } else { echo "Tambah Jenis"; } ?></h6>
                    <form action="" method="POST">
                        <?php if ($data_edit) { ?>
                            <input type="hidden" name="id_jenis" value="<?php echo $data_edit['id_jenis']; ?>">
                        <?php } ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Jenis</label>
                            <input type="text" name="nama_jenis" class="form-control"
                                   placeholder="Contoh: manis"
                                   value="<?php if ($data_edit) { echo $data_edit['nama_jenis']; } ?>">
                        </div>
                        <div class="d-flex gap-2">
                            <?php if ($data_edit) { ?>
                                <button type="submit" name="edit" class="btn btn-warning">Simpan</button>
                                <a href="jenis.php" class="btn btn-secondary">Batal</a>
                            <?php } else { ?>
                                <button type="submit" name="tambah" class="btn btn-danger">Tambah</button>


                            <label class="form-label">Jenis</label>
                            <input type="text" name="jenis" class="form-control"
                                   placeholder="Contoh: Manis"
                                   value="<?php if ($data_edit) { echo $data_edit['jenis']; } ?>">
                        </div>
                        <div class="d-flex gap-2">
                            <?php if ($data_edit) { ?>
                                <button type="submit" name="edit" class="btn btn-warning">Simpan</button>
                                <a href="jenis.php" class="btn btn-secondary">Batal</a>
                            <?php } else { ?>
                                <button type="submit" name="tambah" class="btn btn-danger">Tambah</button>

                            <?php } }?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Daftar jenis</h6>
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Jenis</th>
                                <th>Jumlah Menu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['nama_jenis']; ?></td>
                            <td><span class="badge bg-primary"><?php echo $row['jml_menu']; ?> menu</span></td>
                            <td>
                                <a href="jenis.php?edit=<?php echo $row['id_jenis']; ?>"
                                   class="btn btn-sm btn-warning">Edit</a>
                                <a href="jenis.php?hapus=<?php echo $row['id_jenis']; ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Hapus jenis ini?')">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-center text-muted py-3">
    &copy; <?php echo date('Y'); ?> FoodOrder Admin
</div>

</body>
</html>