 @props([
 'userId' => '',
 'title' => 'Edit'
 ])
 <a class="dropdown-item has-icon" href="{{ route('user.edit', $userId)}}"><i class="fas fa-pencil-alt"></i> {{ $title }}</a>
