<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> Barang Retur </h6>
        </div>
        <div class="card-body">
            <!-- Tambah tombol di atas tabel -->
            <div class="mb-3">
                <a href="?page=barangretur&aksi=tambahbarangretur" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Barang
                </a>
            </div>
            <div class="mb-3">
                <a href="export4.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Export Table
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="barangretur" width="100%" cellspacing="0">
                    <!-- Include DataTables CSS -->
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Retur</th>
                            <th>Tanggal Retur</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kondisi</th>
                            <th>Kerusakan</th>
                            <th>Jumlah Retur</th>
                            <th>Tujuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = $koneksi->query("SELECT * FROM barang_retur ORDER BY id_retur");
                        while ($data = $sql->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($data['id_retur']); ?></td>
                                <td><?php echo htmlspecialchars($data['tanggal_retur']); ?></td>
                                <td><?php echo htmlspecialchars($data['kode_barang']); ?></td>
                                <td><?php echo htmlspecialchars($data['nama_barang']); ?></td>
                                <td><?php echo htmlspecialchars($data['kondisi']); ?></td>
                                <td><?php echo htmlspecialchars($data['kerusakan']); ?></td>
                                <td><?php echo htmlspecialchars($data['jumlah']); ?></td>
                                <td><?php echo htmlspecialchars($data['tujuan']); ?></td>
                                <!-- Ubah bagian tombol hapus di dalam loop while -->
                                <td>

                                    <!-- Setelah -->
                                    <a href="?page=barangretur&aksi=hapusbarangretur&id_retur=<?php echo $data['id_retur']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">
                                        <i class="fas fa-trash"></i> Hapus
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

<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    $(document).ready(function () {
        $('#barangretur').DataTable({
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
            order: [[1, 'asc']], // Urutkan berdasarkan kode barang
            pageLength: 10 // Jumlah data per halaman
        });
    });
</script>