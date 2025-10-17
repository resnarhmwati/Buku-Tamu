<?php
require_once('function.php');
include_once 'templates/header.php';

// Membuat id_tamu otomatis
$query = mysqli_query($koneksi, "SELECT MAX(id_tamu) as kodeTerbesar FROM buku_tamu");
$data = mysqli_fetch_array($query);
$kodeTamu = $data['kodeTerbesar'];
$urutan = 1; // default kalau tabel kosong
if ($kodeTamu) {
    $urutan = (int) substr($kodeTamu, 2, 3);
    $urutan++;
}
$huruf = "TM";
$kodeTamu = $huruf . sprintf("%03s", $urutan);

// ==== PROSES SIMPAN DATA TAMU ====
if (isset($_POST["simpan"])) {
    // panggil fungsi tambah_tamu dari function.php
    if (tambah_tamu($_POST) > 0) {
        echo "<script>
                alert('Data tamu berhasil ditambahkan!');
                document.location.href = 'buku_tamu.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Data tamu gagal ditambahkan!');
                document.location.href = 'buku_tamu.php';
              </script>";
        exit;
    }
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Buku Tamu</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#tambahModal">
                <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                <span class="text">Data Tamu</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Nama Tamu</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">No HP</th>
                            <th class="text-center">Bertemu</th>
                            <th class="text-center">Kepentingan</th>
                            <th colspan="2" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $buku_tamu = query("SELECT * FROM buku_tamu ORDER BY tanggal DESC");
                        foreach ($buku_tamu as $tamu) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $tamu['tanggal']; ?></td>
                                <td><?= $tamu['nama_tamu']; ?></td>
                                <td><?= $tamu['alamat']; ?></td>
                                <td><?= $tamu['no_hp']; ?></td>
                                <td><?= $tamu['bertemu']; ?></td>
                                <td><?= $tamu['kepentingan']; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-success" href="edit_tamu.php?id=<?= $tamu['id_tamu']; ?>">Ubah</a>
                                </td>
                                <td class="text-center">
                                    <a href="hapus_tamu.php?id=<?= $tamu['id_tamu']; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Tamu -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Data Tamu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_tamu" value="<?= $kodeTamu; ?>">
                    <div class="form-group row">
                        <label for="nama_tamu" class="col-sm-3 col-form-label">Nama Tamu</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_tamu" id="nama_tamu" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="alamat" id="alamat" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_hp" class="col-sm-3 col-form-label">No. Telepon</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="no_hp" id="no_hp" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bertemu" class="col-sm-3 col-form-label">Bertemu dg.</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="bertemu" id="bertemu" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kepentingan" class="col-sm-3 col-form-label">Kepentingan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="kepentingan" id="kepentingan" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="gambar" class="col-sm-3 col-form-label">Unggah Foto</label>
                        <div class="custom-file col-sm-8">
                            <input type="file" class="custom-file-input" id="gambar" name="gambar">
                            <label for="gambar" class="custom-file-label">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="simpan" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once 'templates/footer.php'; ?>