<x-app-layout title='{{ $title }}'>
    <x-section.section>
        <x-section.header :title="$title" :button="true" routeAdd="menu.create" :variable="$breadcrumbs" />
    </x-section.section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Semua Data Main Menu</h4>
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
                                    @foreach($menus as $menu)
                                    <tr>
                                        <td style="width: 5%">{{ $loop->iteration }}</td>
                                        <td>{{ $menu->name }}</td>
                                        <td>{{ $menu->route ?? '#' }}</td>
                                        <td>
                                            <div class="badge badge-{{ isset($menu->application->name) ? 'success' : 'dark'}}">
                                                {{$menu->application ? ucwords($menu->application->name) : 'Super admin'}}
                                            </div>
                                        </td>
                                        <td>{{ $menu->permission ? $menu->permission->name : '' }}</td>
                                        <td>
                                            <div class="dropdown d-inline">
                                                <x-button.action-button />
                                                <div class="dropdown-menu">
                                                    @if(empty($menu->route))
                                                    <a class="dropdown-item has-icon" href="{{ route('menu.show', $menu->id)}}"><i class="fas fa-bars"></i> SubMenu</a>
                                                    @endif
                                                    <x-button.edit-button route="menu.edit" :id="$menu->id" />
                                                    <x-button.delete-button route="menu.destroy" :id="$menu->id" />
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
                <form action="{{ route('menu.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Menu <i><small class="required-label"></small></i>
                            </label>
                            <input type="text" name="name" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label>Rute <i><small class="required-label"></small></i>
                            </label>
                            <input type="text" name="route" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label for="icon">Pilih Ikon:</label>
                            <select id="icon" class="form-control select2" name="icon">
                                @foreach($icons as $icon)
                                <option value="{{ $icon->class }}">{{$icon->label}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nama Aplikasi <i><small class="required-label"></small></i>
                            </label>
                            <select class="form-control selectric" name="application_id">
                                <option selected disabled>-- pilih --</option>
                                @foreach($applications as $app)
                                <option value="{{ $app->id}}">{{$app->name}}</option>
                                @endforeach
                                <option value="0">super admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Perizinan <i><small class="required-label"></small></i>
                            </label>
                            <select class="form-control" name="permission_id">
                                {{-- <option value="web" selected>web</option>
                                <option value="api">api</option> --}}
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
    <script src="{{ asset('stisla/assets/js/page/forms-advanced-forms.js')}}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{ asset('js/delete-confirm.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('select[name="application_id"]').selectric().on('change', function() {
                var applicationId = $(this).val();
                if (applicationId) {
                    $.ajax({
                        url: '{{ route("permissions.get", ":id") }}'.replace(':id', applicationId)
                        , type: "GET"
                        , dataType: "json"
                        , success: function(data) {
                            var $permissionSelect = $('select[name="permission_id"]');
                            $permissionSelect.empty();
                            $.each(data, function(key, value) {
                                $permissionSelect.append('<option value="' + key + '">' + value + '</option>');
                            });
                            $permissionSelect.selectric('refresh');
                        }
                    });
                } else {
                    var $permissionSelect = $('select[name="permission_id"]');
                    $permissionSelect.empty();
                    $permissionSelect.selectric('refresh');
                }
            });
        });

    </script>

    @endpush
</x-app-layout>
