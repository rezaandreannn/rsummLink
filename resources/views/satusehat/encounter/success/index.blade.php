<x-app-layout title="{{ $title ?? 'Encounter Success'}}">
    <section class="section">
        <div class="section-header">
            <h1>{{$title ?? 'Encounter Success'}}</h1>
            {{-- <a href="{{ route('encounter.mapping.create')}}" class="btn btn-primary ml-1"> <i class="far fa-plus-square"></i> Tambah Data </a> --}}
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Encounter</a></div>
                <div class="breadcrumb-item">Encounter Success </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Log Transaksi Encounter Success.</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-1" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Registrasi</th>
                                        <th>encounter ID</th>
                                        <th>Patient ID</th>
                                        <th>Practitioner ID</th>
                                        <th>Location ID</th>
                                        <th>Created By</th>
                                        <th>Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($successEncounters as $value)
                                    <tr>
                                        <td style="width: 5%">{{$loop->iteration}}</td>
                                        <td>{{$value->kode_register}}</td>
                                        <td>{{$value->encounter_id}}</td>
                                        <td>{{$value->patient_id}}</td>
                                        <td>{{$value->practitioner_id}}</td>
                                        <td>{{$value->location_id}}</td>
                                        <td>{{$value->created_by}}</td>
                                        <td>{{$value->created_at}}</td>
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


    @endpush
</x-app-layout>
