<x-app-layout>
    <section class="section">
        <div class="section-header">
            <h1>{{ $title  ?? 'Mapping Encounter'}}</h1>
            <a href="{{ route('menu.create')}}" class="btn btn-primary ml-1"> <i class="far fa-plus-square"></i> Tambah Data </a>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Mapping</a></div>
                <div class="breadcrumb-item">{{ $title  ?? 'Mapping Encounter'}}</div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                {{-- <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
                    <i class="ion ion-plus"> </i> Tambah Menu
                </button> --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Basic DataTables</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-1" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kd Dokter Rs</th>
                                        <th>Kd Dokter Ihs</th>
                                        <th>Nama Dokter Ihs</th>
                                        <th>Lokasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mappingEncounters as $item)
                                    <tr>
                                        <td style="width: 5%">{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode_dokter ?? '' }}</td>
                                        <td>{{ $item->practitioner_ihs ?? '' }}</td>
                                        <td>{{ $item->practitioner_display ?? '' }}</td>
                                        <td>{{ $item->location_display ?? '' }}</td>
                                        <td>
                                            <div class="dropdown d-inline">
                                                <button class="btn  btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item has-icon" href="{{ route('menu.edit', $item->id)}}"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                    <form id="delete-form-{{$item->id}}" action="{{ route('menu.destroy', $item->id) }}" method="POST" style="display: none;">
                                                        @method('delete')
                                                        @csrf
                                                    </form>
                                                    <a class="dropdown-item has-icon" confirm-delete="true" data-mapEncounterId="{{$item->id}}" href="#"><i class="fas fa-trash"></i> Hapus</a>
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
    <script src="{{ asset('stisla/assets/js/page/modules-datatables.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/selectric/public/jquery.selectric.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    @include('sweetalert::alert')
    @endpush

    @push('js-spesific')
    <!-- Page Specific JS File -->
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

    <script>
        document.querySelectorAll('[confirm-delete="true"]').forEach(function(element) {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                var menuId = this.getAttribute('data-mapEncounterId');
                Swal.fire({
                    title: 'Apakah Kamu Yakin?'
                    , text: "Anda tidak akan dapat mengembalikan ini!"
                    , icon: 'warning'
                    , showCancelButton: true
                    , confirmButtonColor: '#6777EF'
                    , cancelButtonColor: '#d33'
                    , confirmButtonText: 'Ya, Hapus saja!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = document.getElementById('delete-form-' + menuId);
                        if (form) {
                            form.submit();
                        } else {
                            console.error('Form not found for menu ID:', menuId);
                        }
                    }
                });
            });
        });

    </script>
    @endpush
</x-app-layout>
