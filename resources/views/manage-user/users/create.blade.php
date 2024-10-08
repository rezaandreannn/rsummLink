<x-app-layout title="{{$title ?? 'Tambah Pengguna'}}">
    <x-section.section>
        <x-section.header :title="$title" :button="false" :variable="$breadcrumbs" :backButton="true" :backUrl="route('user.index')" />

        <div class="section-body">
            <h2 class="section-title">{{$title ?? ''}}</h2>
            <p class="section-lead">
                Di halaman ini Anda dapat membuat pengguna baru dan mengisi semua kolom.
            </p>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('user.store')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Pengguna<code>*</code></label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name" value={{old('name')}}>
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Lengkap<code>*</code></label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value={{ old('full_name')}}>
                                        @error('full_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email<code>*</code></label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email')}}">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No HP<code>*</code></label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone')}}">
                                        @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kata sandi<code>*</code></label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                        @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Ulangi kata sandi<code>*</code></label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="password" class="form-control  @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                                        @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
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
    @endpush
</x-app-layout>
