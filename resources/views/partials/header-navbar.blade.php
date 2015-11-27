<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Libros JB</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            @yield('navbar-content')
            @if(auth()->check() && auth()->user()->isAdmin())
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-user"></span>  {{ auth()->user()->email }}</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ action('DashboardController@index') }}">Dashboard</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ action('SessionController@logout') }}">Cerrar Sesión</a></li>
                            </ul>
                    </li>
                </ul>
            @endif
        </div><!--/.nav-collapse -->
    </div>
</nav>