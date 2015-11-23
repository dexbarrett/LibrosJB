@extends('layouts.master')
@section('page-title', 'Libros en venta')
@section('navbar-content')
<div id="navbar" class="collapse navbar-collapse">
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
</div><!--/.nav-collapse -->
@stop
@section('page-content')
@foreach($books->chunk(4) as $row)
    <div class="row book-row">
        @foreach($row as $book)
            <div class="col-md-3 col-sm-6 book">
                <img src="/images/book-covers/{{ $book->cover_picture }}" title="{{ $book->title }}" class="img-responsive img-thumbnail center-block">
            </div>
        @endforeach
    </div>
    <div class="row text-center">
        {!! $books->render() !!}
    </div>
@endforeach
@stop