<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: Admin.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_sport";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email-phone'];
    $password = $_POST['password'];

    // Mencari pengguna berdasarkan email
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika pengguna ditemukan, verifikasi password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Jika password cocok, simpan data pengguna di session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: Admin.php");
            exit();
        } else {
            $error_message = "Password salah!";
        }
    } else {
        $error_message = "Email tidak ditemukan!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css" />
    <script>
        // Fungsi untuk menampilkan alert
        function showError(message) {
            alert(message);
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h1>SportSchedule</h1>
            <div class="login-box">
                <h2>MASUK</h2>
                <a href="Registrasi.php" class="daftar-link">Daftar</a>
                <form method="POST">
                    <label for="email-phone">Nomer HP/Email</label>
                    <input type="text" id="email-phone" name="email-phone" placeholder="Nomer HP/Email" required />

                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="Kata Sandi" required />

                    <button type="submit" class="btn-masuk" id="loginSubmit">MASUK</button>
                </form>
            </div>
        </div>
        <div class="image-container">
            <img src="gambar1.jpeg" alt="Gambar" />
        </div>
    </div>

    <!-- Menampilkan alert jika ada pesan error -->
    <?php if (!empty($error_message)) { ?>
        <script>
            showError("<?php echo $error_message; ?>");
        </script>
    <?php } ?>
</body>

</html>
