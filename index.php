<?php

session_start();
include('koneksi.php'); // Menyertakan file koneksi.php untuk menghubungkan ke database

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php"); // Redirect ke login jika belum login
    exit;
}

echo "Selamat datang, " . $_SESSION['username']; // Menampilkan username yang login

$team_name = "";
$match_score = "";
$stadium = "";
$match_date = "";
$sukses = "";
$error = "";

// Cek apakah ada operasi (edit, delete)
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

// Delete Operation
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "DELETE FROM football_teams WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error = "Gagal menghapus data";
    }
}

// Edit Operation
if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM football_teams WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);

    // Cek apakah data ditemukan
    if ($r1) {
        $team_name = $r1['team_name'];
        $match_score = $r1['match_score'];
        $stadium = $r1['stadium'];
        $match_date = $r1['match_date'];
    } else {
        $error = "Data tidak ditemukan";
    }
}

// Create/Update Operation
if (isset($_POST['simpan'])) { // Create or Update
    $team_name = $_POST['team_name'];
    $match_score = $_POST['match_score'];
    $stadium = $_POST['stadium'];
    $match_date = $_POST['match_date'];

    if ($team_name && $match_score && $stadium && $match_date) {
        if ($op == 'edit') { // Update Operation
            $sql1 = "UPDATE football_teams SET team_name = '$team_name', match_score = '$match_score', stadium = '$stadium', match_date = '$match_date' WHERE id = '$id'";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
                header("Location: index.php"); // Redirect agar tidak lagi dalam mode edit
                exit();
            } else {
                $error = "Data gagal diupdate";
            }
        } else { // Insert Operation
            $sql1 = "INSERT INTO football_teams (team_name, match_score, stadium, match_date) VALUES ('$team_name', '$match_score', '$stadium', '$match_date')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil memasukkan data baru";
                header("Location: index.php"); // Redirect untuk mencegah pengulangan submit
                exit();
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tim Sepak Bola</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .card {
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn-logout {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>

<body>
    <a href="logout.php" class="btn btn-danger btn-logout">Logout</a>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>Data Tim Sepak Bola</h3>
            </div>
            <div class="card-body">
                <!-- Form untuk Create/Edit -->
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="team_name" class="col-sm-2 col-form-label">Nama Tim</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="team_name" name="team_name"
                                value="<?php echo $team_name ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="match_score" class="col-sm-2 col-form-label">Skor Pertandingan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="match_score" name="match_score"
                                value="<?php echo $match_score ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="stadium" class="col-sm-2 col-form-label">Stadion</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="stadium" name="stadium"
                                value="<?php echo $stadium ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="match_date" class="col-sm-2 col-form-label">Tanggal Pertandingan</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="match_date" name="match_date"
                                value="<?php echo $match_date ?>">
                        </div>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-success">Simpan Data</button>
                </form>
            </div>
        </div>

        <!-- Table untuk menampilkan data -->
        <div class="card mt-3">
            <div class="card-header bg-secondary text-white">
                <h3>Daftar Tim</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Tim</th>
                            <th>Skor Pertandingan</th>
                            <th>Stadion</th>
                            <th>Tanggal Pertandingan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2 = "SELECT * FROM football_teams ORDER BY id DESC";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id = $r2['id'];
                            $team_name = $r2['team_name'];
                            $match_score = $r2['match_score'];
                            $stadium = $r2['stadium'];
                            $match_date = $r2['match_date'];
                            ?>
                            <tr>
                                <td><?php echo $urut++ ?></td>
                                <td><?php echo $team_name ?></td>
                                <td><?php echo $match_score ?></td>
                                <td><?php echo $stadium ?></td>
                                <td><?php echo $match_date ?></td>
                                <td>
                                    <a href="index.php?op=edit&id=<?php echo $id ?>" class="btn btn-warning">Edit</a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" class="btn btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus data?');">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>