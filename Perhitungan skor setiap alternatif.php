<?php

// ==========================
// Bobot Kriteria
// ==========================
$bobot = [0.42, 0.26, 0.16, 0.10, 0.06];

// ==========================
// CR / Normalisasi Alternatif
// ==========================
$CR = [
    [0.22, 0.22, 0.57, 0.57, 0.41], // A1
    [0.13, 1.00, 1.00, 0.57, 0.41], // A2
    [0.13, 0.10, 0.57, 1.00, 0.41], // A3
    [1.00, 0.10, 0.57, 1.00, 0.41]  // A4
];

$namaAlternatif = ["A1", "A2", "A3", "A4"];

$skor = [];
$rumus = [];

// ==========================
// HITUNG SKOR ALTERNATIF
// ==========================
for ($i = 0; $i < count($CR); $i++) {

    $total = 0;
    $bagianRumus = [];

    for ($j = 0; $j < count($bobot); $j++) {

        $nilai = $bobot[$j] * $CR[$i][$j];
        $total += $nilai;

        // format: (0.42 × 0.22)
        $bagianRumus[] = "(" . $bobot[$j] . " × " . $CR[$i][$j] . ")";
    }

    $rumus[$i] = implode(" + ", $bagianRumus);
    $skor[$i] = $total;
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Perhitungan Skor Alternatif</title>
    <style>
        table {
            border-collapse: collapse;
            width: 90%;
            margin: auto;
            font-family: Arial;
            text-align: center;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background: #e2e2e2;
        }
    </style>
</head>

<body>

    <h2 style="text-align:center;">Perhitungan Skor Alternatif A1 – A4</h2>

    <table>
        <tr>
            <th>Alternatif</th>
            <th>Rumus Perhitungan</th>
            <th>Skor Akhir</th>
        </tr>

        <?php for ($i = 0; $i < count($skor); $i++): ?>
            <tr>
                <td><b><?= $namaAlternatif[$i] ?></b></td>
                <td><?= $rumus[$i] ?></td>
                <td><b><?= round($skor[$i], 4) ?></b></td>
            </tr>
        <?php endfor; ?>

    </table>

</body>

</html>
<!-- Tombol menuju konsistensi -->
<a href="Skor Alternatif AHP.php" class="btn btn-green">➡ Lanjut ke Skor Alternatif AHP</a>