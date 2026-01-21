<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/EPERPUS/vendor/autoload.php");

$connect = mysqli_connect("localhost", "root", "", "eperpus");
if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
$query = mysqli_query($connect, "SELECT p.*, 
        a.nama AS nama_anggota, 
        a.nim_nidn AS nim_nidn, 
        b.judul_buku AS judul_buku, 
        a.email AS email
        FROM peminjaman p
        JOIN anggota a ON a.id_anggota = p.id_anggota
        JOIN buku b ON b.id_buku = p.id_buku
        WHERE p.status = 'Dikembalikan'
        AND p.denda > 0
        AND p.tanggal_dikembalikan IS NOT NULL
        ORDER BY p.id DESC");

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// HEADER KOLUMNYA 
$headers = ['NO', 'ID', 'Nama anggota','judul buku' , 'denda', 'Tanggal pinjam', 'Tanggal kembali', 'Tanggal dikembalikan',];
$col = 'A';
foreach ($headers as $h) {
    $sheet->setCellValue($col . '1', $h);
    $col++;
}
$no = 1;
$rowNumber = 2;

while ($row = mysqli_fetch_assoc($query)) {
    $sheet->setCellValue("A$rowNumber", $no++);
    $sheet->setCellValue("B$rowNumber", $row['id']);
    $sheet->setCellValue("C$rowNumber", $row['nama_anggota']);
    $sheet->setCellValue("D$rowNumber", $row['judul_buku']);
    $sheet->setCellValue("E$rowNumber", $row['denda']);
    $sheet->setCellValue(
        "F$rowNumber",
        date('d-m-Y', strtotime($row['tanggal_pinjam']))
    );
    $sheet->setCellValue(
        "G$rowNumber",
        date('d-m-Y', strtotime($row['tanggal_kembali']))
    );

    $sheet->setCellValue(
        "H$rowNumber",
        date('d-m-Y', strtotime($row['tanggal_dikembalikan']))
    );
    $rowNumber++;
}

// Auto size kolom
foreach (range('A', 'H') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Nama file
$filename = "Laporan_denda" . date('d-m-Y') . ".xlsx";

// Bersihkan buffer lagi sebelum output
ob_clean();

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;