<?php


// Cek koneksi
if (!isset($koneksi)) {
    die("Koneksi database tidak tersedia!");
}

// Cek parameter id
if (!isset($_GET['id'])) {
    echo "<script>
        alert('ID tidak ditemukan!');
        window.location.href='?page=jenisbarang';
    </script>";
    exit;
}

$id = (int) $_GET['id'];
// Debug query
$query = "SELECT * FROM jenis_barang WHERE id = '$id'";


$sql = $koneksi->query($query);

// Cek query
if (!$sql) {
    die("Error query: " . $koneksi->error);
}

$data = $sql->fetch_assoc();

// Cek data
if (!$data) {
    echo "<script>
        alert('Data tidak ditemukan!');
        window.location.href='?page=jenisbarang';
    </script>";
    exit;
}
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ubah Jenis Barang</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="body">
                    <form method="POST">
                        <label for="jenis_barang">Jenis Barang</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" name="jenis_barang" id="jenis_barang"
                                    value="<?php echo htmlspecialchars($data['jenis_barang']); ?>" class="form-control"
                                    required />
                            </div>
                        </div>

                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                        <a href="?page=jenisbarang" class="btn btn-secondary">Kembali</a>
                    </form>

                    <?php
                    if (isset($_POST['simpan'])) {
                        $jenis_barang = mysqli_real_escape_string($koneksi, $_POST['jenis_barang']);

                        // Debug data yang akan diupdate
                        echo "<pre>Data yang akan diupdate:";
                        echo "\nID: $id";
                        echo "\nJenis Barang: $jenis_barang";
                        echo "</pre>";

                        $update = $koneksi->prepare("UPDATE jenis_barang SET jenis_barang = ? WHERE id = ?");
                        $update->bind_param("si", $jenis_barang, $id);

                        if ($update->execute()) {
                            echo "<script>
                                alert('Data Berhasil Diubah');
                                window.location.href='?page=jenisbarang';
                            </script>";
                        } else {
                            echo "<script>
                                alert('Gagal mengubah data: " . $koneksi->error . "');
                            </script>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>