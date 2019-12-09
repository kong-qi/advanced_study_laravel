<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion  " id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="javascript:;"
       href="javascript:;" admin-href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">管理后台 <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="javascript:;" admin-href="home.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>控制台</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Nav Item - Pages Collapse Menu -->
    @php
        $admin_menu=config('admin_menu');
    @endphp
    @foreach($admin_menu as $k=>$v)
        <li class="nav-item">
            @if(empty($v['sub_menus']))
                <a class="nav-link collapsed" href="javascript:;"  admin-href="{{ nroute('router') }}" >
                    <i class="fas fa-fw fa-cog"></i>
                    <span>{{ $v['name'] }}</span>
                </a>
            @else
                <a class="nav-link collapsed" href="javascript:;"  data-toggle="collapse"
                   data-target="#collapseTwo{{ $k }}"
                   aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>{{ $v['name'] }}</span>
                </a>
            @endif
            <div id="collapseTwo{{ $k }}" class="collapse" aria-labelledby="headingTwo{{ $k }}"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if(!empty($v['sub_menus']))
                        @foreach($v['sub_menus'] as $k2=>$v2)
                            <a class="collapse-item" href="javascript:;"
                               admin-href="{{ nroute($v2['router']) }}">{{ $v2['title'] }}</a>

                        @endforeach
                    @endif
                </div>
            </div>
        </li>
@endforeach


<!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
