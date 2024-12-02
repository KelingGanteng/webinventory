<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "webinventory");

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_POST['kode_barang'])) {
    $kode_barang = $_POST['kode_barang'];

    // Ambil stok barang dari gudang berdasarkan kode barang
    $query = $koneksi->query("SELECT jumlah FROM gudang WHERE kode_barang = '$kode_barang'");
    $data = $query->fetch_assoc();

    if ($data) {
        echo $data['jumlah']; // Kembalikan stok barang
    } else {
        echo 0; // Jika barang tidak ditemukan, kembalikan 0
    }
}
?>