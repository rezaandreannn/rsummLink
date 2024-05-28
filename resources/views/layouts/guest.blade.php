{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>
</html> --}}

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Form HTML Design</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('auth/assets/css/style.css')}}">
</head>

<body>
    <div class="container-fluid form-container">
        <div class="container login-container">
            <div class="row">
                <div class="col-md-5 content-part">
                    <h4 class="logo">Smart Account</h4>

                    <img src="{{ asset('auth/assets/images/feature-img-05.png')}}" alt="">

                    <h2>Get instant visibility into all your team work.</h2>
                    <p>Don’t waste time on tedious manual tasks. Let Automation do it for you. Simplify workflows,
                        reduce errors, and save time for solving more important problems.</p>
                </div>
                <div class="col-md-7 form-part">
                    <div class="row">
                        <p class="signinlink">Dont have an account <a href="index.html">Sign Up</a></p>

                        <div class="col-lg-8 col-md-11 login formcol mx-auto">
                            {{ $slot }}


                            {{-- <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" placeholder="Enter Email Address">
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="form-floating">
                                <button class="btn btn-primary">Login</button>
                            </div> --}}


                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</body>
</html
