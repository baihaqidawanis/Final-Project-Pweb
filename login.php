<?php
// Mulai sesi untuk memeriksa status login
session_start();

// Pastikan koneksi database sudah benar
include('koneksi.php'); // Pastikan file koneksi database sudah ada

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi form untuk memastikan input tidak kosong
    if (!empty($username) && !empty($password)) {
        // Query untuk mencari username yang dimasukkan
        $query = "SELECT * FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($koneksi, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $username); // Bind parameter
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // Periksa apakah username ada dalam database
            if ($user = mysqli_fetch_assoc($result)) {
                // Verifikasi password dengan password yang dienkripsi
                if (password_verify($password, $user['password'])) {
                    // Jika password benar, buat session
                    $_SESSION['logged_in'] = true;
                    $_SESSION['username'] = $username;
                    header("Location: index.php"); // Redirect ke halaman utama
                    exit;
                } else {
                    // Jika password salah
                    $error = "Username atau Password salah!";
                }
            } else {
                // Jika username tidak ditemukan
                $error = "Username tidak ditemukan!";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing query: " . mysqli_error($koneksi);
        }
    } else {
        $error = "Username dan Password tidak boleh kosong!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-card {
            width: 400px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .login-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-title">Login</div>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <?php if (isset($error)): ?>
                <p class="text-danger mt-3 text-center"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>

</html>