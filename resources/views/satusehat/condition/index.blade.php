<x-app-layout title="{{ $title ?? 'condition'}}">
    <section class="section">
        <div class="section-header">
            <h1>
                @if(request()->get('status') == '1')
                Condition Terkirim
                @elseif(request()->get('status') == '0')
                Condition Tertunda
                @else
                Condition
                @endif
            </h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Condition</a></div>
                @if(request()->get('status') == '1')
                <div class="breadcrumb-item">Terkirim </div>
                @elseif(request()->get('status') == '0')
                <div class="breadcrumb-item">Tertunda </div>
                @else
                @endif
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Transaksi condition
                            @if(request()->get('status') == '1')
                            Condition Terkirim
                            @elseif(request()->get('status') == '0')
                            Condition Tertunda
                            @else
                            Semua
                            @endif
                            .</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('condition.index')}}" method="get">
                            <div class="row justify-content-end">
                                <div class="col-12 col-md-2">
                                    <div class="form-group">
                                        <input type="date" class="form-control" id="created_at" name="created_at" value="{{ old('created_at', request()->get('created_at')) }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <select id="status" class="form-control selectric" name="status">
                                            <option selected disabled>Status</option>
                                            <option value="1" {{ request()->get('status') == '1' ? 'selected' : ''}}>Terkirim</option>
                                            <option value="0" {{ request()->get('status') == '0' ? 'selected' : ''}}>Tertunda</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="table-1" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Registrasi</th>
                                        <th>Condition ID</th>
                                        <th>Kode Diagnosa</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($conditions as $value)
                                    <tr>
                                        <td style="width: 5%">{{$loop->iteration}}</td>
                                        <td>{{$value->kode_register}}</td>
                                        <td>{{$value->condition_id}}</td>
                                        <td>{{$value->kode_diagnosa}}</td>
                                        <td>
                                            @if($value->status == 1)
                                            <div class="badge badge-success">
                                                Terkirim
                                            </div>
                                            @else
                                            <div class="badge badge-warning">
                                                Tertunda
                                            </div>
                                            @endif
                                        </td>
                                        <td>{{$value->created_by}}</td>
                                        <td>{{$value->created_at}}</td>
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


    <script>
        $(document).ready(function() {
            $('#created_at, #status').on('change', function() {
                $(this).closest('form').submit();
            });
        });

    </script>

    @endpush
</x-app-layout>
