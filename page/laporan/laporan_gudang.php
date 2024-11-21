<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Stok Gudang</h6>
    </div>
    <div class="card-body">
      <!-- Tambah tombol di atas tabel -->
      <div class="mb-3">
        <a href="?page=gudang&aksi=tambahgudang" class="btn btn-primary">
          <i class="fas fa-plus"></i> Tambah Data
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered" id="gudang" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Jenis Barang</th>

              <th>Jumlah Barang</th>
              <th>Satuan</th>


            </tr>
          </thead>


          <tbody>
            <?php

            $no = 1;
            $sql = $koneksi->query("select * from gudang");
            while ($data = $sql->fetch_assoc()) {

              ?>

              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['kode_barang'] ?></td>
                <td><?php echo $data['nama_barang'] ?></td>
                <td><?php echo $data['jenis_barang'] ?></td>

                <td><?php echo $data['jumlah'] ?></td>
                <td><?php echo $data['satuan'] ?></td>





              </tr>
            <?php } ?>

          </tbody>
        </table>
        <a href="page/laporan/export_laporan_gudang_excel.php" class="btn btn-primary" style="margin-top:8 px"><i
            class="fa fa-print"></i>ExportToExcel</a>

        </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script>

  $(document).ready(function () {
    $('#gudang').DataTable({
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