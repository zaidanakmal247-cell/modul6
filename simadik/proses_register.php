<?php
include 'koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username  = $_POST['username'];
    $email     = $_POST['email'];
    $password  = MD5($_POST['password-new']);
    $gender    = isset($_POST['gender']) ? $_POST['gender'] : '';
    $is_anon   = isset($_POST['anonymous']) ? 1 : 0;
    $role      = 'user';

    // Cek apakah email sudah terdaftar
    $cek = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        echo "<script>
            alert('Email sudah terdaftar! Gunakan email lain.');
            window.location.href='register.php';
        </script>";
    } else {
        $sql  = "INSERT INTO users (username, email, password, gender, is_anonymous, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt->bind_param("ssssis", $username, $email, $password, $gender, $is_anon, $role);

        if ($stmt->execute()) {
            echo "<script>
                alert('Registrasi berhasil! Silakan login.');
                window.location.href='index.php';
            </script>";
        } else {
            echo "<script>
                alert('Gagal registrasi, coba lagi.');
                window.location.href='register.php';
            </script>";
        }
        $stmt->close();
    }
    $cek->close();
}
$conn->close();
?>
```

---


```
