<x-app-layout title="{{ $title ?? 'detail pengguna'}}">
    <x-section.section class="section">
        <x-section.header :title="$title" :button="false" :variable="$breadcrumbs" :backButton="true" :backUrl="route('user.index')" />

        <div class="section-body">
            <h2 class="section-title">{{$user->full_name ?? 'Kosong'}}</h2>
            <p class="section-lead">
                {{$user->email}}
            </p>

            <div class="row">
                <div class="col-12">
                    <div class="card">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-section.section>

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
