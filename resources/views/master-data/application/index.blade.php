<x-app-layout title="{{ $title ?? 'Aplikasi'}}">
    <x-section.section>
        <x-section.header :title="$title" :button="true" routeAdd="aplikasi.create" :variable="$breadcrumbs" />

        <div class="section-body">
            <h2 class="section-title">{{$title ?? 'Aplikasi'}}</h2>
            <p class="section-lead">Menampilkan semua data aplikasi yang ada pada RsummLink.</p>

            <div class="row">
                @foreach($applications as $app)
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <article class="article article-style-b">
                        <div class="article-header">
                            <div class="article-image" data-background="{{ asset('storage/' . $app->image) }}">
                            </div>
                            <div class="article-badge">
                                @switch($app->status)
                                @case('active')
                                <div class="article-badge-item bg-success">
                                    <i class="fas fa-check-circle"></i> Active
                                </div>
                                @break

                                @case('inactive')
                                <div class="article-badge-item bg-danger">
                                    <i class="fas fa-times-circle"></i> Inactive
                                </div>
                                @break

                                @case('maintenance')
                                <div class="article-badge-item bg-warning">
                                    <i class="fas fa-tools"></i> Maintenance
                                </div>
                                @break

                                @default
                                <div class="article-badge-item bg-secondary">
                                    <i class="fas fa-question-circle"></i> Unknown
                                </div>
                                @endswitch
                            </div>
                        </div>
                        <div class="article-details">
                            <div class="article-title">
                                <h2><a href="#">{{ ucwords($app->name)}}<span class="text-secondary" style="font-size: 12px;">({{$app->prefix}})</span></a></h2>

                            </div>
                            <p>{{ $app->description}} </p>
                            <div class="article-cta">
                                <a href="{{ route('aplikasi.edit', $app->id)}}" class="btn btn-sm btn-white"><i class="fas fa-pencil-alt"></i> Edit</a>
                                <a href="#" class="btn btn-sm btn-white"> <i class="fas fa-trash"></i> Hapus</a>
                                {{-- <a href="#">Read More <i class="fas fa-chevron-right"></i></a> --}}
                            </div>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>
        </div>
    </x-section.section>

    @push('js-libraries')
    @include('sweetalert::alert')
    @endpush
</x-app-layout>
