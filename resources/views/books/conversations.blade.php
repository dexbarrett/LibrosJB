@extends('layouts.master')
@section('page-title', 'Conversaciones')
@section('custom-meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
@section('page-content')
    <div class="row">
        <div class="col-md-10">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#conversations" aria-controls="conversations" role="tab" data-toggle="tab">Conversaciones</a></li>
                <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Configuración</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane messages-tab active" id="conversations">
                    <ul>
                        @foreach($conversations as $conversation)
                        <li>
                            <a href="{{ action('MessagesController@showConversation', ['conversationID' => $conversation->id]) }}">
                                {{ ucwords($conversation->bookTitle) }}
                            </a>
                        @if($conversation->unreadCount > 0)
                            <span class="label label-info">
                            {{ $conversation->unreadCount  }}
                            {{ pluralize('mensaje', $conversation->unreadCount) }}
                            sin leer
                            </span>
                        @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane messages-tab" id="settings">
                    <input id="email-notifications" type="checkbox" value="1" @if($conversation->email_notifications) checked @endif> recibir una notificación por correo cuando alguien me envíe un mensaje
                </div>
            </div>
        </div>
    </div>
@stop
@section('custom-scripts')
<script type="text/javascript" src="/lib/stickytabs/jquery.stickytabs.js"></script>
<script>
    $('.nav-tabs').stickyTabs();
    
    $('#email-notifications').on('click', function(){
        var emailNotifications = $(this).prop('checked');

        $.ajax({
            url: '/me/settings/email_notifications',
            type: 'POST',
            timeout: 3000,
            cache: false,
            data: {
                emailNotifications: emailNotifications
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
@stop