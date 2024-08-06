<?php
session_start();
// Cek apakah user sudah login
if(!isset($_SESSION["signIn"])) {
header("Location: ../login/login.php");
exit;
}

// Proses logout
if(isset($_GET['logout'])) {
session_unset();
session_destroy();
header("Location: ../index.php");
exit;
}
// Halaman pengelolaan peminjaman tb_produk perpustakaan
require "../config/config.php";
$dataPeminjam = queryReadData("SELECT beli_produk.id_beli, beli_produk.id_produk, tb_produk.produk, beli_produk.username_member, member.nama_member, member.pekerjaan, member.jabatan, beli_produk.id_admin,  beli_produk.tanggal_beli
FROM beli_produk
INNER JOIN member ON beli_produk.username_member = member.username_member
INNER JOIN tb_produk ON beli_produk.id_produk = tb_produk.id_produk");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/admin/data_beli.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Data Pembeli || admin</title>
</head>

<body>

    <!-- Navbar -->
    <div class="navbar navbar-expand-lg navbar-light fixed-top mb-5" style="background-color:#012269">
        <div class="container">
            <a class="navbar-brand text-light" href="#"><span class="text-warning">E- </span>MANUFAKTUR</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-light mx-3" href="dashboard_admin.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light mx-3" href="data_member.php">Member</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light mx-3" href="data_produk.php">produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light mx-3" href="data_beli.php">Pembelian</a>
                    </li>
                </ul>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div class="dropdown">
                    <i class="fa-solid fa-user text-center" id="dropdownMenuButton" data-bs-toggle="dropdown"
                        aria-expanded="false"
                        style="font-size:20px;background-color:white;color:#333333;border-radius:50%;width:35px;height:35px;cursor:pointer;display: flex; align-items: center; justify-content: center;"></i>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="?logout=true">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="p-4 mt-2">

        <div class="mt-5">
            <div class="mt-5 alert alert-primary fw-bold text-capitalize text-center" role="alert">- List produk Yang Di
                beli -
            </div>
            <div class="table-responsive mt-3" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-striped table-hover">
                    <thead class="text-center align-middle">
                        <tr>
                            <th class="bg-primary text-light">Id Pembelin</th>
                            <th class="bg-primary text-light">Id Produk</th>
                            <th class="bg-primary text-light">Produk</th>
                            <th class="bg-primary text-light">Username</th>
                            <th class="bg-primary text-light">Nama</th>
                            <th class="bg-primary text-light">Pekerjaan</th>
                            <th class="bg-primary text-light">Jabatan</th>
                            <th class="bg-primary text-light">Id Admin</th>
                            <th class="bg-primary text-light">Tanggal beli</th>
                        </tr>
                    </thead>
                    <?php foreach ($dataPeminjam as $item) : ?>
                    <tr class="text-center align-middle">
                        <td><?= $item["id_beli"]; ?></td>
                        <td><?= $item["id_produk"]; ?></td>
                        <td><?= $item["produk"]; ?></td>
                        <td><?= $item["username_member"]; ?></td>
                        <td><?= $item["nama_member"]; ?></td>
                        <td><?= $item["pekerjaan"]; ?></td>
                        <td><?= $item["jabatan"]; ?></td>
                        <td><?= $item["id_admin"]; ?></td>
                        <td><?= $item["tanggal_beli"]; ?></td>
                    </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="text-center p-3 text-light" style="background-color:#012269">
        &copy; 2024 Website E-manufaktur
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>