<?php
// kelas.php
require 'config.php';

// Logika untuk menambah data kelas
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_kelas'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $id_wali_kelas = $_POST['id_wali_kelas'];

    // Query untuk memasukkan data kelas baru
    $sql = "INSERT INTO kelas (nama_kelas, id_wali_kelas) VALUES ('$nama_kelas', '$id_wali_kelas')";
    if ($connection->query($sql)) {
        echo "<div class='alert alert-success'>Kelas berhasil ditambahkan!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $connection->error . "</div>";
    }
}

// Logika untuk menghapus data kelas
if (isset($_GET['delete'])) {
    $id_kelas = $_GET['delete'];

    // Query untuk menghapus data kelas
    $sql = "DELETE FROM kelas WHERE id_kelas = $id_kelas";
    if ($connection->query($sql)) {
        echo "<div class='alert alert-success'>Kelas berhasil dihapus!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $connection->error . "</div>";
    }
}

// Query untuk mengambil data kelas
$result = $connection->query("SELECT * FROM kelas");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kelas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <h1>Data Kelas</h1>

    <!-- Form untuk menambah data kelas -->
    <form method="POST" action="">
        <div class="mb-3">
            <label for="nama_kelas" class="form-label">Nama Kelas</label>
            <input type="text" name="nama_kelas" class="form-control" id="nama_kelas" required>
        </div>
        <div class="mb-3">
            <label for="id_wali_kelas" class="form-label">Wali Kelas</label>
            <select name="id_wali_kelas" class="form-control" id="id_wali_kelas" required>
                <option value="">Pilih Wali Kelas</option>
                <?php
                // Menampilkan daftar guru untuk wali kelas
                $guruResult = $connection->query("SELECT * FROM guru");
                while ($guru = $guruResult->fetch_assoc()) {
                    echo "<option value='" . $guru['id_guru'] . "'>" . $guru['nama_guru'] . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" name="add_kelas" class="btn btn-primary">Tambah Kelas</button>
    </form>

    <!-- Menampilkan tabel data kelas -->
    <h2 class="mt-4">Daftar Kelas</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kelas</th>
                <th>Wali Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama_kelas']; ?></td>
                        <td>
                            <?php
                            // Menampilkan nama wali kelas berdasarkan id_wali_kelas
                            $waliKelasResult = $connection->query("SELECT nama_guru FROM guru WHERE id_guru = " . $row['id_wali_kelas']);
                            $waliKelas = $waliKelasResult->fetch_assoc();
                            echo $waliKelas['nama_guru'];
                            ?>
                        </td>
                        <td>
                            <a href="?delete=<?= $row['id_kelas']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">Hapus</a>
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
