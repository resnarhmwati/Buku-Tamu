<?php
include_once 'templates/header.php';
require_once 'koneksi.php';
require_once 'function.php';

// jika ada tombol simpan
if (isset($_POST['simpan'])) {
  if (ubah_tamu($_POST) > 0) {
    echo "<script>
                alert('Data berhasil diubah!');
                window.location.href='buku_tamu.php';
              </script>";
  } else {
    echo "<script>
                alert('Data gagal diubah!');
                window.location.href='buku_tamu.php';
              </script>";
  }
}

// jika ada parameter id di URL
if (isset($_GET['id'])) {
  $id_tamu = mysqli_real_escape_string($koneksi, $_GET['id']);
  $result = mysqli_query($koneksi, "SELECT * FROM buku_tamu WHERE id_tamu = '$id_tamu'");
  $data = mysqli_fetch_assoc($result);
}
?>

<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Ubah Data Tamu</h1>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6>Form Edit Tamu</h6>
    </div>
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_tamu" value="<?= $data['id_tamu'] ?>">
        <input type="hidden" name="gambarLama" value="<?= $data['gambar'] ?>">

        <div class="form-group row">
          <label for="nama_tamu" class="col-sm-3 col-form-label">Nama Tamu</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="nama_tamu" id="nama_tamu"
              value="<?= $data['nama_tamu'] ?>" required>
          </div>
        </div>

        <div class="form-group row">
          <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
          <div class="col-sm-8">
            <textarea class="form-control" name="alamat" id="alamat" required><?= $data['alamat'] ?></textarea>
          </div>
        </div>

        <div class="form-group row">
          <label for="no_hp" class="col-sm-3 col-form-label">No. Telepon</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="no_hp" id="no_hp"
              value="<?= $data['no_hp'] ?>" required>
          </div>
        </div>

        <div class="form-group row">
          <label for="bertemu" class="col-sm-3 col-form-label">Bertemu dg.</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="bertemu" id="bertemu"
              value="<?= $data['bertemu'] ?>" required>
          </div>
        </div>

        <div class="form-group row">
          <label for="kepentingan" class="col-sm-3 col-form-label">Kepentingan</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="kepentingan" id="kepentingan"
              value="<?= $data['kepentingan'] ?>" required>
          </div>
        </div>

        <div class="form-group row">
          <label for="gambar" class="col-sm-3 col-form-label">Gambar Foto</label>
          <div class="col-sm-8">
            <?php if (!empty($data['gambar'])): ?>
              <img src="assets/upload_gambar/<?= $data['gambar'] ?>" alt="Foto Tamu" width="120" class="mb-2">
            <?php endif; ?>
            <input type="file" class="form-control" name="gambar" id="gambar">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-8 offset-sm-3 d-flex justify-content-end gap-2">
            <a class="btn btn-danger" href="buku_tamu.php">Kembali</a>
            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include_once 'templates/footer.php'; ?>