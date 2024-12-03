<?php
// Menghubungkan ke database
include('koneksibarang.php');

// Menyimpan data jika tombol submit ditekan
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $nama_karyawan = $_POST['nama_karyawan'];
    $departemen_id = $_POST['departemen_id'];

    // Query untuk menyimpan data
    $sql = $koneksi->query("INSERT INTO daftar_karyawan (nama, departemen_id) VALUES ('$nama_karyawan', '$departemen_id')");

    // Cek jika berhasil
    if ($sql) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location='?page=daftarkaryawan';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data!');</script>";
    }
}

// Query untuk mengambil data departemen
$departemen_sql = $koneksi->query("SELECT * FROM departemen");

?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Daftar Karyawan</h6>
        </div>
        <div class="card-body">
            <!-- Form untuk menambahkan karyawan -->
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nama_karyawan">Nama Karyawan</label>
                    <input type="text" id="nama_karyawan" name="nama_karyawan" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="departemen_id">Departemen</label>
                    <select name="departemen_id" id="departemen_id" class="form-control" required>
                        <option value="">Pilih Departemen</option>
                        <?php
                        while ($departemen = $departemen_sql->fetch_assoc()) {
                            echo "<option value='" . $departemen['id'] . "'>" . htmlspecialchars($departemen['nama']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    <a href="?page=daftarkaryawan" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Page Content -->