<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id        = $_POST['id'];
    $kategori  = $_POST['kategori'];
    $sekolah   = $_POST['sekolah'];
    $deskripsi = $_POST['deskripsi'];
    $status    = isset($_POST['status']) ? $_POST['status'] : 'Menunggu';

    $sql  = "UPDATE laporan SET kategori=?, sekolah=?, deskripsi=?, status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $kategori, $sekolah, $deskripsi, $status, $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>