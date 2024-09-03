<x-app-layout title="{{ $title }}">
    <x-section.section>
        <x-section.header :title="$title" :button="true" buttonType="modal" :variable="$breadcrumbs" />
    </x-section.section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Semua Data</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-1" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        @foreach($theads as $th)
                                        <th>{{ $th }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                    <tr>
                                        <td style="width: 5%">{{ $loop->iteration }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            {{ $role->guard_name}}
                                        </td>
                                        <td>{{ $role->application ?  ucwords($role->application->name) : 'Super admin' }}</td>
                                        <td>
                                            <div class="dropdown d-inline">
                                                <x-button.action-button />
                                                <div class="dropdown-menu">
                                                    @if(isset($role->application_id))
                                                    <a class="dropdown-item has-icon" href="#" data-toggle="modal" data-target="#perizinan{{ $role->id}}"><i class="fas fa-key"></i> Perizinan</a>
                                                    @endif
                                                    <x-button.edit-button :id="$role->id" modal="true" />
                                                    <x-button.delete-button route="role.destroy" :id="$role->id" />
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
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data {{ $title ?? ''}}</h5>
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
                                {{-- <option value="">super admin</option> --}}
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
                            <label>Nama Peran <i><small class="required-label"></small></i>
                            </label>
                            <input type="text" name="name" class="form-control" value="{{ $role->name }}" required="">
                        </div>
                        <div class="form-group">
                            <label>Tipe <i><small class="required-label"></small></i>
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
                                {{-- <option value="" {{ $role->application_id == '' ? 'selected' : ''}}>super admin</option> --}}
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

    @foreach ($roles as $role)
    <div class="modal fade" id="perizinan{{ $role->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Perizinan dari peran : {{$role->name}}({{isset($role->application) ? $role->application->name : ''}})</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Nama Perizinan</th>
                                <th class="text-center">Hak Akses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($permissions[$role->application_id]) && count($permissions[$role->application_id]) > 0)
                            @foreach($permissions[$role->application_id] as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td class="text-center">
                                    <div class="form-check custom-checkbox custom-control">
                                        <input class="form-check-input" type="checkbox" name="rolePermission" roleId="{{$role->id}}" value="{{$permission->id}}" id="defaultCheck1" {{checkRolePermission($role->id, $permission->id) ? 'checked' : '' }}>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon btn-danger" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    {{-- <button type="submit" class="btn btn-primary">Simpan</button> --}}
                </div>

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

    @push('js-spesific')
    <script>
        $(document).ready(function() {
            $('input[name="rolePermission"]').change(function() {
                var checkbox = $(this);
                var permissionId = checkbox.val();
                var roleId = $(this).attr('roleId');
                var status = $(this).is(':checked');
                var action = ""


                if (status) {
                    action = "insert"
                } else {
                    action = "delete"
                }

                $.ajax({
                    url: '{{ route("role.permission.manage") }}'
                    , method: 'GET'
                    , data: {
                        roleId: roleId
                        , permissionId: permissionId
                        , action: action
                    }
                    , success: function(response) {
                        console.log(response)
                        Swal.fire({
                            position: 'top-end'
                            , toast: true
                            , icon: 'success'
                            , title: 'sukses!'
                            , text: response.message
                            , showConfirmButton: false
                            , timer: 3000
                            , timerProgressBar: true
                            , backgroundColor: '#28a745'
                            , titleColor: '#fff'
                        , })
                    }
                    , error: function(error) {
                        console.error(error);
                    }
                });
            });
        });

    </script>

    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{ asset('js/delete-confirm.js') }}"></script>


    @endpush
</x-app-layout>
