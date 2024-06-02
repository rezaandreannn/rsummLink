 <div class="main-sidebar sidebar-style-2">
     <aside id="sidebar-wrapper">
         <div class="sidebar-brand">
             <a href="index.html">{{ $app }}</a>
         </div>
         <div class="sidebar-brand sidebar-brand-sm">
             <a href="index.html">{{$initialApp}}</a>
         </div>
         <ul class="sidebar-menu">
             <li class="menu-header">{{$app}}</li>
             @foreach($menus as $menu)
             <li class="{{ $menu->route == '' ? 'nav-item dropdown' : ''}}">
                 <a href="{{ Route::has($menu->route) ? route($menu->route) : '#'}}" class="nav-link {{ $menu->route == '' ? 'has-dropdown' : ''}}"><i class="fas fa-fire"></i><span>{{$menu->name}}</span></a>
                 @if(isset($menuItemsByMenuId[$menu->id]) && count($menuItemsByMenuId[$menu->id]) > 0)
                 <ul class="dropdown-menu">
                     @foreach($menuItemsByMenuId[$menu->id] as $menuItem)
                     <li><a class="nav-link" href="{{ Route::has($menuItem->route) ? route($menuItem->route) : ''}}">{{ $menuItem->name }}</a></li>
                     @endforeach
                 </ul>
                 @endif
             </li>
             @endforeach
         </ul>

         <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
             <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                 <i class="fas fa-rocket"></i> Documentation
             </a>
         </div>
     </aside>
 </div>
