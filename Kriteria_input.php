<!DOCTYPE html>
<html>

<head>
    <title>Input Kriteria</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function tambahSub() {
            let div = document.createElement("div");
            div.innerHTML = '<input type="text" name="subkriteria[]" required>';
            document.getElementById("subkriteria").appendChild(div);
        }
    </script>
</head>

<body>

    <div class="container">
        <h2>Input Kriteria & Sub Kriteria</h2>

        <form action="kriteria_simpan.php" method="post">
            <label>Kriteria</label>
            <input type="text" name="kriteria" required>

            <label>Sub Kriteria</label>
            <div id="subkriteria">
                <input type="text" name="subkriteria[]" required>
            </div>

            <button type="button" onclick="tambahSub(