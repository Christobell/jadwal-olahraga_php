<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "sportschedule");

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Hapus data berdasarkan ID
    $sql = "DELETE FROM categories WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='categories.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    header("Location: categories.php");
}
?>
