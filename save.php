<?php
$conn = new mysqli("localhost", "root", "", "spk");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

foreach ($_POST['kriteria'] as $kriteria_id => $nama_kriteria) {

    // simpan kriteria
    $stmt = $conn->prepare("INSERT INTO kriteria (nama_kriteria) VALUES (?)");
    $stmt->bind_param("s", $nama_kriteria);
    $stmt->execute();
    $id_kriteria_db = $stmt->insert_id;

    // simpan sub kriteria
    foreach ($_POST['sub_kriteria'][$kriteria_id] as $sub) {
        if (!empty($sub)) {
            $stmt2 = $conn->prepare(
                "INSERT INTO sub_kriteria (kritewsria_id, nama_sub_kriteria) VALUES (?, ?)"
            );
            $stmt2->bind_param("is", $id_kriteria_db, $sub);
            $stmt2->execute();
        }
    }
}

echo "<script>alert('Data berhasil disimpan'); window.location='index.php';</script>";
