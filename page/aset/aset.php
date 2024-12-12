<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Asset Management</h6>
        </div>
        <div class="card-body">
            <!-- Tombol Tambah Aset -->
            <div class="mb-3">
                <a href="?page=aset&aksi=tambahaset" class="btn btn-primary custom-btn">
                    <i class="fas fa-plus me-2"></i> Tambah Aset
                </a>
            </div>

            <!-- Filter Tanggal dan Status -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">Dari</span>
                        <input type="date" id="min" name="min" class="form-control">
                        <span class="input-group-text">Sampai</span>
                        <input type="date" id="max" name="max" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">Status</span>
                        <select id="status_filter" class="form-control">
                            <option value="">Semua</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tabel Asset Management -->
            <div class="table-responsive">
                <table class="table table-bordered" id="assetTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th style="width: 150px; text-align: center;">Kode Aset</th>
                            <th style="width: 150px; text-align: center;">Jenis Barang</th> <!-- Kolom Jenis Barang -->
                            <th style="width: 200px; text-align: center;">Nama Aset</th>
                            <th style="width: 100px; text-align: center;">Departemen</th>
                            <th style="width: 150px; text-align: center;">Tanggal Pembelian</th>
                            <th style="width: 100px; text-align: center;">Status</th>
                            <th style="width: 100px; text-align: center;">Kondisi</th>
                            <th style="width: 200px; text-align: center;">Pengaturan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = "SELECT a.*, d.nama AS departemen, k.nama AS karyawan, j.jenis_barang 
                        FROM aset a
                         LEFT JOIN departemen d ON a.departemen_id = d.id
                         LEFT JOIN daftar_karyawan k ON a.karyawan_id = k.id
                         LEFT JOIN jenis_barang j ON a.kode_aset = j.code_barang"; // Query yang sudah diperbarui
                        $result = $koneksi->query($sql);
                        while ($data = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $no++; ?></td>
                                <td style="text-align: center;"><?php echo $data['kode_aset'] ?></td>
                                <td style="text-align: center;"><?php echo $data['jenis_barang'] ?></td>
                                <td style="text-align: center;"><?php echo $data['nama_aset'] ?></td>
                                <td style="text-align: center;"><?php echo $data['departemen'] ?></td>
                                <td style="text-align: center;"><?php echo $data['tanggal_pembelian'] ?></td>
                                <td style="text-align: center;"><?php echo $data['status'] ?></td>
                                <td style="text-align: center;"><?php echo $data['kondisi'] ?></td>
                                <td style="text-align: center;">
                                    <a href="?page=aset&aksi=ubahaset&id_aset=<?php echo $data['id_aset']; ?>"
                                        class="btn btn-info btn-sm custom-btn">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="?page=aset&aksi=hapusaset&id_aset=<?php echo $data['id_aset']; ?>"
                                        class="btn btn-danger btn-sm custom-btn"
                                        onclick="return confirm('Apakah anda yakin ingin menghapus aset ini?')">
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

<!-- CSS for Custom Button Styling -->
<style>
    .custom-btn {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .custom-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .custom-btn:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
    }

    .btn-sm {
        font-size: 0.9rem;
    }

    .btn-sm i {
        margin-right: 5px;
    }
</style>

<!-- DataTable Initialization Script -->
<script>
    $(document).ready(function () {
        var table = $('#assetTable').DataTable({
            dom: 'Bfrtip',
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
            order: [[4, 'desc']] // Urutkan berdasarkan tanggal pembelian
        });

        // Filter berdasarkan status dan tanggal
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                var min = $('#min').val();        // Tanggal awal
                var max = $('#max').val();        // Tanggal akhir
                var status = $('#status_filter').val();  // Status filter
                var date = data[5];  // Tanggal Pembelian (kolom ke-6)
                var itemStatus = data[6]; // Status (kolom ke-7, indeks 6)

                // Pastikan format tanggalnya sesuai
                if (min !== "" && date < min) return false;
                if (max !== "" && date > max) return false;

                // Memeriksa status jika status filter dipilih
                if (status !== "" && itemStatus.trim().toLowerCase() !== status.trim().toLowerCase()) {
                    return false;
                }

                // Jika semua kondisi lolos, tampilkan baris
                return true;
            }
        );

        // Update tabel ketika ada perubahan di filter
        $('#min, #max, #status_filter').on('change', function () {
            table.draw();
        });
    });

</script>