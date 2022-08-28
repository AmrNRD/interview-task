<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('dashboard')}}" class="nav-link">Home</a>
        </li>
    </ul>
    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item" style="width:66px;text-align:center">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
        <li class="nav-item dropdown" style="width:66px">
            <a class="nav-link" data-toggle="dropdown" href="#" style="width:66px;padding: 3px 11px;">
                <img src="{{asset('layout-dist')}}/img/logo.png" alt="Hydrogen Logo" class="w-100 h-100 rounded-circle" style="opacity: .8">
{{--                          <img src="{{asset('layout-dist')}}/img/user1-128x128.jpg" alt="User Avatar" class="w-100 h-100 rounded-circle">--}}
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item" style="padding:0;background:url('https://demo.dashboardpack.com/kero-html-sidebar-pro/assets/images/dropdown-header/city1.jpg')">
                    <!-- Message Start -->
                    <div class="media" style="background: #000000b3;color: #ffffff;padding:26px 7px">
                        {{--              <img src="{{asset('layout-dist')}}/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 rounded-circle">--}}
                        <div class="media-body">
                            <h2 class="dropdown-item-title" style="font-size: 21px;font-family: sans-serif;font-weight: bold;">{{Auth::user()?->name}}</h2>
                            <p class="badge badge-primary text-sm">Administration</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
