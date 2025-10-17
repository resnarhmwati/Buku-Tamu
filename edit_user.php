<?php
include_once 'templates/header.php';
require_once 'koneksi.php';
require_once 'function.php';

// Proses update data user
if (isset($_POST['simpan'])) {
    if (ubah_user($_POST) > 0) {
        echo "<div class='alert alert-success' role='alert'>Data berhasil diubah!</div>";
        echo "<meta http-equiv='refresh' content='1; url=users.php'>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Data gagal diubah!</div>";
        echo "<meta http-equiv='refresh' content='1; url=users.php'>";
    }
}

// Proses ganti password
if (isset($_POST['ganti_password'])) {
    $id_user  = $_POST['id_user'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "UPDATE users SET password = '$password' WHERE id_user = '$id_user'";
    if (mysqli_query($koneksi, $query)) {
        echo "<div class='alert alert-success' role='alert'>Password berhasil diganti!</div>";
        echo "<meta http-equiv='refresh' content='1; url=users.php'>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Password gagal diganti!</div>";
        echo "<meta http-equiv='refresh' content='1; url=users.php'>";
    }
}

// Ambil data berdasarkan id di URL
if (isset($_GET['id'])) {
    $id_user = $_GET['id'];
    $result  = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = '$id_user'");
    $data    = mysqli_fetch_assoc($result);
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Data User</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6>Form Edit User</h6>
        </div>
        <div class="card-body">
            <form method="post">
                <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">

                <div class="form-group row">
                    <label for="username" class="col-sm-3 col-form-label">Username</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="username" name="username"
                               value="<?= $data['username'] ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="user_role" class="col-sm-3 col-form-label">User Role</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="user_role" name="user_role" required>
                            <option value="admin" <?= $data['user_role'] == 'admin' ? 'selected' : '' ?>>Administrator</option>
                            <option value="operator" <?= $data['user_role'] == 'operator' ? 'selected' : '' ?>>Operator</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-8 offset-sm-3 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-info" data-toggle="modal"
                                data-target="#gantiPassword" data-id="<?= $data['id_user'] ?>">
                            Ganti Password
                        </button>
                        <a href="users.php" class="btn btn-danger">Kembali</a>
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
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
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">
                    <div class="form-group row">
                        <label for="password" class="col-sm-4 col-form-label">Password Baru</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="password" name="password" required>
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

<?php include_once 'templates/footer.php'; ?>