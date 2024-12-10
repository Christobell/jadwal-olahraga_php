<?php
session_start(); // Memulai session untuk mengecek apakah pengguna sudah login

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: Login.php");
    exit();
}

// Cek apakah pengguna ingin logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset(); // Menghapus semua data session
    session_destroy(); // Menghancurkan session
    header("Location: Login.php"); // Redirect ke halaman login setelah logout
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="css/admin.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <title>SportSchedule</title>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class="bx bx-football"></i> 
            <span class="logo_name">SportSchedule</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="#" class="active">
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
                <a href="Admin.php?action=logout">
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
                <span class="admin_name">Welcome, <?php echo $_SESSION['user_email']; ?></span> <!-- Menampilkan email pengguna yang login -->
            </div>
        </nav>
        <div class="home-content">
            <h1>Selamat Datang Di SportSchedule</h1>
        </div>
    </section>
</body>

</html>
