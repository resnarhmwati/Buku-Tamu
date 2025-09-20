<?php
require_once('function.php');
include_once('templates/header.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">Buku Tamu</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <button type="button" class="btn btn-primary btn-icon-split">
        data-toggle="modal" data-target="#tambahModal">
          <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
          </span>
      </button>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Nama Tamu</th>
              <th>Alamat</th>
              <th>No. Telp/HP</th>
              <th>Bertemu Dengan</th>
              <th>Kepentingan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Nama Tamu</th>
              <th>Alamat</th>
              <th>No. Telp/HP</th>
              <th>Bertemu Dengan</th>
              <th>Kepentingan</th>
              <th>Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php
            $no = 1;
            $buku_tamu = query("SELECT * FROM buku_tamu");
            if($buku_tamu):
              foreach($buku_tamu as $tamu): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $tamu['tanggal'] ?></td>
                  <td><?= $tamu['nama_tamu'] ?></td>
                  <td><?= $tamu['alamat'] ?></td>
                  <td><?= $tamu['no_hp'] ?></td>
                  <td><?= $tamu['bertemu'] ?></td>
                  <td><?= $tamu['kepentingan'] ?></td>
                  <td>
                    <button class="btn btn-success btn-sm" type="button">Ubah</button>
                    <button class="btn btn-danger btn-sm" type="button">Hapus</button>
                  </td>
                </tr>
              <?php endforeach;
            else: ?>
              <tr>
                <td colspan="8" class="text-center">Belum ada data</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- ModalTambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<?php include_once('templates/footer.php'); ?>
