<?php
session_start();

$kriteria = ['Jaminan', 'Lama Pinjam', 'Kegunaan', 'Pengeluaran', 'Pendapatan'];
$n = count($kriteria);

// Ambil matriks sebelumnya dari session
$matrikPrev = $_SESSION['matrikKriteria'] ?? [];

// Simpan input user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matrik = [];
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n; $j++) {
            $key = "nilai_{$i}_{$j}";
            $val = isset($_POST[$key]) ? floatval($_POST[$key]) : 1;
            if ($val <= 0) $val = 1;
            $matrik[$i][$j] = $val;
        }
    }
    $_SESSION['matrikKriteria'] = $matrik;
    header("Location: matrik_nilai_kriteria.php");
    exit;
}

// Hitung jumlah tiap kolom untuk preview
$jumlahKolom = [];
if (!empty($matrikPrev)) {
    for ($j = 0; $j < $n; $j++) {
        $jumlahKolom[$j] = 0;
        for ($i = 0; $i < $n; $i++) {
            $jumlahKolom[$j] += $matrikPrev[$i][$j];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Matriks Perbandingan Kriteria</title>
    <style>
        table {
            border-collapse: collapse;
            margin: 20px auto;
            text-align: center;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
        }

        input[type=number] {
            width: 60px;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center;">Matriks Perbandingan Berpasangan Kriteria</h2>
    <form method="POST">
        <table>
            <tr>
                <th>Kriteria</th>
                <?php foreach ($kriteria as $k): ?><th><?= $k ?></th><?php endforeach; ?>
            </tr>

            <?php for ($i = 0; $i < $n; $i++): ?>
                <tr>
                    <td><?= $kriteria[$i] ?></td>
                    <?php for ($j = 0; $j < $n; $j++): ?>
                        <td>
                            <input type="number" step="0.01" min="0.01" name="nilai_<?= $i ?>_<?= $j ?>" value="<?= $matrikPrev[$i][$j] ?? ($i == $j ? 1 : 1) ?>">
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>

            <?php if (!empty($matrikPrev)): ?>
                <tr>
                    <td><strong>Jumlah Kolom</strong></td>
                    <?php for ($j = 0; $j < $n; $j++): ?>
                        <td><strong><?= round($jumlahKolom[$j], 2) ?></strong></td>
                    <?php endfor; ?>
                </tr>
            <?php endif; ?>
        </table>

        <div style="text-align:center; margin-top:10px;">
            <button type="submit">💾 Simpan & Lanjut ke Matriks Nilai Kriteria</button>
        </div>
    </form>
</body>

</html>