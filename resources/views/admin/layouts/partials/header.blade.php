  <header class="main-header">

    <a href="{{ url('admin') }}" class="logo">
      <span class="logo-mini"><b>{{ site_name() }}</b></span>
      <span class="logo-lg"><b>{{ site_name() }}</b></span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">导航开关</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li><a href="{{ url('/') }}"> <span>前台</span></a></li>

          <li class="dropdown user user-menu">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

              <img src="{{ Auth::user()->getAvatarUrl() }}" class="user-image" alt="User Image">

              <span class="hidden-xs">{{ Auth::user()->fullname }}</span>
            </a>
            <ul class="dropdown-menu">

              <li class="user-header">
                <img src="{{ Auth::user()->getAvatarUrl() }}" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::user()->fullname }}
                  <small>创建于{{ Auth::user()->created_at->format('Y-m-d H:i:s') }}</small>
                </p>
              </li>

              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ route('account.dashboard') }}" class="btn btn-default btn-flat">我的账户</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat">登出</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>