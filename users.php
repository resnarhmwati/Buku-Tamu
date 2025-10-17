<?php
require_once 'function.php';
include_once 'templates/header.php';

// Cek role hanya admin yang boleh akses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "<script>
            alert('Anda tidak memiliki akses ke halaman ini!');
            window.location.href = 'index.php';
          </script>";
    exit;
}

// Tambah user
if (isset($_POST['simpan'])) {
    if (tambah_user($_POST) > 0) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                Data berhasil ditambahkan!
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Data gagal ditambahkan!
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
    }
}

// Ganti password
if (isset($_POST['ganti_password'])) {
    if (ganti_password($_POST) > 0) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                Password berhasil diubah!
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Password gagal diubah!
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
    }
}
?>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
<ul>
  <li>
    <a href="users.php" class="nav-link">
      <i class="fas fa-fw fa-users"></i>
      <span>User</span>
    </a>
  </li>
</ul>
<?php endif; ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Buku Users</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- Tombol Tambah User -->
            <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#tambahModal">
                <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                <span class="text">Tambah User</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">User Role</th>
                            <th colspan="3" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $users = query("SELECT * FROM users ORDER BY id_user ASC");
                        foreach ($users as $user) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td class="text-center"><?= $user['username'] ?></td>
                                <td class="text-center"><?= $user['user_role'] ?></td>
                                <td class="text-center">
                                    <!-- Ganti Password -->
                                    <button class="btn btn-info btn-sm mr-2" data-toggle="modal" data-target="#gantiPassword" data-id="<?= $user['id_user'] ?>">
                                        Ganti Password
                                    </button>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-success btn-sm mr-2" href="edit_user.php?id=<?= $user['id_user'] ?>">Edit</a>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" href="hapus_user.php?id=<?= $user['id_user'] ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
// Ambil id_user terakhir untuk auto-generate
$query = mysqli_query($koneksi, "SELECT max(id_user) as kodeTerbesar FROM users");
$data = mysqli_fetch_array($query);
$urutan = (int) substr($data['kodeTerbesar'], 2, 3) + 1;
$kodeuser = "zt" . sprintf("%03s", $urutan);

// juga bisa buat versi lain seperti USRxx
$urutan2 = (int) substr($data['kodeTerbesar'], 3, 2) + 1;
$kodeuser2 = "USR" . sprintf("%02s", $urutan2);
?>

<!-- Modal Tambah User -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="tambahModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="id_user" value="<?= $kodeuser ?>">
                    <div class="form-group row">
                        <label for="username" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user_role" class="col-sm-3 col-form-label">User Role</label>
                        <div class="col-sm-8">
                            <select name="user_role" id="user_role" class="form-control" required>
                                <option value="admin">Administrator</option>
                                <option value="operator">Operator</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ganti Password -->
<div class="modal fade" id="gantiPassword" tabindex="-1" aria-labelledby="gantiPasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gantiPasswordLabel">Ganti Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="">
                <div class="modal-body">
                    <input type="hidden" name="id_user" id="id_user_modal">
                    <div class="form-group row">
                        <label for="password" class="col-sm-4 col-form-label">Password Baru</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="password_modal" name="password" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                    <button type="submit" name="ganti_password" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Set id_user ke modal ganti password
    $('#gantiPassword').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);
        modal.find('#id_user_modal').val(id);
    });
</script>

<?php include_once 'templates/footer.php'; ?>
