<?php
include('templates/header.php');
require_once('function.php');

if (isset($_POST['tampilkan'])) {
    $p_awal = $_POST['p_awal'];
    $p_akhir = $_POST['p_akhir'];

    $link = "export-laporan.php?cari=true&p_awal=$p_awal&p_akhir=$p_akhir";
    $buku_tamu = query("SELECT * FROM buku_tamu WHERE tanggal BETWEEN '$p_awal' AND '$p_akhir' ");
} else {
    $buku_tamu = query("SELECT * FROM buku_tamu ORDER BY id_tamu DESC");
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Laporan Tamu</h1>

    <!-- Form Periode -->
    <div class="row mx-auto d-flex justify-content-center">
        <div class="col-xl-8 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <form method="post" action="" class="d-flex align-items-end">
                        <div class="d-flex flex-grow-1 align-items-end">
                            <div class="mr-2">
                                <label for="p_awal" class="font-weight-bold text-primary mb-1">Periode</label>
                                <input type="date" class="form-control" id="p_awal" name="p_awal" required>
                            </div>
                            <div class="mr-2">
                                <label for="p_akhir" class="font-weight-bold text-primary mb-1">s.d</label>
                                <input type="date" class="form-control" id="p_akhir" name="p_akhir" required>
                            </div>
                            <div class="mr-2">
                                <button type="submit" name="tampilkan" class="btn btn-primary">Tampilkan</button>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Histori Tamu -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?= isset($_POST['tampilkan']) ? $link : 'export-laporan.php';?>" target="_blank" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-file-excel"></i>
                </span>
                <span class="text">Export to Excel</span>
            </a>
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
                            <th class="text-center">No. Telp/HP</th>
                            <th class="text-center">Bertemu Dengan</th>
                            <th class="text-center">Kepentingan</th>
                            <th class="text-center" colspan="2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (isset($_POST['tampilkan'])) {
                            foreach ($buku_tamu as $tamu) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= $tamu['tanggal']; ?></td>
                                    <td class="text-center"><?= $tamu['nama_tamu']; ?></td>
                                    <td><?= $tamu['alamat']; ?></td>
                                    <td class="text-center"><?= $tamu['no_hp']; ?></td>
                                    <td class="text-center"><?= $tamu['bertemu']; ?></td>
                                    <td><?= $tamu['kepentingan']; ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-success" href="edit-tamu.php?id=<?= $tamu['id_tamu']; ?>">Ubah</a>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-danger" href="hapus-tamu.php?id=<?= $tamu['id_tamu']; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach;
                        } else {
                            foreach ($buku_tamu as $tamu) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= $tamu['tanggal']; ?></td>
                                    <td class="text-center"><?= $tamu['nama_tamu']; ?></td>
                                    <td><?= $tamu['alamat']; ?></td>
                                    <td class="text-center"><?= $tamu['no_hp']; ?></td>
                                    <td class="text-center"><?= $tamu['bertemu']; ?></td>
                                    <td><?= $tamu['kepentingan']; ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-success" href="edit-tamu.php?id=<?= $tamu['id_tamu']; ?>">Ubah</a>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-danger" href="hapus-tamu.php?id=<?= $tamu['id_tamu']; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include('templates/footer.php') ?>