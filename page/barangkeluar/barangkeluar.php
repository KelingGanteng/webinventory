<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Barang Keluar</h6>
		</div>
		<div class="card-body">
			<!-- Tambah tombol di atas tabel -->
			<div class="mb-3">
				<a href="?page=barangkeluar&aksi=tambahbarangkeluar" class="btn btn-primary">
					<i class="fas fa-plus"></i> Tambah Barang
				</a>
			</div>

			<div class="row mb-3">
				<div class="col-md-6">
					<div class="input-group">
						<span class="input-group-text">Dari</span>
						<input type="date" id="min" name="min" class="form-control">
						<span class="input-group-text">Sampai</span>
						<input type="date" id="max" name="max" class="form-control">
					</div>
				</div>
			</div>

			<div class="table-responsive">
				<table class="table table-bordered" id="barangkeluar" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>No</th>
							<th>Id Transaksi</th>
							<th>Tanggal Keluar</th>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Jumlah Keluar</th>
							<th>Satuan</th>
							<th>Pengaturan</th>
						</tr>
					</thead>

					<tbody>
						<?php
						$no = 1;
						// Query dengan JOIN untuk mendapatkan data satuan dari tabel gudang
						$sql = $koneksi->query("SELECT barang_keluar.*, gudang.satuan FROM barang_keluar INNER JOIN gudang ON barang_keluar.kode_barang = gudang.kode_barang");
						while ($data = $sql->fetch_assoc()) {
							?>
							<tr>
								<td><?php echo $no++; ?></td>
								<td><?php echo $data['id_transaksi']; ?></td>
								<td><?php echo $data['tanggal']; ?></td>
								<td><?php echo $data['kode_barang']; ?></td>
								<td><?php echo $data['nama_barang']; ?></td>
								<td><?php echo $data['jumlah']; ?></td>
								<td><?php echo $data['satuan']; ?></td> <!-- Menampilkan satuan dari tabel gudang -->
								<td>
									<a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"
										href="?page=barangkeluar&aksi=hapusbarangkeluar&id_transaksi=<?php echo $data['id_transaksi']; ?>"
										class="btn btn-danger">Hapus</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		var table = $('#barangkeluar').DataTable({
			dom: 'Bfrtip',
			buttons: [
				{
					extend: 'copy',
					text: '<i class="fas fa-copy"></i> Copy',
					className: 'btn btn-secondary btn-sm'
				},
				{
					extend: 'csv',
					text: '<i class="fas fa-file-csv"></i> CSV',
					className: 'btn btn-secondary btn-sm'
				},
				{
					extend: 'excel',
					text: '<i class="fas fa-file-excel"></i> Excel',
					className: 'btn btn-secondary btn-sm'
				},
				{
					extend: 'pdf',
					text: '<i class="fas fa-file-pdf"></i> PDF',
					className: 'btn btn-secondary btn-sm'
				},
				{
					extend: 'print',
					text: '<i class="fas fa-print"></i> Print',
					className: 'btn btn-secondary btn-sm'
				}
			],
			language: {
				search: "Cari:",
				lengthMenu: "Tampilkan _MENU_ data per halaman",
				zeroRecords: "Data tidak ditemukan",
				info: "Menampilkan halaman _PAGE_ dari _PAGES_",
				infoEmpty: "Tidak ada data yang tersedia",
				infoFiltered: "(difilter dari _MAX_ total data)",
				paginate: {
					first: "Pertama",
					last: "Terakhir",
					next: "Selanjutnya",
					previous: "Sebelumnya"
				}
			},
			order: [[2, 'desc']]
		});

		$.fn.dataTable.ext.search.push(
			function (settings, data, dataIndex) {
				var min = $('#min').val();
				var max = $('#max').val();
				var date = data[2];

				if (min === "" && max === "") return true;
				if (min === "") return date <= max;
				if (max === "") return date >= min;
				return date >= min && date <= max;
			}
		);

		$('#min, #max').on('change', function () {
			table.draw();
		});
	});
</script>