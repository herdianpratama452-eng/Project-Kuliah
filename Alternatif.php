<?php
session_start();

// Ambil data alternatif dari session
$dataAlternatif = $_SESSION['dataAlternatif'] ?? [];

// ===== HAPUS DATA =====
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if (isset($dataAlternatif[$id])) {
        unset($dataAlternatif[$id]);
        $_SESSION['dataAlternatif'] = array_values($dataAlternatif); // reindex
        header("Location: Alternatif.php");
        exit;
    }
}

// ===== EDIT DATA =====
$editData = null;
$editIndex = null;
if (isset($_GET['edit'])) {
    $editIndex = (int)$_GET['edit'];
    if (isset($dataAlternatif[$editIndex])) {
        $editData = $dataAlternatif[$editIndex];
    }
}

// ===== PROSES SIMPAN DATA (BARU / EDIT) =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alternatif = trim($_POST['alternatif']);
    $jaminan = trim($_POST['jaminan']);
    $lama_pinjam = trim($_POST['lama_pinjam']);
    $kegunaan = trim($_POST['kegunaan']);
    $pengeluaran = trim($_POST['pengeluaran']);
    $pendapatan = trim($_POST['pendapatan']);

    $newData = [
        'alternatif' => $alternatif,
        'jaminan' => $jaminan,
        'lama_pinjam' => $lama_pinjam,
        'kegunaan' => $kegunaan,
        'pengeluaran' => $pengeluaran,
        'pendapatan' => $pendapatan
    ];

    if (isset($_POST['edit_index'])) {
        // update data
        $index = (int)$_POST['edit_index'];
        if (isset($dataAlternatif[$index])) {
            $dataAlternatif[$index] = $newData;
        }
    } else {
        // tambah data baru
        $dataAlternatif[] = $newData;
    }

    $_SESSION['dataAlternatif'] = $dataAlternatif;
    header("Location: Alternatif.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Alternatif</title>
    <style>
        body {
            font-family: Arial;
            margin: 20px;
        }

        input[type=text] {
            width: 90%;
            padding: 4px;
            margin: 4px 0;
        }

        button {
            padding: 6px 12px;
            margin-top: 10px;
            cursor: pointer;
            border: none;
            color: white;
            border-radius: 4px;
        }

        button.submit {
            background-color: #28a745;
        }

        button.delete {
            background-color: #dc3545;
        }

        button.edit {
            background-color: #007bff;
        }

        button.next {
            background-color: #17a2b8;
            margin-top: 20px;
        }

        button.next {
            background-color: #17a2b8;
            padding: 10px 18px;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button.next:hover {
            background-color: #17a2b8;
            transform: translateY(-2px);
        }

        button.next:active {
            transform: translateY(1px);
            background-color: #17a2b8;
        }

        button.next:focus {
            outline: none;
            ring: 2px solid #17a2b8;
        }

        form {
            max-width: 400px;
            margin: auto;
            text-align: center;
        }

        h2 {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
            text-align: center;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
        }

        th {
            background-color: #f2f2f2;
        }

        caption {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 18px;
        }

        .table-container {
            margin-bottom: 50px;
        }

        a {
            text-decoration: none;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
        }
    </style>
</head>

<body>

    <h2><?= $editData ? "Edit Data Alternatif" : "Input Data Alternatif" ?></h2>

    <form method="POST" action="">
        <input type="text" name="alternatif" placeholder="Nama Alternatif" value="<?= $editData['alternatif'] ?? '' ?>" required><br>
        <input type="text" name="jaminan" placeholder="Jaminan" value="<?= $editData['jaminan'] ?? '' ?>" required><br>
        <input type="text" name="lama_pinjam" placeholder="Lama Pinjam" value="<?= $editData['lama_pinjam'] ?? '' ?>" required><br>
        <input type="text" name="kegunaan" placeholder="Kegunaan" value="<?= $editData['kegunaan'] ?? '' ?>" required><br>
        <input type="text" name="pengeluaran" placeholder="Pengeluaran" value="<?= $editData['pengeluaran'] ?? '' ?>" required><br>
        <input type="text" name="pendapatan" placeholder="Pendapatan" value="<?= $editData['pendapatan'] ?? '' ?>" required><br>
        <?php if ($editData): ?>
            <input type="hidden" name="edit_index" value="<?= $editIndex ?>">
            <button type="submit" class="submit">💾 Update Alternatif</button>
            <a href="Alternatif.php"><button type="button">❌ Batal</button></a>
        <?php else: ?>
            <button type="submit" class="submit">💾 Simpan Alternatif</button>
        <?php endif; ?>
    </form>

    <div class="table-container">
        <table>
            <caption>Data Alternatif</caption>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Alternatif</th>
                    <th>Jaminan</th>
                    <th>Lama Pinjam</th>
                    <th>Kegunaan</th>
                    <th>Pengeluaran</th>
                    <th>Pendapatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($dataAlternatif)): ?>
                    <tr>
                        <td colspan="8">Belum ada data alternatif</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($dataAlternatif as $i => $alt): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($alt['alternatif']) ?></td>
                            <td><?= htmlspecialchars($alt['jaminan']) ?></td>
                            <td><?= htmlspecialchars($alt['lama_pinjam']) ?></td>
                            <td><?= htmlspecialchars($alt['kegunaan']) ?></td>
                            <td><?= htmlspecialchars($alt['pengeluaran']) ?></td>
                            <td><?= htmlspecialchars($alt['pendapatan']) ?></td>
                            <td>
                                <a href="Alternatif.php?edit=<?= $i ?>"><button class="edit">Edit</button></a>
                                <a href="Alternatif.php?delete=<?= $i ?>" onclick="return confirm('Yakin ingin hapus?')"><button class="delete">Hapus</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- NEXT STEP BUTTON -->
    <?php if (!empty($dataAlternatif)): ?>
        <div style="text-align:center;">
            <a href="matrik_kriteria.php"><button class="next">➡ Lanjut ke Matriks Kriteria</button></a>
        </div>
    <?php endif; ?>

    <div style="text-align:center;">
        <a href="tabel_kriteria.php">⬅ Kembali ke Kriteria</a>
    </div>

</body>

</html>