<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Satuan Barang</h6>
    </div>
    <div class="card-body">
      <!-- Tambah tombol di atas tabel -->
      <div class="mb-3">
        <a href="?page=satuanbarang&aksi=tambahsatuan" class="btn btn-primary">
          <i class="fas fa-plus"></i> Tambah barang
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered" id="satuanbarang" width="100%" cellspacing="0">
          <!-- Include DataTables CSS -->
          <thead>
            <tr>
              <th>No</th>
              <th>Satuan Barang</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1; // Inisialisasi nomor urut
            // Pastikan data diurutkan dengan benar berdasarkan ID atau kolom yang sesuai
            $sql = $koneksi->query("SELECT * FROM satuan");
            while ($data = $sql->fetch_assoc()) {
              ?>
              <tr>
                <!-- Tampilkan nomor urut -->
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['satuan']; ?></td>
                <td>
                  <a href="?page=satuanbarang&aksi=ubahsatuan&id=<?php echo $data['id']; ?>" class="btn btn-info btn-sm">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <a href="?page=satuanbarang&aksi=hapussatuan&id=<?php echo $data['id']; ?>"
                    class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?')">
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

<script>
  $(document).ready(function () {
    $('#satuanbarang').DataTable({
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
      order: [[1, 'asc']], // Urutkan berdasarkan kolom pertama (satuan barang)
      pageLength: 10 // Jumlah data per halaman
    });
  });
</script>