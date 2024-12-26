<?php
// jadwal.php
// File untuk mengelola data jadwal pelajaran
require 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jadwal Pelajaran</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <h1>Data Jadwal Pelajaran</h1>
    <?php
    // Logika untuk menambah, menghapus, dan menampilkan data jadwal
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_jadwal'])) {
        $id_mapel = $_POST['id_mapel'];
        $id_kelas = $_POST['id_kelas'];
        $id_guru = $_POST['id_guru'];
        $hari = $_POST['hari'];
        $jam_mulai = $_POST['jam_mulai'];
        $jam_selesai = $_POST['jam_selesai'];

        $sql = "INSERT INTO jadwalpelajaran (id_mapel, id_kelas, id_guru, hari, jam_mulai, jam_selesai)
                VALUES ('$id_mapel', '$id_kelas', '$id_guru', '$hari', '$jam_mulai', '$jam_selesai')";
        if ($connection->query($sql)) {
            echo "<div class='alert alert-success'>Jadwal pelajaran berhasil ditambahkan!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $connection->error . "</div>";
        }
    }

    if (isset($_GET['delete'])) {
        $id_jadwal = $_GET['delete'];
        $sql = "DELETE FROM jadwalpelajaran WHERE id_jadwal = $id_jadwal";
        if ($connection->query($sql)) {
            echo "<div class='alert alert-success'>Jadwal pelajaran berhasil dihapus!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $connection->error . "</div>";
        }
    }

    // Ambil data jadwal pelajaran
    $result = $connection->query("SELECT jp.id_jadwal, mp.nama_mapel, k.nama_kelas, g.nama_guru, jp.hari, jp.jam_mulai, jp.jam_selesai
                                  FROM jadwalpelajaran jp
                                  JOIN matapelajaran mp ON jp.id_mapel = mp.id_mapel
                                  JOIN kelas k ON jp.id_kelas = k.id_kelas
                                  JOIN guru g ON jp.id_guru = g.id_guru");

    // Ambil data untuk dropdown
    $mapel_result = $connection->query("SELECT id_mapel, nama_mapel FROM matapelajaran");
    $kelas_result = $connection->query("SELECT id_kelas, nama_kelas FROM kelas");
    $guru_result = $connection->query("SELECT id_guru, nama_guru FROM guru");
    ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="id_mapel" class="form-label">Mata Pelajaran</label>
            <select name="id_mapel" class="form-control" id="id_mapel" required>
                <option value="">Pilih Mata Pelajaran</option>
                <?php while ($mapel = $mapel_result->fetch_assoc()): ?>
                    <option value="<?= $mapel['id_mapel']; ?>"><?= $mapel['nama_mapel']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="id_kelas" class="form-label">Kelas</label>
            <select name="id_kelas" class="form-control" id="id_kelas" required>
                <option value="">Pilih Kelas</option>
                <?php while ($kelas = $kelas_result->fetch_assoc()): ?>
                    <option value="<?= $kelas['id_kelas']; ?>"><?= $kelas['nama_kelas']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="id_guru" class="form-label">Guru</label>
            <select name="id_guru" class="form-control" id="id_guru" required>
                <option value="">Pilih Guru</option>
                <?php while ($guru = $guru_result->fetch_assoc()): ?>
                    <option value="<?= $guru['id_guru']; ?>"><?= $guru['nama_guru']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="hari" class="form-label">Hari</label>
            <input type="text" name="hari" class="form-control" id="hari" required>
        </div>
        <div class="mb-3">
            <label for="jam_mulai" class="form-label">Jam Mulai</label>
            <input type="time" name="jam_mulai" class="form-control" id="jam_mulai" required>
        </div>
        <div class="mb-3">
            <label for="jam_selesai" class="form-label">Jam Selesai</label>
            <input type="time" name="jam_selesai" class="form-control" id="jam_selesai" required>
        </div>
        <button type="submit" name="add_jadwal" class="btn btn-primary">Tambah Jadwal</button>
    </form>

    <h2 class="mt-4">Daftar Jadwal Pelajaran</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Guru</th>
                <th>Hari</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama_mapel']; ?></td>
                        <td><?= $row['nama_kelas']; ?></td>
                        <td><?= $row['nama_guru']; ?></td>
                        <td><?= $row['hari']; ?></td>
                        <td><?= $row['jam_mulai']; ?></td>
                        <td><?= $row['jam_selesai']; ?></td>
                        <td>
                            <a href="?delete=<?= $row['id_jadwal']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
