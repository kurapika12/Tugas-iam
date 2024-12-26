<?php
// guru.php
// File untuk mengelola data guru
require 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h1>Data Guru</h1>
    <?php
    // Variabel untuk inputan form
    $nama_guru = $spesialisasi = $nomor_hp = '';

    // Logika untuk menambah, menghapus, dan menampilkan data guru
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_guru'])) {
        $nama_guru = $_POST['nama_guru'];
        $spesialisasi = $_POST['spesialisasi'];
        $nomor_hp = $_POST['nomor_hp'];

        // Menggunakan nama kolom yang sesuai dengan database
        $sql = "INSERT INTO guru (nama_guru, spesialisasi, nomor_hp) VALUES ('$nama_guru', '$spesialisasi', '$nomor_hp')";
        if ($connection->query($sql)) {
            echo "<div class='alert alert-success'>Data guru berhasil ditambahkan!</div>";
            // Redirect setelah submit sukses untuk menghindari refresh form yang sama
            header("Location: guru.php"); 
            exit();  // Pastikan script berhenti di sini setelah redirect
        } else {
            echo "<div class='alert alert-danger'>Error: " . $connection->error . "</div>";
        }
    }

    if (isset($_GET['delete'])) {
        $id_guru = $_GET['delete'];
        $sql = "DELETE FROM guru WHERE id_guru = $id_guru";
        if ($connection->query($sql)) {
            echo "<div class='alert alert-success'>Data guru berhasil dihapus!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $connection->error . "</div>";
        }
    }

    $result = $connection->query("SELECT * FROM guru");
    ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="nama_guru" class="form-label">Nama Guru</label>
            <input type="text" name="nama_guru" class="form-control" id="nama_guru" value="<?= htmlspecialchars($nama_guru); ?>" required>
        </div>
        <div class="mb-3">
            <label for="spesialisasi" class="form-label">Spesialisasi</label>
            <input type="text" name="spesialisasi" class="form-control" id="spesialisasi" value="<?= htmlspecialchars($spesialisasi); ?>" required>
        </div>
        <div class="mb-3">
            <label for="nomor_hp" class="form-label">Nomor HP</label>
            <input type="text" name="nomor_hp" class="form-control" id="nomor_hp" value="<?= htmlspecialchars($nomor_hp); ?>" required>
        </div>
        <button type="submit" name="add_guru" class="btn btn-primary">Tambah Guru</button>
    </form>

    <h2 class="mt-4">Daftar Guru</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Guru</th>
                <th>Spesialisasi</th>
                <th>Nomor HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama_guru']; ?></td>
                        <td><?= $row['spesialisasi']; ?></td>
                        <td><?= $row['nomor_hp']; ?></td>
                        <td>
                            <a href="?delete=<?= $row['id_guru']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
