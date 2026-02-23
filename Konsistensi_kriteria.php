<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tabel Perhitungan Rasio Konsistensi</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h3 class="judul">Tabel 6. Perhitungan Rasio Konsistensi</h3>

    <table class="tabel">
        <tr>
            <th>Kriteria</th>
            <th>Jumlah</th>
            <th>Bobot</th>
            <th>Hasil</th>
        </tr>
        <tr>
            <td>Jaminan</td>
            <td>2,28</td>
            <td>0,42</td>
            <td>0,96</td>
        </tr>
        <tr>
            <td>Lama pinjam</td>
            <td>4,08</td>
            <td>0,26</td>
            <td>1,06</td>
        </tr>
        <tr>
            <td>Kegunaan</td>
            <td>6,83</td>
            <td>0,16</td>
            <td>1,09</td>
        </tr>
        <tr>
            <td>Pengeluaran</td>
            <td>10,5</td>
            <td>0,10</td>
            <td>1,05</td>
        </tr>
        <tr>
            <td>Pendapatan</td>
            <td>15</td>
            <td>0,06</td>
            <td>0,90</td>
        </tr>
        <tr class="jumlah">
            <td colspan="3">Jumlah</td>
            <td>5,06</td>
        </tr>

        <!-- Proses Perhitungan -->
        <tr class="proses">
            <td colspan="3">λ maks</td>
            <td>5,06</td>
        </tr>
        <tr class="proses">
            <td colspan="3">n</td>
            <td>5</td>
        </tr>
        <tr class="proses">
            <td colspan="3">CI = (λ maks − n) / (n − 1)</td>
            <td>0,02</td>
        </tr>
        <tr class="proses">
            <td colspan="3">RI</td>
            <td>1,12</td>
        </tr>
        <tr class="proses akhir">
            <td colspan="3">CR = CI / RI</td>
            <td>0,02 (Konsisten)</td>
        </tr>
    </table>

</body>

</html>