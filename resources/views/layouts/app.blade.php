<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>RSUMM | {{ $title ?? '' }} </title>

    <!-- favicon icon -->
    <link rel="shortcut icon" href="{{ asset('logo_rsumm.ico')}}" />

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- CSS Libraries -->
    @stack('css-libraries')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('stisla/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('stisla/assets/css/components.css')}}">

    <!-- spesific CSS -->
    @stack('css-spesific')
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            {{-- @include('layouts.header') --}}
            <x-header-component />

            {{-- @include('layouts.navigation') --}}
            <x-navigation-component />

            <!-- Main Content -->
            <div class="main-content">
                {{ $slot }}
            </div>


            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; {{ date('Y')}}
                    <div class="bullet"></div> Design By <a href="https://nauval.in/">Reza Andrean</a>
                </div>
                <div class="footer-right">
                    v{{ Illuminate\Foundation\Application::VERSION }}
                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ asset('stisla/assets/js/stisla.js')}}"></script>

    <!-- JS Libraies -->
    @stack('js-libraries')


    <!-- Template JS File -->
    <script src="{{ asset('stisla/assets/js/scripts.js')}}"></script>
    <script src="{{ asset('stisla/assets/js/custom.js')}}"></script>

    <!-- Page Specific JS File -->
    @stack('js-spesific')

    {{-- @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"]) --}}
</body>
</html>
