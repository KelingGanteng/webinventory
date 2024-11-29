<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "webinventory");

// Cek koneksi ke database
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil ID Transaksi terakhir
$no = mysqli_query($koneksi, "SELECT id_retur FROM barang_retur ORDER BY id_retur DESC LIMIT 1");
$idtran = mysqli_fetch_array($no);

// Jika tidak ada transaksi retur sebelumnya, inisialisasi kode retur pertama
if ($idtran) {
    $kode = $idtran['id_retur'];
} else {
    // Jika tidak ada data retur sebelumnya, buat kode retur pertama
    $kode = "RTR-" . date("m") . date("y") . "000"; // Format awal retur
}

// Mengambil angka urut dari id_retur terakhir
$urut = substr($kode, 8, 3);

// Tambah 1 pada angka urut
$tambah = (int) $urut + 1;

// Format bulan dan tahun
$bulan = date("m");
$tahun = date("y");

// Membuat format kode retur berdasarkan angka urut
if (strlen($tambah) == 1) {
    $format = "RTR-" . $bulan . $tahun . "00" . $tambah;
} else if (strlen($tambah) == 2) {
    $format = "RTR-" . $bulan . $tahun . "0" . $tambah;
} else {
    $format = "RTR-" . $bulan . $tahun . $tambah;
}

$tanggal_retur = date("Y-m-d"); // Tanggal retur
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Barang Retur</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form method="POST" enctype="multipart/form-data">
                    <!-- Form ID Retur -->
                    <label for="id_retur">ID Retur</label>
                    <div class="form-group">
                        <input type="text" name="id_retur" class="form-control" id="id_retur"
                            value="<?php echo $format; ?>" readonly />
                    </div>

                    <!-- Tanggal Retur -->
                    <label for="tanggal_retur">Tanggal Retur</label>
                    <div class="form-group">
                        <input type="date" name="tanggal_retur" class="form-control" id="tanggal_retur"
                            value="<?php echo $tanggal_retur; ?>" />
                    </div>

                    <!-- Barang -->
                    <label for="barang">Barang</label>
                    <div class="form-group">
                        <select name="barang" id="cmb_barang" class="form-control">
                            <option value="">-- Pilih Barang --</option>
                            <?php
                            $sql = $koneksi->query("SELECT * FROM gudang ORDER BY nama_barang");
                            while ($data = $sql->fetch_assoc()) {
                                echo "<option value='$data[kode_barang].$data[nama_barang]'>$data[kode_barang] | $data[nama_barang]</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Kondisi Barang -->
                    <label for="kondisi">Kondisi</label>
                    <div class="form-group">
                        <div class="checkbox-group">
                            <label><input type="checkbox" name="kondisi[]" value="Baik" /> Baik</label>
                            <label><input type="checkbox" name="kondisi[]" value="Rusak" /> Rusak</label>
                            <label><input type="checkbox" name="kondisi[]" value="Retur" /> Retur</label>
                        </div>
                    </div>

                    <!-- Kerusakan -->
                    <label for="kerusakan">Kerusakan</label>
                    <div class="form-group">
                        <input type="text" name="kerusakan" id="kerusakan" class="form-control" />
                    </div>

                    <!-- Jumlah Barang -->
                    <label for="jumlah_retur">Jumlah Retur</label>
                    <div class="form-group">
                        <input type="text" name="jumlah_retur" id="jumlah_retur" class="form-control" />
                    </div>

                    <!-- Tujuan Retur -->
                    <label for="tujuan">Tujuan Retur</label>
                    <div class="form-group">
                        <input type="text" name="tujuan" class="form-control" />
                    </div>

                    <input type="submit" name="simpan_retur" value="Simpan Retur" class="btn btn-primary" />
                </form>

                <?php
                if (isset($_POST['simpan_retur'])) {
                    $id_retur = $_POST['id_retur'];
                    $tanggal_retur = $_POST['tanggal_retur'];

                    // Ambil barang yang dipilih
                    $barang = $_POST['barang'];
                    $pecah_barang = explode(".", $barang);
                    $kode_barang = $pecah_barang[0];
                    $nama_barang = $pecah_barang[1];

                    // Ambil kondisi yang dipilih
                    $kondisi = isset($_POST['kondisi']) ? implode(", ", $_POST['kondisi']) : '';

                    $kerusakan = $_POST['kerusakan'];
                    $jumlah_retur = $_POST['jumlah_retur'];
                    $tujuan = $_POST['tujuan'];

                    // Simpan data retur
                    $sql = $koneksi->query("INSERT INTO barang_retur (id_retur, id_transaksi, tanggal_retur, kode_barang, nama_barang, kondisi, kerusakan, jumlah, tujuan) 
                    VALUES('$id_retur', '$id_retur', '$tanggal_retur', '$kode_barang', '$nama_barang', '$kondisi', '$kerusakan', '$jumlah_retur', '$tujuan')");

                    // Update stok barang di gudang
                    $sql2 = $koneksi->query("UPDATE gudang SET jumlah = jumlah + $jumlah_retur WHERE kode_barang='$kode_barang'");


                    ?>
                    <script type="text/javascript">
                        alert("Simpan Data Retur Berhasil");
                        window.location.href = "?page=barangretur";
                    </script>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>