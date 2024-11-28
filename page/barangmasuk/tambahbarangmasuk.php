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
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "webinventory");

// Periksa apakah koneksi berhasil
if ($koneksi->connect_error) {
	die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil ID transaksi terakhir dari tabel barang_masuk
$no = mysqli_query($koneksi, "SELECT id_transaksi FROM barang_masuk ORDER BY id_transaksi DESC LIMIT 1");

// Cek apakah query berhasil dan ada data yang ditemukan
$idtran = mysqli_fetch_array($no);

// Jika ada data transaksi sebelumnya
if ($idtran) {
	$kode = $idtran['id_transaksi'];
} else {
	// Jika tidak ada transaksi sebelumnya, buat ID transaksi pertama
	$kode = "TRK-" . date("m") . date("y") . "001"; // Format awal transaksi
}

$tanggal_masuk = date("Y-m-d");  // Ambil tanggal sekarang
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
									value="<?php echo $kode; ?>" readonly />
							</div>
						</div>

						<!-- Input lainnya -->
						<label for="">Tanggal Masuk</label>
						<div class="form-group">
							<div class="form-line">
								<input type="date" name="tanggal_masuk" class="form-control"
									value="<?php echo $tanggal_masuk; ?>" />
							</div>
						</div>

						<label for="">Barang</label>
						<div class="form-group">
							<div class="form-line">
								<select name="barang" id="cmb_barang" class="form-control">
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

						<div class="tampung"></div>

						<label for="">Jumlah</label>
						<div class="form-group">
							<div class="form-line">
								<input type="text" name="jumlahmasuk" id="jumlahmasuk" onkeyup="sum()"
									class="form-control" />
							</div>
						</div>

						<label for="">Kondisi</label>
						<div class="form-group">
							<div class="form-line">
								<!-- Menampilkan checkbox dalam format sederhana -->
								<div class="checkbox-group">
									<label><input type="checkbox" name="kondisi[]" value="Baik" /> Baik</label>
									<label><input type="checkbox" name="kondisi[]" value="Rusak" /> Rusak</label>
									<label><input type="checkbox" name="kondisi[]" value="Retur" /> Retur</label>
									<label><input type="checkbox" name="kondisi[]" value="Basi" /> Basi</label>
								</div>
							</div>
						</div>
						<style>
							.checkbox-group label {
								display: inline-block;
								margin-right: 15px;
								font-size: 14px;
							}

							.checkbox-group input {
								margin-right: 5px;
							}
						</style>


						<label for="jumlah">Total Stok</label>
						<div class="form-group">
							<div class="form-line">
								<input readonly="readonly" name="jumlah" id="jumlah" type="number"
									class="form-control" />
							</div>
						</div>

						<label for="satuan">Satuan Barang</label>
						<div class="form-group">
							<div class="form-line">
								<select name="satuan" id="satuan" class="form-control">
									<option value="">-- Pilih Satuan --</option>
									<?php
									// Ambil data satuan dari tabel satuan
									$sql_satuan = $koneksi->query("SELECT * FROM satuan ORDER BY satuan");
									while ($data_satuan = $sql_satuan->fetch_assoc()) {
										echo "<option value='" . $data_satuan['satuan'] . "'>" . $data_satuan['satuan'] . "</option>";
									}
									?>
								</select>
							</div>
						</div>

						<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
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
						$satuan = $_POST['satuan'];

						// Menangani kondisi yang dikirimkan sebagai array
						$kondisi = isset($_POST['kondisi']) ? implode(", ", $_POST['kondisi']) : '';

						// Insert data barang masuk
						$sql = $koneksi->query("INSERT INTO barang_masuk (id_transaksi, tanggal, kode_barang, nama_barang, jumlah, satuan, kondisi) 
										VALUES('$id_transaksi', '$tanggal', '$kode_barang', '$nama_barang', '$jumlah', '$satuan', '$kondisi')");

						if ($sql) {
							echo "<script type='text/javascript'>
							alert('Simpan Data Berhasil');
							window.location.href = '?page=barangmasuk';
						  </script>";
						} else {
							echo "<script type='text/javascript'>
							alert('Simpan Data Gagal');
						  </script>";
						}
					}

					?>
				</div>
			</div>
		</div>
	</div>
</div>