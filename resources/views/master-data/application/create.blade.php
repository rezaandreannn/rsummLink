<x-app-layout title="{{ $title ?? 'Buat aplikasi baru'}}">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('aplikasi.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Buat Aplikasi Baru</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Aplikasi</a></div>
                <div class="breadcrumb-item">Buat Aplikasi Baru</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Buat Aplikasi Baru</h2>
            <p class="section-lead">
                On this page you can create a new post and fill in all fields.
            </p>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Write Your Post</h4>
                        </div>
                        <form action="{{ route('menu.store')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Aplikasi</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Prefix</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="route">
                                        <span class="text-sm">tidak boleh pakai spasi</span>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar</label>
                                    <div class="col-sm-12 col-md-7">
                                        <img class="img-preview mb-2" style="width: 300px">
                                        <input class="form-control d-block @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="Live()">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select id="icon" class="form-control select2" name="icon">
                                            @foreach($statuses as $status)
                                            <option value="{{ $status }}">{{$status}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
                                    <div class="col-sm-12 col-md-7">
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button class="btn btn-primary" type="submit">Buat Aplikasi</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>


    {{-- css library --}}
    @push('css-libraries')
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/selectric/public/selectric.css')}}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/select2/dist/css/select2.min.css') }}" />
    @endpush

    @push('js-libraries')
    <script src="{{ asset('stisla/node_modules/selectric/public/jquery.selectric.min.js')}}"></script>
    <script src="{{ asset('stisla/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    @endpush


    @push('js-spesific')
    <!-- Page Specific JS File -->
    <script src="{{ asset('stisla/assets/js/page/forms-advanced-forms.js')}}"></script>
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

    <script>
        function Live() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            console.log(imgPreview)

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);


            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;

            }
        }

    </script>
    @endpush
</x-app-layout>
