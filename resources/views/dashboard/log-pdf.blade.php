<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log Pembuatan Akun</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead tr td {
            text-align: center;
            font-weight: bold;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td>Riwayat Perubahan Akun</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->logs }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>