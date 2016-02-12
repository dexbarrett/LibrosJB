@extends('layouts.master')
@section('page-title', $book->title)
@section('custom-styles')
<link href="/lib/fancybox/jquery.fancybox.css" rel="stylesheet">
@stop
@section('page-content')
<div class="row">
    <div class="col-md-3 book-detail-cover">
        <img src="/{{ $book->cover_thumbnail_path }}" alt="{{ $book->title }}" class="img-responsive">
        @if(auth()->guest())
            <a href="{{ action('SessionController@showUserLogin') }}" class="btn btn-info book-details-buy">
                contactar vendedor
            </a>
        @elseif(auth()->check() && !$book->isSoldBy(auth()->user()->id))
            {!! Form::open(['action' => ['MessagesController@createConversation', $book->id]]) !!}
            {!! Form::submit('contactar vendedor', ['class' => 'btn btn-info book-details-buy']) !!}
            {!! Form::close() !!}
        @endif
    </div>
    <div class="col-md-9 book-details">
        <h2>{{ ucfirst($book->title) }}</h2>
        <ul>
            <li>Autor - <strong>{{ $book->author->name }}</strong></li>
            <li>Editorial - <strong>{{ $book->publisher->name }}</strong></li>
            <li>Año de edición - <strong>{{ $book->edition_year }}</strong></li>
            <li>Número de páginas - <strong>{{ $book->pages }}</strong></li>
            <li>Formato - <strong>{{ $book->format->name }}</strong></li>
            <li>Precio - <strong>${{ $book->sale_price }}</strong></li>
            <li>Idioma - <strong>{{ $book->language->name }}</strong></li>
            <li>Condición - <strong>{{ $book->condition->name }}</strong></li>
        </ul>
        <p><strong>Sinopsis</strong></p>
        <p class="text-justify">{{ $book->extract }}</p>
        @if($book->hasComments())
        <div class="alert alert-warning">
            <p><strong>Notas del vendedor</strong></p>
            <p>{{ $book->comments }}</p>
        </div>
        @endif
        <hr>
        <div class="row">
            @include('partials.photo-gallery')
        </div>
    </div>
</div>
@stop
@section('custom-scripts')
<script src="/lib/fancybox/jquery.fancybox.pack.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".fancybox").fancybox({
            loop: false,
            tpl: {
                error: '<p class="fancybox-error">No fue posible cargar la imagen</p>'
            }
        });
    });
</script>
@stop