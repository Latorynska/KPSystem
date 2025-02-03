<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lembar Pengesahan</title>
    <style>
        body{
            padding-left: 25px;
            padding-right: 25px;
        }
        .header {
            padding-left: 15%;
            padding-right: 10%;
            margin: 0 auto;
            font-family: serif;
            font-size: 16px;
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
            padding: 2px;
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
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
            <p>Berita Acara</p>
            <p style="text-decoration: underline">
                Seminar Kerja Praktek
            </p>
    </div>
    {{-- metadata kp --}}
    <div style="margin-top: 25px">
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
    {{-- penilaian akhir table --}}
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
                <td style="vertical-align: top; text-align: center;">
                    {{
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
                    }}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">2. Penguji</td>
                <td style="vertical-align: top;">{{$kp->penguji->name}}</td>
                <td style="vertical-align: top; text-align: center;">
                    {{
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
                    }}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">3. Kordinator KP</td>
                <td style="vertical-align: top;">Diny Syarifah Sany, ST., MT.</td>
                <td style="vertical-align: top; text-align: center;">
                    {{
                        optional($kp->penilaian)->nilai_kordinator ? 
                            number_format(
                                ((optional($kp->penilaian->nilai_kordinator)->proposal ?? 0) +
                                (optional($kp->penilaian->nilai_kordinator)->bimbingan ?? 0) +
                                (optional($kp->penilaian->nilai_kordinator)->proposal ?? 0)) / 30 * 100
                            ,2) 
                            : 'no data'
                    }}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">4. Instansi/Perusahaan</td>
                <td style="vertical-align: top;">{{$kp->metadata->instansi}}</td>
                <td style="vertical-align: top; text-align: center;">
                    {{
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
                    }}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;" colspan="2">
                    <b>NILAI ANGKA</b> 
                    (0.3 X Nilai Ketua Penguji) + 
                    (0.3 X Nilai Penguji) + 
                    (0.3 x Nilai Koordinator) + 
                    (0.1 x Nilai Instansi)
                </td>
                <td style="vertical-align: top; text-align: center;">
                    {{
                        number_format(
                            (0.3 * (
                                optional($kp->penilaian)->nilai_pembimbing ? 
                                    (
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
                                    ) : 0
                            )) +
                            (0.3 * (
                                optional($kp->penilaian)->nilai_penguji ? 
                                    (
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
                                    ) : 0
                            )) +
                            (0.3 * (
                                optional($kp->penilaian)->nilai_kordinator ? 
                                    (
                                        ((optional($kp->penilaian->nilai_kordinator)->proposal ?? 0) +
                                        (optional($kp->penilaian->nilai_kordinator)->bimbingan ?? 0) +
                                        (optional($kp->penilaian->nilai_kordinator)->proposal ?? 0)) / 30 * 100
                                    ) : 0
                            )) +
                            (0.1 * (
                                optional($kp->penilaian)->nilai_lapangan ? 
                                    (
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
                                    ) : 0
                            ))
                        ,2)
                    }}
                </td>
            </tr>            
            <tr>
                <td style="vertical-align: top;" colspan="2"><b>NILAI HURUF</b></td>
                <td style="vertical-align: top; text-align: center;">
                    @php
                        $nilaiAngka = 
                            (optional($kp->penilaian)->nilai_pembimbing ? 
                                ((optional($kp->penilaian->nilai_pembimbing)->pemahaman_masalah ?? 0) +
                                (optional($kp->penilaian->nilai_pembimbing)->deskripsi_solusi ?? 0) +
                                (optional($kp->penilaian->nilai_pembimbing)->percaya_diri ?? 0) +
                                (optional($kp->penilaian->nilai_pembimbing)->tata_tulis ?? 0) +
                                (optional($kp->penilaian->nilai_pembimbing)->pembuktian_produk ?? 0) +
                                (optional($kp->penilaian->nilai_pembimbing)->efektivitas_produk ?? 0) +
                                (optional($kp->penilaian->nilai_pembimbing)->kontribusi ?? 0) +
                                (optional($kp->penilaian->nilai_pembimbing)->originalitas ?? 0) +
                                (optional($kp->penilaian->nilai_pembimbing)->kemudahan_produk ?? 0) +
                                (optional($kp->penilaian->nilai_pembimbing)->peningkatan_kinerja ?? 0)) * 0.3 : 0) +
            
                            (optional($kp->penilaian)->nilai_penguji ? 
                                ((optional($kp->penilaian->nilai_penguji)->pemahaman_masalah ?? 0) +
                                (optional($kp->penilaian->nilai_penguji)->deskripsi_solusi ?? 0) +
                                (optional($kp->penilaian->nilai_penguji)->percaya_diri ?? 0) +
                                (optional($kp->penilaian->nilai_penguji)->tata_tulis ?? 0) +
                                (optional($kp->penilaian->nilai_penguji)->pembuktian_produk ?? 0) +
                                (optional($kp->penilaian->nilai_penguji)->efektivitas_produk ?? 0) +
                                (optional($kp->penilaian->nilai_penguji)->kontribusi ?? 0) +
                                (optional($kp->penilaian->nilai_penguji)->originalitas ?? 0) +
                                (optional($kp->penilaian->nilai_penguji)->kemudahan_produk ?? 0) +
                                (optional($kp->penilaian->nilai_penguji)->peningkatan_kinerja ?? 0)) * 0.3 : 0) +
            
                            (optional($kp->penilaian)->nilai_kordinator ? 
                                (((optional($kp->penilaian->nilai_kordinator)->proposal ?? 0) +
                                (optional($kp->penilaian->nilai_kordinator)->bimbingan ?? 0) +
                                (optional($kp->penilaian->nilai_kordinator)->proposal ?? 0)) / 30 * 100) * 0.3 : 0) +
            
                            (optional($kp->penilaian)->nilai_lapangan ? 
                                (((optional($kp->penilaian->nilai_lapangan)->pemahaman_masalah ?? 0) +
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
                                (optional($kp->penilaian->nilai_lapangan)->hasil_infrastruktur ?? 0)) / 65 * 100) * 0.1 : 0)
                    @endphp
            
                    @if ($nilaiAngka >= 80)
                        A
                    @elseif ($nilaiAngka >= 73)
                        AB
                    @elseif ($nilaiAngka >= 65)
                        B
                    @elseif ($nilaiAngka >= 57)
                        BC
                    @elseif ($nilaiAngka >= 50)
                        C
                    @elseif ($nilaiAngka >= 35)
                        D
                    @else
                        no data
                    @endif
                </td>
            </tr>
        </table>
    </div>
    {{-- RANGE NILAI --}}
    <div style="margin-top:10px; margin-left:5px;">
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
    {{-- keterangan --}}
    <div style="margin-top:5px; margin-left:5px;">
        <p>
            KETERANGAN : LULUS / TIDAK LULUS
        </p>
    </div>
    {{-- ttd dan tanggal pengesahan --}}
    <div style="margin-top:5px; margin-left:5px;">
        <p>
            Cianjur, {{ \Carbon\Carbon::parse($kp->syarat_seminar->tanggal)->translatedFormat('d F Y') }}
        </p>
        <table>
            <tr>
                <td>
                    Pembimbing
                </td>
                <td></td>
                <td>
                    <center>
                        Penguji
                    </center>
                </td>
            </tr>
            <tr>
                <td style="height: 50px;">&nbsp;</td>
                <td style="height: 50px;">&nbsp;</td>
                <td style="height: 50px;">&nbsp;</td>
            </tr>
            <tr>
                <td>
                    ({{$kp->pembimbing->name}})
                </td>
                <td></td>
                <td>
                    <center>
                        ({{$kp->penguji->name}})
                    </center>
                </td>
            </tr>
        </table>
        <center>
            <p>Mengetahui,</p>
            <p>Koordinator Kerja Praktek</p>
            <div>
                <img src="{{ storage_path('app/public/ttdkoor.png') }}" style="height: 50px;" alt="Tanda Tangan Koordinator">
            </div>
            <p>(Diny Syarifah Sany, ST., MT)</p>
        </center>
    </div>
        
    {{-- page Penilaian --}}
    <div class="page-break"></div>
    <div class="header">
        <p>Lembar Penilaian Seminar Kerja Praktek</p>
        <p>Program Studi Teknik Informatika</p>
    </div>
    {{-- metadata kp --}}
    <div style="margin-top: 25px">
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
                <td width="30%" style="vertical-align: top;">Periode Kerja Praktek</td>
                <td width="5%" style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">
                    {{
                        \Carbon\Carbon::parse($kp->created_at)->month > 8 
                            ? \Carbon\Carbon::parse($kp->created_at)->year . '/' . (\Carbon\Carbon::parse($kp->created_at)->year + 1) 
                            : (\Carbon\Carbon::parse($kp->created_at)->year - 1) . '/' . \Carbon\Carbon::parse($kp->created_at)->year
                    }}
                </td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top;">Tanggal Seminar KP</td>
                <td width="5%" style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{ \Carbon\Carbon::parse($kp->syarat_seminar->tanggal)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top;">Tempat Kerja Praktek</td>
                <td width="5%" style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{$kp->metadata->instansi}}</td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top;">Judul Kerja Praktek</td>
                <td width="5%" style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{$kp->metadata->judul}}</td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top;">Nama Penguji</td>
                <td width="5%" style="vertical-align: top;">:</td>
                <td style="vertical-align: top;">{{$kp->penguji->name}}</td>
            </tr>
        </table>
    </div>
    {{-- penilaian akhir table --}}
    <div style="margin-top:20px; margin-left:5px;">
        <p>
            PENILAIAN
        </p>
        <table border="1" >
            <thead>
                <tr>
                    <th rowspan="2" style="width: 30px;"><center>No</center></th>
                    <th rowspan="2"><center>Materi Penilaian</center></th>
                    <th colspan="8"><center>Nilai</center></th>
                </tr>
                <tr>
                    <th colspan="2" style="width: 75px;"><center>Kurang</center></th>
                    <th colspan="2" style="width: 75px;"><center>Cukup</center></th>
                    <th colspan="2" style="width: 75px;"><center>Baik</center></th>
                    <th colspan="2" style="width: 75px;"><center>Sangat Baik</center></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="10"><center>Seminar</center></td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;text-align: center;">1.</td>
                    <td style="vertical-align: top;">Pemahaman Terhadap Masalah</td>
                    @for ($i = 2; $i <= 9; $i++)
                        <td style="vertical-align: middle; text-align: center;">
                            @if ($i == $kp->penilaian->nilai_penguji->pemahaman_masalah)
                                <p style="
                                    border: 1px solid black; 
                                    border-radius: 50%; 
                                    width: 30px; 
                                    height: 30px; 
                                    display: flex; 
                                    align-items: center; 
                                    justify-content: center;
                                    text-align: center; 
                                    line-height: 25px;
                                    margin: auto;">
                                    {{ $i }}
                                </p>
                            @else
                                <p>{{ $i }}</p>
                            @endif
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td style="vertical-align: middle;text-align: center;">2.</td>
                    <td style="vertical-align: top;">Mendeskripsikan Langkah yang diambil untuk dapat menghasilkan solusi</td>
                    @for ($i = 2; $i <= 9; $i++)
                        <td style="vertical-align: middle; text-align: center;">
                            @if ($i == $kp->penilaian->nilai_penguji->deskripsi_solusi)
                                <p style="
                                    border: 1px solid black; 
                                    border-radius: 50%; 
                                    width: 30px; 
                                    height: 30px; 
                                    display: flex; 
                                    align-items: center; 
                                    justify-content: center;
                                    text-align: center; 
                                    line-height: 25px;
                                    margin: auto;">
                                    {{ $i }}
                                </p>
                            @else
                                <p>{{ $i }}</p>
                            @endif
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td style="vertical-align: middle;text-align: center;">3.</td>
                    <td style="vertical-align: top;">Percaya Diri dalam mengkomunikasikan hasil kerja praktek</td>
                    @for ($i = 2; $i <= 9; $i++)
                        <td style="vertical-align: middle; text-align: center;">
                            @if ($i == $kp->penilaian->nilai_penguji->percaya_diri)
                                <p style="
                                    border: 1px solid black; 
                                    border-radius: 50%; 
                                    width: 30px; 
                                    height: 30px; 
                                    display: flex; 
                                    align-items: center; 
                                    justify-content: center;
                                    text-align: center; 
                                    line-height: 25px;
                                    margin: auto;">
                                    {{ $i }}
                                </p>
                            @else
                                <p>{{ $i }}</p>
                            @endif
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td style="vertical-align: middle;text-align: center;">4.</td>
                    <td style="vertical-align: top;">Tata tulis laporan</td>
                    @for ($i = 2; $i <= 9; $i++)
                        <td style="vertical-align: middle; text-align: center;">
                            @if ($i == $kp->penilaian->nilai_penguji->tata_tulis)
                                <p style="
                                    border: 1px solid black; 
                                    border-radius: 50%; 
                                    width: 30px; 
                                    height: 30px; 
                                    display: flex; 
                                    align-items: center; 
                                    justify-content: center;
                                    text-align: center; 
                                    line-height: 25px;
                                    margin: auto;">
                                    {{ $i }}
                                </p>
                            @else
                                <p>{{ $i }}</p>
                            @endif
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td style="vertical-align: middle;text-align: center;">5.</td>
                    <td style="vertical-align: top;">Mampu membuktikan hasil KP sebagai solusi dari masalah</td>
                    @for ($i = 2; $i <= 9; $i++)
                        <td style="vertical-align: middle; text-align: center;">
                            @if ($i == $kp->penilaian->nilai_penguji->pembuktian_produk)
                                <p style="
                                    border: 1px solid black; 
                                    border-radius: 50%; 
                                    width: 30px; 
                                    height: 30px; 
                                    display: flex; 
                                    align-items: center; 
                                    justify-content: center;
                                    text-align: center; 
                                    line-height: 25px;
                                    margin: auto;">
                                    {{ $i }}
                                </p>
                            @else
                                <p>{{ $i }}</p>
                            @endif
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td colspan="10"><center>PRODUK YANG DIHASILKAN</center></td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;text-align: center;">6.</td>
                    <td style="vertical-align: top;">Hasil produk menjawab permasalahan</td>
                    @for ($i = 2; $i <= 9; $i++)
                        <td style="vertical-align: middle; text-align: center;">
                            @if ($i == $kp->penilaian->nilai_penguji->efektivitas_produk)
                                <p style="
                                    border: 1px solid black; 
                                    border-radius: 50%; 
                                    width: 30px; 
                                    height: 30px; 
                                    display: flex; 
                                    align-items: center; 
                                    justify-content: center;
                                    text-align: center; 
                                    line-height: 25px;
                                    margin: auto;">
                                    {{ $i }}
                                </p>
                            @else
                                <p>{{ $i }}</p>
                            @endif
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td style="vertical-align: middle;text-align: center;">7.</td>
                    <td style="vertical-align: top;">Kontribusi nyata terhadap instansi</td>
                    @for ($i = 2; $i <= 9; $i++)
                        <td style="vertical-align: middle; text-align: center;">
                            @if ($i == $kp->penilaian->nilai_penguji->kontribusi)
                                <p style="
                                    border: 1px solid black; 
                                    border-radius: 50%; 
                                    width: 30px; 
                                    height: 30px; 
                                    display: flex; 
                                    align-items: center; 
                                    justify-content: center;
                                    text-align: center; 
                                    line-height: 25px;
                                    margin: auto;">
                                    {{ $i }}
                                </p>
                            @else
                                <p>{{ $i }}</p>
                            @endif
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td style="vertical-align: middle;text-align: center;">8.</td>
                    <td style="vertical-align: top;">Originalitas produk (bukan pekerjaan oranglain)</td>
                    @for ($i = 2; $i <= 9; $i++)
                        <td style="vertical-align: middle; text-align: center;">
                            @if ($i == $kp->penilaian->nilai_penguji->originalitas)
                                <p style="
                                    border: 1px solid black; 
                                    border-radius: 50%; 
                                    width: 30px; 
                                    height: 30px; 
                                    display: flex; 
                                    align-items: center; 
                                    justify-content: center;
                                    text-align: center; 
                                    line-height: 25px;
                                    margin: auto;">
                                    {{ $i }}
                                </p>
                            @else
                                <p>{{ $i }}</p>
                            @endif
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td style="vertical-align: middle;text-align: center;">9.</td>
                    <td style="vertical-align: top;">Kemudahan penggunaan hasil/produk</td>
                    @for ($i = 2; $i <= 9; $i++)
                        <td style="vertical-align: middle; text-align: center;">
                            @if ($i == $kp->penilaian->nilai_penguji->kemudahan_produk)
                                <p style="
                                    border: 1px solid black; 
                                    border-radius: 50%; 
                                    width: 30px; 
                                    height: 30px; 
                                    display: flex; 
                                    align-items: center; 
                                    justify-content: center;
                                    text-align: center; 
                                    line-height: 25px;
                                    margin: auto;">
                                    {{ $i }}
                                </p>
                            @else
                                <p>{{ $i }}</p>
                            @endif
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td style="vertical-align: middle;text-align: center;">10.</td>
                    <td style="vertical-align: top;">Produk meningkatkan kinerja instansi</td>
                    @for ($i = 2; $i <= 9; $i++)
                        <td style="vertical-align: middle; text-align: center;">
                            @if ($i == $kp->penilaian->nilai_penguji->peningkatan_kinerja)
                                <p style="
                                    border: 1px solid black; 
                                    border-radius: 50%; 
                                    width: 30px; 
                                    height: 30px; 
                                    display: flex; 
                                    align-items: center; 
                                    justify-content: center;
                                    text-align: center; 
                                    line-height: 25px;
                                    margin: auto;">
                                    {{ $i }}
                                </p>
                            @else
                                <p>{{ $i }}</p>
                            @endif
                        </td>
                    @endfor
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2"><center>Total</center></th>
                    <td colspan="8"><center>{{ $kp->penilaian->nilai_penguji->total_nilai()}}</center></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
