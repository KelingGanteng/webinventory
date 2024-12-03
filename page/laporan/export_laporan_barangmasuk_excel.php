<?php
if (isset($_POST['submit'])) { ?>

	<?php
	$koneksi = new mysqli("localhost", "root", "", "webinventory");

	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Barang_Masuk (" . date('d-m-Y') . ").xls");

	// Mendapatkan rentang tanggal dari form
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];

	?>

	<body>
		<center>
			<h2>Laporan Barang Masuk Dari <?php echo $start_date; ?> Sampai <?php echo $end_date; ?></h2>
		</center>
		<table border="1">
			<tr>
				<th>No</th>
				<th>Id Transaksi</th>
				<th>Tanggal Masuk</th>
				<th>Kode Barang</th>
				<th>Nama Barang</th>
				<th>Kondisi</th>
				<th>Jumlah Masuk</th>
				<th>Satuan Barang</th>
				<th>Total Stok</th>
			</tr>

			<?php
			$no = 1;
			// Query yang menyaring data berdasarkan rentang tanggal
			$sql = $koneksi->query("SELECT * FROM barang_masuk WHERE tanggal BETWEEN '$start_date' AND '$end_date'");
			while ($data = $sql->fetch_assoc()) {
				?>

				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo $data['id_transaksi'] ?></td>
					<td><?php echo $data['tanggal'] ?></td>
					<td><?php echo $data['kode_barang'] ?></td>
					<td><?php echo $data['nama_barang'] ?></td>
					<td><?php echo $data['kondisi'] ?></td>
					<td><?php echo $data['jumlah'] ?></td>
					<td><?php echo $data['satuan'] ?></td>
					<td>isi total stok</td>
				</tr>
			<?php } ?>
		</table>
	</body>

	<?php
}
?>

<?php

$koneksi = new mysqli("localhost", "root", "", "webinventory");

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
?>

<?php
if ($start_date == '' || $end_date == '') {
	?>
	<div class="table-responsive">
		<table class="display table table-bordered" id="transaksi">
			<thead>
				<tr>
					<th>No</th>
					<th>Id Transaksi</th>
					<th>Tanggal Masuk</th>
					<th>Kode Barang</th>
					<th>Nama Barang</th>
					<th>Kondisi</th>
					<th>Jumlah Masuk</th>
					<th>Satuan Barang</th>
					<th>Total Stok</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				// Jika tidak ada rentang tanggal, tampilkan semua data
				$sql = $koneksi->query("SELECT * FROM barang_masuk");
				while ($data = $sql->fetch_assoc()) {
					?>
					<tr>
						<td><?php echo $no++; ?></td>
						<td><?php echo $data['id_transaksi'] ?></td>
						<td><?php echo $data['tanggal'] ?></td>
						<td><?php echo $data['kode_barang'] ?></td>
						<td><?php echo $data['nama_barang'] ?></td>
						<td><?php echo $data['kondisi'] ?></td>
						<td><?php echo $data['jumlah'] ?></td>
						<td><?php echo $data['satuan'] ?></td>
						<td>isi total stok</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<?php
} else {
	?>
	<div class="table-responsive">
		<table class="display table table-bordered" id="transaksi">
			<thead>
				<tr>
					<th>No</th>
					<th>Id Transaksi</th>
					<th>Tanggal Masuk</th>
					<th>Kode Barang</th>
					<th>Nama Barang</th>
					<th>Kondisi</th>
					<th>Jumlah Masuk</th>
					<th>Satuan Barang</th>
					<th>Total Stok</th>
				</tr>
			</thead>
			<tbody>

				<?php
				$no = 1;
				// Query dengan filter rentang tanggal
				$sql = $koneksi->query("SELECT * FROM barang_masuk WHERE tanggal BETWEEN '$start_date' AND '$end_date'");
				while ($data = $sql->fetch_assoc()) {
					?>

					<tr>
						<td><?php echo $no++; ?></td>
						<td><?php echo $data['id_transaksi'] ?></td>
						<td><?php echo $data['tanggal'] ?></td>
						<td><?php echo $data['kode_barang'] ?></td>
						<td><?php echo $data['nama_barang'] ?></td>
						<td><?php echo $data['kondisi'] ?></td>
						<td><?php echo $data['jumlah'] ?></td>
						<td><?php echo $data['satuan'] ?></td>
						<td>isi total stok</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<?php
}

?>