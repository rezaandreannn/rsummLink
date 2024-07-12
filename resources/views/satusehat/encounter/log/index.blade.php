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
                                            <span class="badge badge-success">{{$logTransaction->status}}</span>
                                            @elseif($logTransaction->status == 400)
                                            <span class="badge badge-danger">{{$logTransaction->status}}</span>
                                            @else
                                            <span class="badge badge-secondary">{{$logTransaction->status}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <pre>{{ json_encode(json_decode($logTransaction->message), JSON_PRETTY_PRINT) }}</pre>
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
    <script src="{{ asset('stisla/node_modules/selectric/public/jquery.selectric.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('stisla/assets/js/page/modules-datatables.js')}}"></script>
    @include('sweetalert::alert')
    @endpush

    @push('js-spesific')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>


    @endpush
</x-app-layout>
