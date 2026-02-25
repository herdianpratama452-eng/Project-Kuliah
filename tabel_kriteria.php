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

	        button.next {
	            background-color: #17a2b8;
	            margin-top: 20px;
	        }

	        button.next {
	            background-color: #17a2b8;
	            padding: 10px 18px;
	            background: #17a2b8;
	            color: white;
	            border: none;
	            border-radius: 6px;
	            cursor: pointer;
	        }

	        button.next:hover {
	            background-color: #17a2b8;
	            transform: translateY(-2px);
	        }

	        button.next:active {
	            transform: translateY(1px);
	            background-color: #17a2b8;
	        }

	        button.next:focus {
	            outline: none;
	            ring: 2px solid #17a2b8;
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
	    <div style="text-align:center; margin-top:10px;">
	        <a href="Alternatif.php"><button class="next">➡ Next to Alternatif</button></a>
	    </div>
	</body>

	</html>