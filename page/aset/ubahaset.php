<?php
// Koneksi ke database
include 'koneksibarang.php'; // Pastikan koneksi ke database sudah benar

// Cek apakah ada ID aset yang diterima dari URL (untuk mengedit aset tertentu)
if (isset($_GET['id_aset'])) {
    $id_aset = $_GET['id_aset'];

    // Ambil data aset yang akan diubah
    $query = "SELECT * FROM aset WHERE id_aset = ?";
    if ($stmt = $koneksi->prepare($query)) {
        $stmt->bind_param("i", $id_aset);
        $stmt->execute();
        $result = $stmt->get_result();

        // Jika aset ditemukan
        if ($result->num_rows > 0) {
            $data_aset = $result->fetch_assoc();
        } else {
            echo "<script>alert('Aset tidak ditemukan!'); window.location.href='?page=aset';</script>";
            exit;
        }

        $stmt->close();
    } else {
        echo "<script>alert('Terjadi kesalahan!'); window.location.href='?page=aset';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID Aset tidak ditemukan!'); window.location.href='?page=aset';</script>";
    exit;
}

// Proses simpan perubahan data aset
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $kode_aset = htmlspecialchars($_POST['kode_aset']);
    $nama_aset = htmlspecialchars($_POST['nama_aset']);
    $departemen_id = $_POST['departemen_id']; // Departemen ID
    $lokasi = htmlspecialchars($_POST['lokasi']);
    $status = $_POST['status']; // Status Aset
    $tanggal_pembelian = $_POST['tanggal_pembelian'];
    $karyawan_id = $_POST['karyawan_id']; // ID Karyawan yang mengelola atau bertanggung jawab terhadap aset
    $kondisi = $_POST['kondisi']; // Kondisi Aset

    // Query untuk update data aset
    $query = "UPDATE aset SET kode_aset = ?, nama_aset = ?, departemen_id = ?, lokasi = ?, status = ?, tanggal_pembelian = ?, karyawan_id = ?, kondisi = ? WHERE id_aset = ?";

    // Prepare statement
    if ($stmt = $koneksi->prepare($query)) {
        // Bind parameters
        $stmt->bind_param("ssisssisi", $kode_aset, $nama_aset, $departemen_id, $lokasi, $status, $tanggal_pembelian, $karyawan_id, $kondisi, $id_aset);

        // Eksekusi query
        if ($stmt->execute()) {
            echo "<script>alert('Data aset berhasil diubah!'); window.location.href='?page=aset';</script>";
        } else {
            echo "<script>alert('Gagal mengubah data aset!');</script>";
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "<script>alert('Terjadi kesalahan!');</script>";
    }
}
?>

<!-- Form untuk ubah aset -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ubah Aset</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="">

                <!-- Kode Aset -->
                <div class="mb-3">
                    <label for="kode_aset" class="form-label">Kode Aset</label>
                    <input type="text" class="form-control" id="kode_aset" name="kode_aset"
                        value="<?php echo htmlspecialchars($data_aset['kode_aset']); ?>" required>
                </div>

                <!-- Nama Aset -->
                <div class="mb-3">
                    <label for="nama_aset" class="form-label">Nama Aset</label>
                    <input type="text" class="form-control" id="nama_aset" name="nama_aset"
                        value="<?php echo htmlspecialchars($data_aset['nama_aset']); ?>" required>
                </div>

                <!-- Pilih Departemen -->
                <div class="mb-3">
                    <label for="departemen_id" class="form-label">Departemen</label>
                    <select class="form-control" id="departemen_id" name="departemen_id" required>
                        <?php
                        // Ambil data departemen dari tabel departemen
                        $query_departemen = "SELECT id, nama FROM departemen";
                        $result_departemen = $koneksi->query($query_departemen);
                        while ($row = $result_departemen->fetch_assoc()) {
                            $selected = ($row['id'] == $data_aset['departemen_id']) ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($row['id']) . "' $selected>" . htmlspecialchars($row['nama']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Lokasi Aset -->
                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi Aset</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi"
                        value="<?php echo htmlspecialchars($data_aset['lokasi']); ?>" required>
                </div>

                <!-- Status Aset -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status Aset</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Aktif" <?php echo ($data_aset['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif
                        </option>
                        <option value="Tidak Aktif" <?php echo ($data_aset['status'] == 'Tidak Aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
                    </select>
                </div>

                <!-- Tanggal Pembelian -->
                <div class="mb-3">
                    <label for="tanggal_pembelian" class="form-label">Tanggal Pembelian</label>
                    <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian"
                        value="<?php echo htmlspecialchars($data_aset['tanggal_pembelian']); ?>" required>
                </div>

                <!-- Karyawan yang bertanggung jawab -->
                <div class="mb-3">
                    <label for="karyawan_id" class="form-label">Karyawan</label>
                    <select class="form-control" id="karyawan_id" name="karyawan_id" required>
                        <?php
                        // Ambil data karyawan dari tabel daftar_karyawan
                        $query_karyawan = "SELECT id, nama FROM daftar_karyawan";
                        $result_karyawan = $koneksi->query($query_karyawan);
                        while ($row = $result_karyawan->fetch_assoc()) {
                            $selected = ($row['id'] == $data_aset['karyawan_id']) ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($row['id']) . "' $selected>" . htmlspecialchars($row['nama']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Kondisi Aset -->
                <div class="mb-3">
                    <label for="kondisi" class="form-label">Kondisi Aset</label>
                    <select class="form-control" id="kondisi" name="kondisi" required>
                        <option value="Baik" <?php echo ($data_aset['kondisi'] == 'Baik') ? 'selected' : ''; ?>>Baik
                        </option>
                        <option value="Rusak" <?php echo ($data_aset['kondisi'] == 'Rusak') ? 'selected' : ''; ?>>Rusak
                        </option>
                        <option value="Perlu Perawatan" <?php echo ($data_aset['kondisi'] == 'Perlu Perawatan') ? 'selected' : ''; ?>>Perlu Perawatan</option>
                    </select>
                </div>

                <button type="submit" name="submit" class="btn btn-primary custom-btn">
                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>

<!-- CSS for Custom Button Styling -->
<style>
    .custom-btn {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .custom-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .custom-btn:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
    }
</style>