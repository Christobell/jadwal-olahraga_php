<?php
session_start(); // Memulai session untuk mengecek apakah pengguna sudah login

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "sportschedule");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID dari parameter URL
$id = $_GET['id'];

// Ambil data foto untuk menghapus file
$sql = "SELECT photo FROM teams WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Hapus file foto jika ada
if (!empty($row['photo'])) {
    $file_path = "uploads/" . $row['photo'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

// Hapus data dari database
$sql = "DELETE FROM teams WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: Team.php?message=Data berhasil dihapus");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
