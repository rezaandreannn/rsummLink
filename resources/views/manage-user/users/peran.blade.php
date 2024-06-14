<x-app-layout title="{{ $title ?? 'detail pengguna'}}">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('user.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Detail Peran Pengguna</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Pengguna</a></div>
                <div class="breadcrumb-item">Detail</div>
            </div>
        </div>


        <div class="content">
            <h2 class="section-title">{{$user->full_name ?? ''}}</h2>
            <p class="section-lead">
                menampilkan semua peran dari semau aplikasi
            </p>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{-- <div class="card-header"> --}}
                        {{-- @foreach($applications as $app)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input app-checkbox" type="checkbox" id="app_{{ $app->id }}" value="{{ $app->id}}" data-appid="{{ $app->id }}">
                        <label class="form-check-label" for="app_{{ $app->id }}">
                            <h4>{{ ucwords($app->name) }}</h4>
                        </label>
                    </div>
                    @endforeach --}}

                    {{-- </div> --}}
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="header-table">
                                    <tr>
                                        @foreach($applications as $app)
                                        <th class="text-white">{{ ucwords($app->name) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $maxRolesCount = 0;
                                    foreach ($roles as $appId => $appRoles) {
                                    $maxRolesCount = max($maxRolesCount, count($appRoles));
                                    }
                                    @endphp
                                    @for ($i = 0; $i < $maxRolesCount; $i++) <tr>
                                        @foreach($applications as $app)
                                        <td scope="row">
                                            @if(isset($roles[$app->id][$i]))
                                            @php
                                            $role = $roles[$app->id][$i];
                                            $isChecked = isset($userRoles[$role->id]) && $userRoles[$role->id];
                                            @endphp
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="userRole" value="{{ $role->id }}" id="role_{{ $role->id }}" userId="{{ $user->id }}" @if($isChecked) checked @endif>
                                                <label class="custom-control-label" for="role_{{ $role->id }}">{{ ucwords($role->name) }}</label>
                                            </div>
                                            @endif
                                        </td>
                                        @endforeach
                                        </tr>
                                        @endfor
                                </tbody>
                            </table>


                            {{-- @foreach($applications as $app)
                            <ul class="list-group list-group-flush role-table table" id="roleTable_{{ $app->id}}" style="display:none;">
                            @foreach($roles[$app->id] as $role)
                            <li class=" list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="userRole" value="{{ $role->id }}" id="role_{{ $role->id }}" @if(isset($userRoles[$role->id]) && $userRoles[$role->id]) checked @endif>
                                    <label class="custom-control-label" for="role_{{ $role->id }}"> {{ ucwords($role->name)}}</label>
                                </div>
                            </li>
                            @endforeach

                            </ul> --}}
                            {{-- <table class="table table-bordered role-table" id="roleTble_{{ $app->id}}" style="display:none;">
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
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="userRole" value="{{ $role->id }}" id="role_{{ $role->id }}" userId="{{ $user->id }}" @if(isset($userRoles[$role->id]) && $userRoles[$role->id]) checked @endif>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="userRole" value="{{ $role->id }}" id="role_{{ $role->id }}" @if(isset($userRoles[$role->id]) && $userRoles[$role->id]) checked @endif>
                                            <label class="custom-control-label" for="role_{{ $role->id }}">Check this custom checkbox</label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table> --}}
                            {{-- @endforeach --}}
                        </div>
                    </div>
                </div>
            </div>
    </section>

    @push('css-spesific')
    <style>
        .header-table {
            background-color: #6777ef;
            border-color: #6777ef;

        }

    </style>
    @endpush

    @push('js-spesific')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    {{-- <script>
        $(document).ready(function() {
            $('.app-checkbox').on('change', function() {
                $('.app-checkbox').not(this).prop('checked', false);
            });
        });

    </script> --}}

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            var checkboxes = document.querySelectorAll('.app-checkbox');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var appId = this.getAttribute('data-appid');
                    var roleTable = document.getElementById('roleTable_' + appId);

                    // Hide all role tables first
                    var allRoleTables = document.querySelectorAll('.role-table');
                    allRoleTables.forEach(function(table) {
                        table.style.display = 'none';
                    });

                    // Show the related role table if checked
                    if (this.checked) {
                        roleTable.style.display = 'table';
                    }
                });
            });
        });

    </script> --}}

    <script>
        $(document).ready(function() {
            $('.custom-control-input').change(function() {
                var checkbox = $(this);
                var roleId = checkbox.val();
                var userId = $(this).attr('userId');
                var status = $(this).is(':checked');
                var action = ""



                if (status) {
                    action = "insert"
                } else {
                    action = "delete"
                }

                $.ajax({
                    url: '{{ route("user.role") }}'
                    , method: 'GET'
                    , data: {
                        roleId: roleId
                        , userId: userId
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

    @endpush
</x-app-layout>
