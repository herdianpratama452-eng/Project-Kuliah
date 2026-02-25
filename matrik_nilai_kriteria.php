<?php
session_start();

$kriteria = ['Jaminan', 'Lama Pinjam', 'Kegunaan', 'Pengeluaran', 'Pendapatan'];
$n = count($kriteria);

// Ambil matriks dari session
$matrik = $_SESSION['matrikKriteria'] ?? [];

if (empty($matrik)) {
    echo "<p style='text-align:center; color:red;'>Matriks belum disimpan. <a href='matrik_kriteria.php'>Kembali ke Matriks</a></p>";
    exit;
}

// Hitung jumlah tiap kolom
$jumlahKolom = [];
for ($j = 0; $j < $n; $j++) {
    $jumlahKolom[$j] = 0;
    for ($i = 0; $i < $n; $i++) {
        $jumlahKolom[$j] += $matrik[$i][$j];
    }
}

// Matriks normalisasi = nilai sel / jumlah kolom
$matrikNorm = [];
for ($i = 0; $i < $n; $i++) {
    for ($j = 0; $j < $n; $j++) {
        $matrikNorm[$i][$j] = round($matrik[$i][$j] / $jumlahKolom[$j], 2);
    }
}

// **Simpan matriks normalisasi ke session untuk prioritas**
$_SESSION['matrikNorm'] = $matrikNorm;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Matriks Nilai Kriteria</title>
    <style>
        table {
            border-collapse: collapse;
            margin: auto;
            text-align: center;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
        }

        small {
            color: #555;
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
    </style>
</head>

<body>

    <h2 style="text-align:center;">Matriks Normalisasi / Nilai Kriteria</h2>

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
                        <?= $matrikNorm[$i][$j] ?>
                        <br><small>(<?= $matrik[$i][$j] ?> / <?= round($jumlahKolom[$j], 2) ?>)</small>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>

    <div style="text-align:center; margin-top:10px;">
        <a href="proses_prioritas_kriteria.php"><button class="next">➡ Lihat Bobot Prioritas Kriteria</button></a>
    </div>
</body>

</html>