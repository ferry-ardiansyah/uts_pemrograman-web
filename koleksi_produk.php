<?php 
session_start();
// Cek apakah user sudah login
if(!isset($_SESSION["signIn"])) {
    header("Location: ../login/login.php");
    exit;
}

require "../config/config.php";
$akunMember = $_SESSION["member"]["username_member"];
$dataPinjam = queryReadData("SELECT beli_produk.id_beli, beli_produk.id_produk, tb_produk.produk, beli_produk.username_member, member.nama_member, akun_admin.nama_admin, beli_produk.tanggal_beli
FROM beli_produk
INNER JOIN tb_produk ON beli_produk.id_produk = tb_produk.id_produk
INNER JOIN member ON beli_produk.username_member = member.username_member
INNER JOIN akun_admin ON beli_produk.id_admin = akun_admin.id_admin
WHERE beli_produk.username_member = '$akunMember'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link rel="stylesheet" href="../style/koleksi_buku.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- Navbar -->
    <div class="navbar navbar-expand-lg fixed-top shadow-sm" style="background-color:#012269">
        <div class="container">
            <a class="navbar-brand text-light" href="dashboard_member.php"><span
                    class="text-warning">E-</span>Manufaktur</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="dashboard_member.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="dashboard_member.php#profile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="menu_buku.php">E-Manufaktur</a>
                    </li>
                </ul>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div class="dropdown">
                    <i class="fa-solid fa-user text-center" id="dropdownMenuButton" data-bs-toggle="dropdown"
                        aria-expanded="false"
                        style="font-size:20px;background-color:white;color:#333333;border-radius:50%;width:35px;height:35px;cursor:pointer;display: flex; align-items: center; justify-content: center;"></i>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#koleksi">Daftar</a></li>
                        <li><a class="dropdown-item" href="?logout=true">Logout</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <!-- koleksi tb_produk -->
    <div class="p-4 mt-2 text-center">
        <div class="mt-5 alert alert-primary fw-bold text-capitalize" role="alert">- Daftar Buku Yang Dijual -
        </div>


        <div class="table-responsive mt-2" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-striped table-hover">
                <thead class="text-center align-middle">
                    <tr>
                        <th class="bg-primary text-light">Id Pembeli</th>
                        <th class="bg-primary text-light">Id Barang</th>
                        <th class="bg-primary text-light">Nama Barang</th>
                        <th class="bg-primary text-light">Username</th>
                        <th class="bg-primary text-light">Nama Pembeli</th>
                        <th class="bg-primary text-light">Nama Admin</th>
                        <th class="bg-primary text-light">Tanggal Pembelian</th>
                        <th class="bg-primary text-light">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($dataPinjam as $item) : ?>
                    <tr class="text-center align-middle">
                        <td><?= $item["id_beli"]; ?></td>
                        <td><?= $item["id_produk"]; ?></td>
                        <td><?= $item["produk"]; ?></td>
                        <td><?= $item["username_member"]; ?></td>
                        <td><?= $item["nama_member"]; ?></td>
                        <td><?= $item["nama_admin"]; ?></td>
                        <td><?= $item["tanggal_beli"]; ?></td>
                        <td>
                            <a href="delete.php?id_beli=<?= $item["id_beli"]; ?>"
                                onclick="return confirm('Yakin ingin menghapus data tb_produk ? ');"
                                style="padding: 5px;">
                                <i class="fa-solid fa-trash" style="font-size: 1.5em;"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Copyright -->
    <div class="text-center p-3 text-light" style="background-color:#012269">
        &copy; 2024 Website E-manufaktur
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>