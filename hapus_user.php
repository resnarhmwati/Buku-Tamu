<?php
require_once 'function.php';

// Pastikan ada parameter id
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Jalankan fungsi hapus_user
    if (hapus_user($id) > 0) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location.href='users.php';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal dihapus!');
                window.location.href='users.php';
              </script>";
    }
} else {
    // Jika tidak ada id di URL
    echo "<script>
            alert('ID user tidak ditemukan!');
            window.location.href='users.php';
          </script>";
}
?>