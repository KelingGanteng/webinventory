<?php
// Pastikan ID Transaksi diterima dengan benar dari URL
if (isset($_GET['id_transaksi'])) {
	$id_transaksi = $_GET['id_transaksi'];

	// Pastikan id_transaksi tidak kosong dan valid
	if (!empty($id_transaksi)) {
		// Cek apakah id_transaksi ada dalam tabel terlebih dahulu
		$sql_check = $koneksi->query("SELECT * FROM barang_masuk WHERE id_transaksi = '$id_transaksi'");
		if ($sql_check->num_rows > 0) {
			// Lakukan penghapusan jika data ditemukan
			$sql_delete = $koneksi->query("DELETE FROM barang_masuk WHERE id_transaksi = '$id_transaksi'");
			if ($sql_delete) {
				echo "<script type='text/javascript'>
                        alert('Data Berhasil Dihapus');
                        window.location.href = '?page=barangmasuk';
                      </script>";
			} else {
				echo "<script type='text/javascript'>
                        alert('Gagal Menghapus Data');
                        window.location.href = '?page=barangmasuk';
                      </script>";
			}
		} else {
			echo "<script type='text/javascript'>
                    alert('Data Tidak Ditemukan');
                    window.location.href = '?page=barangmasuk';
                  </script>";
		}
	} else {
		echo "<script type='text/javascript'>
                alert('ID Transaksi Tidak Valid');
                window.location.href = '?page=barangmasuk';
              </script>";
	}
} else {
	// Jika id_transaksi tidak ada di URL, kembali ke halaman barangmasuk
	echo "<script type='text/javascript'>
            alert('ID Transaksi Tidak Ditemukan');
            window.location.href = '?page=barangmasuk';
          </script>";
}
?>