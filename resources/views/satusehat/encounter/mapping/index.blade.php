<x-app-layout title="{{ $title ?? 'Mapping'}}">
    <section class="section">
        <div class="section-header">
            <h1>{{$title ?? 'Mapping'}}</h1>
            <a href="{{ route('encounter.mapping.create')}}" class="btn btn-primary ml-1"> <i class="far fa-plus-square"></i> Tambah Data </a>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Encounter</a></div>
                <div class="breadcrumb-item">Mapping</div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Dokter termapping dengan Location dan Organization.</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-1" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Dokter SS</th>
                                        <th>Location</th>
                                        <th>Managing Organization</th>
                                        <th>Pelayanan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $pelayanans = [
                                    1 => 'rawat jalan',
                                    2 => 'rawat inap',
                                    3 => 'igd',
                                    ];
                                    @endphp
                                    @foreach($mappings as $map)
                                    <tr>
                                        <td style="width: 5%">{{$loop->iteration}}</td>
                                        <td>{{$map->Practitioner->nama_dokter}}</td>
                                        <td>{{$map->location->name}}</td>
                                        <td>{{$map->organization->name}}</td>
                                        <td>
                                            @foreach($pelayanans as $key => $value)
                                            @if($map->cara_masuk == $key)
                                            {{ $value }}
                                            @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="dropdown d-inline">
                                                <button class="btn  btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item has-icon" href="{{ route('encounter.mapping.edit', $map->id)}}"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                </div>
                                            </div>
                                        </td>
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
