<?php
require 'vendor/autoload.php'; // Pastikan path ini benar

use Dompdf\Dompdf;

$conn = new mysqli("localhost", "root", "", "sportschedule");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel team
$sql = "SELECT * FROM team";
$result = $conn->query($sql);

// Mulai konten HTML untuk PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Team Schedule Report</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Tanggal Bermain</th>
            </tr>
        </thead>
        <tbody>';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '
            <tr>
                <td>' . $row['name'] . '</td>
                <td>' . $row['category'] . '</td>
                <td>' . $row['description'] . '</td>
                <td>' . $row['play_date'] . '</td>
            </tr>';
    }
} else {
    $html .= '
        <tr>
            <td colspan="4">Tidak ada data tim.</td>
        </tr>';
}
$html .= '
        </tbody>
    </table>
</body>
</html>';

$conn->close();

// Buat PDF menggunakan DOMPDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("team-schedule.pdf", ["Attachment" => true]);
?>
