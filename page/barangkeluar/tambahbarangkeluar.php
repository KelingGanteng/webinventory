<script>
	function sum() {
		var stok = document.getElementById('stok').value;
		var jumlahkeluar = document.getElementById('jumlahkeluar').value;
		var result = parseInt(stok) - parseInt(jumlahkeluar);
		if (!isNaN(result)) {
			document.getElementById('total').value = result;
		}
	}

	$(document).ready(function () {
		// Ketika barang dipilih
		$('#cmb_barang').change(function () {
			var tamp = $(this).val(); // Ambil nilai barang
			$.ajax({
				type: 'POST',
				url: 'get_satuan.php',
				data: { tamp: tamp },  // Kirimkan kode barang untuk mengambil satuan
				success: function (response) {
					// Masukkan response (HTML satuan) ke dalam div tampung
					$('.tampung').html(response);
				}
			});
		});
	});
</script>

</script>

<?php

$koneksi = new mysqli("localhost", "root", "", "webinventory");

// Cek koneksi ke database
if ($koneksi->connect_error) {
	die("Koneksi gagal: " . $koneksi->connect_error);
}

// Query untuk mengambil id_transaksi terakhir dari tabel barang_keluar
$no = mysqli_query($koneksi, "SELECT id_transaksi FROM barang_keluar ORDER BY id_transaksi DESC LIMIT 1");
$idtran = mysqli_fetch_array($no);

// Jika tidak ada transaksi sebelumnya, inisialisasi kode transaksi pertama
if ($idtran) {
	$kode = $idtran['id_transaksi'];
} else {
	// Jika tidak ada data transaksi sebelumnya, buat kode transaksi pertama
	$kode = "TRK-" . date("m") . date("y") . "000"; // Format awal transaksi
}

// Mengambil angka urut dari id_transaksi terakhir
$urut = substr($kode, 8, 3);

// Tambah 1 pada angka urut
$tambah = (int) $urut + 1;

// Format bulan dan tahun
$bulan = date("m");
$tahun = date("y");

// Membuat format kode transaksi berdasarkan angka urut
if (strlen($tambah) == 1) {
	$format = "TRK-" . $bulan . $tahun . "00" . $tambah;
} else if (strlen($tambah) == 2) {
	$format = "TRK-" . $bulan . $tahun . "0" . $tambah;
} else {
	$format = "TRK-" . $bulan . $tahun . $tambah;
}

// Tanggal barang keluar
$tanggal_keluar = date("Y-m-d");

?>



<div class="container-fluid">

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Tambah Barang Keluar</h6>
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



						<label for="">Tanggal Keluar</label>
						<div class="form-group">
							<div class="form-line">
								<input type="date" name="tanggal_keluar" class="form-control" id="tanggal_kelauar"
									value="<?php echo $tanggal_keluar; ?>" />
							</div>
						</div>


						<label for="">Barang</label>
						<div class="form-group">
							<div class="form-line">
								<select name="barang" id="cmb_barang" class="form-control" />
								<option value="">-- Pilih Barang --</option>
								<?php

								$sql = $koneksi->query("select * from gudang order by kode_barang");
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
								<input type="text" name="jumlahkeluar" id="jumlahkeluar" onkeyup="sum()"
									class="form-control" />



							</div>
						</div>

						<label for="total">Total Stok</label>
						<div class="form-group">
							<div class="form-line">
								<input readonly="readonly" name="total" id="total" type="number" class="form-control">


							</div>
						</div>

						<div class="tampung1"></div>

						<label for="">Tujuan</label>
						<div class="form-group">
							<div class="form-line">
								<input type="text" name="tujuan" class="form-control" />
							</div>
						</div>



						<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">

					</form>



					<?php

					if (isset($_POST['simpan'])) {
						$id_transaksi = $_POST['id_transaksi'];
						$tanggal = $_POST['tanggal_keluar'];

						$barang = $_POST['barang'];
						$pecah_barang = explode(".", $barang);
						$kode_barang = $pecah_barang[0];
						$nama_barang = $pecah_barang[1];
						$jumlah = $_POST['jumlahkeluar'];

						$satuan = $_POST['satuan'];
						$tujuan = $_POST['tujuan'];


						$total = $_POST['total'];
						$sisa2 = $total;
						if ($sisa2 < 0) {
							?>

							<script type="text/javascript">
								alert("Stok Barang Habis, Transaksi Tidak Dapat Dilakukan");
								window.location.href = "?page=barangkeluar&aksi=tambahbarangkeluar";
							</script>

							<?php
						} else {


							$sql = $koneksi->query("INSERT INTO barang_keluar (id_transaksi, tanggal, kode_barang, nama_barang, jumlah, satuan) 
							VALUES('$id_transaksi', '$tanggal', '$kode_barang', '$nama_barang', '$jumlah', '$satuan')");
							$sql2 = $koneksi->query("update gudang set jumlah=(jumlah) where kode_barang='$kode_barang'");
							?>





							<script type="text/javascript">
								alert("Simpan Data Berhasil");
								window.location.href = "?page=barangkeluar";

							</script>
							<?php
						}
					}


					?>