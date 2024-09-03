<x-app-layout title="{{ $title ?? 'Pengguna'}}">
    <x-section.section>
        <x-section.header :title="$title" :button="true" routeAdd="user.create" :variable="$breadcrumbs" />
    </x-section.section>

    <x-section.section class="content">
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
                                    @foreach($users as $user)
                                    <tr>
                                        <td style="width: 5%">{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->full_name ?? ''}}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone ?? '' }}</td>
                                        <td class="d-flex align-items-center">
                                            <i id="toggle-icon-{{ $user->id }}" class="fas {{ $user->status == 'aktif' ? 'fa-toggle-on text-success' : 'fa-toggle-off text-danger' }} toggle-status" data-id="{{ $user->id }}" data-status="{{ $user->status }}" style="cursor: pointer;"></i>
                                        </td>
                                        <td>
                                            <div class="dropdown d-inline">
                                                <x-button.action-button />
                                                <div class="dropdown-menu">
                                                    <x-button.detail-button route="user.show" :id="$user->id" />
                                                    <x-button.edit-button route="user.edit" :id="$user->id" />
                                                    <x-button.delete-button route="user.destroy" :id="$user->id" />
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
    </x-section.section>

    {{-- css library --}}
    @push('css-libraries')
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/selectric/public/selectric.css')}}">
    @endpush

    @push('css-spesific')
    <style>
        .toggle-status {
            font-size: 24px;
            cursor: pointer;
            padding: 10px;
        }

    </style>

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
    <script src="{{ asset('js/delete-confirm.js') }}"></script>


    <script>
        $(document).ready(function() {
            $('.form-check-input').on('change', function() {
                $('.form-check-input').not(this).prop('checked', false);
            });
        });

    </script>

    <script>
        $(document).ready(function() {
            $('.toggle-status').click(function() {
                var userId = $(this).data('id');
                var status = $(this).data('status');
                var newStatus = status === 'aktif' ? 'tidak aktif' : 'aktif';

                $.ajax({
                    url: '/user/toggle-status/' + userId
                    , type: 'POST'
                    , data: {
                        _token: '{{ csrf_token() }}'
                        , status: newStatus
                    }
                    , success: function(response) {
                        if (response.success) {
                            if (newStatus === 'aktif') {
                                $('#toggle-icon-' + userId).removeClass('fa-toggle-off text-danger').addClass('fa-toggle-on text-success');
                            } else {
                                $('#toggle-icon-' + userId).removeClass('fa-toggle-on text-success').addClass('fa-toggle-off text-danger');
                            }
                            $('#toggle-icon-' + userId).data('status', newStatus);
                        } else {
                            alert('Failed to update status');
                        }
                    }
                    , error: function() {
                        alert('Failed to update status');
                    }
                });
            });
        });

    </script>

    @endpush
</x-app-layout>
