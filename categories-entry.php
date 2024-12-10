<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "sportschedule");

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $name = $_POST['categories'];
    $sport = $_POST['price'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $photo = $_FILES['photo']['name'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($photo);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO categories (name, sport, description, date, photo)
                VALUES ('$name', '$sport', '$description', '$date', '$photo')";

        if ($conn->query($sql) === TRUE) {
            $message = "Data berhasil disimpan.";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $message = "Terjadi kesalahan saat mengunggah foto.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
    <title>SportSchedule | Input Categories</title>
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
            <h3>Input Categories</h3>

            <?php if (isset($message)) : ?>
                <div class="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="form-login">
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="categories">Nama</label>
                    <input class="input" type="text" name="categories" id="categories" placeholder="Nama Anda" required>

                    <label for="price">Olahraga</label>
                    <input class="input" type="text" name="price" id="price" placeholder="Jenis Olahraga" required>

                    <label for="description">Deskripsi</label>
                    <input class="input" type="text" name="description" id="description" placeholder="Deskripsi" required>

                    <label for="date">Tanggal</label>
                    <input class="input" type="date" name="date" id="date" required>

                    <label for="photo">Photo</label>
                    <input type="file" name="photo" id="photo" style="margin-bottom: 20px" required>

                    <button type="submit" class="btn btn-simpan" name="simpan">Simpan</button>
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
