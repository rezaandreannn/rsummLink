@props([
'title' => 'Default Title',
'routeAdd' => '',
'buttonType' => 'link', // Bisa 'link' atau 'modal'
'button' => false,
'backButton' => false,
'backUrl' => '',
'variable' => []
])

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
    @if($buttonType === 'link')
    <a href="{{ route($routeAdd) }}" class="btn btn-primary ml-1">
        <i class="far fa-plus-square"></i> Tambah Data
    </a>
    @elseif($buttonType === 'modal')
    <button type="button" class="btn btn-primary ml-1" data-toggle="modal" data-target="#addModal">
        <i class="far fa-plus-square"></i> Tambah Data
    </button>
    @endif
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
        @endforelse
    </div>
</div>
