<x-app-layout title="{{ $title ?? 'Register Pasien RS'}}">
    <section class="section">
        <div class="section-header">
            <h1>{{$title ?? 'Register Pasien RS'}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Master Data</a></div>
                <div class="breadcrumb-item">Register Pasien RS</div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <div class="form-group">
                            <form method="GET" action="{{ route('pasien.index')}}">
                        <select class="custom-select mr-sm-2 select2" id="inlineFormCustomSelect" name="range_id" onchange="this.form.submit()">
                            @foreach ($data as $range)
                            <option value="{{ $range['id'] }}" {{ $range['id'] == $selectedRange ? 'selected' : '' }}>
                                {{ $range['start'] }} - {{ $range['end'] }}
                            </option>
                            @endforeach
                        </select>
                        </form>
                    </div> --}}
                    <div class="form-group">
                        <h4>Cari Berdasarkan No MR, Nama Pasien dan NIK!</h4>
                        <input type="text" name="search" id="search" placeholder="ketikan dengan sesuai . . ." class="form-control" onfocus="this.value=''">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="search_list">

                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>




    {{-- css library --}}
    @push('css-libraries')
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/selectric/public/selectric.css')}}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/select2/dist/css/select2.min.css') }}" />
    @endpush

    @push('js-libraries')
    <script src="{{ asset('stisla/node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/selectric/public/jquery.selectric.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('stisla/assets/js/page/modules-datatables.js')}}"></script>
    @include('sweetalert::alert')
    @endpush

    @push('js-spesific')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script>
        $(document).ready(function() {
            let debounceTimer;

            $('#search').on('keyup', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function() {
                    var query = $('#search').val();
                    $.ajax({
                        url: '/satu-sehat/master/register/search'
                        , type: "GET"
                        , data: {
                            'search': query
                        }
                        , success: function(data) {
                            $('#search_list').html(data);
                        }
                        , error: function(xhr, status, error) {
                            console.error("Error: " + status + " - " + error);
                        }
                    });
                }, 300); // Adjust the delay as needed (300ms in this example)
            });
        });

    </script>

    @endpush
</x-app-layout>
