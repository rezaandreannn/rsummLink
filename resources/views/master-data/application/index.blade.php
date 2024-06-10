<x-app-layout title="{{ $title ?? 'Aplikasi'}}">
    <section class="section">
        <div class="section-header">
            <h1>{{$title ?? 'Aplikasi'}}</h1>
            <a href="{{ route('aplikasi.create')}}" class="btn btn-primary ml-1"> <i class="far fa-plus-square"></i> Tambah Data </a>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Master Data</a></div>
                <div class="breadcrumb-item">Aplikasi</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">{{$title ?? 'Aplikasi'}}</h2>
            <p class="section-lead">Menampilkan seluruh aplikasi yang ada pada RsummLink.</p>

            <div class="row">
                @foreach($applications as $app)
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <article class="article article-style-b">
                        <div class="article-header">
                            <div class="article-image" data-background="{{ asset('storage/' . $app->image) }}">
                            </div>
                            <div class="article-badge">
                                <div class="article-badge-item bg-success"><i class="fas fa-fire"></i> {{$app->status ?? ''}}</div>
                            </div>
                        </div>
                        <div class="article-details">
                            <div class="article-title">
                                <h2><a href="#">{{ ucwords($app->name)}}</a></h2>
                            </div>
                            <p>{{ $app->description}} </p>
                            <div class="article-cta">
                                <a href="{{ route('aplikasi.edit', $app->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i> Edit</a>
                                <a href="#" class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i> Hapus</a>
                                {{-- <a href="#">Read More <i class="fas fa-chevron-right"></i></a> --}}
                            </div>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    @push('js-libraries')
    @include('sweetalert::alert')
    @endpush
</x-app-layout>
