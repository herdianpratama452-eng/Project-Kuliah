<?php
session_start();
$h = $_SESSION['hasil'];
$kriteria = ["Jaminan", "Lama Pinjam", "Kegunaan", "Pengeluaran", "Pendapatan"];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Hasil SPK</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <h2>Bobot Prioritas Kriteria (AHP)</h2>
        <table>
            <tr>
                <th>Kriteria</th>
                <th>Bobot</th>
            </tr>
            <?php
            for ($i = 0; $i < 5; $i++) {
                echo "<tr><td>{$kriteria[$i]}</td><td>" . round($h['bobot'][$i], 3) . "</td></tr>";
            }
            ?>
        </table>

        <h3>Uji Konsistensi</h3>
        λ max = <?= round($h['lambda'], 3); ?><br>
        CI = <?= round($h['CI'], 3); ?><br>
        CR = <?= round($h['CR'], 3); ?><br>
        <b class="<?= ($h['CR'] < 0.1 ? 'status-layak' : 'status-tidak'); ?>">
            <?= ($h['CR'] < 0.1 ? 'KONSISTEN' : 'TIDAK KONSISTEN'); ?>
        </b>

        <h2>Skor Alternatif AHP</h2>
        <table>
            <tr>
                <th>Alternatif</th>
                <th>Skor</th>
                <th>Status</th>
            </tr>
            <?php
            foreach ($h['skorAHP'] as $a => $v) {
                $s = $v >= 0.5 ? 'Layak' : 'Tidak Layak';
                echo "<tr><td>$a</td><td>" . round($v, 4) . "</td>
<td class='" . ($s == 'Layak' ? 'status-layak' : 'status-tidak') . "'>$s</td></tr>";
            }
            ?>
        </table>

        <h2>Skor Alternatif SAW</h2>
        <table>
            <tr>
                <th>Alternatif</th>
                <th>Skor</th>
                <th>Status</th>
            </tr>
            <?php
            foreach ($h['skorSAW'] as $a => $v) {
                $s = $v >= 0.6 ? 'Layak' : 'Tidak Layak';
                echo "<tr><td>$a</td><td>" . round($v, 3) . "</td>
<td class='" . ($s == 'Layak' ? 'status-layak' : 'status-tidak') . "'>$s</td></tr>";
            }
            ?>
        </table>

    </div>
</body>

</html>