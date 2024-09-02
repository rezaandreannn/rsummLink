 @props([
 'route' => '',
 'id' => '',
 'title' => 'Edit',
 'modal' => false
 ])

 @switch($modal)
 @case(false)
 <a class="dropdown-item has-icon" href="{{ route($route , $id)}}"><i class="fas fa-pencil-alt"></i> {{ $title }}</a>
 @break
 @case(true)
 <a class="dropdown-item has-icon" href="#" data-toggle="modal" data-target="#editModal{{ $id }}"><i class="fas fa-pencil-alt"></i> Edit</a>
 @default

 @endswitch
