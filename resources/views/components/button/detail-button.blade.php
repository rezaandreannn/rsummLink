@props([
'route' => '',
'id' => '',
'title' => 'Detail'
])
<a class="dropdown-item has-icon" href="{{ route($route, $id)}}"><i class="fas fa-info-circle"></i> {{ $title }}</a>
