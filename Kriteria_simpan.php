<?php
session_start();

if (!isset($_SESSION['kriteria'])) {
    $_SESSION['kriteria'] = [];
}

$kriteria = $_POST['kriteria'];
$sub = $_POST['subkriteria'];

$_SESSION['kriteria'][$kriteria] = $sub;

header("Location: kriteria_input.php");

$_SESSION['kriteria'] = [
  "Jaminan" => ["Sertifikat Tanah", "Sertifikat Rumah", ...],
  "Lama Pinjam" => ["6 bulan", "12 bulan", ...]
];
