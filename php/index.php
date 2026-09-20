<?php
require_once 'Film.php';
session_start();

// ---------- Inisialisasi data dummy ----------
if (!isset($_SESSION['daftarFilm'])) {
    $_SESSION['daftarFilm'] = [
        new Film(1, "Spider-Man: Brand New Day", "Action", "145", "img/spiderman.jpeg"),
        new Film(2, "Ghost In The Cell", "Horor/Komedi", "107", "img/ghost.jpg")
    ];
}

// ---------- Handle upload gambar ----------
function uploadGambar($fileInput) {
    if (!isset($_FILES[$fileInput]) || $_FILES[$fileInput]['error'] !== UPLOAD_ERR_OK) {
        return "";
    }
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $namaFile = time() . "_" . basename($_FILES[$fileInput]['name']);
    $targetFile = $targetDir . $namaFile;

    // Validasi ekstensi
    $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($ext, $allowed)) {
        return "";
    }
    if (move_uploaded_file($_FILES[$fileInput]['tmp_name'], $targetFile)) {
        return $targetFile;
    }
    return "";
}

// ---------- Tambah Film ----------
if (isset($_POST['tambah'])) {
    $id     = $_POST['id'];
    $judul  = $_POST['judul'];
    $genre  = $_POST['genre'];
    $durasi = $_POST['durasi'];

    // Upload gambar (jika ada)
    $gambar = uploadGambar('gambar');

    // Cek ID duplikat
    $duplikat = false;
    foreach ($_SESSION['daftarFilm'] as $f) {
        if ($f->getId() == $id) {
            $duplikat = true;
            break;
        }
    }

    if (!$duplikat) {
        $_SESSION['daftarFilm'][] = new Film($id, $judul, $genre, $durasi, $gambar);
    }
    header("Location: index.php");
    exit();
}

// ---------- Hapus Film ----------
if (isset($_GET['hapus'])) {
    $idHapus = $_GET['hapus'];
    foreach ($_SESSION['daftarFilm'] as $key => $film) {
        if ($film->getId() == $idHapus) {
            // Hapus file gambar
            if ($film->getGambar() && file_exists($film->getGambar())) {
                unlink($film->getGambar());
            }
            unset($_SESSION['daftarFilm'][$key]);
            $_SESSION['daftarFilm'] = array_values($_SESSION['daftarFilm']);
            break;
        }
    }
    header("Location: index.php");
    exit();
}

