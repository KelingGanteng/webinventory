<?php
$koneksi = new mysqli("localhost", "root", "", "webinventory");

// Check connection
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

// Query to fetch data from the database
$query = "SELECT * FROM gudang ORDER BY kode_barang";
$result = $koneksi->query($query);

// Prepare an array to store the data
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Return data in JSON format
echo json_encode($data);
?>