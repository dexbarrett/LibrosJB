@extends('layouts.master')
@section('page-title', 'Libros en venta')
@section('navbar-content')
    <ul class="nav navbar-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">ordenar por <strong>{{ $sortField }}</strong> <span class="fa fa-sort-{{ $direction }}"></span></a>
            <ul class="dropdown-menu">
                <li>{!! sortBooksBy('título', 'titulo', 'asc') !!}</li>
                <li>{!! sortBooksBy('autor', 'autor', 'asc') !!}</li>
                <li>{!! sortBooksBy('precio', 'precio', 'asc') !!}</li>
            </ul>
        </li>
    </ul>
@stop
@section('page-content')
@foreach($books->chunk(4) as $row)
    <div class="row book-row">
        @foreach($row as $book)
            <div class="col-md-3 col-sm-6 book">
                <a href="{{ action('BookController@show', ['slug' => $book->url_slug]) }}">
                    <img src="/{{ $book->cover_thumbnail_path }}" title="{{ $book->title }}" class="img-responsive img-thumbnail center-block">
                </a>
            </div>
        @endforeach
    </div>
    <div class="row text-center">
        {!! $books->render() !!}
    </div>
@endforeach
@stop