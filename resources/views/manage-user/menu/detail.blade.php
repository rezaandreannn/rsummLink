<x-app-layout title='{{ $title }}'>
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('menu.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Submenu </h1>
            <button type="button" class="btn btn-primary ml-1" data-toggle="modal" data-target="#exampleModal">
                <i class="far fa-plus-square"></i> Tambah Data </button>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Modules</a></div>
                <div class="breadcrumb-item">Calendar</div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                {{-- <a href="{{ route('menu.create')}}" class="btn btn-primary mb-2"> <i class="far fa-plus-square"></i> Tambah Menu </a> --}}

                <div class="card">
                    <div class="card-header">
                        <h4>Basic DataTables</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama SubMenu</th>
                                        <th>Rute</th>
                                        <th>Perizinan</th>
                                        <th>No Urut</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($menuItems as $submenu)
                                    <tr>
                                        <td style="width: 5%">{{ $loop->iteration }}</td>
                                        <td>{{ $submenu->name }}</td>
                                        <td>{{ $submenu->route ?? '#' }}</td>
                                        <td>{{$submenu->permission ? $submenu->permission->name : '' }} </td>
                                        <td>{{$submenu->serial_number ?? '' }}</td>
                                        <td>
                                            <div class="dropdown d-inline">
                                                <button class="btn  btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item has-icon" href="#" data-toggle="modal" data-target="#editModal{{ $submenu->id}}"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                    <form id="delete-form-{{$submenu->id}}" action="{{ route('submenu.destroy', $submenu->id)}}" method="POST" style="display: none;">
                                                        @method('delete')
                                                        @csrf
                                                    </form>
                                                    <a class="dropdown-item has-icon" confirm-delete="true" data-submenuId="{{$submenu->id}}" href="#"><i class="fas fa-trash"></i> Hapus</a>
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

    <!-- Modal Add -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data {{ $title ?? ''}} - {{$menu->application ? $menu->application->name : 'Super Admin'}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('submenu.store')}}" method="POST">
                    @csrf

                    <input type="hidden" name="menu_id" class="form-control" value="{{$menu->id}}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama SubMenu <i><small class="required-label"></small></i>
                            </label>
                            <input type="text" name="name" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>Rute <i><small class="required-label"></small></i>
                            </label>
                            <input type="text" name="route" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Perizinan<i><small class="required-label"></small></i>
                            </label>
                            <select class="form-control selectric" name="permission_id">
                                <option selected disabled>-- pilih --</option>
                                @foreach($permissions as $permission)
                                <option value="{{ $permission->id }}">{{$permission->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>No Urut <i><small class="required-label"></small></i>
                            </label>
                            <input type="number" name="serial_number" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-icon btn-danger" data-dismiss="modal"><i class="fas fa-times"></i></button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($menuItems as $submenu)
    <div class="modal fade" id="editModal{{ $submenu->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data {{ $title ?? ''}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('submenu.update', $submenu->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="menu_id" class="form-control" value="{{$menu->id }}">
                        <div class="form-group">
                            <label>Nama SubMenu <i><small class="required-label"></small></i>
                            </label>
                            <input type="text" name="name" class="form-control" value="{{$submenu->name }}">
                        </div>
                        <div class="form-group">
                            <label>Rute <i><small class="required-label"></small></i>
                            </label>
                            <input type="text" name="route" class="form-control" value="{{$submenu->route}}">
                        </div>
                        <div class="form-group">
                            <label>Perizinan<i><small class="required-label"></small></i>
                            </label>
                            <select class="form-control selectric" name="permission_id">
                                <option selected disabled>-- pilih --</option>
                                @foreach($permissions as $permission)
                                <option value="{{ $permission->id }}" {{$permission->id == $submenu->permission_id ?  'selected' : ''}}>{{$permission->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>No Urut <i><small class="required-label"></small></i>
                            </label>
                            <input type="number" name="serial_number" class="form-control" value="{{ $submenu->serial_number}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-icon btn-danger" data-dismiss="modal"><i class="fas fa-times"></i></button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

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
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script>
        document.querySelectorAll('[confirm-delete="true"]').forEach(function(element) {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                var submenuId = this.getAttribute('data-submenuId');
                Swal.fire({
                    title: 'Apakah Kamu Yakin?'
                    , text: "Anda tidak akan dapat mengembalikan ini!"
                    , icon: 'warning'
                    , showCancelButton: true
                    , confirmButtonColor: '#6777EF'
                    , cancelButtonColor: '#d33'
                    , cancelButtonText: 'Batal'
                    , confirmButtonText: 'Ya, Hapus saja!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = document.getElementById('delete-form-' + submenuId);
                        if (form) {
                            form.submit();
                        } else {
                            console.error('Form not found for role ID:', roleId);
                        }
                    }
                });
            });
        });

    </script>

    @endpush
</x-app-layout>
