<?php
$host = "localhost";
$username = "root";
$password = "";
$database_name = "manufaktur_feri";
$connection = mysqli_connect($host, $username, $password, $database_name);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// MENAMPILKAN DATA KATEGORI BUKU
function queryReadData($query, $params = []) {
  global $connection;
  $stmt = mysqli_prepare($connection, $query);
  
  if (!$stmt) {
    die("Prepare failed: " . mysqli_error($connection));
  }
  
  if (!empty($params)) {
    // Dynamically bind parameters
    $types = str_repeat('s', count($params)); // Assuming all params are strings
    mysqli_stmt_bind_param($stmt, $types, ...$params);
  }
  
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $items = [];
  
  while ($item = mysqli_fetch_assoc($result)) {
    $items[] = $item;
  }
  
  mysqli_stmt_close($stmt);
  return $items;
}

function tambahProduk($dataProduk) {
  global $connection;
  
  $idproduk = $dataProduk["id_produk"];
  $cover = upload();
  $kategoriProduk = $dataProduk["kategori"];
  $produk = $dataProduk["produk"];
  $produsen = $dataProduk["produsen"];
  $produksi = $dataProduk["produksi"];
  $tahunProduksi = $dataProduk["tahun_produksi"];
  $jumlahProduk = $dataProduk["jumlah_produk"];
  $deskripsiProduk = $dataProduk["deskripsi_produk"];
  
  if(!$cover) {
    return 0;
  } 
  
  $queryInsertDataBuku = "INSERT INTO tb_produk VALUES('$idproduk','$cover', '$kategoriProduk', '$produk', '$produsen', '$produksi', '$tahunProduksi', '$jumlahProduk', '$deskripsiProduk')";
  
  mysqli_query($connection, $queryInsertDataBuku);
  return mysqli_affected_rows($connection);
  
}       

// Function upload gambar 
function upload() {
  $namaFile = $_FILES["cover"]["name"];
  $ukuranFile = $_FILES["cover"]["size"];
  $error = $_FILES["cover"]["error"];
  $tmpName = $_FILES["cover"]["tmp_name"];
  
  // cek apakah ada gambar yg diupload
  if($error === 4) {
    echo "<script>
    alert('Silahkan upload cover tb_produk terlebih dahulu!')
    </script>";
    return 0;
  }
  
  // cek kesesuaian format gambar
  $jpg = "jpg";
  $jpeg = "jpeg";
  $png = "png";
  $svg = "svg";
  $bmp = "bmp";
  $psd = "psd";
  $tiff = "tiff";
  $formatGambarValid = [$jpg, $jpeg, $png, $svg, $bmp, $psd, $tiff];
  $ekstensiGambar = explode('.', $namaFile);
  $ekstensiGambar = strtolower(end($ekstensiGambar));
  
  if(!in_array($ekstensiGambar, $formatGambarValid)) {
    echo "<script>
    alert('Format file tidak sesuai');
    </script>";
    return 0;
  }
  
  // batas ukuran file
  if($ukuranFile > 2000000) {
    echo "<script>
    alert('Ukuran file terlalu besar!');
    </script>";
    return 0;
  }
  
   //generate nama file baru, agar nama file tdk ada yg sama
  $namaFileBaru = uniqid();
  $namaFileBaru .= ".";
  $namaFileBaru .= $ekstensiGambar;
  
  move_uploaded_file($tmpName, '../imgDB/' . $namaFileBaru);
  return $namaFileBaru;
} 

// Function to search for books
function search($keyword) {
  global $connection;
  $query = "SELECT * FROM tb_produk WHERE produk LIKE '%$keyword%' OR produsen LIKE '%$keyword%' OR produksi LIKE '%$keyword%' OR kategori LIKE '%$keyword%'";
  return queryReadData($query);
  }

function beliProduk($dataBeli) {
  global $connection;
  $id_produk = $dataBeli["id_produk"];
  $username_member = $dataBeli["username_member"];
  $id_admin = $dataBeli["id_admin"];
  $tanggal_beli = $dataBeli["tanggal_beli"];
  
  $queryBeliProduk = "INSERT INTO beli_produk VALUES (null,'$id_produk', '$username_member', '$id_admin','$tanggal_beli')";
  mysqli_query($connection, $queryBeliProduk);
  return mysqli_affected_rows($connection);
}


// Hapus member yang terdaftar
function deleteMember($username_member) {
  global $connection;
  
  $deleteMember = "DELETE FROM member WHERE username_member = '$username_member'";
  mysqli_query($connection, $deleteMember);
  return mysqli_affected_rows($connection);
}

// Hapus history pengembalian data BUKU
function deleteDataPengembalian($idPengembalian) {
  global $connection;
  
  $deleteDataPengembalianBuku = "DELETE FROM kembali_buku WHERE id_pengembalian = '$idPengembalian'";
  mysqli_query($connection, $deleteDataPengembalianBuku);
  return mysqli_affected_rows($connection);
}

// DELETE DATA Buku
function delete($produkId) {
  global $connection;
  $queryDeleteProduk = "DELETE FROM tb_produk WHERE id_produk = '$produkId'
  ";
  mysqli_query($connection, $queryDeleteProduk);
  
  return mysqli_affected_rows($connection);
}
function deletekoleksi($produkId) {
  global $connection;
  $queryDeleteProduk = "DELETE FROM beli_produk WHERE id_beli = '$produkId'
  ";
  mysqli_query($connection, $queryDeleteProduk);
  
  return mysqli_affected_rows($connection);
}

// UPDATE || EDIT DATA BUKU 
function updateProduk($dataProduk) {
  global $connection;

  $gambarLama = htmlspecialchars($dataProduk["coverLama"]);
  $id_produk = htmlspecialchars($dataProduk["id_produk"]);
  $kategoriBuku = $dataProduk["kategori"];
  $judulBuku = htmlspecialchars($dataProduk["produk"]);
  $penulisBuku = htmlspecialchars($dataProduk["produsen"]); 
  $penerbitBuku = htmlspecialchars($dataProduk["produksi"]);
  $tahunTerbit = $dataProduk["tahun_produksi"];
  $jumlahHalaman = $dataProduk["jumlah_produk"];
  $deskripsiBuku = htmlspecialchars($dataProduk["deskripsi_produk"]);
  
  
  // pengecekan mengganti gambar || tidak
  if($_FILES["cover"]["error"] === 4) {
    $cover = $gambarLama;
  }else {
    $cover = upload();
  }
  // 4 === gagal upload gambar
  // 0 === berhasil upload gambar
  
  $queryUpdate = "UPDATE tb_produk SET 
  cover = '$cover',
  id_produk = '$id_produk',
  kategori = '$kategoriBuku',
  produk = '$judulBuku',
  produsen = '$penulisBuku',
  produksi = '$penerbitBuku',
  tahun_produksi = '$tahunTerbit',
  jumlah_produk = $jumlahHalaman,
  deskripsi_produk = '$deskripsiBuku'
  WHERE id_produk = '$id_produk'
  ";
  
  mysqli_query($connection, $queryUpdate);
  return mysqli_affected_rows($connection);
}

// fungsi jumlah member
function jumlahMember() {
  global $connection;
  $query = "SELECT COUNT(*) AS count FROM member";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);
  return $row['count'];
}

// Function to get the count of books
function jumlahBuku() {
  global $connection;
  $query = "SELECT COUNT(*) AS count FROM tb_produk";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);
  return $row['count'];
}

// Function to get the count of borrowed books
function bukuDipinjam() {
  global $connection;
  $query = "SELECT COUNT(*) AS count FROM beli_produk";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);
  return $row['count'];
}
?>