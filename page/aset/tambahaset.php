<?php
// Koneksi ke database
include 'koneksibarang.php'; // Pastikan file koneksibarang.php sudah ada dan berfungsi dengan baik

// Proses simpan data aset
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

    // Query untuk memasukkan data ke tabel aset
    $query = "INSERT INTO aset (kode_aset, nama_aset, departemen_id, lokasi, status, tanggal_pembelian, karyawan_id, kondisi)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = $koneksi->prepare($query)) {
        // Bind parameters
        $stmt->bind_param("ssisssis", $kode_aset, $nama_aset, $departemen_id, $lokasi, $status, $tanggal_pembelian, $karyawan_id, $kondisi);

        // Eksekusi query
        if ($stmt->execute()) {
            echo "<script>alert('Aset berhasil ditambahkan!'); window.location.href='?page=aset';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan aset!');</script>";
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "<script>alert('Terjadi kesalahan!');</script>";
    }
}

// Ambil data kode_barang dan jenis_barang dari tabel jenis_barang
$query_jenis_barang = "SELECT code_barang, jenis_barang FROM jenis_barang";
$result_jenis_barang = $koneksi->query($query_jenis_barang);
$kode_aset_terakhir = [];

if ($result_jenis_barang->num_rows > 0) {
    while ($row = $result_jenis_barang->fetch_assoc()) {
        // Ambil kode barang dan jenis barang
        $jenis_barang = $row['jenis_barang'];
        $kode_barang = $row['code_barang'];

        // Ambil nomor urut terakhir berdasarkan jenis barang
        $query_last_code = "SELECT MAX(SUBSTRING(code_aset, -4)) AS last_code FROM aset WHERE code_aset LIKE '$kode_barang%'";
        $result_last_code = $koneksi->query($query_last_code);

        if ($result_last_code->num_rows > 0) {
            $last_code = $result_last_code->fetch_assoc();
            $last_code_value = $last_code['last_code'] ? (int) $last_code['last_code'] : 0;
            $next_code = str_pad($last_code_value + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada kode aset untuk jenis ini, mulai dari 0001
            $next_code = '0001';
        }

        // Simpan kode aset terakhir yang tersedia
        $kode_aset_terakhir[$kode_barang] = $kode_barang . "/" . $next_code;
    }
}
?>

<!-- Form untuk tambah aset -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Aset</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <!-- Kode Aset -->
                <div class="mb-3">
                    <label for="kode_aset" class="form-label">Kode Aset</label>
                    <select class="form-control" id="kode_aset" name="kode_aset" required>
                        <option value="">Pilih Kode Aset atau Masukkan Kode Baru</option>
                        <?php
                        // Ambil data kode_barang dari tabel jenis_barang
                        $query_jenis_barang = "SELECT code_barang, jenis_barang FROM jenis_barang";
                        $result_jenis_barang = $koneksi->query($query_jenis_barang);
                        if ($result_jenis_barang->num_rows > 0) {
                            while ($row = $result_jenis_barang->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($row['code_barang']) . "' data-jenis='" . htmlspecialchars($row['jenis_barang']) . "'>" . htmlspecialchars($row['code_barang']) . "</option>";
                            }
                        } else {
                            echo "<option value=''>Tidak ada kode aset</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Gabungkan Kode Aset dan Jenis Barang -->
                <div class="mb-3">
                    <label for="kode_jenis_barang" class="form-label">Kode Aset dan Jenis Barang</label>
                    <input type="text" class="form-control" id="kode_jenis_barang" name="kode_jenis_barang" readonly>
                </div>



                <!-- Nama Aset -->
                <div class="mb-3">
                    <label for="nama_aset" class="form-label">Nama Aset</label>
                    <input type="text" class="form-control" id="nama_aset" name="nama_aset" required>
                </div>

                <!-- Pilih Departemen -->
                <div class="mb-3">
                    <label for="departemen_id" class="form-label">Departemen</label>
                    <select class="form-control select2" id="departemen_id" name="departemen_id" required>
                        <option value="">Pilih Departemen</option>
                        <?php
                        $query_departemen = "SELECT id, nama FROM departemen";
                        $result_departemen = $koneksi->query($query_departemen);
                        if ($result_departemen->num_rows > 0) {
                            while ($row = $result_departemen->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nama']) . "</option>";
                            }
                        } else {
                            echo "<option value=''>Tidak ada departemen</option>";
                        }
                        ?>

                        <!-- Gunakan Select2 versi terbaru -->
                        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
                            rel="stylesheet" />
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

                        <script>
                            $(document).ready(function () {
                                // Inisialisasi Select2 untuk Departemen dengan filter
                                $('#departemen_id').select2({
                                    placeholder: "Pilih Departemen",  // Placeholder untuk dropdown
                                    allowClear: true,                 // Mengizinkan pengguna memilih 'kosong'
                                    width: '100%',                    // Membuat dropdown selebar kontainer
                                    theme: 'classic'                  // Tema klasik Select2 (sesuaikan jika diperlukan)
                                });

                                // Inisialisasi Select2 untuk Karyawan dengan filter
                                $('#karyawan_id').select2({
                                    placeholder: "Pilih Karyawan",    // Placeholder untuk dropdown
                                    allowClear: true,                 // Mengizinkan pengguna memilih 'kosong'
                                    width: '100%',                    // Membuat dropdown selebar kontainer
                                    theme: 'classic'                  // Tema klasik Select2
                                });


                                // Inisialisasi Select2 untuk elemen lainnya jika ada
                                $('.select2').select2({
                                    placeholder: "Pilih",
                                    allowClear: true
                                });
                            });
                        </script>

                    </select>
                </div>

                <!-- Lokasi Aset -->
                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi Aset</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                </div>

                <!-- Status Aset -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status Aset</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>

                <!-- Tanggal Pembelian -->
                <div class="mb-3">
                    <label for="tanggal_pembelian" class="form-label">Tanggal Pembelian</label>
                    <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian" required>
                </div>

                <!-- Karyawan yang bertanggung jawab -->
                <div class="mb-3">
                    <label for="karyawan_id" class="form-label">Karyawan</label>
                    <select class="form-control select2" id="karyawan_id" name="karyawan_id" required>
                        <option value="">Pilih Karyawan</option>
                        <?php
                        // Ambil data karyawan dari tabel daftar_karyawan
                        $query_karyawan = "SELECT id, nama FROM daftar_karyawan";
                        $result_karyawan = $koneksi->query($query_karyawan);
                        while ($row = $result_karyawan->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nama']) . "</option>";
                        }
                        ?>






                    </select>
                </div>


                <!-- Kondisi Aset -->
                <div class="mb-3">
                    <label for="kondisi" class="form-label">Kondisi Aset</label>
                    <select class="form-control" id="kondisi" name="kondisi" required>
                        <option value="Baik">Baik</option>
                        <option value="Rusak">Rusak</option>
                        <option value="Perlu Perawatan">Perlu Perawatan</option>
                    </select>
                </div>

                <button type="submit" name="submit" class="btn btn-primary custom-btn">
                    <i class="fas fa-save me-2"></i> Simpan Aset
                </button>
            </form>
        </div>

    </div>
    <script>
        // Fungsi untuk memperbarui input gabungan kode aset dan jenis barang
        document.getElementById('kode_aset').addEventListener('change', function () {
            var kodeAset = this.value;
            var jenisBarang = this.options[this.selectedIndex].getAttribute('data-jenis');  // Ambil jenis barang dari atribut data

            // Gabungkan kode aset dan jenis barang ke dalam input baru
            if (kodeAset !== "" && jenisBarang) {
                document.getElementById('kode_jenis_barang').value = kodeAset + " - " + jenisBarang;
            } else {
                document.getElementById('kode_jenis_barang').value = ''; // Kosongkan jika tidak ada kode aset
            }
        });
    </script>

</div>

<!-- Gunakan Select2 versi terbaru -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>