<?php
session_start();

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

// Ambil ID kategori dari URL
$id = $_GET['id'];

// Query untuk mendapatkan data kategori berdasarkan ID
$sql = "SELECT * FROM categories WHERE id = $id";
$result = $conn->query($sql);

// Cek apakah data ditemukan
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan!";
    exit();
}

// Proses update data ketika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $name = $_POST['categories'];
    $sport = $_POST['price'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $photo = $_FILES['photo']['name'];

    // Simpan file foto jika diupload
    if ($photo) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo_name = $photo; // Nama file baru
        } else {
            $photo_name = $row['photo']; // Gunakan foto lama jika upload gagal
        }
    } else {
        $photo_name = $row['photo']; // Jika tidak ada foto baru, gunakan foto lama
    }

    // Query untuk update data
    $sql_update = "UPDATE categories SET 
                    name = '$name', 
                    sport = '$sport', 
                    description = '$description', 
                    date = '$date', 
                    photo = '$photo_name' 
                   WHERE id = $id";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: categories.php"); // Redirect ke halaman categories setelah berhasil
        exit();
    } else {
        $message = "Error: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
    <title>SportSchedule | Edit Category</title>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class="bx bx-football"></i>
            <span class="logo_name">SportSchedule</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="Admin.php" class="active">
                    <i class="bx bx-grid-alt"></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="categories.php">
                    <i class="bx bx-calendar"></i>
                    <span class="links_name">Sport Schedule</span>
                </a>
            </li>
            <li>
                <a href="Team.php">
                    <i class="bx bx-list-ul"></i>
                    <span class="links_name">Team Schedule</span>
                </a>
            </li>
            <li>
                <a href="Login.php">
                    <i class="bx bx-log-out"></i>
                    <span class="links_name">Log out</span>
                </a>
            </li>
        </ul>
    </div>

    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
            </div>
            <div class="profile-details">
                <span class="admin_name">SportScheduler Admin</span>
            </div>
        </nav>

        <div class="home-content">
            <h3>Edit Category</h3>

            <?php if (isset($message)) : ?>
                <div class="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="form-login">
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="categories">Nama</label>
                    <input class="input" type="text" name="categories" id="categories" value="<?php echo $row['name']; ?>" required>

                    <label for="price">Olahraga</label>
                    <input class="input" type="text" name="price" id="price" value="<?php echo $row['sport']; ?>" required>

                    <label for="description">Deskripsi</label>
                    <input class="input" type="text" name="description" id="description" value="<?php echo $row['description']; ?>" required>

                    <label for="date">Tanggal</label>
                    <input class="input" type="date" name="date" id="date" value="<?php echo $row['date']; ?>" required>

                    <label for="photo">Photo</label>
                    <input type="file" name="photo" id="photo" style="margin-bottom: 20px">

                    <small>Foto saat ini:</small>
                    <?php if (!empty($row['photo'])): ?>
                        <img src="uploads/<?php echo $row['photo']; ?>" alt="Current Photo" style="width: 100px; height: auto;"><br>
                    <?php else: ?>
                        Tidak ada foto
                    <?php endif; ?>

                    <button type="submit" class="btn btn-simpan" name="simpan">Update</button>
                </form>
            </div>
        </div>
    </section>

    <script>
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        sidebarBtn.onclick = function () {
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        };
    </script>
</body>

</html>
