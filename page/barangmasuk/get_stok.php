<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "webinventory");

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil kode barang dari parameter URL
$kode_barang = $_GET['kode_barang'];

// Ambil stok barang berdasarkan kode_barang
$sql = $koneksi->query("SELECT jumlah FROM gudang WHERE kode_barang = '$kode_barang'");
if ($sql->num_rows > 0) {
    $data = $sql->fetch_assoc();
    echo json_encode(['stok' => $data['jumlah']]);
} else {
    echo json_encode(['stok' => 0]);
}

$koneksi->close();
?>