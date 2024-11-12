<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lembar Pengesahan</title>
    <style>
        .header {
            padding-left: 15%;
            padding-right: 10%;
            margin: 0 auto;
            font-family: serif;
            font-size: 16px;
            margin-top: 10%;
            margin-bottom: 20px;
            font-size: 22px;
            text-align: center;
            letter-spacing: 1px;
        }
        .header p {
            margin-bottom: 5px;
            margin: 0;
            font-weight: bold
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .informasi table {
            border: 0.5px solid black;
            border-collapse: collapse;
            width: 100%;
        }
        .informasi th,
        .informasi td {
            border: 0.5px solid black;
        }
        th, td{
            padding: 5px;
            text-align: left;
        }
        .metadata{
            width: 90%;
        }
        .keterangan{
            margin: 20px 20px 10px 5px;
            text-align: justify;
        }
        .ttd{
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="header">
            <p>Berita Acara</p>
            <p
                style="text-decoration: underline"
            >Seminar Kerja Praktek</p>
    </div>
    <div style="margin-top: 50px">
        {{-- tabel informasi kp mahasiswa --}}
        <table>
            <tr>
                <td width="30%" style="vertical-align: top;">Nama Mahasiswa</td>
                <td width="5%" style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{$kp->mahasiswa->name}}</td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top;">NPM</td>
                <td width="5%" style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{$kp->mahasiswa->nomor_induk}}</td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top;">Tanggal Seminar KP</td>
                <td width="5%" style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ \Carbon\Carbon::parse($kp->syarat_seminar->tanggal)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top;">Judul Kerja Praktek</td>
                <td width="5%" style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{$kp->metadata->judul}}</td>
            </tr>
        </table>
        {{-- tabel informasi pengujian --}}
        <table style="margin-top: 20px">
            <tr>
                <td width="30%" style="vertical-align: top;">Ketua Penguji</td>
                <td width="5%" style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{$kp->pembimbing->name}}</td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top;">Penguji</td>
                <td width="5%" style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{$kp->penguji->name}}</td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top;">Tempat Kerja Praktek</td>
                <td width="5%" style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{$kp->metadata->instansi}}</td>
            </tr>
        </table>
    </div>
    <div style="margin-top:20px; margin-left:5px;">
        <p>
            PENILAIAN
        </p>
        <table border="1">
            <thead>
                <tr>
                    <td><center>PENILAIAN</center></td>
                    <td><center>NAMA</center></td>
                    <td width="25%"><center>NILAI AKHIR</center></td>
                </tr>
            </thead>
            <tr>
                <td style="vertical-align: top;">1. Ketua Penguji</td>
                <td style="vertical-align: top;">{{$kp->pembimbing->name}}</td>
                <td style="vertical-align: top;"></td>
            </tr>
            <tr>
                <td style="vertical-align: top;">2. Penguji</td>
                <td style="vertical-align: top;">{{$kp->penguji->name}}</td>
                <td style="vertical-align: top;"></td>
            </tr>
            <tr>
                <td style="vertical-align: top;">3. Kordinator KP</td>
                <td style="vertical-align: top;">Diny Syarifah Sany, ST., MT.</td>
                <td style="vertical-align: top;"></td>
            </tr>
            <tr>
                <td style="vertical-align: top;">4. Instansi/Perusahaan</td>
                <td style="vertical-align: top;">{{$kp->metadata->instansi}}</td>
                <td style="vertical-align: top;"></td>
            </tr>
            <tr>
                <td style="vertical-align: top;" colspan="2">
                    <b>NILAI ANGKA</b> 
                    (0.3 X Nilai Ketua Penguji) + 
                    (0.3 X Nilai Penguji) + 
                    (0.3 x Nilai Koordinator) + 
                    (0.1 x Nilai Instansi)
                </td>
                <td style="vertical-align: top;"></td>
            </tr>
            <tr>
                <td style="vertical-align: top;" colspan="2"><b>NILAI HURUF</b></td>
                <td style="vertical-align: top;"></td>
            </tr>
        </table>
    </div>
    {{-- RANGE NILAI --}}
    <div style="margin-top:20px; margin-left:5px;">
        <p>
            Range Nilai
        </p>
        <table border="1">
            <thead>
                <tr>
                    <td style="text-align: center;">A</td>
                    <td style="text-align: center;">AB</td>
                    <td style="text-align: center;">B</td>
                    <td style="text-align: center;">BC</td>
                    <td style="text-align: center;">C</td>
                    <td style="text-align: center;">D</td>
                </tr>
            </thead>
            <tr>
                <td style="text-align: center;">100-80</td>
                <td style="text-align: center;">73-79</td>
                <td style="text-align: center;">72-65</td>
                <td style="text-align: center;">65-57</td>
                <td style="text-align: center;">57-50</td>
                <td style="text-align: center;">50-35</td>
            </tr>
        </table>
    </div>
        {{-- <div class="keterangan">Penilaian Dosen Pembimbing: {{
            optional($kp->penilaian)->nilai_pembimbing ? 
                number_format(
                    (optional($kp->penilaian->nilai_pembimbing)->pemahaman_masalah ?? 0) +
                    (optional($kp->penilaian->nilai_pembimbing)->deskripsi_solusi ?? 0) +
                    (optional($kp->penilaian->nilai_pembimbing)->percaya_diri ?? 0) +
                    (optional($kp->penilaian->nilai_pembimbing)->tata_tulis ?? 0) +
                    (optional($kp->penilaian->nilai_pembimbing)->pembuktian_produk ?? 0) +
                    (optional($kp->penilaian->nilai_pembimbing)->efektivitas_produk ?? 0) +
                    (optional($kp->penilaian->nilai_pembimbing)->kontribusi ?? 0) +
                    (optional($kp->penilaian->nilai_pembimbing)->originalitas ?? 0) +
                    (optional($kp->penilaian->nilai_pembimbing)->kemudahan_produk ?? 0) +
                    (optional($kp->penilaian->nilai_pembimbing)->peningkatan_kinerja ?? 0)
                ,2) 
                : 'no data'
        }}</div>
        <div class="keterangan">Penilaian Dosen Penguji: {{
            optional($kp->penilaian)->nilai_penguji ? 
                number_format(
                    (optional($kp->penilaian->nilai_penguji)->pemahaman_masalah ?? 0) +
                    (optional($kp->penilaian->nilai_penguji)->deskripsi_solusi ?? 0) +
                    (optional($kp->penilaian->nilai_penguji)->percaya_diri ?? 0) +
                    (optional($kp->penilaian->nilai_penguji)->tata_tulis ?? 0) +
                    (optional($kp->penilaian->nilai_penguji)->pembuktian_produk ?? 0) +
                    (optional($kp->penilaian->nilai_penguji)->efektivitas_produk ?? 0) +
                    (optional($kp->penilaian->nilai_penguji)->kontribusi ?? 0) +
                    (optional($kp->penilaian->nilai_penguji)->originalitas ?? 0) +
                    (optional($kp->penilaian->nilai_penguji)->kemudahan_produk ?? 0) +
                    (optional($kp->penilaian->nilai_penguji)->peningkatan_kinerja ?? 0)
                ,2) 
                : 'no data'
        }}</div>       
        <div class="keterangan">Penilaian Kordinator: {{
            optional($kp->penilaian)->nilai_kordinator ? 
                number_format(
                    ((optional($kp->penilaian->nilai_kordinator)->proposal ?? 0) +
                    (optional($kp->penilaian->nilai_kordinator)->bimbingan ?? 0) +
                    (optional($kp->penilaian->nilai_kordinator)->proposal ?? 0)) / 30 * 100
                ,2) 
                : 'no data'
        }}</div>  
        <div class="keterangan">Penilaian Pembimbing Lapangan: {{
            optional($kp->penilaian)->nilai_lapangan ? 
                number_format(
                    ((optional($kp->penilaian->nilai_lapangan)->pemahaman_masalah ?? 0) +
                    (optional($kp->penilaian->nilai_lapangan)->kemampuan_penyelesaian ?? 0) +
                    (optional($kp->penilaian->nilai_lapangan)->keterampilan ?? 0) +
                    (optional($kp->penilaian->nilai_lapangan)->disiplin ?? 0) +
                    (optional($kp->penilaian->nilai_lapangan)->teamwork ?? 0) +
                    (optional($kp->penilaian->nilai_lapangan)->komunikasi ?? 0) +
                    (optional($kp->penilaian->nilai_lapangan)->sikap_perilaku ?? 0) +
                    (optional($kp->penilaian->nilai_lapangan)->hasil_solusi ?? 0) +
                    (optional($kp->penilaian->nilai_lapangan)->kepuasan ?? 0) +
                    (optional($kp->penilaian->nilai_lapangan)->manfaat ?? 0) +
                    (optional($kp->penilaian->nilai_lapangan)->peluang_digunakan ?? 0) +
                    (optional($kp->penilaian->nilai_lapangan)->kemudahan ?? 0) +
                    (optional($kp->penilaian->nilai_lapangan)->hasil_infrastruktur ?? 0)) / 65 * 100
                ,2)
                : 'no data'
        }}</div>             --}}
</body>
</html>