// ---------- Cari Film ----------
$searchResult = null;
if (isset($_GET['cari_id']) && $_GET['cari_id'] !== "") {
    $idCari = $_GET['cari_id'];
    foreach ($_SESSION['daftarFilm'] as $film) {
        if ($film->getId() == $idCari) {
            $searchResult = $film;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Manajemen Bioskop</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            padding: 40px 30px;
            color: #e6edf7;
            background: linear-gradient(135deg, #0a1128 0%, #12224a 45%, #1b3a6b 100%);
            background-attachment: fixed;
            position: relative;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        body::before, body::after {
            content: "";
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            z-index: 0;
            pointer-events: none;
        }
        body::before {
            width: 420px; height: 420px;
            top: -120px; left: -100px;
            background: rgba(64, 130, 255, 0.35);
        }
        body::after {
            width: 500px; height: 500px;
            bottom: -180px; right: -140px;
            background: rgba(0, 200, 255, 0.22);
        }

        h1, h2, h3 {
            color: #ffffff;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1;
            text-align: center;
        }
        h1 {
            font-size: 30px;
            margin-bottom: 28px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.45);
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            width: 100%;
            max-width: 1300px;
        }
        h2 { font-size: 20px; margin: 0 0 14px; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.4); }
        h3 { font-size: 17px; margin-bottom: 10px; }

        .layout-wrapper {
            display: grid;
            grid-template-columns: 7fr 3fr;
            gap: 28px;
            align-items: start;
            width: 100%;
            max-width: 1300px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            text-align: left;
        }
        .kolom-kiri { width: 100%; text-align: center; }
        .kolom-kanan { width: 100%; display: flex; flex-direction: column; gap: 4px; text-align: center; }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0 auto 10px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
        }
        table, th, td { border: none; }
        th, td {
            padding: 14px 16px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        th {
            background: rgba(20, 50, 110, 0.55);
            color: #cfe4ff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12.5px;
            letter-spacing: 1px;
        }
        tbody tr { transition: background 0.25s ease; }
        tbody tr:hover { background: rgba(255, 255, 255, 0.07); }
        tbody tr:last-child td { border-bottom: none; }
        td { color: #e8f0fb; font-size: 14.5px; }

        img.poster {
            width: 60px; height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        form {
            background: rgba(255, 255, 255, 0.09);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 16px;
            padding: 20px 22px;
            margin: 0 auto 12px;
            width: 100%;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        form label {
            display: block;
            font-size: 13px;
            color: #b9d2f2;
            margin-bottom: 4px;
            letter-spacing: 0.3px;
        }
        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 10px 12px;
            margin: 4px 0 14px;
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            font-size: 14px;
            outline: none;
            transition: all 0.25s ease;
        }
        input::placeholder { color: rgba(255,255,255,0.55); }
        input:focus {
            border-color: #4da3ff;
            background: rgba(255,255,255,0.18);
            box-shadow: 0 0 0 3px rgba(77,163,255,0.25);
        }
        input[type="file"] { font-size: 12px; padding: 8px; }

        button {
            background: linear-gradient(135deg, #2b6cd4, #1b3a6b);
            color: #ffffff;
            border: 1px solid rgba(255,255,255,0.25);
            padding: 10px 18px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.4px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 18px rgba(20, 60, 140, 0.45);
            margin: 6px auto 0;
            display: inline-block;
        }
        button:hover {
            background: linear-gradient(135deg, #3f83f0, #24508f);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(40, 100, 200, 0.55);
        }

        a { color: #8ec5ff; text-decoration: none; transition: color 0.2s ease; }
        a:hover { color: #cfe4ff; text-decoration: underline; }

        a.btn-hapus {
            color: #ff8b9a;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 8px;
            background: rgba(255, 80, 110, 0.12);
            border: 1px solid rgba(255, 120, 140, 0.3);
            transition: all 0.25s ease;
            display: inline-block;
        }
        a.btn-hapus:hover {
            background: rgba(255, 80, 110, 0.28);
            color: #ffffff;
            text-decoration: none;
        }

        a.btn-edit {
            color: #ffd27a;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 8px;
            background: rgba(255, 200, 80, 0.12);
            border: 1px solid rgba(255, 210, 120, 0.3);
            transition: all 0.25s ease;
            display: inline-block;
            margin-right: 6px;
        }
        a.btn-edit:hover {
            background: rgba(255, 200, 80, 0.28);
            color: #ffffff;
            text-decoration: none;
        }

        p { color: #dce8f8; position: relative; z-index: 1; line-height: 1.6; text-align: center; }
        p strong { color: #ffffff; }

        .notif-error {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 10px;
            background: rgba(255, 70, 90, 0.15);
            border: 1px solid rgba(255, 110, 130, 0.35);
            color: #ffb3bd !important;
            margin: 0 auto;
        }

        @media (max-width: 900px) {
            .layout-wrapper { grid-template-columns: 1fr; }
        }
        @media (max-width: 600px) {
            body { padding: 24px 14px; }
            h1 { font-size: 22px; }
            th, td { padding: 10px; font-size: 13px; }
        }
    </style>
</head>
<body>

    <h1>Sistem Manajemen Bioskop</h1>

    <div class="layout-wrapper">

        <!-- ================= KOLOM KIRI: TABEL ================= -->
        <div class="kolom-kiri">
            <h2>Daftar Film</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Poster</th>
                        <th>Judul</th>
                        <th>Genre</th>
                        <th>Durasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($_SESSION['daftarFilm'])): ?>
                        <tr><td colspan="6" style="text-align:center;">Belum ada data film.</td></tr>
                    <?php else: ?>
                        <?php foreach ($_SESSION['daftarFilm'] as $f): ?>
                            <tr>
                                <td><?= htmlspecialchars($f->getId()); ?></td>
                                <td>
                                    <?php if ($f->getGambar() && file_exists($f->getGambar())): ?>
                                        <img class="poster" src="<?= htmlspecialchars($f->getGambar()); ?>" alt="Poster">
                                    <?php else: ?>
                                        <span style="color:#ffb3bd; font-size:12px;">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($f->getJudul()); ?></td>
                                <td><?= htmlspecialchars($f->getGenre()); ?></td>
                                <td><?= htmlspecialchars($f->getDurasi()); ?> min</td>
                                <td>
                                    
                                    <a class="btn-hapus" href="?hapus=<?= $f->getId(); ?>" onclick="return confirm('Hapus film ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- ================= KOLOM KANAN: FORM ================= -->
        <div class="kolom-kanan">

            <h2>Tambah Film Baru</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <label>ID:</label>
                <input type="number" name="id" required>
                <label>Judul:</label>
                <input type="text" name="judul" required>
                <label>Genre:</label>
                <input type="text" name="genre" required>
                <label>Durasi (menit):</label>
                <input type="text" name="durasi" required>
                <label>Upload Poster (lokal):</label>
                <input type="file" name="gambar" accept="image/*">
                <button type="submit" name="tambah">Tambah Data</button>
            </form>

            <h2>Cari Film berdasarkan ID</h2>
            <form action="" method="GET">
                <input type="number" name="cari_id" placeholder="Masukkan ID Film" required>
                <button type="submit">Cari</button>
                <a href="index.php" style="margin-left:10px;">Reset</a>
            </form>

            <?php if (isset($_GET['cari_id'])): ?>
                <h3>Hasil Pencarian:</h3>
                <?php if ($searchResult): ?>
                    <?php if ($searchResult->getGambar() && file_exists($searchResult->getGambar())): ?>
                        <img src="<?= htmlspecialchars($searchResult->getGambar()); ?>" alt="Poster"
                             style="width:120px;height:160px;object-fit:cover;border-radius:10px;margin-bottom:10px;border:1px solid rgba(255,255,255,0.2);">
                    <?php endif; ?>
                    <p>
                        <strong>ID:</strong> <?= htmlspecialchars($searchResult->getId()); ?> |
                        <strong>Judul:</strong> <?= htmlspecialchars($searchResult->getJudul()); ?> |
                        <strong>Genre:</strong> <?= htmlspecialchars($searchResult->getGenre()); ?> |
                        <strong>Durasi:</strong> <?= htmlspecialchars($searchResult->getDurasi()); ?> min
                    </p>
                <?php else: ?>
                    <p class="notif-error">Film dengan ID tersebut tidak ditemukan.</p>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>

</body>
</html>