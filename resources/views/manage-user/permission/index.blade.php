<x-app-layout title='{{ $title }}'>
    <section class="section">
        <div class="section-header">
            <h1>Perizinan</h1>
            <button type="button" class="btn btn-primary ml-1" data-toggle="modal" data-target="#exampleModal">
                <i class="far fa-plus-square"></i> Tambah Data
            </button>
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
                                        <th>Nama Perizinan</th>
                                        <th>Aplikasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permissions as $permission)
                                    <tr>
                                        <td style="width: 5%">{{ $loop->iteration }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            <div class="badge badge-{{ isset($permission->application->name) ? 'success' : 'dark'}}">
                                                {{ $permission->application ? ucwords($permission->application->name) : 'Super admin' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown d-inline">
                                                <button class="btn  btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item has-icon" href="#" data-toggle="modal" data-target="#editModal{{ $permission->id}}"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                    <form id="delete-form-{{$permission->id}}" action="{{ route('permission.destroy', $permission->id) }}" method="POST" style="display: none;">
                                                        @method('delete')
                                                        @csrf
                                                    </form>
                                                    <a class="dropdown-item has-icon" href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{$permission->id}}').submit();"><i class="fas fa-trash"></i> Hapus</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data {{ $title ?? ''}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('permission.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Perizinan <i><small class="required-label"></small></i>
                            </label>
                            <input type="text" name="name" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>Tipe <i><small class="required-label"></small></i>
                            </label>
                            <select class="form-control selectric" name="guard_name">
                                <option value="web" selected>web</option>
                                <option value="api">api</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Aplikasi <i><small class="required-label"></small></i>
                            </label>
                            <select class="form-control selectric" name="application_id">
                                <option selected disabled>-- pilih --</option>
                                @foreach($applications as $app)
                                <option value="{{ $app->id }}">{{$app->name}}</option>
                                @endforeach
                                <option value="">super admin</option>
                            </select>
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

    @foreach ($permissions as $permission)
    <div class="modal fade" id="editModal{{ $permission->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data {{ $title ?? ''}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('permission.update', $permission->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>permission Name <i><small class="required-label"></small></i>
                            </label>
                            <input type="text" name="name" class="form-control" value="{{ $permission->name }}" required="">
                        </div>
                        <div class="form-group">
                            <label>Guard Name <i><small class="required-label"></small></i>
                            </label>
                            <select class="form-control selectric" name="guard_name">
                                <option value="web" {{ $permission->guard_name=='web' ? 'selected' : ''}}>web</option>
                                <option value="api" {{ $permission->guard_name=='api' ? 'selected' : ''}}>api</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Aplikasi <i><small class="required-label"></small></i>
                            </label>
                            <select class="form-control selectric" name="application_id">
                                <option selected disabled>-- pilih --</option>
                                @foreach($applications as $app)
                                <option value="{{ $app->id }}" {{ $permission->application_id == $app->id ? 'selected' : ''}}>{{$app->name}}</option>
                                @endforeach
                                <option value="" {{ $permission->application_id == '' ? 'selected' : ''}}>super admin</option>
                            </select>
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
    @endpush

    @push('js-libraries')
    <script src="{{ asset('stisla/node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/selectric/public/jquery.selectric.min.js')}}"></script>
    <script src="{{ asset('stisla/assets/js/page/modules-datatables.js')}}"></script>
    @include('sweetalert::alert')

    @endpush
</x-app-layout>
