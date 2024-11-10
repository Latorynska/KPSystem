<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lembar Pengesahan</title>
    <style>
        body {
            padding-left: 15%;
            padding-right: 10%;
            margin: 0 auto;
            font-family: serif;
            font-size: 16px;
            
        }
        .header {
            margin-top: 10%;
            margin-bottom: 20px;
            font-size: 22px;
            text-align: center;
            letter-spacing: 1px;
        }
        .header p {
            margin-bottom: 5px;
            margin: 0;
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
        <p>Lembar Penilaian</p>
        <p>Hasil Kerja Praktek</p>
        <p>{{$kp->metadata->judul}}</p>
        <div class="keterangan">Penilaian Dosen Pembimbing: {{
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
        }}</div>            
    </div>
</body>
</html>
