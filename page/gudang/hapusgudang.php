<?php
// File: page/gudang/hapusgudang.php

if (!isset($koneksi)) {
    die("Koneksi database tidak tersedia!");
}

if (isset($_GET['kode_barang'])) {
    $kode_barang = mysqli_real_escape_string($koneksi, $_GET['kode_barang']);

    // Cek apakah data ada
    $check = $koneksi->query("SELECT nama_barang FROM gudang WHERE kode_barang='$kode_barang'");
    $data = $check->fetch_assoc();

    if ($data) {
        // Hapus data
        $sql = $koneksi->query("DELETE FROM gudang WHERE kode_barang='$kode_barang'");

        if ($sql) {
            ?>
            <script type="text/javascript">
                alert("Data Berhasil Dihapus");
                window.location.href = "?page=gudang";
            </script>
            <?php
        }
    }
}