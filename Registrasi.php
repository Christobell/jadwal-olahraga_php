<?php
// Cek jika pengguna sudah login
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: Admin.php");
    exit();
}

// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "login_sport"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Validasi input
    if ($password != $confirmPassword) {
        $error = "Password tidak cocok!";
    } else {
        // Hash password sebelum disimpan
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah email sudah terdaftar
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email sudah terdaftar!";
        } else {
            // Masukkan data pengguna ke database
            $insertQuery = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sss", $fullname, $email, $hashedPassword);
            if ($stmt->execute()) {
                header("Location: Login.php"); // Redirect ke halaman login setelah registrasi
                exit();
            } else {
                $error = "Terjadi kesalahan saat registrasi!";
            }
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registrasi</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h1>Registrasi</h1>
            <form method="POST">
                <label for="fullname">Nama Lengkap</label>
                <input type="text" id="fullname" name="fullname" placeholder="Nama Lengkap" required />

                <label for="email">Masukkan Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan Email" required />

                <label for="password">Masukkan Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password" required />

                <label for="confirm-password">Ulangi Password</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Ulangi Password" required />

                <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>

                <button type="submit" class="btn-daftar">DAFTAR</button>
                <p>Sudah punya akun? <a href="Login.php">Masuk disini</a></p>
            </form>
        </div>
        <div class="image-container">
            <img src="gambar1.jpeg" alt="Gambar" />
        </div>
    </div>
</body>

</html>
