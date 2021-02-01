<!-- START HEADER-->
<header class="header">
    <div class="page-brand" >
        <a class="link" href="/">
            <span class="brand">
                Inventory <span class="brand-tip">MGMT</span>
                {{-- <img src="{{asset('assets/img/logo.png')}}" class="" width="80%" alt="closet Nepal Logo"> --}}
            </span>
            <span class="brand-mini">IM</span>
        </a>
    </div>
    <div class="flexbox flex-1">
        <!-- START TOP-LEFT TOOLBAR-->
        <ul class="nav navbar-toolbar">
            <li>
                <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
            </li>
        </ul>
        <!-- END TOP-LEFT TOOLBAR-->
        <!-- START TOP-RIGHT TOOLBAR-->
        <ul class="nav navbar-toolbar">
            <li class="dropdown dropdown-user">
                <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                    <span></span>{{ucwords(Auth::user()->name)}}<i class="fa fa-angle-down m-l-5"></i></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href=""><i class="fa fa-key"></i>Password Change</a>
                    <li class="dropdown-divider"></li>

                    {{-- <a class="dropdown-item" href="{{ route('logout') }}">
                    <i class="fa fa-power-off"></i>Logout</a> --}}
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fa fa-power-off"></i>Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            </li>
        </ul>
        <!-- END TOP-RIGHT TOOLBAR-->
    </div>
</header>
<!-- END HEADER-->