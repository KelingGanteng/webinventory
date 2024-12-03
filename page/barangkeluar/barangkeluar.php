<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Barang Keluar</h6>
		</div>
		<div class="card-body">
			<!-- Tombol Tambah Barang -->
			<div class="mb-3">
				<a href="?page=barangkeluar&aksi=tambahbarangkeluar" class="btn btn-primary custom-btn">
					<i class="fas fa-plus me-2"></i> Tambah Barang
				</a>
			</div>
			<!-- Tombol Export Table -->
			<div class="mb-3">
				<a href="export2.php" class="btn btn-success custom-btn" data-bs-toggle="tooltip"
					data-bs-placement="top" title="Export Table">
					<i class="fas fa-download me-2"></i> Export Table
				</a>
			</div>

			<!-- Filter tanggal -->
			<div class="row mb-3">
				<div class="col-md-6">
					<div class="input-group">
						<span class="input-group-text"><i class="fas fa-calendar-alt"></i> Dari</span>
						<input type="date" id="min" name="min" class="form-control">
						<span class="input-group-text"><i class="fas fa-calendar-alt"></i> Sampai</span>
						<input type="date" id="max" name="max" class="form-control">
					</div>
				</div>
			</div>

			<!-- Tabel Barang Keluar -->
			<div class="table-responsive">
				<table class="table table-bordered" id="barangkeluar" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>No</th>
							<th>Id Transaksi</th>
							<th>Tanggal Keluar</th>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Kondisi</th>
							<th>Jumlah Keluar</th>
							<th>Satuan</th>
							<th>Pengaturan</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						$sql = $koneksi->query("SELECT barang_keluar.*, gudang.satuan FROM barang_keluar INNER JOIN gudang ON barang_keluar.kode_barang = gudang.kode_barang");
						while ($data = $sql->fetch_assoc()) {
							?>
							<tr>
								<td><?php echo $no++; ?></td>
								<td><?php echo $data['id_transaksi']; ?></td>
								<td><?php echo $data['tanggal']; ?></td>
								<td><?php echo $data['kode_barang']; ?></td>
								<td><?php echo $data['nama_barang']; ?></td>
								<td><?php echo $data['kondisi']; ?></td>
								<td><?php echo $data['jumlah']; ?></td>
								<td><?php echo $data['satuan']; ?></td>
								<td>
									<a href="?page=barangkeluar&aksi=ubahbarangkeluar&id_transaksi=<?php echo $data['id_transaksi']; ?>"
										class="btn btn-info btn-sm mb-1 custom-btn">
										<i class="fas fa-edit"></i> Edit
									</a>
									<a href="?page=barangkeluar&aksi=hapusbarangkeluar&id_transaksi=<?php echo $data['id_transaksi']; ?>"
										class="btn btn-danger btn-sm custom-btn"
										onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">
										<i class="fas fa-trash"></i> Hapus
										<a href="pdf3.php" class="btn btn-warning btn-sm custom-btn">
											<i class="fas fa-file-pdf"></i> Export PDF
										</a>
									</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- JavaScript untuk DataTable dan Filter Tanggal -->
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
				var date = data[2]; // Kolom Tanggal Keluar

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

<!-- Additional Styles -->
<style>
	/* Custom button styling */
	.custom-btn {
		background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
		color: white;
		border: none;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
		transition: transform 0.2s ease, box-shadow 0.2s ease;
	}

	/* Button hover effect */
	.custom-btn:hover {
		transform: scale(1.05);
		box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
	}

	/* Button focus effect */
	.custom-btn:focus {
		outline: none;
		box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
	}

	/* Tooltip */
	.custom-btn[data-bs-toggle="tooltip"] {
		position: relative;
	}

	/* Style for the table buttons */
	.btn-sm {
		font-size: 0.9rem;
	}

	/* Button spacing in table */
	.btn-sm i {
		margin-right: 5px;
	}

	/* Buttons for the DataTable */
	.dt-buttons .btn {
		background-color: #007bff;
		color: white;
		border: none;
		font-size: 0.875rem;
		padding: 5px 10px;
		margin: 0 5px;
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
		transition: all 0.3s ease;
	}

	.dt-buttons .btn:hover {
		background-color: #0056b3;
		transform: scale(1.05);
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
	}

	.dt-buttons .btn i {
		margin-right: 5px;
	}
</style>

<!-- Tooltip Initialization (Bootstrap 5) -->
<script>
	var tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
	})
</script>