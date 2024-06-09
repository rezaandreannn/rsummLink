<x-app-layout title="{{ $title ?? 'Pengguna'}}">
    <section class="section">
        <div class="section-header">
            <h1>{{$title ?? 'Pengguna'}}</h1>
            <a href="{{ route('user.create')}}" class="btn btn-primary ml-1">
                <i class="far fa-plus-square"></i> Tambah Data
            </a>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                {{-- <div class="breadcrumb-item"><a href="#">Pengguna</a></div> --}}
                <div class="breadcrumb-item">Pengguna</div>
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
                                        <th>Nama Pengguna</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>No HP</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td style="width: 5%">{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            {{ $user->full_name ?? ''}}
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone ?? '' }}</td>
                                        <td class="d-flex align-items-center">
                                            {{ $user->status ?? '' }}
                                            <a class="ml-2" href="{{ route('user.edit', $user->id)}}" data-toggle="modal" data-target="#changeStatus{{ $user->id}}">
                                                <i class="fas fa-exchange-alt"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="dropdown d-inline">
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

    @foreach ($users as $user)
    <div class="modal fade" id="changeStatus{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('user.changeStatus', $user->id)}}" method="POST">
                    <div class="modal-body">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label>Plih status <i><small class="required-label"></small></i>
                            </label>
                            <select class="form-control selectric" name="status">
                                <option value="aktif" {{ $user->status == 'aktif' ? 'selected' : ''}}>Aktif</option>
                                <option value="tidak aktif" {{ $user->status == 'tidak aktif' ? 'selected' : ''}}>Tidak Aktif</option>
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

    @foreach ($users as $user)
    <div class="modal fade" id="role{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5>Detail Peran</h5>
                    </div>
                    <div class="modal-body modal-lg">
                        @foreach($applications as $app)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input app-checkbox" type="checkbox" id="app_{{ $app->id }}" value="{{ $app->id}}" data-appid="{{ $app->id }}">
                            <label class="form-check-label" for="app_{{ $app->id }}">{{ $app->name }}</label>
                        </div>
                        <table class="table table-bordered role-table" id="roleTable_{{ $app->id}}_{{$user->id}}" style="display:none;">
                            <thead>
                                <tr>
                                    <th>Nama Peran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles[$app->id] as $role)
                                <tr>
                                    <td>{{$role->name ?? ''}}</td>
                                    <td></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-icon btn-danger" data-dismiss="modal"><i class="fas fa-times"></i></button>
                        {{-- <button type="submit" class="btn btn-primary">Simpan</button> --}}
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

    @push('js-spesific')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

    <script>
        document.querySelectorAll('[confirm-delete="true"]').forEach(function(element) {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                var userId = this.getAttribute('data-userId');
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
                        var form = document.getElementById('delete-form-' + userId);
                        if (form) {
                            form.submit();
                        } else {
                            console.error('Form not found for user ID:', userId);
                        }
                    }
                });
            });
        });

    </script>

    <script>
        $(document).ready(function() {
            $('.form-check-input').on('change', function() {
                $('.form-check-input').not(this).prop('checked', false);
            });
        });

    </script>

    {{-- <script>
        $(document).ready(function() {
            $('.form-check-input').on('change', function() {
                var appId = $(this).val();
                $('table[id^="roleTable_"]').find('tbody').empty(); // Kosongkan isi tabel sebelum memuat data baru
                if (this.checked) {
                    $.ajax({
                        url: '/get-roles/' + appId
                        , type: 'GET'
                        , success: function(response) {
                            var tableBody = $('table[id^="roleTable_"]').find('tbody');
                            $.each(response, function(index, role) {
                                // Tambahkan baris tabel dan centang jika diperlukan
                                var checkboxHtml = isChecked ? 'checked' : '';
                                tableBody.append('<tr><td>' + role.name + '</td><td><div class="form-check"><input class="form-check-input" type="checkbox" value="' + role.id + '" id="role_' + role.id + '"></div></td></tr>');
                            });
                        }
                        , error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });

    </script> --}}

    <!-- Place modal content here -->

    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var checkboxes = document.querySelectorAll('.app-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var appId = this.getAttribute('data-appid');
                    var userId = this.getAttribute('data-userid');
                    var roleTable = document.getElementById('roleTable_' + appId + '_' + userId);
                    if (this.checked) {
                        roleTable.style.display = 'table';
                    } else {
                        roleTable.style.display = 'none';
                    }
                });
            });
        });

    </script>





    @endpush
</x-app-layout>
