<x-app-layout title="Role">
    <section class="section">
        <div class="section-header">
            <h1>Data Role</h1>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
                    <i class="ion ion-plus"> </i> Tambah Role
                </button>
                <div class="card">
                    <div class="card-body">
                        <table id="table-1" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Role</th>
                                    <th>Tipe</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td style="width: 5%">{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <div class="badge badge-{{ $role->guard_name == 'web' ? 'dark' : 'light'}}">
                                            {{ $role->guard_name}}
                                        </div>
                                    </td>
                                    {{-- <td> --}}
                                    {{-- <button type="button" class="badge border-0
                                             @if($role->permissions->count() > 1)
                                                    badge-primary
                                                @elseif($role->permissions->count() == 1)
                                                    badge-success
                                                @else
                                                    badge-danger
                                                @endif" data-toggle="modal" data-target="#changePermission{{ $role->permissions->count() > 1 ? $role->id : ''}}">
                                    @if($role->permissions->count() > 1)
                                    {{$role->permissions->count()}} Permission
                                    @elseif($role->permissions->count() == 1)
                                    {{ $role->permissions[0]->name }}
                                    @else
                                    Not Permissions
                                    @endif
                                    </button> --}}
                                    {{-- </td> --}}

                                    <td>
                                        <x-button-edit href="{{ route('admin.role.edit', $role->id) }}" />
                                        <x-button-delete action="{{ route('admin.role.destroy', $role->id) }}" />
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
                <form action="{{ route('admin.role.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Role <i><small class="required-label"></small></i>
                            </label>
                            <input type="text" name="name" class="form-control" required="">
                            <div class="valid-feedback">

                            </div>
                            <div class="invalid-feedback">
                                <i>Input Role name wajib diisi.</i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tipe<i><small class="required-label"></small></i>
                            </label>
                            <select class="form-control select2" name="guard_name">
                                <option value="web" selected>web</option>
                                <option value="api">api</option>
                            </select>

                            <div class="valid-feedback">

                            </div>
                            <div class="invalid-feedback">
                                <i>Input guard name wajib diisi.</i>
                            </div>
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



    {{-- css library --}}
    @push('css-libraries')
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">

    <link rel="stylesheet" href="{{ asset('stisla/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/select2/dist/css/select2.min.css') }}" />
    @endpush

    @push('js-libraries')
    <script src="{{ asset('stisla/node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('stisla/assets/js/page/modules-datatables.js')}}"></script>
    @include('sweetalert::alert')

    @endpush
</x-app-layout>
