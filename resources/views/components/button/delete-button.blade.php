 @props([
 'userId' => ''
 ])

 <form id="delete-form-{{$userId}}" action="{{ route('user.destroy', $userId) }}" method="POST" style="display:none;">
     @method('delete')
     @csrf
 </form>
 <a class="dropdown-item has-icon" confirm-delete="true" data-userId="{{$userId}}" href="#"><i class="fas fa-trash"></i> Hapus</a>
