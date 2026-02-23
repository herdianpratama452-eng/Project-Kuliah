<?php
echo "<h2>Hasil Input Kriteria & Sub Kriteria</h2>";

$kriteria = $_POST['kriteria'];
$subkriteria = $_POST['subkriteria'];

foreach ($kriteria as $id => $nama_kriteria) {
    echo "<strong>Kriteria:</strong> " . $nama_kriteria . "<br>";
    echo "Sub Kriteria:<ul>";

    foreach ($subkriteria[$id] as $sub) {
        echo "<li>" . $sub . "</li>";
    }

    echo "</ul><hr>";
}
