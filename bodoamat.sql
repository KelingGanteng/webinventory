CREATE TABLE barang_keluar (
    id_transaksi VARCHAR(20) PRIMARY KEY,
    tanggal DATE NOT NULL,
    kode_barang VARCHAR(50),
    nama_barang VARCHAR(100),
    jumlah INT NOT NULL,
    total INT,
    satuan VARCHAR(20),
    tujuan VARCHAR(100),
    FOREIGN KEY (kode_barang) REFERENCES gudang(kode_barang)
);