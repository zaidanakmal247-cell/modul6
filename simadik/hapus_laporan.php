<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id   = $_GET['id'];
    $sql  = "DELETE FROM laporan WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
$conn->close();
header("Location: dashboard.php");
exit();
?>
```

---

## ✅ LANGKAH 8 — Coba Jalankan!

Buka browser:
```
http://localhost/simadik/index.php