<x-app-layout title="Role">
    <section class="section">
        <div class="section-header">
            <h1>Data Peran</h1>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
                    <i class="far fa-plus-square"></i> Tambah Peran
                </button>
                <div class="card">
                    <div class="card-body">
                        <table id="table-1" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Role</th>
                                    <th>Tipe</th>
                                    <th>Aplikasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td style="width: 5%">{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        {{-- <div class="badge badge-{{ $role->guard_name == 'web' ? 'dark' : 'light'}}"> --}}
                                        {{ $role->guard_name}}
                                        {{-- </div> --}}
                                    </td>
                                    <td>{{ $role->application ?  ucwords($role->application->name) : 'Super admin' }}</td>
                                    <td>
                                        <div class="dropdown d-inline">
                                            <button class="btn  btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Aksi
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item has-icon" href="#" data-toggle="modal" data-target="#editModal{{ $role->id}}"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                <form id="delete-form-{{$role->id}}" action="{{ route('role.destroy', $role->id) }}" method="POST" style="display: none;">
                                                    @method('delete')
                                                    @csrf
                                                </form>
                                                <a class="dropdown-item has-icon" href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{$role->id}}').submit();"><i class="fas fa-trash"></i> Hapus</a>
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
                <form action="{{ route('role.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Peran <i><small class="required-label"></small></i>
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
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($roles as $role)
    <div class="modal fade" id="editModal{{ $role->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data {{ $title ?? ''}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('role.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>role Name <i><small class="required-label"></small></i>
                            </label>
                            <input type="text" name="name" class="form-control" value="{{ $role->name }}" required="">
                        </div>
                        <div class="form-group">
                            <label>Guard Name <i><small class="required-label"></small></i>
                            </label>
                            <select class="form-control selectric" name="guard_name">
                                <option value="web" {{ $role->guard_name=='web' ? 'selected' : ''}}>web</option>
                                <option value="api" {{ $role->guard_name=='api' ? 'selected' : ''}}>api</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Aplikasi <i><small class="required-label"></small></i>
                            </label>
                            <select class="form-control selectric" name="application_id">
                                <option selected disabled>-- pilih --</option>
                                @foreach($applications as $app)
                                <option value="{{ $app->id }}" {{ $role->application_id == $app->id ? 'selected' : ''}}>{{$app->name}}</option>
                                @endforeach
                                <option value="" {{ $role->application_id == '' ? 'selected' : ''}}>super admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
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
