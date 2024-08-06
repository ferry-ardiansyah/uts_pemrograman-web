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
require "../config/config.php";
// Ambil data dari url
$tb_produk = $_GET["id_produk"];
$editProduk = queryReadData("SELECT * FROM tb_produk WHERE id_produk = '$tb_produk'")[0];

 // Data kategori tb_produk
$kategori = queryReadData("SELECT * FROM kategori_produk"); 

if(isset($_POST["update"]) ) {
  
  if(updateProduk($_POST) > 0) {
    echo "<script>
    alert('Data tb_produk berhasil diupdate!');
    document.location.href = 'data_produk.php';
    </script>";
  }else {
    echo "<script>
    alert('Data tb_produk gagal diupdate!');
    </script>";
  }
  
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/admin/edit_buku.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Edit Produk || Admin</title>
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
                        <a class="nav-link text-light mx-3" href="data_produk.php">Produk</a>
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

    <div class="container p-3 mt-5 mb-5">
        <div class="card p-2 mt-5">
            <h1 class="text-center fw-bold p-3">Form Edit Produk</h1>
            <form action="" method="post" enctype="multipart/form-data" class="mt-3 p-2">

                <div class="mb-3">
                    <input type="hidden" name="coverLama" value="<?= $editProduk["cover"];?>">
                    <img src="../imgDB/<?= $editProduk["cover"]; ?>" width="80px" height="80px">
                    <label for="formFileMultiple" class="form-label">Cover Produk</label>
                    <input class="form-control" type="file" name="cover" id="formFileMultiple">
                </div>
                <div class="custom-css-form">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Id Produk</label>
                        <input type="text" class="form-control" name="id_produk" id="exampleFormControlInput1"
                            placeholder="example inf01" value="<?= $editProduk["id_produk"]; ?>" readonly>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book"></i></span>
                    <input type="text" class="form-control" name="produk" id="judul_buku" placeholder="Judul"
                        aria-label="Username" aria-describedby="basic-addon1" value="<?= $editProduk["produk"]; ?>">
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Kategori</label>
                    <select class="form-select" id="inputGroupSelect01" name="kategori">
                        <option selected><?= $editProduk["kategori"]; ?></option>
                        <?php foreach ($kategori as $item) : ?>
                        <option><?= $item["kategori"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Produsen</label>
                    <input type="text" class="form-control" name="produsen" id="exampleFormControlInput1"
                        placeholder="nama pengarang" value="<?= $editProduk["produsen"]; ?>">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Produksi</label>
                    <input type="text" class="form-control" name="produksi" id="exampleFormControlInput1"
                        placeholder="nama produksi" value="<?= $editProduk["produksi"]; ?>">
                </div>

                <label for="validationCustom01" class="form-label">Tahun Produksi</label>
                <div class="input-group mt-0">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-calendar-days"></i></span>
                    <input type="date" class="form-control" name="tahun_produksi" id="validationCustom01"
                        value="<?= $editProduk["tahun_produksi"]; ?>">
                </div>

                <label for="validationCustom01" class="form-label">Jumlah Produk</label>
                <div class="input-group mt-0 mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book-open"></i></span>
                    <input type="number" class="form-control" name="jumlah_produk" id="validationCustom01"
                        value="<?= $editProduk["jumlah_produk"]; ?>">
                </div>
                <div class="form-floating mt-3 mb-3">
                    <textarea class="form-control" placeholder="sinopsis tentang tb_produk ini" name="deskripsi_produk"
                        id="floatingTextarea2" style="height: 100px"><?= $editProduk["deskripsi_produk"]; ?></textarea>
                    <label for="floatingTextarea2">Sinopsis</label>
                </div>

                <button class="btn btn-warning" type="submit" name="update">Edit</button>
                <a class="btn btn-danger" href="data_produk.php">Batal</a>
            </form>
        </div>
    </div>

    <!-- Copyright -->
    <div class="text-center p-3 text-light" style="background-color:#012269">
        &copy; 2024 Website E-Manufaktur
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>