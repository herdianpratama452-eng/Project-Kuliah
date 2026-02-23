<?php
session_start();

// Ambil data
$dataAlternatif = $_SESSION['dataAlternatif'] ?? [];
$prioritasKriteria = $_SESSION['prioritasKriteria'] ?? [];

$kriteria = ['Jaminan', 'Lama Pinjam', 'Kegunaan', 'Pengeluaran', 'Pendapatan'];

$nAlt = count($dataAlternatif);
$nKrit = count($kriteria);

if ($nAlt == 0 || empty($prioritasKriteria)) {
    echo "<p style='text-align:center;color:red;'>Data belum lengkap.</p>";
    exit;
}

$nilaiAlternatif = [];
$skorAkhir = [];

// ============================
// Hitung Prioritas Alternatif
// ============================
for ($k = 0; $k < $nKrit; $k++) {

    $matrik = $_SESSION["matrikAlternatif_$k"] ?? [];

    // Normalisasi setiap kolom matriks alternatif
    $colSum = [];
    for ($j = 0; $j < $nAlt; $j++) {
        $colSum[$j] = 0;
        for ($i = 0; $i < $nAlt; $i++) {
            $colSum[$j] += $matrik[$i][$j];
        }
    }

    // Menghitung bobot alternatif pada kriteria ke-k
    for ($i = 0; $i < $nAlt; $i++) {
        $normal = 0;
        for ($j = 0; $j < $nAlt; $j++) {
            $normal += $matrik[$i][$j] / $colSum[$j];
        }
        $nilaiAlternatif[$k][$i] = $normal / $nAlt; // bobot alternatif
    }
}

// ============================
// Hitung Skor Akhir Alternatif
// ============================
for ($i = 0; $i < $nAlt; $i++) {
    $total = 0;

    for ($k = 0; $k < $nKrit; $k++) {
        $total += $nilaiAlternatif[$k][$i] * $prioritasKriteria[$k];
    }

    $skorAkhir[$i] = [
        'alternatif' => $dataAlternatif[$i]['alternatif'],
        'nilai' => $total
    ];
}

// Urutkan ranking
usort($skorAkhir, function ($a, $b) {
    return $b['nilai'] <=> $a['nilai'];
});

?>

<!DOCTYPE html>
<html>

<head>
    <title>Skor Setiap Alternatif</title>
    <style>
        table {
            border-collapse: collapse;
            margin: auto;
            text-align: center;
            font-family: Arial;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px 10px;
        }

        th {
            background: #eaeaea;
        }
    </style>
</head>

<body>

    <h2 style="text-align:center;">Perhitungan Skor Setiap Alternatif</h2>

    <!-- ============================
     TABEL SKOR AKHIR
=============================== -->
    <table>
        <tr>
            <th>Ranking</th>
            <th>Alternatif</th>
            <th>Skor Akhir</th>
        </tr>

        <?php
        $rank = 1;
        foreach ($skorAkhir as $item):
        ?>
            <tr>
                <td><?= $rank++ ?></td>
                <td><?= $item['alternatif'] ?></td>
                <td><?= round($item['nilai'], 4) ?></td>
            </tr>
        <?php endforeach; ?>

    </table>

    <p style="text-align:center; margin-top:20px;">
        <a href="matrik_nilai_alternatif.php">⬅ Kembali ke Matriks Alternatif</a>
    </p>

</body>

</html>