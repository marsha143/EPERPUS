<?php
session_start();
include("./config/db.php");

// Jika sudah login, redirect sesuai role
if (isset($_SESSION['login'])) {
    if ($_SESSION['user']['role_id'] == 2) {
        header('Location: app');
    } elseif ($_SESSION['user']['role_id'] == 3) {
        header('Location: app_anggota');
    }
    exit;
}

// Proses login
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $query = "
        SELECT id, username, password, role_id, nama_role FROM (
            SELECT 
                a.id_admin AS id,
                a.username,
                a.password,
                a.role AS role_id,
                r.nama_role
            FROM admin a
            JOIN role r ON a.role = r.id

            UNION ALL

            SELECT 
                ag.id_anggota AS id,
                ag.username,
                ag.password,
                ag.role AS role_id,
                r.nama_role
            FROM anggota ag
            JOIN role r ON ag.role = r.id
        ) AS users
        WHERE username = ?
        LIMIT 1
    ";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // Username tidak ditemukan
    if (!$user) {
        echo "<script>alert('Username tidak ditemukan');window.location='login';</script>";
        exit;
    }

    // Password salah
    if (!password_verify($password, $user['password'])) {
        echo "<script>alert('Password salah');window.location='login';</script>";
        exit;
    }

    // Set session
    $_SESSION['login'] = true;
    $_SESSION['user'] = [
        'id' => $user['id'],
        'username' => $user['username'],
        'role_id' => $user['role_id'],
        'role' => $user['nama_role']
    ];

    // Redirect berdasarkan role
    if ($user['role_id'] == 2) {
        header('Location: app'); // admin
    } elseif ($user['role_id'] == 3) {
        header('Location: app_anggota'); // anggota
    } else {
        echo "<script>alert('Role tidak valid');window.location='login';</script>";
    }
    exit;
}
?>

<?php include('./anggota/layouts_anggota/header.php'); ?>
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
                        <form method="POST" class="text-start">
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>

                            <div class="input-group input-group-outline mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
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
<?php include('./anggota/layouts_anggota/footer.php'); ?>