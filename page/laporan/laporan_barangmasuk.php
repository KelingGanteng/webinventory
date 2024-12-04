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
            LAPORAN PERBULAN DAN PERTAHUN
          </td>
        </tr>
        <tr>
          <td width="50%">
            <form action="page/laporan/export_laporan_barangmasuk_excel.php" method="post">
              <div class="row form-group">

                <div class="col-md-5">
                  <select class="form-control " name="bln">


                    <option value="1" selected="">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <?php
                  $now = date('Y');
                  echo "<select name='thn' class='form-control'>";
                  for ($a = 2018; $a <= $now; $a++) {
                    echo "<option value='$a'>$a</option>";
                  }
                  echo "</select>";
                  ?>
                </div>

                <input type="submit" class="" name="submit" value="Export to Excel">
              </div>
            </form>


            <form id="Myform1">
              <div class="row form-group">

                <div class="col-md-5">
                  <select class="form-control " name="bln">

                    <option value="all" selected="">ALL</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <?php
                  $now = date('Y');
                  echo "<select name='thn' class='form-control'>";
                  for ($a = 2018; $a <= $now; $a++) {
                    echo "<option value='$a'>$a</option>";
                  }
                  echo "</select>";
                  ?>
                </div>


                <input type="submit" class="" name="submit2" value="Tampilkan">
              </div>
            </form>
          </td>


      </table>

      <div class="tampung1">

        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th style="width: 50px; text-align: center;">No</th>
                <th style="width: 150px; text-align: center;">Id Transaksi</th>
                <th style="width: 150px; text-align: center;">Tanggal Masuk</th>
                <th style="width: 150px; text-align: center;">Kode Barang</th>
                <th style="width: 200px; text-align: center;">Nama Barang</th>
                <th style="width: 100px; text-align: center;">Kondisi</th>
                <th style="width: 150px; text-align: center;">Jumlah Masuk</th>
                <th style="width: 100px; text-align: center;">Satuan</th>
                <th style="width: 200px; text-align: center;">Pengaturan</th>
              </tr>
            </thead>


            <tbody>
              <?php

              $no = 1;
              $sql = $koneksi->query("select * from barang_masuk");
              while ($data = $sql->fetch_assoc()) {

                ?>

                <tr>
                  <td style="text-align: center;"><?php echo $no++; ?></td>
                  <td style="text-align: center;"><?php echo $data['id_transaksi'] ?></td>
                  <td style="text-align: center;"><?php echo $data['tanggal'] ?></td>
                  <td style="text-align: center;"><?php echo $data['kode_barang'] ?></td>
                  <td style="text-align: center;"><?php echo $data['nama_barang'] ?></td>
                  <td style="text-align: center;"><?php echo $data['kondisi'] ?></td>
                  <td style="text-align: center;"><?php echo $data['jumlah'] ?></td>
                  <td style="text-align: center;"><?php echo $data['satuan'] ?></td>
                  <td style="text-align: center;">
                    <a href="export.php?id=<?php echo $data['id_transaksi']; ?>" class="btn btn-sm btn-primary">Export
                      PDF</a>


                </tr>
              <?php } ?>

            </tbody>
          </table>

          </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>