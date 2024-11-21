<?php
include '/config/koneksibarang.php'; // Sesuaikan path koneksi database

// Cek tipe export dari parameter GET
$export_type = isset($_GET['type']) ? $_GET['type'] : 'excel';

if ($export_type == 'excel') {
    // Export Excel
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan_Data_Supplier(" . date('d-m-Y') . ").xls");
} elseif ($export_type == 'pdf') {
    // Export PDF
    require_once('../vendor/tcpdf/tcpdf.php'); // Pastikan sudah install TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetCreator('Your Name');
    $pdf->SetTitle('Laporan Data Supplier');
    $pdf->SetHeaderData('', 0, 'Laporan Data Supplier', date('d-m-Y'));
    $pdf->setHeaderFont(array('helvetica', '', 12));
    $pdf->setFooterFont(array('helvetica', '', 10));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetAutoPageBreak(TRUE, 15);
    $pdf->AddPage();
}
?>

<!-- Header Laporan -->
<h2>Laporan Data Supplier</h2>
<p>Tanggal: <?php echo date('d-m-Y'); ?></p>

<!-- Tabel Data -->
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Kode Supplier</th>
        <th>Nama Supplier</th>
        <th>Alamat</th>
        <th>Telepon</th>
    </tr>

    <?php
    $no = 1;
    $sql = $koneksi->query("SELECT * FROM tb_supplier ORDER BY kode_supplier");

    // Jika export CSV, buat file CSV
    if ($export_type == 'csv') {
        $filename = "Laporan_Data_Supplier(" . date('d-m-Y') . ").csv";
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $output = fopen('php://output', 'w');
        fputcsv($output, array('No', 'Kode Supplier', 'Nama Supplier', 'Alamat', 'Telepon'));
    }

    while ($data = $sql->fetch_assoc()) {
        if ($export_type == 'csv') {
            // Tulis data ke CSV
            fputcsv($output, array(
                $no,
                $data['kode_supplier'],
                $data['nama_supplier'],
                $data['alamat'],
                $data['telepon']
            ));
        } else {
            // Tampilkan data dalam tabel HTML (untuk Excel dan PDF)
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo htmlspecialchars($data['kode_supplier']); ?></td>
                <td><?php echo htmlspecialchars($data['nama_supplier']); ?></td>
                <td><?php echo htmlspecialchars($data['alamat']); ?></td>
                <td><?php echo htmlspecialchars($data['telepon']); ?></td>
            </tr>
            <?php
        }
        $no++;
    }

    if ($export_type == 'csv') {
        fclose($output);
        exit;
    } elseif ($export_type == 'pdf') {
        $html = ob_get_contents();
        ob_end_clean();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('Laporan_Data_Supplier(' . date('d-m-Y') . ').pdf', 'D');
        exit;
    }
    ?>
</table>