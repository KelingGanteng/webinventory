<?php
$id_retur = $_GET['id_retur'];
$sql2 = $koneksi->query("SELECT * FROM barang_retur WHERE id_retur = '$id_retur'");
$tampil = $sql2->fetch_assoc();
?>

<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ubah Barang Retur</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="body">
                    <form method="POST" enctype="multipart/form-data">

                        <label for="">Kode Barang</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name="kode_barang" class="form-control" id="kode_barang"
                                    value="<?php echo $tampil['kode_barang']; ?>" readonly />
                            </div>
                        </div>

                        <label for="">Nama Barang</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name="nama_barang" value="<?php echo $tampil['nama_barang']; ?>"
                                    class="form-control" required />
                            </div>
                        </div>
                        <label for="">Kerusakan</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name="kerusakan" value="<?php echo $tampil['kerusakan']; ?>"
                                    class="form-control" required />
                            </div>
                        </div>

                        <label for="">Kondisi</label>
                        <div class="form-group">
                            <div class="form-line">
                                <!-- Checkbox untuk kondisi barang -->
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="kondisi[]" value="Baik" 
                                            <?php echo (in_array('Baik', explode(',', $tampil['kondisi']))) ? 'checked' : ''; ?>> Baik
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="kondisi[]" value="Rusak" 
                                            <?php echo (in_array('Rusak', explode(',', $tampil['kondisi']))) ? 'checked' : ''; ?>> Rusak
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="kondisi[]" value="Perlu Perbaikan" 
                                            <?php echo (in_array('Perlu Perbaikan', explode(',', $tampil['kondisi']))) ? 'checked' : ''; ?>> Perlu Perbaikan
                                    </label>
                                </div>
                            </div>
                        </div>

                        <label for="">Jenis Barang</label>
                        <div class="form-group">
                            <div class="form-line">
                                <select name="jenis_barang" class="form-control" required>
                                    <?php
                                    $sql = $koneksi->query("SELECT * FROM jenis_barang ORDER BY jenis_barang");
                                    while ($data = $sql->fetch_assoc()) {
                                        // Menandai option yang terpilih dengan "selected"
                                        $selected = ($tampil['jenis_barang'] == $data['jenis_barang']) ? 'selected' : '';
                                        echo "<option value='{$data['id']}.{$data['jenis_barang']}' $selected>{$data['jenis_barang']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        

                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                    </form>

                    <?php
                    if (isset($_POST['simpan'])) {
                        $kode_barang = $_POST['kode_barang'];
                        $nama_barang = $_POST['nama_barang'];
                        $kerusakan = $_POST['kerusakan'];
                        
                        // Mengambil kondisi yang dipilih dari checkbox
                        $kondisi = isset($_POST['kondisi']) ? implode(',', $_POST['kondisi']) : '';

                        // Ambil nilai jenis barang dan pecah ID dan nama
                        $jenis_barang = $_POST['jenis_barang'];
                        $pecah_jenis = explode(".", $jenis_barang);
                        $id_jenis = $pecah_jenis[0];
                        $jenis_barang = $pecah_jenis[1];

                        // Ambil nilai satuan dan pecah ID dan nama
                       
                        // Update data ke database
                        $sql = $koneksi->query("UPDATE barang_retur 
                                                SET nama_barang='$nama_barang', kerusakan='$kerusakan', kondisi='$kondisi', jenis_barang='$jenis_barang' 
                                                WHERE id_retur='$id_retur'");

                        if ($sql) {
                            ?>
                            <script type="text/javascript">
                                alert("Data Berhasil Diubah");
                                window.location.href = "?page=barangretur";
                            </script>
                            <?php
                        } else {
                            echo "<script type='text/javascript'>alert('Gagal mengubah data!');</script>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
