<x-app-layout title="{{ $title ?? 'detail pengguna'}}">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('user.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Detail Peran Pengguna</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Modules</a></div>
                <div class="breadcrumb-item">Calendar</div>
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
                        <div class="card-header">
                            @foreach($applications as $app)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input app-checkbox" type="checkbox" id="app_{{ $app->id }}" value="{{ $app->id}}" data-appid="{{ $app->id }}">
                                <label class="form-check-label" for="app_{{ $app->id }}">
                                    <h4>{{ ucwords($app->name) }}</h4>
                                </label>
                            </div>
                            @endforeach

                        </div>
                        <div class="card-body">
                            @foreach($applications as $app)
                            <table class="table table-bordered role-table" id="roleTable_{{ $app->id}}" style="display:none;">
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
                                                <input class="form-check-input" type="checkbox" value="{{ $role->id }}" id="role_{{ $role->id }}" @if(isset($userRoles[$role->id]) && $userRoles[$role->id]) checked @endif>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
    </section>

    @push('js-spesific')
    <script>
        $(document).ready(function() {
            $('.app-checkbox').on('change', function() {
                $('.app-checkbox').not(this).prop('checked', false);
            });
        });

    </script>

    <script>
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

    </script>

    @endpush
</x-app-layout>
