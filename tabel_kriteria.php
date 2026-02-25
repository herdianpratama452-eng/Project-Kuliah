	<?php
    session_start();
    $data = $_SESSION['dataKriteria'] ?? [];
    ?>

	<!DOCTYPE html>
	<html lang="id">

	<head>
	    <meta charset="UTF-8">
	    <title>Tabel Data Kriteria</title>
	    <style>
	        table {
	            border-collapse: collapse;
	            width: 70%;
	            margin: 30px auto;
	            font-family: "Times New Roman";
	            text-align: center;
	        }

	        th,
	        td {
	            border: 1px solid black;
	            padding: 6px;
	        }

	        caption {
	            font-weight: bold;
	            margin-bottom: 8px;
	        }
	    </style>
	</head>

	<body>

	    <table>
	        <caption>Tabel 1. Data Kriteria</caption>
	        <thead>
	            <tr>
	                <th>Kriteria</th>
	                <th>Sub Kriteria</th>
	            </tr>
	        </thead>
	        <tbody>
	            <?php if (empty($data)) : ?>
	                <tr>
	                    <td colspan="2">Data belum tersedia</td>
	                </tr>
	            <?php else: ?>
	                <?php foreach ($data as $item): ?>
	                    <?php $subCount = count($item['sub_kriteria']); ?>
	                    <?php foreach ($item['sub_kriteria'] as $index => $sub): ?>
	                        <tr>
	                            <?php if ($index === 0): ?>
	                                <td rowspan="<?= $subCount ?>"><?= htmlspecialchars($item['kriteria']) ?></td>
	                            <?php endif; ?>
	                            <td><?= htmlspecialchars($sub) ?></td>
	                        </tr>
	                    <?php endforeach; ?>
	                <?php endforeach; ?>
	            <?php endif; ?>
	        </tbody>
	    </table>

	</body>

	</html>