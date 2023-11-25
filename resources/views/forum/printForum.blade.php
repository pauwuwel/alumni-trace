<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Tabel Data Forum</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table id="data-table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Pembuat</th>
                <th>Waktu Buat</th>
                <th>Isi Forum</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <tr>
                @foreach($forum_data as $forum)
                <td>{{ $forum->judul }}</td>
                <td>{{ $forum->nama_pembuat }}</td>
                <td>{{ $forum->tanggal_post }}</td>
                <td>{{ $forum->content }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>
    <script src="script.js"></script>
</body>
</html>