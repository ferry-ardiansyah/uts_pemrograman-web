<?php 
require "../config/config.php";
$produkId = $_GET["id_beli"];

if(deletekoleksi($produkId) > 0) {
  echo "
  <script>
  alert('Data  berhasil dihapus');
  document.location.href = 'koleksi_produk.php';
  </script>";
}else {
  echo "
  <script>
  alert('Data buku gagal dihapus');
  document.location.href = 'koleksi_produk.php';
  </script>";
}
?>