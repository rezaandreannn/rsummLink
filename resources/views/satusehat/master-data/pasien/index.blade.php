<x-app-layout title="{{ $title ?? 'Pasien'}}">
    <section class="section">
        <div class="section-header">
            <h1>{{$title ?? 'Pasien'}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Master Data</a></div>
                <div class="breadcrumb-item">Pasien</div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Menampilkan data Pasien yang sudah terdaftar di SatuSehat.</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-1" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>No MR</th>
                                        <th>NIK</th>
                                        <th>Nama Pasien</th>
                                        <th>Dibuat Oleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pasiens as $pasien)
                                    <tr>
                                        <td style="width: 5%">{{ $loop->iteration }}</td>
                                        <td>{{$pasien->id_pasien ?? ''}}</td>
                                        <td>{{$pasien->no_mr ?? ''}}</td>
                                        <td>{{ $pasien->nik ?? ''}} </td>
                                        <td>{{$pasien->nama_pasien ?? ''}}</td>
                                        <td>{{$pasien->created_by ?? ''}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                        url: '/satu-sehat/master/pasien/search'
                        , type: "GET"
                        , data: {
                            'search': query
                        }
                        , success: function(data) {
                            console.log(data)
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
