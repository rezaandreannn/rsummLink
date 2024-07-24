<x-app-layout title="{{ $title ?? 'Buat Mapping'}}">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Mapping</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Master Data</a></div>
                <div class="breadcrumb-item">Buat Mapping</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Buat Mapping</h2>
            <p class="section-lead">
                Silahkan isi semua kolom berikut untuk membuat Mapping.
            </p>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <code data-toggle="tooltip" title="Fields marked with (*) are required">*</code> Wajib diisi
                            </h4>
                        </div>
                        <form action="{{ route('encounter.mapping.store')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Practitioner<code>*</code></label>
                                    <div class="col-sm-12 col-md-7">
                                        <select id="practitioner_id" class="form-control select2" name="practitioner_id">
                                            @foreach($practitioners as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Organization<code>*</code></label>
                                    <div class="col-sm-12 col-md-7">
                                        <select id="organization_id" class="form-control select2" name="organization_id">
                                            @foreach($organizations as $name => $id)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                                </select>
                            </div>
                    </div> --}}
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Location<code>*</code></label>
                        <div class="col-sm-12 col-md-7">
                            <select id="location_id" class="form-control select2" name="location_id">
                                @foreach($locations as $name => $id)
                                <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pelayanan<code>*</code></label>
                        <div class="col-sm-12 col-md-7">
                            <select id="cara_masuk" class="form-control selectric" name="cara_masuk">
                                @foreach($pelayanans as $key => $value)
                                <option value="{{ $value }}">{{ $key }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary" type="submit">Simpan</button>
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

    @endpush
</x-app-layout>
