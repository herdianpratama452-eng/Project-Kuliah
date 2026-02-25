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

        button.next {
            background-color: #17a2b8;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        button.next:hover {
            background-color: #17a2b8;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        button.next:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #17a2b8;
        }

        button.next:focus {
            outline: none;
            ring: 2px solid #94d3a2;
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
<div style="text-align:center; margin-top:10px;">
    <a href="Skor Alternatif AHP.php"><button class="next">➡ Lanjut ke hasil</button></a>
</div>