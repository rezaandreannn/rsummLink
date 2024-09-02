@props([
'userId' => '',
'title' => 'Detail'
])
<a class="dropdown-item has-icon" href="{{ route('user.show', $userId)}}"><i class="fas fa-info-circle"></i> {{ $title }}</a>
