<?php
session_start();
include '../koneksi.php';


if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: menu.php");
    exit();
}

$id_pesanan = $_GET['id'];
$id_user    = $_SESSION['id_user'];

$q_pesanan  = "SELECT * FROM pesanan WHERE id_pesanan=$id_pesanan AND id_user=$id_user";
$r_pesanan  = mysqli_query($koneksi, $q_pesanan);


if (mysqli_num_rows($r_pesanan) == 0) {
    echo "<script>alert('Pesanan tidak ditemukan!'); window.location='menu.php';</script>";
    exit();
}

$pesanan = mysqli_fetch_assoc($r_pesanan);


$q_detail = "SELECT * FROM detail_pesanan WHERE id_pesanan=$id_pesanan";
$r_detail = mysqli_query($koneksi, $q_detail);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan - FoodOrder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f0f0; }

        
        .struk {
            background: white;
            width: 380px;
            margin: 30px auto;
            padding: 30px 24px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            font-family: 'Courier New', monospace;
        }
        .struk-judul {
            text-align: center;
            border-bottom: 2px dashed #ccc;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .struk-judul h4 { color: #dc3545; margin: 0; }
        .struk-judul p  { color: #888; font-size: 0.8rem; margin: 4px 0 0; }

        .struk-baris {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            padding: 3px 0;
        }
        .struk-garis { border: none; border-top: 1px dashed #ccc; margin: 10px 0; }
        .struk-total {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 1rem;
            padding: 6px 0;
        }
        .struk-footer {
            text-align: center;
            margin-top: 14px;
            font-size: 0.75rem;
            color: #888;
        }
        .label-section {
            font-size: 0.75rem;
            color: #666;
            font-weight: bold;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        
        .tombol-area {
            width: 380px;
            margin: 0 auto 40px;
            display: flex;
            gap: 10px;
        }

    
        @media print {
            body * { visibility: hidden; }
            .struk, .struk * { visibility: visible; }
            .struk { position: fixed; top: 0; left: 0; width: 100%; box-shadow: none; }
        }
    </style>
</head>
<body>


<div class="text-center pt-4 pb-2">
    <h4 class="text-success">Pesanan Berhasil Dibuat!</h4>
    <p class="text-muted small">Pesanan kamu sedang kami proses.</p>
</div>


<div class="struk" id="areaCetak">

   
    <div class="struk-judul">
        <h4>FoodOrder</h4>
        <p>Sistem Pemesanan Makanan Online</p>
    </div>

    
    <div class="label-section">Info Pesanan</div>
    <div class="struk-baris">
        <span>No. Pesanan</span>
        <span><b>#<?php echo $pesanan['id_pesanan']; ?></b></span>
    </div>
    <div class="struk-baris">
        <span>Tanggal</span>
        <span><?php echo date('d M Y H:i', strtotime($pesanan['tanggal'])); ?></span>
    </div>
    <div class="struk-baris">
        <span>Status</span>
        <span><?php echo ucfirst($pesanan['status']); ?></span>
    </div>

    <hr class="struk-garis">

    <div class="label-section">Data Penerima</div>
    <div class="struk-baris">
        <span>Nama</span>
        <span><?php echo $pesanan['nama_penerima']; ?></span>
    </div>
    <div class="struk-baris">
        <span>Telepon</span>
        <span><?php echo $pesanan['telepon']; ?></span>
    </div>
    <div class="struk-baris" style="align-items: flex-start;">
        <span>Alamat</span>
        <span style="text-align:right; max-width:200px;"><?php echo $pesanan['alamat']; ?></span>
    </div>

    <hr class="struk-garis">

    <div class="label-section">Item Pesanan</div>
    <?php while ($item = mysqli_fetch_assoc($r_detail)) { ?>
        <div class="struk-baris" style="align-items: flex-start;">
            <span>
                <?php echo $item['nama_menu']; ?><br>
                <small style="color:#888;"><?php echo $item['jumlah']; ?> x Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></small>
            </span>
            <span><b>Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></b></span>
        </div>
    <?php } ?>

    <hr class="struk-garis">

    
    <div class="struk-baris">
        <span>Subtotal</span>
        <span>Rp <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></span>
    </div>
    <div class="struk-baris">
        <span>Ongkos Kirim</span>
        <span style="color: green;">GRATIS</span>
    </div>
    <div class="struk-total">
        <span>TOTAL BAYAR</span>
        <span style="color: #dc3545;">Rp <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></span>
    </div>

    <hr class="struk-garis">

    <div class="struk-baris">
        <span>Metode Bayar</span>
        <span>COD (Bayar di Tempat)</span>
    </div>

    
    <div class="struk-footer">
        <hr class="struk-garis">
        <p>Terima kasih telah memesan!</p>
        <p>Simpan struk ini sebagai bukti pesanan.</p>
    </div>

</div>


->
<div class="tombol-area">
    <button onclick="window.print()" class="btn btn-danger flex-grow-1">
         Screenshot
    </button>
    <a href="pesanan_saya.php" class="btn btn-warning flex-grow-1">
        Pesanan Saya
    </a>
    <a href="menu.php" class="btn btn-outline-secondary flex-grow-1">
        Pesan Lagi
    </a>
</div>

</body>
</html>
