<x-app-layout>
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>

        </div>

        {{-- <h2 class="section-title"> --}}
        <div class="col-12 col-md-4">
            <form action="{{ route('satu-sehat.dashboard') }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>
                        <input type="text" name="daterange" class="form-control daterange-cus" value="{{ old('daterange', $daterange) }}">
                    </div>
                </div>
            </form>
        </div>
        {{-- </h2> --}}


        @if (isset($logs))
        <div class="row">
            @foreach($logs as $resource => $total)
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>{{ $resource }}</h4>
                    </div>
                    <div class="card-body">
                        <p>Total <code class="large-number">{{$total}}</code></p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        </div>
    </section>

    @push('css-libraries')
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/selectric/public/selectric.css')}}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/select2/dist/css/select2.min.css') }}" />
    <style>
        .large-number {
            font-size: 1.5em;
            /* Adjust the size as needed */
            font-weight: bold;
            /* Optional: make the number bold */
        }

    </style>
    @endpush

    @push('js-libraries')
    <script src="{{ asset('stisla/node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/selectric/public/jquery.selectric.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('stisla/assets/js/page/modules-datatables.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    @include('sweetalert::alert')
    @endpush

    @push('js-spesific')
    <script>
        $(document).ready(function() {
            $('.daterange-cus').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                }
                , drops: 'down'
                , opens: 'right'
            });

            $('.daterange-cus').on('apply.daterangepicker', function(ev, picker) {
                this.form.submit();
            });
        });

    </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var daterangeInput = document.querySelector('.daterange-cus');

            daterangeInput.addEventListener('change', function() {
                this.form.submit();
            });
        });

    </script> --}}

    @endpush
</x-app-layout>
