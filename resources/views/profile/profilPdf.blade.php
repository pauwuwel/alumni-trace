<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Profil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .cv-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            max-width: 800px;
            margin: auto;
        }

        .left-column {
            flex: 1;
            text-align: center;
            padding-bottom: 20px;
        }

        .right-column {
            flex: 2;
            padding-left: 20px;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 50%;
        }

        .personal-info {
            margin-bottom: 20px;
        }

        .career-history {
            margin-top: 10px;
        }

        h2 {
            border-bottom: 3px solid #00AEA6;
            padding-bottom: 5px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="cv-container">

        @foreach ($profile as $data)
            <div class="right-column">
                <div class="personal-info">
                    <h2>Informasi Data Diri</h2>
                    <p>Nama: {{ $data->nama !== null ? $data->nama : '-' }}</p>
                    <p>Tanggal Lahir: {{ $data->tanggal_lahir !== null ? $data->tanggal_lahir : '-' }}</p>
                    <p>Jenis Kelamin: {{ $data->jenis_kelamin !== null ? $data->jenis_kelamin : '-' }}</p>
                    <p>Nomor Telepon: {{ $data->nomor_telepon !== null ? $data->nomor_telepon : '-' }}</p>
                    <p>Alamat: {{ $data->jalan !== null ? 'Jalan ' . $data->jalan : '' }}
                        {{ $data->gang !== null ? 'Gang ' . $data->gang : '' }}
                        {{ $data->nomor_rumah !== null ? 'No. ' . $data->nomor_rumah : '' }}
                        {{ $data->blok !== null ? 'Blok ' . $data->blok : '' }}
                        {{ $data->rt !== null ? 'RT ' . $data->rt : '' }}
                        {{ $data->rw !== null ? 'RW ' . $data->rw : '' }}
                        {{ $data->kelurahan !== null ? 'Kelurahan ' . $data->kelurahan : '' }}
                        {{ $data->kecamatan !== null ? 'Kecamatan ' . $data->kecamatan : '' }}
                        {{ $data->kota !== null ? 'Kota ' . $data->kota : '' }}
                        {{ $data->kodepos !== null ? $data->kodepos : '' }} </p>
                </div>
        @endforeach

        <h2>Riwayat Karir</h2>
        @foreach ($career as $karir)
            <div class="career-history">
                {{ $karir->tanggal_selesai !== null ? 'Telah ' : 'Sedang ' }}
                {{ $karir->jenis_karir == 'kuliah'
                    ? 'menjalankan kuliah di '
                    : ($karir->jenis_karir == 'kerja'
                        ? 'bekerja pada '
                        : ($karir->jenis_karir == 'wirausaha'
                            ? 'menjalankan usaha dengan nama '
                            : '')) }}
                {{ $karir->nama_instansi }}
                {{ $karir->jenis_karir == 'kuliah'
                    ? 'dengan jurusan '
                    : ($karir->jenis_karir == 'kerja'
                        ? 'dengan jabatan '
                        : ($karir->jenis_karir == 'wirausaha'
                            ? 'dalam bidang '
                            : '')) }}
                {{ $karir->posisi_bidang }}
                {{ $karir->tanggal_selesai !== null ? 'pada ' : 'sejak ' }}
                {{ $karir->tanggal_mulai }}
                {{ $karir->tanggal_selesai !== null ? 'hingga ' . $karir->tanggal_selesai : ' ' }}

            </div>
        @endforeach
    </div>
    </div>

</body>

</html>