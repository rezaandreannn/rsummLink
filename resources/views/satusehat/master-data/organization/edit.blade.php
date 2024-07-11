<x-app-layout title="{{ $title ?? 'Ubah Organization'}}">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('organization.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Organization</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Master Data</a></div>
                <div class="breadcrumb-item">Ubah Organization</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Ubah Organization</h2>
            <p class="section-lead">
                Silahkan isi semua kolom berikut untuk memperbarui organization.
            </p>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <code data-toggle="tooltip" title="Fields marked with (*) are required">*</code> Wajib diisi
                            </h4>
                        </div>
                        <form action="{{ route('organization.update', $organization->organization_id)}}" method="POST">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Identifier</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="identifier" value="{{ $identifierValue ?? ''}}">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Name</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="name" value="{{$organization->name}}">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Part Of</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select id="part_of" class="form-control select2" name="part_of">
                                            @foreach($organizations as $name => $id)
                                            <option value="{{ $id }}" {{ $id == $organization->part_of ? 'selected' : ''}}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button class="btn btn-primary" type="submit">Update</button>
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
