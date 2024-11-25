<script>
	function sum() {
		var stok = document.getElementById('stok').value;
		var jumlahmasuk = document.getElementById('jumlahmasuk').value;
		var result = parseInt(stok) + parseInt(jumlahmasuk);
		if (!isNaN(result)) {
			document.getElementById('jumlah').value = result;
		}
	}
</script>

<?php

// Koneksi database
$koneksi = new mysqli("localhost", "root", "", "webinventory");
if ($koneksi->connect_error) {
	die("Koneksi gagal: " . $koneksi->connect_error);
}

// Mengambil kode transaksi
$no = mysqli_query($koneksi, "SELECT id_transaksi FROM barang_masuk ORDER BY id_transaksi DESC");
$idtran = mysqli_fetch_array($no);
$kode = 1; // Default jika tidak ada data transaksi sebelumnya

$urut = substr($kode, 8, 3);
$tambah = (int) $urut + 1;
$bulan = date("m");
$tahun = date("y");

if (strlen($tambah) == 1) {
	$format = "TRM-" . $bulan . $tahun . "00" . $tambah;
} else if (strlen($tambah) == 2) {
	$format = "TRM-" . $bulan . $tahun . "0" . $tambah;
} else {
	$format = "TRM-" . $bulan . $tahun . $tambah;
}

$tanggal_masuk = date("Y-m-d");

?>

<div class="container-fluid">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Tambah Barang Masuk</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<div class="body">
					<form method="POST" enctype="multipart/form-data">
						<label for="">Id Transaksi</label>
						<div class="form-group">
							<div class="form-line">
								<input type="text" name="id_transaksi" class="form-control" id="id_transaksi"
									value="<?php echo $format; ?>" readonly />
							</div>
						</div>

						<label for="">Tanggal Masuk</label>
						<div class="form-group">
							<div class="form-line">
								<input type="date" name="tanggal_masuk" class="form-control" id="tanggal_masuk"
									value="<?php echo $tanggal_masuk; ?>" />
							</div>
						</div>

						<label for="">Barang</label>
						<div class="form-group">
							<div class="form-line">
								<select name="barang" id="cmb_barang" class="form-control" required>
									<option value="">-- Pilih Barang --</option>
									<?php
									$sql = $koneksi->query("SELECT * FROM gudang ORDER BY kode_barang");
									while ($data = $sql->fetch_assoc()) {
										echo "<option value='$data[kode_barang].$data[nama_barang]'>$data[kode_barang] | $data[nama_barang]</option>";
									}
									?>
								</select>
							</div>
						</div>

						<label for="">Jumlah</label>
						<div class="form-group">
							<div class="form-line">
								<input type="number" name="jumlahmasuk" id="jumlahmasuk" onkeyup="sum()"
									class="form-control" required />
							</div>
						</div>

						<label for="jumlah">Total Stok</label>
						<div class="form-group">
							<div class="form-line">
								<input readonly="readonly" name="jumlah" id="jumlah" type="number" class="form-control">
							</div>
						</div>

						<!-- Field Pengirim dan Satuan -->
						<label for="pengirim">Pengirim</label>
						<div class="form-group">
							<div class="form-line">
								<input type="text" name="pengirim" id="pengirim" class="form-control" required />
							</div>
						</div>


						<label for="satuan">Satuan</label>
						<div class="form-group">
							<div class="form-line">
								<!-- Dropdown untuk memilih satuan -->
								<select name="satuan" id="satuan" class="form-control" required>
									<option value="">-- Pilih Satuan --</option>
									<?php
									// Query untuk mengambil daftar satuan dari database
									$sql_satuan = $koneksi->query("SELECT * FROM satuan");
									while ($data_satuan = $sql_satuan->fetch_assoc()) {
										// Menampilkan opsi satuan dalam dropdown
										echo "<option value='" . $data_satuan['satuan'] . "'>" . $data_satuan['satuan'] . "</option>";
									}
									?>
								</select>
							</div>
						</div>

						<!-- Tombol Simpan -->
						<div class="form-group">
							<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
						</div>

					</form>

					<?php
					if (isset($_POST['simpan'])) {
						$id_transaksi = $_POST['id_transaksi'];
						$tanggal = $_POST['tanggal_masuk'];
						$barang = $_POST['barang'];
						$pecah_barang = explode(".", $barang);
						$kode_barang = $pecah_barang[0];
						$nama_barang = $pecah_barang[1];
						$jumlah = $_POST['jumlahmasuk'];
						$satuan = $_POST['satuan'];  // Mengambil data satuan dari dropdown
						$pengirim = $_POST['pengirim'];

						// Memastikan semua field diisi
						if (empty($id_transaksi) || empty($tanggal) || empty($kode_barang) || empty($nama_barang) || empty($jumlah) || empty($satuan) || empty($pengirim)) {
							echo "<script type='text/javascript'>
								alert('Semua field harus diisi!');
							</script>";
						} else {
							// Insert data ke tabel barang_masuk
							$sql = $koneksi->query("INSERT INTO barang_masuk (id_transaksi, tanggal, kode_barang, nama_barang, jumlah, satuan, pengirim) 
								VALUES('$id_transaksi','$tanggal','$kode_barang','$nama_barang','$jumlah','$satuan','$pengirim')");

							if ($sql) {
								echo "<script type='text/javascript'>
									alert('Simpan Data Berhasil');
									window.location.href = '?page=barangmasuk';
								</script>";
							} else {
								echo "<script type='text/javascript'>
									alert('Gagal Simpan Data');
								</script>";
							}
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>