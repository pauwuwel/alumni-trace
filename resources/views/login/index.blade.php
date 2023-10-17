<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <style>
        body {
            font-family: 'Montserrat';
        }
    </style>
</head>
<body>
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <div class="col-lg-8 d-none d-lg-block border border-dark">
                <img src="" alt="foto smk 1" srcset="">
            </div>
            <div class="col-lg-4 col-sm-12 d-flex align-items-center justify-content-center">
                <form method="POST" action="">
                    <div class="d-flex flex-column" style="width: 26vw;gap: 12px;">
                        <img src="" alt="logo alumni-trace" class="border border-dark">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Masukan username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" class="form-control" name="password" id="password" placeholder="Masukan password">
                        </div>
                        <button type="submit" class="btn text-light text-uppercase fw-bold btn-md mt-1" style="letter-spacing: 2px;background: #00AEA6;">Masuk</button>
                        @csrf
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- <form method="POST" action="/login">
        <input type="text" name="username">
        <input type="password" name="password">
        <input type="submit">
        @csrf
    </form> --}}
</body>
</html>