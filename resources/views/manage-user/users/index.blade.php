<x-app-layout title="{{ $title ?? 'Pengguna'}}">
    <x-section.section>
        <x-section.header :title="$title" :button="true" :variable="$breadcrumbs" />
    </x-section.section>

    <x-section.section class="content">
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
                                        <th></th>
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
                                            <i id="toggle-icon-{{ $user->id }}" class="fas {{ $user->status == 'aktif' ? 'fa-toggle-on text-success' : 'fa-toggle-off text-danger' }} toggle-status" data-id="{{ $user->id }}" data-status="{{ $user->status }}" style="cursor: pointer;"></i>
                                        </td>
                                        <td>
                                            <div class="dropdown d-inline">
                                                {{-- <button class="btn  btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button> --}}
                                                <a href="#" class="text-secondary" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item has-icon" href="{{ route('user.show', $user->id)}}"><i class="fas fa-info-circle"></i> Detail</a>
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
    </x-section.section>
    {{-- <section class="content">
    </section> --}}


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
