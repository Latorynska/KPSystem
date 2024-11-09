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
    </div>
</body>
</html>
