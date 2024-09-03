<x-app-layout title="{{ $title ?? ''}}">
    <x-section.section>
        <x-section.header :title="$title" :button="false" :variable="$breadcrumbs" :backButton="true" :backUrl="route('menu.index')" />

        <div class="section-body">
            <h2 class="section-title">{{ $title ?? ''}}</h2>
            <p class="section-lead">
                Di halaman ini Anda dapat membuat menu baru dan mengisi semua kolom.
            </p>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('menu.store')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Menu</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Rute</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="route">
                                        <span class="text-sm">bisa dikosongkan jika menu memiliki submenu</span>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pilih Icon</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select id="icon" class="form-control select2" name="icon">
                                            @foreach($icons as $icon)
                                            <option value="{{ $icon->class }}">{{$icon->label}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pilih Aplikasi</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select class="form-control selectric" name="application_id">
                                            <option selected disabled>-- pilih --</option>
                                            @foreach($applications as $app)
                                            <option value="{{ $app->id}}">{{$app->name}}</option>
                                            @endforeach
                                            <option value="0">super admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pilih Perizinan</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select class="form-control" name="permission_id">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Urut</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="number" class="form-control" name="serial_number">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <x-button.save-button action="create" />
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
    @endpush
</x-app-layout>
