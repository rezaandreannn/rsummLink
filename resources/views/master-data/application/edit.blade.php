<x-app-layout title="{{ $title ?? 'Ubah aplikasi'}}">
    <x-section.section>
        <x-section.header :title="$title" :button="false" :variable="$breadcrumbs" :backButton="true" :backUrl="route('aplikasi.index')" />


        <div class="section-body">
            <h2 class="section-title">{{ $title }}</h2>
            <p class="section-lead">
                Di halaman ini Anda dapat mengubah aplikasi.
            </p>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('aplikasi.update', $application->id)}}" method="POST" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="card-body">
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Aplikasi<code>*</code></label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $application->name)}}">
                                    </div>
                                </div>
                                {{-- <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Prefix</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="route">
                                        <span class="text-sm">tidak boleh pakai spasi</span>
                                    </div>
                                </div> --}}
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar</label>
                                    <div class="col-sm-12 col-md-7">
                                        @if($application->image)
                                        <img src="{{ asset('storage/' . $application->image) }}" class="img-preview mb-2 d-block" style="width: 300px">
                                        @else
                                        <img class="img-preview mb-2" style="width: 300px">
                                        @endif
                                        <input type="hidden" value="{{ $application->image }}" name="oldImage">
                                        <input class="form-control d-block @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="Live()">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status<code>*</code></label>
                                    <div class="col-sm-12 col-md-7">
                                        <select id="icon" class="form-control selectric" name="status">
                                            @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ $status == $application->status ? 'selected' : ''}}>{{$status}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
                                    <div class="col-sm-12 col-md-7">
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="description">{{ $application->description ?? ''}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <x-button.save-button action="update" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-section.section>


    {{-- css library --}}
    @push('css-libraries')
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/selectric/public/selectric.css')}}">
    {{-- <link rel="stylesheet" href="{{ asset('stisla/node_modules/select2/dist/css/select2.min.css') }}" /> --}}
    @endpush

    @push('js-libraries')
    <script src="{{ asset('stisla/node_modules/selectric/public/jquery.selectric.min.js')}}"></script>
    {{-- <script src="{{ asset('stisla/node_modules/    select2/dist/js/select2.full.min.js') }}"></script> --}}
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
