<?php
require_once 'koneksi.php'; // koneksi ke database
session_start();

// kalau sudah login langsung ke index
if (isset($_SESSION['login'])) {
  header("Location: index.php");
  exit();
}

if (isset($_POST['login'])) {
  $username = mysqli_real_escape_string($koneksi, $_POST['username']);
  $password = $_POST['password'];

  $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {
      $_SESSION['login'] = true;
      $_SESSION['username'] = $row['username'];
      $_SESSION['role'] = $row['user_role']; // role: admin / operator

      header("Location: index.php");
      exit();
    }
  }
  $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
  <div class="container">
    <?php if (isset($error)) : ?>
      <div class="alert alert-danger mt-3" role="alert">
        Username atau Password salah!
      </div>
    <?php endif; ?>

    <div class="row justify-content-center p-8">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image">
                <div class="d-flex justify-content-center align-items-center h-100">
                  <img src="assets/img/login-page.png" alt="Login Image"
                    class="img-fluid rounded-start" style="width: 90%; height: auto;">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" method="post" action="">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user"
                        id="username" name="username" placeholder="Username..." required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user"
                        id="password" name="password" placeholder="Password..." required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block" name="login">
                      Login
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.html">Create an Account!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="assets/js/sb-admin-2.min.js"></script>
</body>

</html>