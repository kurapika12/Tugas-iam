<?php
// mapel.php
require 'config.php';

// Logika untuk menambah data mata pelajaran
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_mapel'])) {
    $nama_mapel = $_POST['nama_mapel'];
    $tingkat_kesulitan = $_POST['tingkat_kesulitan'];

    $sql = "INSERT INTO matapelajaran (nama_mapel, tingkat_kesulitan) VALUES ('$nama_mapel', '$tingkat_kesulitan')";
    if ($connection->query($sql)) {
        echo "<div class='alert alert-success'>Mata pelajaran berhasil ditambahkan!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $connection->error . "</div>";
    }
}

// Logika untuk menghapus data mata pelajaran
if (isset($_GET['delete'])) {
    $id_mapel = $_GET['delete'];

    // Query untuk menghapus data mata pelajaran
    $sql = "DELETE FROM matapelajaran WHERE id_mapel = $id_mapel";
    if ($connection->query($sql)) {
        echo "<div class='alert alert-success'>Mata pelajaran berhasil dihapus!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $connection->error . "</div>";
    }
}

// Menampilkan data mata pelajaran
$result = $connection->query("SELECT * FROM matapelajaran");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Pelajaran</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <h1>Data Mata Pelajaran</h1>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="nama_mapel" class="form-label">Nama Mata Pelajaran</label>
            <input type="text" name="nama_mapel" class="form-control" id="nama_mapel" required>
        </div>
        <div class="mb-3">
            <label for="tingkat_kesulitan" class="form-label">Tingkat Kesulitan</label>
            <input type="text" name="tingkat_kesulitan" class="form-control" id="tingkat_kesulitan" required>
        </div>
        <button type="submit" name="add_mapel" class="btn btn-primary">Tambah Mata Pelajaran</button>
    </form>

    <h2 class="mt-4">Daftar Mata Pelajaran</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mata Pelajaran</th>
                <th>Tingkat Kesulitan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama_mapel']; ?></td>
                        <td><?= $row['tingkat_kesulitan']; ?></td>
                        <td>
                            <!-- Tombol Hapus -->
                            <a href="?delete=<?= $row['id_mapel']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
