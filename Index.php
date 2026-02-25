<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [];

    // data dikirim via POST berupa arrays
    // format: kriteria[], sub_kriteria[0][], sub_kriteria[1][], ...
    if (isset($_POST['kriteria']) && isset($_POST['sub_kriteria'])) {
        foreach ($_POST['kriteria'] as $index => $kriteria_nama) {
            $k = trim($kriteria_nama);
            if ($k === '') continue;

            $subs = [];
            if (isset($_POST['sub_kriteria'][$index])) {
                foreach ($_POST['sub_kriteria'][$index] as $sub) {
                    $sub_trim = trim($sub);
                    if ($sub_trim !== '') {
                        $subs[] = $sub_trim;
                    }
                }
            }

            if (!empty($subs)) {
                $data[] = [
                    'kriteria' => $k,
                    'sub_kriteria' => $subs
                ];
            }
        }
    }

    $_SESSION['dataKriteria'] = $data;

    // Redirect ke tabel_kriteria.php
    header("Location: tabel_kriteria.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Input Data Kriteria</title>
    <style>
        .container {
            max-width: 700px;
            margin: 20px auto;
            font-family: Arial;
        }

        .kriteria {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input[type=text] {
            width: 100%;
            padding: 6px;
            margin: 5px 0;
        }

        button {
            padding: 6px 12px;
            margin-top: 8px;
            cursor: pointer;
        }

        .btn-add {
            background: #007bff;
            color: white;
            border: none;
        }

        .btn-save {
            background: #28a745;
            color: white;
            border: none;
        }

        .sub-container input {
            margin-bottom: 5px;
        }
    </style>
    <script>
        function tambahSub(button) {
            const container = button.previousElementSibling;
            const input = document.createElement('input');
            input.type = 'text';
            input.name = button.getAttribute('data-sub-name');
            input.placeholder = 'Sub Kriteria baru';
            container.appendChild(input);
        }

        function tambahKriteria() {
            const container = document.getElementById('kriteriaContainer');
            const count = container.children.length;
            const div = document.createElement('div');
            div.className = 'kriteria';

            div.innerHTML = `
        <label>Nama Kriteria</label>
        <input type="text" name="kriteria[]" required>

        <label>Sub Kriteria</label>
        <div class="sub-container">
            <input type="text" name="sub_kriteria[${count}][]" required>
        </div>

        <button type="button" class="btn-add" data-sub-name="sub_kriteria[${count}][]" onclick="tambahSub(this)">+ Tambah Sub Kriteria</button>
    `;
            container.appendChild(div);
        }
    </script>
</head>

<body>

    <div class="container">
        <h2>Input Data Kriteria</h2>

        <form method="POST" action="">
            <div id="kriteriaContainer">

                <div class="kriteria">
                    <label>Nama Kriteria</label>
                    <input type="text" name="kriteria[]" required>

                    <label>Sub Kriteria</label>
                    <div class="sub-container">
                        <input type="text" name="sub_kriteria[0][]" required>
                    </div>

                    <button type="button" class="btn-add" data-sub-name="sub_kriteria[0][]" onclick="tambahSub(this)">+ Tambah Sub Kriteria</button>
                </div>

            </div>

            <button type="button" class="btn-add" onclick="tambahKriteria()">+ Tambah Kriteria</button>

            <br><br>
            <button type="submit" class="btn-save">💾 Simpan Data</button