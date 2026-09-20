<?php
require_once 'Film.php';
session_start();

// Inisialisasi data dummy ke dalam session jika belum ada
if (!isset($_SESSION['daftarFilm'])) {
    $_SESSION['daftarFilm'] = [
        new Film(1, "Interstellar", "Sci-Fi", "169"),
        new Film(2, "Inception", "Action", "148")
    ];
}

// Menangani Aksi Tambah Film
if (isset($_POST['tambah'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $genre = $_POST['genre'];
    $durasi = $_POST['durasi'];

    $_SESSION['daftarFilm'][] = new Film($id, $judul, $genre, $durasi);
    header("Location: index.php");
    exit();
}

// Menangani Aksi Hapus Film
if (isset($_GET['hapus'])) {
    $idHapus = $_GET['hapus'];
    foreach ($_SESSION['daftarFilm'] as $key => $film) {
        if ($film->getId() == $idHapus) {
            unset($_SESSION['daftarFilm'][$key]);
            $_SESSION['daftarFilm'] = array_values($_SESSION['daftarFilm']); // Re-index array
            break;
        }
    }
    header("Location: index.php");
    exit();
}

// Menangani Aksi Update Film
if (isset($_POST['update'])) {
    $idUpdate = $_POST['id'];
    foreach ($_SESSION['daftarFilm'] as $film) {
        if ($film->getId() == $idUpdate) {
            $film->setJudul($_POST['judul']);
            $film->setGenre($_POST['genre']);
            $film->setDurasi($_POST['durasi']);
            break;
        }
    }
    header("Location: index.php");
    exit();
}

// Pencarian Film
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
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            padding: 40px 30px;
            color: #e6edf7;
            background: linear-gradient(135deg, #0a1128 0%, #12224a 45%, #1b3a6b 100%);
            background-attachment: fixed;
            position: relative;
            overflow-x: hidden;

            /* 🔹 Layout utama: susun baris, rata tengah horizontal */
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        /* Ornamen cahaya di background */
        body::before,
        body::after {
            content: "";
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            z-index: 0;
            pointer-events: none;
        }

        body::before {
            width: 420px;
            height: 420px;
            top: -120px;
            left: -100px;
            background: rgba(64, 130, 255, 0.35);
        }

        body::after {
            width: 500px;
            height: 500px;
            bottom: -180px;
            right: -140px;
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

        h2 {
            font-size: 20px;
            margin: 0 0 14px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
            text-align: center;
        }

        h3 {
            font-size: 17px;
            margin-bottom: 10px;
            text-align: center;
        }

        /* =========================================================
        🔹 LAYOUT UTAMA: grid 2 kolom (kiri tabel 70%, kanan form 30%)
        ========================================================= */
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

        .kolom-kiri {
            width: 100%;
            text-align: center;
        }

        .kolom-kanan {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 4px;
            text-align: center;
        }

        /* ---------- Tabel Glassmorphism ---------- */
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

        table, th, td {
            border: none;
        }

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

        tbody tr {
            transition: background 0.25s ease;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.07);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        td {
            color: #e8f0fb;
            font-size: 14.5px;
        }

        /* ---------- Form Glassmorphism ---------- */
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
            text-align: center;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px 12px;
            margin: 4px 0 14px;
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            font-size: 14px;
            outline: none;
            text-align: center;
            transition: border 0.25s ease, background 0.25s ease, box-shadow 0.25s ease;
        }

        input[type="text"]::placeholder,
        input[type="number"]::placeholder {
            color: rgba(255, 255, 255, 0.55);
            text-align: center;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #4da3ff;
            background: rgba(255, 255, 255, 0.18);
            box-shadow: 0 0 0 3px rgba(77, 163, 255, 0.25);
        }

        /* ---------- Tombol ---------- */
        button {
            background: linear-gradient(135deg, #2b6cd4, #1b3a6b);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 10px 18px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.4px;
            transition: transform 0.2s ease, box-shadow 0.25s ease, background 0.25s ease;
            box-shadow: 0 4px 18px rgba(20, 60, 140, 0.45);
            margin: 6px auto 0;
            display: inline-block;
        }

        button:hover {
            background: linear-gradient(135deg, #3f83f0, #24508f);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(40, 100, 200, 0.55);
        }

        button:active {
            transform: translateY(0);
        }

        /* ---------- Link ---------- */
        a {
            color: #8ec5ff;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        a:hover {
            color: #cfe4ff;
            text-decoration: underline;
        }

        a.btn-hapus {
            color: #ff8b9a;
            text-decoration: none;
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

        form a {
            display: inline-block;
            margin-top: 8px;
        }

        /* ---------- Hasil Pencarian ---------- */
        p {
            color: #dce8f8;
            position: relative;
            z-index: 1;
            line-height: 1.6;
            text-align: center;
        }

        p strong {
            color: #ffffff;
        }

        p[style*="color: red"] {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 10px;
            background: rgba(255, 70, 90, 0.15);
            border: 1px solid rgba(255, 110, 130, 0.35);
            color: #ffb3bd !important;
            margin: 0 auto;
        }

        /* ---------- Responsif ---------- */
        @media (max-width: 900px) {
            .layout-wrapper {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 24px 14px;
            }

            h1 {
                font-size: 22px;
            }

            th, td {
                padding: 10px;
                font-size: 13px;
            }
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
                        <th>Judul</th>
                        <th>Genre</th>
                        <th>Durasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($_SESSION['daftarFilm'])): ?>
                        <tr><td colspan="5" style="text-align:center;">Belum ada data film.</td></tr>
                    <?php else: ?>
                        <?php foreach ($_SESSION['daftarFilm'] as $f): ?>
                            <tr>
                                <td><?= $f->getId(); ?></td>
                                <td><?= $f->getJudul(); ?></td>
                                <td><?= $f->getGenre(); ?></td>
                                <td><?= $f->getDurasi(); ?> min</td>
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
            <form action="" method="POST">
                <label>ID:</label>
                <input type="number" name="id" required>
                <label>Judul:</label>
                <input type="text" name="judul" required>
                <label>Genre:</label>
                <input type="text" name="genre" required>
                <label>Durasi (menit):</label>
                <input type="text" name="durasi" required>
                <button type="submit" name="tambah">Tambah Data</button>
            </form>

            <h2>Cari Film berdasarkan ID</h2>
            <form action="" method="GET">
                <input type="number" name="cari_id" placeholder="Masukkan ID Film" required>
                <button type="submit">Cari</button>
                <a href="index.php">Reset</a>
            </form>

            <?php if (isset($_GET['cari_id'])): ?>
                <h3>Hasil Pencarian:</h3>
                <?php if ($searchResult): ?>
                    <p><strong>ID:</strong> <?= $searchResult->getId(); ?> | <strong>Judul:</strong> <?= $searchResult->getJudul(); ?> | <strong>Genre:</strong> <?= $searchResult->getGenre(); ?> | <strong>Durasi:</strong> <?= $searchResult->getDurasi(); ?> min</p>
                <?php else: ?>
                    <p style="color: red;">Film dengan ID tersebut tidak ditemukan.</p>
                <?php endif; ?>
            <?php endif; ?>

        </div>

    </div>

</body>
</html>