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

// Query untuk mengambil data dari tabel teams
$sql = "SELECT * FROM teams";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <title>SportSchedule | Team</title>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class="bx bx-football"></i>
            <span class="logo_name">SportSchedule</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="Admin.php">
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
                <a href="Team.php" class="active">
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
            <h3>Team Schedule</h3>

            <div class="button-container">
                <button type="button" class="btn btn-tambah">
                    <a href="team-entry.php">Tambah Tim</a>
                </button>
                <button type="button" class="btn btn-cetak" onclick="window.print()">
                    Cetak
                </button>
            </div>


            <table class="table-data">
                <thead>
                    <tr>
                        <th scope="col" style="width: 15%">Nama</th>
                        <th scope="col" style="width: 15%">Kategori</th>
                        <th scope="col" style="width: 20%">Deskripsi</th>
                        <th scope="col" style="width: 15%">Tanggal Bermain</th>
                        <th scope="col" style="width: 15%">Photo</th>
                        <th scope="col" style="width: 20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        // Output data setiap baris
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['category'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>" . $row['play_date'] . "</td>";

                            // Tampilkan gambar jika ada
                            if (!empty($row['photo'])) {
                                echo "<td><img src='uploads/" . $row['photo'] . "' alt='Photo' style='width: 100px; height: auto;'></td>";
                            } else {
                                echo "<td>Tidak ada foto</td>";
                            }

                            echo "<td>
                                <a href='team-edit.php?id=" . $row['id'] . "' class='btn-edit'>Edit</a>
                                <a href='team-hapus.php?id=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada data tim.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>