<x-app-layout>
    <section class="section">
        <div class="section-header">
            <h1>Form Edit Data Role</h1>
        </div>

    </section>
    <section class="content-header">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <form action="{{ route('admin.role.update', $role->id)}}" method="POST" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="card-body">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Role</label>
                                <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukan kredensial" value="{{ old('name', $role->name)}}">
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Guard Name</label>
                                <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="guard_name">
                                            <option value="web" {{ $role->guard_name=='web' ? 'selected' : ''}}>web</option>
                                            <option value="api" {{ $role->guard_name=='api' ? 'selected' : ''}}>api</option>   
                                        </select>
                                </div>
                            </div>
                           
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

    </section>

    {{-- css library --}}
    @push('css-libraries')
    {{-- <link rel="stylesheet" href="{{ asset('stisla/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
    --}}
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/select2/dist/css/select2.min.css') }}" />
    @endpush

    @push('js-libraries')
    {{-- <script src="{{ asset('stisla/node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script> --}}
    <script src="{{ asset('stisla/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    @include('sweetalert::alert')

    <script src="{{ asset('adminLTE/plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>

    <script>
        $(function() {
            $('#select2insidemodal').select2({
                dropdownParent: $('#editModal')
            });
        });
    </script>
    @endpush


</x-app-layout>