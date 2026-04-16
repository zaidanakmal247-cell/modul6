<?php
include 'koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = MD5($_POST['password']);

    $sql  = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Simpan data user ke session
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email']    = $user['email'];
        $_SESSION['role']     = $user['role'];

        echo "<script>alert('Login berhasil! Selamat datang, " . $user['username'] . "'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Email atau password salah!'); window.location.href='index.php';</script>";
    }
    $stmt->close();
}
$conn->close();
?>