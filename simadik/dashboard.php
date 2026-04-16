<?php
session_start();
include 'koneksi.php';

// Cek apakah sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id  = $_SESSION['user_id'];
$username = $_SESSION['username'];
$role     = $_SESSION['role'];

// Ambil semua laporan (admin lihat semua, user lihat punyanya sendiri)
if ($role == 'admin') {
    $sql = "SELECT l.*, u.username FROM laporan l JOIN users u ON l.user_id = u.id ORDER BY l.created_at DESC";
    $result = $conn->query($sql);
} else {
    $sql = "SELECT * FROM laporan WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMADIK | Dashboard</title>
    <link rel="stylesheet" href="Styledashboard.css">
    <style>
        .dashboard-wrapper { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        .welcome-bar {
            background: #009c39;
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .welcome-bar a {
            background: white;
            color: #009c39;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
        }
        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #009c39;
            margin-bottom: 16px;
        }
        .btn-tambah {
            background: #009c39;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-tambah:hover { background: #066825; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        th {
            background: #009c39;
            color: white;
            padding: 12px 16px;
            text-align: left;
            font-size: 14px;
        }
        td { padding: 12px 16px; border-bottom: 1px solid #f0f0f0; font-size: 14px; }
        tr:hover td { background: #f9f9f9; }
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-menunggu  { background: #fef3c7; color: #d97706; }
        .badge-proses    { background: #dbeafe; color: #2563eb; }
        .badge-selesai   { background: #d1fae5; color: #059669; }
        .btn-edit   { background: #3b82f6; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 12px; margin-right: 4px; }
        .btn-hapus  { background: #ef4444; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 12px; }
        .btn-edit:hover  { background: #2563eb; }
        .btn-hapus:hover { background: #dc2626; }
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); z-index: 1000;
            justify-content: center; align-items: center;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background: white; padding: 30px;
            border-radius: 10px; width: 90%; max-width: 500px;
            max-height: 90vh; overflow-y: auto;
        }
        .modal h3 { margin-bottom: 20px; color: #009c39; }
        .modal input, .modal select, .modal textarea {
            width: 100%; padding: 10px 12px;
            border: 1px solid #ddd; border-radius: 4px;
            margin-bottom: 14px; font-size: 14px;
        }
        .modal textarea { height: 100px; resize: vertical; }
        .modal-btn-group { display: flex; gap: 10px; justify-content: flex-end; }
        .btn-simpan { background: #009c39; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .btn-batal  { background: #6b7280; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .foto-preview-thumb {
            width: 50px; height: 50px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-container">
        <div class="logo">SIMADIK</div>
        <ul class="nav-menu">
            <li><a href="dashboard.php">Beranda</a></li>
            <li><a href="logout.php" class="btn-logout">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="dashboard-wrapper">
    <!-- Welcome Bar -->
    <div class="welcome-bar">
        <span>👋 Selamat datang, <strong><?= htmlspecialchars($username) ?></strong>!
        <?= $role == 'admin' ? ' (Admin)' : '' ?></span>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Tabel Laporan -->
    <div class="section-title">📋 Daftar Laporan</div>
    <button class="btn-tambah" onclick="bukaModalTambah()">+ Tambah Laporan</button>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <?php if ($role == 'admin'): ?><th>Pelapor</th><?php endif; ?>
                <th>Kode</th>
                <th>Kategori</th>
                <th>Sekolah</th>
                <th>Foto</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        if ($result && $result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                $badge = 'badge-menunggu';
                if ($row['status'] == 'Sedang Diproses') $badge = 'badge-proses';
                if ($row['status'] == 'Selesai') $badge = 'badge-selesai';
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <?php if ($role == 'admin'): ?>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <?php endif; ?>
                <td><?= htmlspecialchars($row['kode']) ?></td>
                <td><?= htmlspecialchars($row['kategori']) ?></td>
                <td><?= htmlspecialchars($row['sekolah']) ?></td>
                <td>
                    <?php if (!empty($row['foto'])): ?>
                        <img src="uploads/<?= htmlspecialchars($row['foto']) ?>"
                             class="foto-preview-thumb"
                             onclick="lihatFoto('uploads/<?= htmlspecialchars($row['foto']) ?>')"
                             title="Klik untuk perbesar">
                    <?php else: ?>
                        <span style="color:#aaa; font-size:12px;">-</span>
                    <?php endif; ?>
                </td>
                <td><span class="badge <?= $badge ?>"><?= $row['status'] ?></span></td>
                <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                <td>
                    <a href="#" class="btn-edit"
                       onclick="bukaModalEdit(
                           '<?= $row['id'] ?>',
                           '<?= addslashes($row['kategori']) ?>',
                           '<?= addslashes($row['sekolah']) ?>',
                           '<?= addslashes($row['deskripsi']) ?>',
                           '<?= $row['status'] ?>',
                           '<?= $row['foto'] ?>'
                       )">Edit</a>
                    <a href="hapus_laporan.php?id=<?= $row['id'] ?>"
                       class="btn-hapus"
                       onclick="return confirm('Yakin hapus laporan ini?')">Hapus</a>
                </td>
            </tr>
        <?php
            endwhile;
        else:
        ?>
            <tr><td colspan="9" style="text-align:center; color:#888;">Belum ada laporan</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- ===================== MODAL TAMBAH ===================== -->
<div class="modal-overlay" id="modalTambah">
    <div class="modal">
        <h3>➕ Tambah Laporan Baru</h3>
        <form method="post" action="tambah_laporan.php" enctype="multipart/form-data">
            <select name="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Bullying">Bullying</option>
                <option value="Pungli">Pungli</option>
                <option value="Pelecehan">Pelecehan</option>
                <option value="Fasilitas">Fasilitas</option>
                <option value="Lainnya">Lainnya</option>
            </select>
            <input type="text" name="sekolah" placeholder="Nama Sekolah" required>
            <textarea name="deskripsi" placeholder="Deskripsi laporan..." required></textarea>

            <!-- INPUT FOTO -->
            <label style="font-size:13px; color:#555; margin-bottom:4px; display:block;">
                📷 Foto Bukti <span style="color:#aaa;">(opsional, maks 2MB)</span>
            </label>
            <input type="file" name="foto" id="inputFotoTambah"
                   accept="image/*"
                   onchange="previewFoto(this, 'previewTambah')"
                   style="margin-bottom:10px;">
            <img id="previewTambah" src="#" alt="Preview"
                 style="display:none; max-width:100%; max-height:160px;
                        border-radius:6px; margin-bottom:12px;
                        object-fit:cover; border:1px solid #ddd;">

            <div class="modal-btn-group">
                <button type="button" class="btn-batal" onclick="tutupModal()">Batal</button>
                <button type="submit" class="btn-simpan">💾 Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ===================== MODAL EDIT ===================== -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <h3>✏️ Edit Laporan</h3>
        <form method="post" action="edit_laporan.php" enctype="multipart/form-data">
            <input type="hidden" name="id" id="editId">
            <input type="hidden" name="foto_lama" id="editFotoLama">
            <select name="kategori" id="editKategori" required>
                <option value="Bullying">Bullying</option>
                <option value="Pungli">Pungli</option>
                <option value="Pelecehan">Pelecehan</option>
                <option value="Fasilitas">Fasilitas</option>
                <option value="Lainnya">Lainnya</option>
            </select>
            <input type="text" name="sekolah" id="editSekolah" placeholder="Nama Sekolah" required>
            <textarea name="deskripsi" id="editDeskripsi" placeholder="Deskripsi..." required></textarea>

            <!-- FOTO LAMA -->
            <div id="fotoLamaWrapper" style="margin-bottom:10px; display:none;">
                <label style="font-size:13px; color:#555;">Foto saat ini:</label><br>
                <img id="fotoLamaPreview" src="#" alt="Foto Lama"
                     style="max-width:100%; max-height:120px; border-radius:6px;
                            margin-top:6px; object-fit:cover; border:1px solid #ddd;">
            </div>

            <!-- INPUT FOTO BARU -->
            <label style="font-size:13px; color:#555; margin-bottom:4px; display:block;">
                📷 Ganti Foto <span style="color:#aaa;">(kosongkan jika tidak ingin ganti)</span>
            </label>
            <input type="file" name="foto" id="inputFotoEdit"
                   accept="image/*"
                   onchange="previewFoto(this, 'previewEdit')"
                   style="margin-bottom:10px;">
            <img id="previewEdit" src="#" alt="Preview Baru"
                 style="display:none; max-width:100%; max-height:160px;
                        border-radius:6px; margin-bottom:12px;
                        object-fit:cover; border:1px solid #ddd;">

            <?php if ($role == 'admin'): ?>
            <select name="status" id="editStatus">
                <option value="Menunggu">Menunggu</option>
                <option value="Sedang Diproses">Sedang Diproses</option>
                <option value="Selesai">Selesai</option>
            </select>
            <?php endif; ?>

            <div class="modal-btn-group">
                <button type="button" class="btn-batal" onclick="tutupModal()">Batal</button>
                <button type="submit" class="btn-simpan">💾 Update</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL LIHAT FOTO -->
<div class="modal-overlay" id="modalFoto" onclick="tutupModalFoto()">
    <div style="max-width:90%; max-height:90vh;">
        <img id="fotoFull" src="#" alt="Foto"
             style="max-width:100%; max-height:85vh;
                    border-radius:8px; display:block;">
        <p style="text-align:center; color:white; margin-top:10px; font-size:13px;">
            Klik di mana saja untuk menutup
        </p>
    </div>
</div>

<script>
function previewFoto(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
}

function bukaModalTambah() {
    document.getElementById('modalTambah').classList.add('active');
}

function bukaModalEdit(id, kategori, sekolah, deskripsi, status, foto) {
    document.getElementById('editId').value       = id;
    document.getElementById('editKategori').value = kategori;
    document.getElementById('editSekolah').value  = sekolah;
    document.getElementById('editDeskripsi').value = deskripsi;
    document.getElementById('editFotoLama').value = foto;

    const editStatus = document.getElementById('editStatus');
    if (editStatus) editStatus.value = status;

    // Tampilkan foto lama kalau ada
    const fotoWrapper  = document.getElementById('fotoLamaWrapper');
    const fotoPreview  = document.getElementById('fotoLamaPreview');
    if (foto && foto !== '') {
        fotoPreview.src = 'uploads/' + foto;
        fotoWrapper.style.display = 'block';
    } else {
        fotoWrapper.style.display = 'none';
    }

    // Reset preview foto baru
    document.getElementById('previewEdit').style.display = 'none';
    document.getElementById('inputFotoEdit').value = '';

    document.getElementById('modalEdit').classList.add('active');
}

function tutupModal() {
    document.getElementById('modalTambah').classList.remove('active');
    document.getElementById('modalEdit').classList.remove('active');
}

function lihatFoto(src) {
    document.getElementById('fotoFull').src = src;
    document.getElementById('modalFoto').classList.add('active');
}

function tutupModalFoto() {
    document.getElementById('modalFoto').classList.remove('active');
}

// Klik di luar modal = tutup
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) {
            tutupModal();
            tutupModalFoto();
        }
    });
});
</script>
</body>
</html>