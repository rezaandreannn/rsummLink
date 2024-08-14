 <div class="main-sidebar sidebar-style-2">
     <aside id="sidebar-wrapper">
         <div class="sidebar-brand">
             <a href="index.html">{{ $app }}</a>
         </div>
         <div class="sidebar-brand sidebar-brand-sm">
             <a href="index.html">{{$initialApp}}</a>
         </div>
         <ul class="sidebar-menu">
             <li class="menu-header">Main Menu</li>
             @foreach($menus as $menu)
             @php
             $isActive = Route::is($menu->route);
             if (isset($menuItemsByMenuId[$menu->id])) {
             foreach ($menuItemsByMenuId[$menu->id] as $menuItem) {
             if (Route::is($menuItem->route)) {
             $isActive = true;
             break;
             }
             }
             }
             @endphp
             <li class="{{ $menu->route == '' ? 'nav-item dropdown' : ''}} {{  $isActive ? 'active' : ''}}">
                 @can($menu->permission ? $menu->permission->name : '')
                 <a href="{{ Route::has($menu->route) ? route($menu->route) : '#'}}" class="nav-link {{ $menu->route == '' ? 'has-dropdown' : ''}}"><i class="{{ $menu->icon  == '' ? 'fas fa-fire' :  $menu->icon}}"></i><span>{{ucwords($menu->name)}}</span>
                 </a>
                 @endcan
                 @if(isset($menuItemsByMenuId[$menu->id]) && count($menuItemsByMenuId[$menu->id]) > 0)
                 <ul class="dropdown-menu">
                     @foreach($menuItemsByMenuId[$menu->id] as $menuItem)
                     <li class="{{ Route::is($menuItem->route) ? 'active' : ''}}">
                         @can($menuItem->permission ? $menuItem->permission->name : '')
                         <a class="nav-link" href="{{ Route::has($menuItem->route) ? route($menuItem->route) : ''}}">{{ ucwords($menuItem->name) }}</a>
                         @endcan
                     </li>
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
