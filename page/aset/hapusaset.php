<?php
// Koneksi ke database
include 'koneksibarang.php'; // Pastikan koneksi ke database sudah benar

// Cek apakah ada ID aset yang diterima dari URL (untuk menghapus aset tertentu)
if (isset($_GET['id_aset'])) {
    $id_aset = $_GET['id_aset'];

    // Query untuk menghapus data aset
    $query = "DELETE FROM aset WHERE id_aset = ?";

    // Siapkan statement untuk menghindari SQL injection
    if ($stmt = $koneksi->prepare($query)) {
        // Bind parameter
        $stmt->bind_param("i", $id_aset);

        // Eksekusi query
        if ($stmt->execute()) {
            // Jika berhasil, alihkan kembali ke halaman utama atau halaman asset management
            echo "<script>alert('Data aset berhasil dihapus!'); window.location.href='?page=aset';</script>";
        } else {
            // Jika gagal, tampilkan pesan error
            echo "<script>alert('Gagal menghapus data aset!'); window.location.href='?page=aset';</script>";
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "<script>alert('Terjadi kesalahan!'); window.location.href='?page=aset';</script>";
    }
} else {
    echo "<script>alert('ID Aset tidak ditemukan!'); window.location.href='?page=aset';</script>";
    exit;
}
?>