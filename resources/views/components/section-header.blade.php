@props([
'title' => 'Default Title',
'button' => false,
'backButton' => false,
'backUrl' => '',
'variable' => []
])

<section class="section">
    <div class="section-header">
        @if($backButton)
        <div class="section-header-back">
            <a href="{{ $backUrl ?: 'javascript:history.back()' }}" class="btn btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        @endif

        <h1>{{ $title }}</h1>

        @if($button)
        <a href="{{ route('user.create') }}" class="btn btn-primary ml-1">
            <i class="far fa-plus-square"></i> Tambah Data
        </a>
        @endif

        <div class="section-header-breadcrumb">
            @forelse($variable as $key => $value)
            <div class="breadcrumb-item active">
                @if($value)
                <a href="{{ $value }}">{{ $key }}</a>
                @else
                {{$key}}
                @endif
            </div>
            @empty
            {{-- If $variable is empty, you can add a fallback here if needed --}}
            @endforelse
        </div>
    </div>
</section>
