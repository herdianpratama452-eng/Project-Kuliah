<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Input Data Kriteria</title>

    <style>
        .container {
            width: 700px;
            margin: 20px auto;
            font-family: Arial
        }

        .kriteria {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px
        }

        label {
            font-weight: bold
        }

        input {
            width: 100%;
            padding: 6px;
            margin: 5px 0
        }

        button {
            padding: 6px 12px;
            margin-top: 8px;
            cursor: pointer
        }

        .btn-add {
            background: #007bff;
            color: white;
            border: none
        }

        .btn-save {
            background: #28a745;
            color: white;
            border: none
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Tabel Data Kriteria</h2>

        <form id="formKriteria">

            <div id="kriteriaContainer">

                <div class="kriteria">
                    <label>Nama Kriteria</label>
                    <input type="text" class="nama-kriteria" placeholder="contoh: Jaminan">

                    <label>Sub Kriteria</label>
                    <div class="sub-container">
                        <input type="text" class="sub-kriteria" placeholder="contoh: Sertifikat Tanah">
                    </div>

                    <button type="button" class="btn-add" onclick="tambahSub(this)">
                        + Tambah Sub Kriteria
                    </button>
                </div>

            </div>

            <button type="button" class="btn-add" onclick="tambahKriteria()">
                + Tambah Kriteria
            </button>

            <br><br>
            <button type="submit" class="btn-save">💾 Simpan Data</button>
        </form>
    </div>

    <script>
        function tambahSub(btn) {
            const container = btn.previousElementSibling;
            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'sub-kriteria';
            input.placeholder = 'contoh: Sub kriteria baru';
            container.appendChild(input);
        }

        function tambahKriteria() {
            const div = document.createElement('div');
            div.className = 'kriteria';
            div.innerHTML = `
        <label>Nama Kriteria</label>
        <input type="text" class="nama-kriteria">

        <label>Sub Kriteria</label>
        <div class="sub-container">
            <input type="text" class="sub-kriteria">
        </div>

        <button type="button" class="btn-add" onclick="tambahSub(this)">
            + Tambah Sub Kriteria
        </button>
    `;
            document.getElementById('kriteriaContainer').appendChild(div);
        }

        document.getElementById('formKriteria').addEventListener('submit', function(e) {
            e.preventDefault();

            let data = [];

            document.querySelectorAll('.kriteria').forEach(k => {
                const nama = k.querySelector('.nama-kriteria').value;
                const subs = [];

                k.querySelectorAll('.sub-kriteria').forEach(s => {
                    if (s.value.trim() !== "") subs.push(s.value);
                });

                if (nama && subs.length > 0) {
                    data.push({
                        kriteria: nama,
                        sub_kriteria: subs
                    });
                }
            });

            localStorage.setItem('dataKriteria', JSON.stringify(data));
            window.location.href = "tabel_kriteria.html";
        });
    </script>

</body>

</html>