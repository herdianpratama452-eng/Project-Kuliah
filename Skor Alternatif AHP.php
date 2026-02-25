<?php
session_start();

// ==========================
// SKOR ALTERNATIF (ambil dari hasil perhitungan sebelumnya)
// ==========================
$namaAlternatif = ["A1", "A2", "A3", "A4"];

// Jika Anda ingin skor tetap (seperti contoh):
$skor = [
    0.3224,  // A1
    0.5562,  // A2
    0.2964,  // A3
    0.6618   // A4
];

// Jika ingin ambil dari session hapus kode atas dan ganti dengan:
// $skor = $_SESSION['skorAlternatif'] ?? [];

// ==========================
// Tentukan Ranking dan Kelayakan
// ==========================
$ranking = $skor;
arsort($ranking); // urutkan nilai dari besar → kecil

$alternatifLayak = array_key_first($ranking); // indeks alternatif terbaik

$kelayakan = [];
foreach ($skor as $index => $nilai) {
    if ($index === $alternatifLayak) {
        $kelayakan[$index] = "Layak ✔";
    } else {
        $kelayakan[$index] = "Tidak Layak";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tabel Skor Alternatif AHP</title>
    <style>
        table {
            border-collapse: collapse;
            width: 70%;
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

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>Hasil Skor Alternatif AHP</h2>

    <table>
        <tr>
            <th>Alternatif</th>
            <th>Skor</th>
            <th>Kelayakan</th>
        </tr>

        <?php
        foreach ($ranking as $index => $nilai): ?>
            <tr>
                <td><b><?= $namaAlternatif[$index] ?></b></td>
                <td><?= number_format($nilai, 4) ?></td>
                <td><?= $kelayakan[$index] ?></td>
            </tr>
        <?php endforeach; ?>

    </table>

</body>

</html>