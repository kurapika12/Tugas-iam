<?php
// siswa.php
// File untuk mengelola data siswa
require 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h1>Data Siswa</h1>
    <?php
    // Variabel untuk inputan form
    $nama_siswa = $alamat = $tanggal_lahir = $id_kelas = '';

    // Logika untuk menambah, menghapus, dan menampilkan data siswa
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_siswa'])) {
        $nama_siswa = $_POST['nama_siswa'];
        $alamat = $_POST['alamat'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $id_kelas = $_POST['id_kelas'];

        // Menggunakan nama kolom yang sesuai dengan database
        $sql = "INSERT INTO siswa (nama_siswa, alamat, tanggal_lahir, id_kelas) VALUES ('$nama_siswa', '$alamat', '$tanggal_lahir', '$id_kelas')";
        if ($connection->query($sql)) {
            echo "<div class='alert alert-success'>Data siswa berhasil ditambahkan!</div>";
            // Redirect setelah submit sukses untuk menghindari refresh form yang sama
            header("Location: siswa.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error: " . $connection->error . "</div>";
        }
    }

    if (isset($_GET['delete'])) {
        $id_siswa = $_GET['delete'];
        $sql = "DELETE FROM siswa WHERE id_siswa = $id_siswa";
        if ($connection->query($sql)) {
            echo "<div class='alert alert-success'>Data siswa berhasil dihapus!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $connection->error . "</div>";
        }
    }

    $result = $connection->query("SELECT * FROM siswa");
    ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="nama_siswa" class="form-label">Nama Siswa</label>
            <input type="text" name="nama_siswa" class="form-control" id="nama_siswa" value="<?= htmlspecialchars($nama_siswa); ?>" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control" id="alamat" required><?= htmlspecialchars($alamat); ?></input>
        </div>
        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" value="<?= htmlspecialchars($tanggal_lahir); ?>" required>
        </div>
        <div class="mb-3">
            <label for="id_kelas" class="form-label">Kelas</label>
            <select name="id_kelas" class="form-control" id="id_kelas" required>
                <option value="">Pilih Kelas</option>
                <?php
                // Mengambil data kelas untuk dropdown
                $kelas_result = $connection->query("SELECT * FROM kelas");
                while ($kelas = $kelas_result->fetch_assoc()) {
                    echo "<option value='" . $kelas['id_kelas'] . "' " . ($kelas['id_kelas'] == $id_kelas ? 'selected' : '') . ">" . $kelas['nama_kelas'] . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" name="add_siswa" class="btn btn-primary">Tambah Siswa</button>
    </form>

    <h2 class="mt-4">Daftar Siswa</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Alamat</th>
                <th>Tanggal Lahir</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama_siswa']; ?></td>
                        <td><?= $row['alamat']; ?></td>
                        <td><?= $row['tanggal_lahir']; ?></td>
                        <td>
                            <?php
                            // Ambil nama kelas berdasarkan id_kelas
                            $kelas_query = $connection->query("SELECT nama_kelas FROM kelas WHERE id_kelas = " . $row['id_kelas']);
                            $kelas = $kelas_query->fetch_assoc();
                            echo $kelas['nama_kelas'];
                            ?>
                        </td>
                        <td>
                            <a href="?delete=<?= $row['id_siswa']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
