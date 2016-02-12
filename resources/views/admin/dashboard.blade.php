@extends('layouts.master')
@section('page-title', 'dashboard')
@section('custom-meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
@section('custom-styles')
<link href="/lib/tooltipster/tooltipster.css" rel="stylesheet">
<link href="/lib/tooltipster/tooltipster-noir.css" rel="stylesheet">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">
<link href="/lib/sweetalert/sweetalert.css" rel="stylesheet">
@stop
@section('page-content')
<table class="table table-condensed dashboard">
    <thead>
        <tr>
            <th>Título</th>
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
                        {{ ucfirst($book->title) }}
                   </a>
                </td>
                <td class="col-md-2 text-center">
                    <div class="btn-group">
                        <a href="{{ action('BookController@edit', ['id' => $book->id]) }}" class="btn btn-primary btn-xs tooltipster" title="editar información"><i class="fa fa-pencil button-icon"></i></a>
                        <a href="{{ action('BookPhotosController@create', ['id' => $book->id]) }}" class="btn btn-danger btn-xs tooltipster" title="agregar fotos">
                            <i class="fa fa-picture-o"></i>
                        </a> 
                        <span class="toggle-wrapper">{!! Form::checkbox('for-sale-' . $book->id, '1', $book->for_sale, ['class' => 'forsale', 'data-id' => $book->id]) !!}</span>
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
<script src="/lib/sweetalert/sweetalert.min.js"></script>
<script>
    var changingStatus = null;

    $('.forsale').bootstrapToggle({
        size: 'mini',
        on: 'en venta',
        off: 'no en venta',
        onstyle: 'success',
        offstyle: 'danger',
        width: 88
    });
    $('.toggle-wrapper').on('click', function(e){
        e.stopPropagation();

        if (changingStatus) {
            return;
        }

        var selectedSwitch = $(this).find('.forsale');
        var bookId  = selectedSwitch.data('id');
        var status  = ! selectedSwitch.prop('checked');

        changingStatus = $.ajax({
            url: '/admin/books/status',
            type: 'POST',
            timeout: 3000,
            cache: false,
            data: {
                id: bookId,
                status: status
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                changingStatus = null;
                selectedSwitch.bootstrapToggle('toggle');
            },
            error: function () {
                changingStatus = null;
                swal("¡Ups!", "Ocurrió un error al tratar de cambiar el estado del libro", "error");
            }
        });
    });

    $('.tooltipster').tooltipster({
        theme: 'tooltipster-noir'
    });
</script>
@stop