@extends('layouts.master')
@section('page-title', 'dashboard')
@section('custom-meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
@section('custom-styles')
<link href="/lib/tooltipster/tooltipster.css" rel="stylesheet">
<link href="/lib/tooltipster/tooltipster-noir.css" rel="stylesheet">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">
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
                        <a href="{{ action('BookController@edit', ['id' => $book->id]) }}" class="btn btn-primary btn-xs tooltipster" title="editar"><i class="fa fa-pencil button-icon"></i></a> 
                        {!! Form::checkbox('for-sale-' . $book->id, '1', $book->for_sale, ['class' => 'forsale', 'data-id' => $book->id]) !!}
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop
@section('custom-scripts')
<script src="/lib/tooltipster/jquery.tooltipster.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>
<script>
    $('.forsale').bootstrapToggle({
        size: 'mini',
        on: 'en venta',
        off: 'vendido',
        onstyle: 'success',
        offstyle: 'danger'
    });
    $('.forsale').on('change', function(e){
        var bookId = $(this).data('id');
        var state  = $(this).prop('checked');
        $.ajax({
            url: '/admin/books/status/' + bookId + '/' + state,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            error: function(){
                console.log('deeead');
            }
        });
    });
    $('.tooltipster').tooltipster({
        theme: 'tooltipster-noir'
    });
</script>
@stop