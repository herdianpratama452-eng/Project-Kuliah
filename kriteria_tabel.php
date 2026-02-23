<?php
session_start();
$data = $_SESSION['data_kriteria'] ?? [];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tabel Data Kriteria</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h2>Tabel Data Kriteria</h2>

        <table>
            <tr>
                <th>No</th>
                <th>Kriteria</th>
                <th>Sub Kriteria</th>
            </tr>

            <?php if (empty($data)) { ?>
                <tr>
                    <td colspan="3">Data belum ada</td>
                </tr>
            <?php } else { ?>
                <?php $no = 1;
                foreach ($data as $d) { ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($d['kriteria']); ?></td>
                        <td><?= htmlspecialchars($d['subkriteria']); ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>

        <br>
        <a href="index.php">
            <button>Lanjut ke Perbandingan AHP</button>
        </a>
    </div>

</body>

</html>