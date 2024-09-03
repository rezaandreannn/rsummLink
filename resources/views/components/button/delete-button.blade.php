 @props([
 'route' => '',
 'id' => ''
 ])

 <form id="delete-form-{{ $id }}" action="{{ route($route, $id) }}" method="POST" style="display:none;">
     @method('delete')
     @csrf
 </form>
 <a class="dropdown-item has-icon" confirm-delete="true" data-id="{{ $id }}" href="#"><i class="fas fa-trash"></i> Hapus</a>
