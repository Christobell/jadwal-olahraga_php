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

// Proses penyimpanan data ketika form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $play_date = $_POST['play_date'];

    // Query untuk menyimpan data
    $sql = "INSERT INTO teams (name, category, description, play_date)
            VALUES ('$name', '$category', '$description', '$play_date')";

    if ($conn->query($sql) === TRUE) {
        $message = "Data berhasil disimpan.";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <title>SportSchedule | Tambah Team</title>
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
            <h3>Tambah Team</h3>

            <?php if (isset($message)): ?>
                <div class="alert"><?php echo $message; ?></div>
            <?php endif; ?>

            <div class="form-login">
                <form action="" method="post">
                    <label for="name">Nama Team</label>
                    <input class="input" type="text" name="name" id="name" placeholder="Nama Team" required>

                    <label for="category">Kategori</label>
                    <input class="input" type="text" name="category" id="category" placeholder="Kategori" required>

                    <label for="description">Deskripsi</label>
                    <textarea class="input" name="description" id="description" placeholder="Deskripsi" required></textarea>

                    <label for="play_date">Tanggal Bermain</label>
                    <input class="input" type="date" name="play_date" id="play_date" required>

                    <button type="submit" class="btn btn-simpan">Simpan</button>
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
