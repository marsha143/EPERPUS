<?php include("./config/db.php"); ?>
<?php

if (isset($_SESSION['login'])){
  header('Location: app');  
  exit;
}

if (isset($_POST['login'])) {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';
  $role     = $_POST['role'] ?? ''; 

  $query = "
    SELECT id, username, password, role FROM (
      SELECT id_admin   AS id, username, password, 'admin'   AS role FROM admin
      UNION ALL
      SELECT id_anggota AS id, username, password, 'anggota' AS role FROM anggota
    ) AS users
    WHERE username = '$username' AND role = '$role'
    LIMIT 1
  ";

  $checkUser = mysqli_query($conn, $query);
  $dataUser  = mysqli_fetch_assoc($checkUser);

  if (!$dataUser) {
    echo "<script>alert('Username tidak ditemukan untuk role $role.'); window.location='login';</script>";
    exit;
  }

  if (!password_verify($password, $dataUser['password'])) {
    echo "<script>alert('Password salah.'); window.location='login';</script>";
    exit;
  }

  $_SESSION['login'] = true;
  $_SESSION['user'] = [
    'id'       => $dataUser['id'],
    'username' => $dataUser['username'],
    'role'     => $dataUser['role']
  ];

  if ($dataUser['role'] === 'admin') {
    header('Location: app');
  } else {
header('Location: app_anggota?page=home_anggota&view=index&id_anggota=' . $dataUser['id']);
exit;       
}
}
?>
<?php include('./anggota/layouts/header.php'); ?>
<div class="page-header align-items-start min-vh-100"
    style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');"
    loading="lazy">
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container my-auto">
        <div class="row">
            <div class="col-lg-4 col-md-8 col-12 mx-auto">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-1 pe-1 ">
                            <h4 class="text-white font-weight-bolder text-center mt-3 mb-3">Sign in</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" class="text-start">
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Username</label>
                                <input type="username" name="username" class="form-control" required>
                            </div>
                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Masuk sebagai:</label>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="admin" value="admin"
                                        required>
                                    <label class="form-check-label" for="admin">
                                        Admin
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="anggota"
                                        value="anggota" required>
                                    <label class="form-check-label" for="anggota">
                                        Anggota
                                    </label>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="login" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('./anggota/layouts/footer.php');?>