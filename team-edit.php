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

// Ambil data berdasarkan ID
$id = $_GET['id'];
$sql = "SELECT * FROM teams WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $team = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan.";
    exit();
}

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $play_date = $_POST['play_date'];

    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

        $sql = "UPDATE teams SET 
                name='$name', category='$category', description='$description', play_date='$play_date', photo='$photo' 
                WHERE id=$id";
    } else {
        $sql = "UPDATE teams SET 
                name='$name', category='$category', description='$description', play_date='$play_date' 
                WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: Team.php?message=Data berhasil diupdate");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <title>Edit Tim</title>
</head>

<body>
    <div class="form-login">
        <h3>Edit Tim</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="name">Nama Tim</label>
            <input class="input" type="text" name="name" id="name" value="<?php echo $team['name']; ?>" required>

            <label for="category">Kategori</label>
            <input class="input" type="text" name="category" id="category" value="<?php echo $team['category']; ?>" required>

            <label for="description">Deskripsi</label>
            <input class="input" type="text" name="description" id="description" value="<?php echo $team['description']; ?>" required>

            <label for="play_date">Tanggal Bermain</label>
            <input class="input" type="date" name="play_date" id="play_date" value="<?php echo $team['play_date']; ?>" required>

            <label for="photo">Foto</label>
            <input type="file" name="photo" id="photo" style="margin-bottom: 20px">
            <img src="uploads/<?php echo $team['photo']; ?>" alt="Photo" style="width: 100px; height: auto; margin-top: 10px;">

            <button type="submit" class="btn btn-simpan">Update</button>
        </form>
    </div>
</body>

</html>
