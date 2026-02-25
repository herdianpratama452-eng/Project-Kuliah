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

        button.home {
            background-color: #28a745;
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

        button.home:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        button.home:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #1e7e34;
        }

        button.home:focus {
            outline: none;
            ring: 2px solid #94d3a2;
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
<div style="text-align:center; margin-top:10px;">
    <a href="index.php"><button class="home">🏠Back to Home</button></a>
</div>