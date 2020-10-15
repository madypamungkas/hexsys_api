<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

  <!-- Sidebar mobile toggler -->
  <div class="sidebar-mobile-toggler text-center">
    <a href="#" class="sidebar-mobile-main-toggle">
      <i class="icon-arrow-left8"></i>
    </a>
    Navigation
    <a href="#" class="sidebar-mobile-expand">
      <i class="icon-screen-full"></i>
      <i class="icon-screen-normal"></i>
    </a>
  </div>
  <!-- /sidebar mobile toggler -->


  <!-- Sidebar content -->
  <div class="sidebar-content">

    <!-- User menu -->
    <div class="sidebar-user">
      <div class="card-body">
        <div class="media">
          <div class="mr-3">
            <a href="#"><img src="../../../../global_assets/images/placeholders/placeholder.jpg" width="38" height="38" class="rounded-circle" alt=""></a>
          </div>

          <div class="media-body">
            <div class="media-title font-weight-semibold">{{Auth::user()->name}}</div>
            <div class="font-size-xs opacity-50">
              @php
                $role = Auth::user()->getRoleNames()->toArray();
                $role = implode(', ',$role);
              @endphp
              <i class="icon-eye8 text-size-small"></i> &nbsp;{{$role}}
            </div>
          </div>

          <div class="ml-3 align-self-center">
            <a href="{{route('profile.index')}}" class="text-white"><i class="icon-cog3"></i></a>
          </div>
        </div>
      </div>
    </div>
    <!-- /user menu -->


    <!-- Main navigation -->
    <div class="card card-sidebar-mobile">
      <ul class="nav nav-sidebar" data-nav-type="accordion">

        <!-- Main -->
        <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
        <li class="nav-item">
          <a href="{{route('home')}}" class="nav-link @yield('dashboard')">
            <i class="icon-home4"></i>
            <span>
              Dashboard
            </span>
          </a>
        </li>
        <li class="nav-item"><a href="{{route('instansi.index')}}" class="nav-link @yield('instansi')"><i class="icon-office"></i><span>Instansi</span></a></li>
        <li class="nav-item"><a href="{{route('ambulan.index')}}" class="nav-link @yield('ambulan')"><i class="fa fa-ambulance"></i><span>Ambulan</span></a></li>
        {{-- <li class="nav-item nav-item-submenu">
          <a href="#" class="nav-link"><i class="icon-stack"></i> <span>Parent</span></a>

          <ul class="nav nav-group-sub" data-submenu-title="Starter kit">
            <li class="nav-item nav-item-submenu">
              <a href="#" class="nav-link">Child</a>
              <ul class="nav nav-group-sub">
                <li class="nav-item"><a href="#" class="nav-link">Putu</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Putu 2</a></li>
              </ul>
            </li>
            <li class="nav-item"><a href="#" class="nav-link">Divider</a></li>
            <li class="nav-item-divider"></li>
            <li class="nav-item"><a href="#" class="nav-link">To Divider</a></li>
          </ul>
        </li> --}}
        <!-- /main -->

        <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Master</div> <i class="icon-menu" title="Master"></i></li>
        <li class="nav-item"><a href="{{route('user.index')}}" class="nav-link @yield('user')"><i class="icon-users"></i><span>User</span></a></li>
        <li class="nav-item"><a href="{{route('component.index')}}" class="nav-link @yield('component')"><i class="icon-pen2"></i><span>Komponen</span></a></li>


      </ul>
    </div>
    <!-- /main navigation -->

  </div>
  <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
