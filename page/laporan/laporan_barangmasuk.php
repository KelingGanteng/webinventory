<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Laporan Barang Masuk</h6>
    </div>
    <div class="card-body">

      <table>
        <tr>
          <td>
            LAPORAN PER RENTANG TANGGAL
          </td>
        </tr>
        <tr>
          <div class="mb-3">
            <a href="export.php" class="btn btn-primary">
              <i class="fas fa-plus"></i> Export Table
            </a>
          </div>

          <td width="50%">
            <form action="page/laporan/export_laporan_barangmasuk_excel.php" method="post">
              <div class="row form-group">

                <!-- Rentang Tanggal (Dari dan Sampai) -->
                <div class="col-md-4">
                  <input type="date" name="start_date" class="form-control" placeholder="Tanggal Dari" required>
                </div>
                <div class="col-md-4">
                  <input type="date" name="end_date" class="form-control" placeholder="Tanggal Sampai" required>
                </div>

                <div class="col-md-4">
                  <input type="submit" name="submit" value="Export to Excel" class="btn btn-success">
                </div>
              </div>
            </form>

            <!-- Form untuk menampilkan data berdasarkan rentang tanggal -->
            <form id="Myform1" method="POST">
              <div class="row form-group">

                <!-- Rentang Tanggal (Dari dan Sampai) -->
                <div class="col-md-4">
                  <input type="date" name="start_date" class="form-control" placeholder="Tanggal Dari" required>
                </div>
                <div class="col-md-4">
                  <input type="date" name="end_date" class="form-control" placeholder="Tanggal Sampai" required>
                </div>

                <div class="col-md-4">
                  <input type="submit" name="submit2" value="Tampilkan" class="btn btn-primary">
                </div>
              </div>
            </form>
          </td>
      </table>

      <div class="tampung1">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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

              // Ambil data rentang tanggal dari form
              $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
              $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

              $query = "SELECT * FROM barang_masuk WHERE 1";

              // Menambahkan filter berdasarkan rentang tanggal jika kedua tanggal diisi
              if ($start_date && $end_date) {
                $query .= " AND tanggal BETWEEN '$start_date' AND '$end_date'";
              }

              $sql = $koneksi->query($query);

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
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

</div>
<!-- End Page Content -->