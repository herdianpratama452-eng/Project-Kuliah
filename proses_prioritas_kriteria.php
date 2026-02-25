<?php
session_start();

// Ambil matriks normalisasi dari session
$matrikNorm = $_SESSION['matrikNorm'] ?? [];

// Daftar kriteria
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

// Simpan prioritas ke session agar bisa digunakan di perhitungan konsistensi & skor alternatif
$_SESSION['prioritas'] = $prioritas;

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Proses Perhitungan Bobot Prioritas Kriteria</title>

    <style>
        table {
            border-collapse: collapse;
            margin: auto;
            width: 85%;
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
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 18px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 5px;
            border: none;
            cursor: pointer;
        }

        .btn-blue {
            background: #007bff;
        }

        .btn-blue:hover {
            background: #0056b3;
        }

        .btn-green {
            background: #17a2b8;
            padding: 10px 18px;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-green:hover {
            background: #17a2b8;
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
                <td><b><?= $p['kriteria'] ?></b></td>

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

    <br><br>

    <p style="text-align:center;">

        <!-- Tombol kembali -->
        <a href="matrik_nilai_kriteria.php" class="btn btn-blue">⬅ Kembali</a>

        <!-- Tombol menuju konsistensi -->
        <a href="Perhitungan rasio konsistensi.php" class="btn btn-green">➡ Lanjut ke Perhitungan Rasio Konsistensi</a>

    </p>

</body>

</html>