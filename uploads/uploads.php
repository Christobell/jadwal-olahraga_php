<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Koneksi ke database
    $conn = new mysqli("localhost", "username", "password", "SportScheduleDB");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $name = $_POST['categories'];
    $sport = $_POST['price'];
    $description = $_POST['description'];
    $date = $_POST['description'];
    $photo = $_FILES['photo']['name'];

    // Simpan file foto ke folder "uploads"
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($photo);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

    // Query untuk menyimpan data
    $sql = "INSERT INTO categories (name, sport, description, date, photo)
            VALUES ('$name', '$sport', '$description', '$date', '$photo')";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil disimpan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
