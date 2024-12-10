<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $sport = $_POST['sport'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "sportschedule");

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Update data
    $sql = "UPDATE categories SET name='$name', sport='$sport', description='$description', date='$date' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil diupdate!'); window.location.href='categories.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    if (isset($_FILES['photo']['name']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
    
        $photo_name = $_FILES["photo"]["name"]; // Nama file untuk disimpan di database
    } else {
        $photo_name = ""; // Jika tidak ada foto, simpan sebagai string kosong
    }
    
    $conn->close();
}
?>
