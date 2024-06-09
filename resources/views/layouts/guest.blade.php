<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Form Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('auth/assets/css/style.css')}}">
</head>

<body>
    <div class="container-fluid form-container">
        <div class="container login-container">
            <div class="row">
                <div class="col-md-5 content-part">

                    <h4 class="logo">
                        <a href="/" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                    </h4>

                    <img src="{{ asset('auth/assets/images/feature-img-05.png')}}" alt="">

                    <h2>Dapatkan visibilitas instan ke semua kerja tim Anda</h2>
                    <p>Jangan buang waktu untuk tugas-tugas manual yang membosankan. Biarkan Otomatisasi melakukannya untuk Anda. Sederhanakan alur kerja,
                        mengurangi kesalahan, dan menghemat waktu untuk memecahkan masalah yang lebih penting.</p>
                </div>
                <div class="col-md-7 form-part">
                    <div class="row">
                        @if(config('app.user_registered') == 'true')
                        <p class="signinlink">
                            Belum punya akun <a href="index.html">Daftar</a></p>
                        @endif

                        <div class="col-lg-8 col-md-11 login formcol mx-auto">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html
