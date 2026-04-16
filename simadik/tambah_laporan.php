<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id   = $_SESSION['user_id'];
    $kategori  = $_POST['kategori'];
    $sekolah   = $_POST['sekolah'];
    $deskripsi = $_POST['deskripsi'];
    $status    = 'Menunggu';
    $foto      = '';

    // Generate kode unik
    $kode = 'LAP-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

    // Proses Upload Foto (kalau ada)
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $max_size    = 2 * 1024 * 1024;
        $original    = $_FILES['foto']['name'];
        $ext         = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        $file_size   = $_FILES['foto']['size'];

        if (!in_array($ext, $allowed_ext)) {
            die("❌ Format file tidak didukung. Gunakan JPG, PNG, GIF, atau WEBP.");
        }
        if ($file_size > $max_size) {
            die("❌ Ukuran file terlalu besar. Maksimal 2 MB.");
        }

        $nama_file = 'foto_' . time() . '_' . uniqid() . '.' . $ext;
        $target    = 'uploads/' . $nama_file;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
            $foto = $nama_file;
        } else {
            die("❌ Gagal mengupload file. Periksa permission folder uploads/.");
        }
    }

    // INSERT laporan baru
    $sql  = "INSERT INTO laporan (user_id, kode, kategori, sekolah, deskripsi, status, foto, created_at) 
             VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $user_id, $kode, $kategori, $sekolah, $deskripsi, $status, $foto);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>