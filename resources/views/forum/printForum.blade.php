<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>@foreach ($forum_data as $item)
            {{ $item->judul}}
        @endforeach</title>
        <style>
            .container {
                width: 100%;
                margin-right: auto;
                margin-left: auto;
            }

            .float-right {
                float: right;
            }

            .post-header {
                margin-bottom: 12px;
            }

            .post-header h2 {
                font-weight: bold;
            }

            .attachment img {
                max-width: 34vw;
            }

            .hr-container {
                margin-bottom: 2px;
            }

            .text-muted {
                color: #6c757d;
            }

            .comment-list {
                margin-bottom: 4px;
            }

            .comment-meta {
                display: flex;
                align-items: center;
            }

            .comment-meta .fw-bold {
                margin-right: 5px;
            }

            .comment-content {
                margin-bottom: 11px;
            }

            .comment-form {
                display: flex;
                margin-top: 8px;
            }

            .comment-form input {
                margin-right: 2px;
            }

            .action-buttons {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                margin-top: 10px;
            }

            .btnAcc,
            .btnTolak,
            .btnHapus,
            .btn-primary,
            .btn-secondary,
            .btn-success,
            .btn-danger {
                padding: 6px 12px;
                font-size: 14px;
                border-radius: 4px;
                cursor: pointer;
                text-decoration: none;
                text-align: center;
            }

            .btn-primary,
            .btn-secondary {
                color: #fff;
                background-color: #007bff;
                border-color: #007bff;
            }

            .btn-success {
                color: #fff;
                background-color: #28a745;
                border-color: #28a745;
            }

            .btn-danger {
                color: #fff;
                background-color: #dc3545;
                border-color: #dc3545;
            }

            .btn-warning {
                color: #212529;
                background-color: #ffc107;
                border-color: #ffc107;
            }
        </style>
    </head>

    <body>
        <div class="container">
            @foreach ($forum_data as $data)
                <div class="post-header">
                    <div class="d-flex align-items-end" style="gap: 12px">
                        <h2 class="fw-bolder">{{ $data->judul }}</h2>
                        <h5>{{ $data->nama_pembuat }} || {{ $data->tanggal_post }}</h5>
                    </div>
                </div>
                <div class="content">
                    <p>{{ $data->content }}</p>
                </div>
                <div class="attachment">
                    @if ($data->attachment !== null)
                        <img src="{{ url('img') . '/' . $data->attachment }}" alt="attachment" style="max-width: 34vw">
                    @endif
                </div>

                @if ($data->status !== 'pending')
                    <div class="comments">
                        <div class="hr-container">
                            <span class="text-muted text">{{ $data->totalKomentar }} Komentar</span>
                            <hr class="my-4">
                        </div>
                        <div class="comment-list">
                            @foreach ($data->komentar as $komen)
                                <div class="comment">
                                    <div class="comment-meta">
                                        <div class="fw-bold">{{ $komen->nama_pembuat }} || {{ $komen->tanggal_post }}
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        {{ $komen->komentar }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

    </body>

</html>
