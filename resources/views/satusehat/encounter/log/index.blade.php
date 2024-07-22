<x-app-layout title="{{ $title ?? 'Log transaksi Encounter'}}">
    <section class="section">
        <div class="section-header">
            <h1>{{$title ?? 'Log'}}</h1>
            {{-- <a href="{{ route('encounter.mapping.create')}}" class="btn btn-primary ml-1"> <i class="far fa-plus-square"></i> Tambah Data </a> --}}
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Encounter</a></div>
                <div class="breadcrumb-item">Log Transaksi </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Log Transaksi Encounter.</h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-end">
                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="created_at">
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <select id="status" class="form-control selectric" name="status">
                                        <option value="">pilih status</option>
                                        <option value="">sukses</option>
                                        <option value="">gagal</option>
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="table-responsive">
                            <table id="table-1" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Registrasi</th>
                                        <th>Status</th>
                                        <th>Message</th>
                                        <th>Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logTransactions as $logTransaction)
                                    <tr>
                                        <td style="width: 5%">{{$loop->iteration}}</td>
                                        <td>{{$logTransaction->registration_id}}</td>
                                        <td>
                                            @if($logTransaction->status == 201)
                                            <span class="btn btn-outline-success btn-sm">201 created</span>
                                            @elseif($logTransaction->status == 400)
                                            <span class="btn btn-outline-danger btn-sm">Gagal</span>
                                            @else
                                            <span></span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-link p-0 ml-3" data-toggle="modal" data-target="#exampleModal{{$logTransaction->id}}">
                                                <i class="fas fa-eye text-primary"></i>
                                            </button>
                                        </td>
                                        <td>{{$logTransaction->created_at}}</td>
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

    <!-- Modal -->
    @foreach($logTransactions as $logTransaction)
    <div class="modal fade" id="exampleModal{{$logTransaction->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Identifier ({{$logTransaction->registration_id}})</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <pre>{{ json_encode(json_decode($logTransaction->message), JSON_PRETTY_PRINT) }}</pre>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
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
    <style>
        .form-group {
            margin-bottom: 0;
        }

        .col-12.col-md-2 {
            padding-left: 0.25rem;
            padding-right: 0.25rem;
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


    @endpush
</x-app-layout>
