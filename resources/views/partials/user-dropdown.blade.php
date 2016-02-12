<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-user menu-icon"></span>{{ auth()->user()->name }}  <i class="fa fa-chevron-circle-down"></i></a>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ action('MessagesController@listConversations') }}">
                <i class="fa fa-envelope menu-icon"></i>Mensajes
                @if($totalUnreadMessages > 0)
                    <span class="label label-info">
                            {{ $totalUnreadMessages  }}
                    </span>
                @endif
            </a>
        </li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ action('SessionController@logout') }}">Cerrar Sesión</a></li>
    </ul>
</li>