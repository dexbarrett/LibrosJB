@extends('layouts.master')
@section('page-title', 'Libros en venta')
@section('page-content')
@foreach($books->chunk(4) as $row)
    <div class="row book-row">
        @foreach($row as $book)
            <div class="col-md-3 col-sm-6 book">
                <img src="/images/book-covers/{{ $book->cover_picture }}" title="{{ $book->title }}" class="img-responsive img-thumbnail center-block">
            </div>
        @endforeach
    </div>
@endforeach
@stop