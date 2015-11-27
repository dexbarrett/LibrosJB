@extends('layouts.master')
@section('page-title', 'dashboard')
@section('custom-styles')
<link href="/lib/tooltipster/tooltipster.css" rel="stylesheet">
<link href="/lib/tooltipster/tooltipster-noir.css" rel="stylesheet">
@stop
@section('page-content')
<table class="table table-condensed dashboard">
    <thead>
        <tr>
            <th>título</th>
            <th class="text-center">
                <a href="{{ action('BookController@create') }}" class="btn btn-info btn-sm">nuevo libro</a></th>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($userBooks as $book)
            <tr>
                <td class="col-md-10">
                   <a href="{{ action('BookController@show', ['slug' => $book->url_slug]) }}" target="_blank">
                        {{ $book->title }}
                   </a>
                </td>
                <td class="col-md-2 text-center">
                    <div class="btn-group">
                        <a href="#" class="btn btn-primary btn-sm tooltipster" title="editar">
                            <i class="fa fa-pencil button-icon"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop
@section('custom-scripts')
<script src="/lib/tooltipster/jquery.tooltipster.min.js"></script>
<script>
    $('.tooltipster').tooltipster({
        theme: 'tooltipster-noir'
    });
</script>
@stop