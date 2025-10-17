<?php
require_once 'koneksi.php';
require_once 'function.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    if (hapus_tamu($id) > 0) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location.href='buku_tamu.php';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal dihapus!');
                window.location.href='buku_tamu.php';
              </script>";
    }
} else {
    echo "<script>
            alert('ID tidak ditemukan!');
            window.location.href='buku_tamu.php';
          </script>";
}
?>