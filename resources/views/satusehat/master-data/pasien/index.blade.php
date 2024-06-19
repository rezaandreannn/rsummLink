<x-app-layout title="{{ $title ?? 'Register Pasien'}}">
    <section class="section">
        <div class="section-header">
            <h1>{{$title ?? 'Register Pasien'}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Master Data</a></div>
                <div class="breadcrumb-item">Register Pasien</div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="form-group">
                            <form method="GET" action="{{ route('pasien.index')}}">
                                <select class="custom-select mr-sm-2 select2" id="inlineFormCustomSelect" name="range_id" onchange="this.form.submit()">
                                    @foreach ($data as $range)
                                    <option value="{{ $range['id'] }}" {{ $range['id'] == $selectedRange ? 'selected' : '' }}>
                                        {{ $range['start'] }} - {{ $range['end'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-1" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2" class="align-center">No MR</th>
                                        <th rowspan="2">NIK</th>
                                        <th rowspan="2">ID Satu Sehat</th>
                                        <th colspan="2" class="text-center">Nama Pasien</th>

                                    </tr>
                                    <tr>
                                        <th>RS</th>
                                        <th>SatuSehat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registerPasiens as $registerPasien)
                                    <tr>
                                        <td style="width: 5%">{{ $loop->iteration }}</td>
                                        <td>{{$registerPasien->no_mr ?? ''}}</td>
                                        <td>{{ $registerPasien->nik ?? ''}} </td>
                                        <td>{{$registerPasien->id_pasien ?? ''}}</td>
                                        <td>{{$registerPasien->nama_pasien_rs ?? ''}}</td>
                                        <td>{{$registerPasien->nama_pasien ?? ''}}</td>
                                        {{-- <td> --}}
                                        {{-- <div class="dropdown d-inline">
                                                <button class="btn  btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item has-icon" href="{{ route('user.show', $user->id)}}"><i class="fas fa-user-tag"></i> Peran</a>
                                        <a class="dropdown-item has-icon" href="{{ route('user.edit', $user->id)}}"><i class="fas fa-pencil-alt"></i> Edit</a>
                                        <form id="delete-form-{{$user->id}}" action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:none;">
                                            @method('delete')
                                            @csrf
                                        </form>
                                        <a class="dropdown-item has-icon" confirm-delete="true" data-userId="{{$user->id}}" href="#"><i class="fas fa-trash"></i> Hapus</a>
                        </div>
                    </div> --}}
                    {{-- </td> --}}
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
