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
            <ul class="nav navbar-nav navbar-right">
            @if(auth()->check())
                 @if(auth()->user()->isAdmin())
                    @include('partials.admin-dropdown')
                @else
                    @include('partials.user-dropdown')
                @endif
            @else
                <li>
                    <a href="{{ action('SessionController@showUserLogin') }}">Iniciar Sesión</a>
                </li>
            @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>