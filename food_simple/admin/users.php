<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] != true || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    

    if ($id == $_SESSION['id_user']) {
        echo "<script>alert('Tidak bisa menghapus akun sendiri!'); window.location='users.php';</script>";
        exit();
    }
    mysqli_query($koneksi, "DELETE FROM users WHERE id_user=$id");
    echo "<script>alert('User berhasil dihapus!'); window.location='users.php';</script>";
    exit();
}


if (isset($_POST['edit'])) {
    $id       = $_POST['id_user'];
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $role     = $_POST['role'];
    $password = $_POST['password'];

    if (empty($password)) {
        
        mysqli_query($koneksi, "UPDATE users SET nama='$nama', username='$username', role='$role' WHERE id_user=$id");
    } else {
        $password = mysqli_real_escape_string($koneksi, $password);
        mysqli_query($koneksi, "UPDATE users SET nama='$nama', username='$username', role='$role', password='$password' WHERE id_user=$id");
    }
    echo "<script>alert('User berhasil diperbarui!'); window.location='users.php';</script>";
    exit();
}


$data_edit = null;
if (isset($_GET['edit'])) {
    $id        = $_GET['edit'];
    $r_edit    = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user=$id");
    $data_edit = mysqli_fetch_assoc($r_edit);
}

$result = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id_user DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - Admin</title>
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
            <a href="pesanan.php"   class="btn btn-outline-light btn-sm">Pesanan</a>
            <a href="../logout.php" class="btn btn-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <h4 class="mb-4">Kelola Pengguna</h4>

    <div class="row">
        <?php if ($data_edit != null) { ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h6>✏️ Edit User</h6>
                    <form action="" method="POST">
                        <input type="hidden" name="id_user" value="<?php echo $data_edit['id_user']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control"
                                   value="<?php echo $data_edit['nama']; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control"
                                   value="<?php echo $data_edit['username']; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="admin"    <?php if ($data_edit['role'] == 'admin')    echo 'selected'; ?>>Admin</option>
                                <option value="customer" <?php if ($data_edit['role'] == 'customer') echo 'selected'; ?>>Customer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Kosongkan jika tidak diganti">
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" name="edit" class="btn btn-warning">Simpan</button>
                            <a href="users.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>

        
        <div class="<?php if ($data_edit) { echo 'col-md-8'; } else { echo 'col-12'; } ?>">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="mb-0">Daftar Pengguna</h6>
                        <a href="../register.php" class="btn btn-danger btn-sm">➕ Tambah User</a>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
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
                            <td>
                                <?php echo $row['nama']; ?>
                                <?php if ($row['id_user'] == $_SESSION['id_user']) { ?>
                                    <span class="badge bg-warning text-dark">Kamu</span>
                                <?php } ?>
                            </td>
                            <td><?php echo $row['username']; ?></td>
                            <td>
                                <?php if ($row['role'] == 'admin') { ?>
                                    <span class="badge bg-danger">Admin</span>
                                <?php } else { ?>
                                    <span class="badge bg-primary">Customer</span>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="users.php?edit=<?php echo $row['id_user']; ?>"
                                   class="btn btn-sm btn-warning">Edit</a>
                                <?php if ($row['id_user'] != $_SESSION['id_user']) { ?>
                                <a href="users.php?hapus=<?php echo $row['id_user']; ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Hapus user <?php echo $row['nama']; ?>?')">
                                   Hapus
                                </a>
                                <?php } ?>
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
