@extends('layouts.master')
@section('page-title', 'Conversaciones')
@section('page-content')
    <div class="row">
        <div class="col-md-10">
            <ul>
                @foreach($conversations as $conversation)
                    <li>
                    <a href="{{ action('MessagesController@showConversation', ['conversationID' => $conversation->id]) }}">
                        {{ ucwords($conversation->bookTitle) }}
                    </a>
                    @if($conversation->unreadCount > 0)
                        <span class="badge">{{ $conversation->unreadCount }}</span>
                    @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@stop