<x-app-layout title="{{ $title ?? 'Icd10'}}">
    <section class="section">
        <div class="section-header">
            <h1>{{$title ?? 'Icd10'}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Master Data</a></div>
                <div class="breadcrumb-item">Icd10</div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Menampilkan data Icd10/Diagnosa yang aktif</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-1" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama EN</th>
                                        <th>Nama ID</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataIcd10 as $icd10)
                                    <tr>
                                        <td style="width: 5%">{{ $loop->iteration }}</td>
                                        <td>{{$icd10->icd10_code ?? ''}}</td>
                                        <td>{{ $icd10->icd10_en ?? ''}} </td>
                                        <td>{{$icd10->icd10_id ?? ''}}</td>
                                        <td>
                                            <div class="dropdown d-inline">
                                                <button class="btn  btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item has-icon" href=""><i class="fas fa-user-tag"></i> Peran</a>
                                                    <a class="dropdown-item has-icon" href=""><i class="fas fa-pencil-alt"></i> Edit</a>
                                                    <form id="delete-form-{{$icd10->id}}" action="" method="POST" style="display:none;">
                                                        @method('delete')
                                                        @csrf
                                                    </form>
                                                    <a class="dropdown-item has-icon" confirm-delete="true" data-userId="{{$icd10->id}}" href="#"><i class="fas fa-trash"></i> Hapus</a>
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
