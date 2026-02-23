<?php
session_start();

// Ambil matriks normalisasi dari session
$matrikNorm = $_SESSION['matrikNorm'] ?? [];

$kriteria = ['Jaminan', 'Lama Pinjam', 'Kegunaan', 'Pengeluaran', 'Pendapatan'];
$n = count($kriteria);

// Validasi
if (empty($matrikNorm)) {
    echo "<p style='text-align:center;color:red;'>Matriks normalisasi tidak ditemukan. 
    <a href='matrik_nilai_kriteria.php'>Kembali</a></p>";
    exit;
}

$proses = [];
$prioritas = [];

// ================================
// PROSES HITUNG BOBOT PRIORITAS
// ================================
for ($i = 0; $i < $n; $i++) {

    $row = $matrikNorm[$i];          // Ambil baris normalisasi
    $sum = array_sum($row);          // Jumlahkan baris
    $prior = $sum / $n;              // Rata-rata = bobot prioritas

    // simpan ke array hasil
    $proses[$i] = [
        'kriteria'  => $kriteria[$i],
        'row'       => $row,
        'sum'       => $sum,
        'prioritas' => $prior
    ];

    $prioritas[$i] = $prior;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Proses Perhitungan Bobot Prioritas Kriteria</title>
    <style>
        table {
            border-collapse: collapse;
            margin: auto;
            font-family: Arial;
            text-align: center;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px 12px;
        }

        th {
            background: #f2f2f2;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>Proses Perhitungan Bobot Prioritas Kriteria</h2>

    <table>
        <tr>
            <th>Kriteria</th>
            <th>Rumus Perhitungan</th>
            <th>Bobot Prioritas</th>
        </tr>

        <?php foreach ($proses as $p): ?>
            <tr>
                <td><?= $p['kriteria'] ?></td>

                <!-- Rumus lengkap -->
                <td>
                    (<?= implode(" + ", array_map(function ($x) {
                            return number_format($x, 2);
                        }, $p['row'])) ?>)

                    / <?= $n ?>
                    = <b><?= number_format($p['prioritas'], 2) ?></b>
                </td>

                <td><b><?= number_format($p['prioritas'], 2) ?></b></td>
            </tr>
        <?php endforeach; ?>

    </table>

    <br>

    <p style="text-align:center;">
        <a href="prioritas_kriteria.php">⬅ Kembali ke Bobot Prioritas</a>
    </p>

</body>

</html>