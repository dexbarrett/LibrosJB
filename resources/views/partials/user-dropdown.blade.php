<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-user"></span>  {{ auth()->user()->email }}</a>
    <ul class="dropdown-menu">
        <li><a href="{{ action('MessagesController@listConversations') }}">Mensajes</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ action('SessionController@logout') }}">Cerrar Sesión</a></li>
    </ul>
</li>