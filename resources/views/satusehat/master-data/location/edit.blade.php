<x-app-layout title="{{ $title ?? 'Buat Location'}}">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Buat Location</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Master Data</a></div>
                <div class="breadcrumb-item">Buat Location</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Buat Location</h2>
            <p class="section-lead">
                On this page you can create a new post and fill in all fields.
            </p>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>(<code>*</code>) Wajib diisi</h4>
                        </div>
                        <form action="{{ route('organization.store')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Identifier<code>*</code></label>
                                            <input type="text" class="form-control" name="identifier">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Name<code>*</code></label>
                                            <input type="text" class="form-control" name="name">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Physical Type<code>*</code></label>
                                            <select id="physical_type" class="form-control select2" name="physical_type">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Managing Organization</label>
                                            <select id="managing_organization" class="form-control select2" name="managing_organization">
                                                <option value="">dfs</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Part Of</label>
                                            <select id="part_of" class="form-control select2" name="part_of">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="submit">Buat Location</button>
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