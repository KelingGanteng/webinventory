<?php
$koneksi = new mysqli("localhost", "root", "", "webinventory");

// Perbaikan query untuk mengambil kode barang terakhir
$sql = "SELECT kode_barang FROM gudang ORDER BY nama_barang DESC LIMIT 1";
$result = mysqli_query($koneksi, $sql);

if ($result && mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_array($result);
	$kode = $row['kode_barang'];
} else {
	// Jika tidak ada data, set kode barang ke nilai default
	$kode = "BAR-" . date("m") . date("y") . "001";
}

// Ambil 3 digit terakhir dari kode barang untuk penambahan urut
$urut = substr($kode, 8, 3);
$tambah = (int) $urut + 1;
$bulan = date("m");
$tahun = date("y");

// Format kode barang baru
if (strlen($tambah) == 1) {
	$format = "BAR-" . $bulan . $tahun . "00" . $tambah;
} else if (strlen($tambah) == 2) {
	$format = "BAR-" . $bulan . $tahun . "0" . $tambah;
} else {
	$format = "BAR-" . $bulan . $tahun . $tambah;
}

$jumlah = 0;
?>

<div class="container-fluid">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Tambah Stok</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<div class="body">
					<form method="POST" enctype="multipart/form-data">
						<label for="">Kode Barang</label>
						<div class="form-group">
							<div class="form-line">
								<input type="text" name="kode_barang" class="form-control"
									value="<?php echo $format; ?>" required />
							</div>
						</div>

						<!-- Kode form lainnya tetap sama -->

						<label for="">Nama Barang</label>
						<div class="form-group">
							<div class="form-line">
								<input type="text" name="nama_barang" class="form-control" required />
							</div>
						</div>

						<la<label for="">Kerusakan</label>
							<div class="form-group">
								<div class="form-line">
									<input type="text" name="kerusakan" class="form-control" required />
								</div>
							</div>


							<label for="">Jenis Barang</label>
							<div class="form-group">
								<div class="form-line">
									<select name="jenis_barang" class="form-control" required>
										<option value="">-- Pilih Jenis Barang --</option>
										<?php
										$sql = $koneksi->query("SELECT * FROM jenis_barang ORDER BY id");
										while ($data = $sql->fetch_assoc()) {
											echo "<option value='$data[id].$data[jenis_barang]'>$data[jenis_barang]</option>";
										}
										?>
									</select>
								</div>
							</div>

							<label for="">Jumlah</label>
							<div class="form-group">
								<div class="form-line">
									<input type="number" name="jumlah" class="form-control" id="jumlah"
										value="<?php echo $jumlah; ?>" required />
								</div>
							</div>

							<label for="">Satuan Barang</label>
							<div class="form-group">
								<div class="form-line">
									<select name="satuan" class="form-control" required>
										<option value="">-- Pilih Satuan Barang --</option>
										<?php
										$sql = $koneksi->query("SELECT * FROM satuan ORDER BY id");
										while ($data = $sql->fetch_assoc()) {
											echo "<option value='$data[id].$data[satuan]'>$data[satuan]</option>";
										}
										?>
									</select>
								</div>
							</div>

							<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
					</form>

					<?php
					if (isset($_POST['simpan'])) {
						$kode_barang = $_POST['kode_barang'];
						$nama_barang = $_POST['nama_barang'];
						$kerusakan = $_POST['kerusakan'];

						$jenis_barang = $_POST['jenis_barang'];
						$pecah_jenis = explode(".", $jenis_barang);
						$id = $pecah_jenis[0];
						$jenis_barang = $pecah_jenis[1];

						$jumlah = $_POST['jumlah'];

						$satuan = $_POST['satuan'];
						$pecah_satuan = explode(".", $satuan);
						$id_satuan = $pecah_satuan[0];
						$satuan = $pecah_satuan[1];

						$sql = $koneksi->query("INSERT INTO gudang (kode_barang, nama_barang, kerusakan, jenis_barang, jumlah, satuan) 
                            VALUES('$kode_barang', '$nama_barang', '$kerusakan', '$jenis_barang', '$jumlah', '$satuan')");

						if ($sql) {
							?>
							<script type="text/javascript">
								alert("Data Berhasil Disimpan");
								window.location.href = "?page=gudang";
							</script>
							<?php
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>