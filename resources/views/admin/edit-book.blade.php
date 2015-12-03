@extends('layouts.master')
@section('page-title', 'editar libro')
@section('custom-styles')
<link href="/lib/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
<link href="/lib/selectize/selectize.css" rel="stylesheet">
<link href="/lib/selectize/selectize.bootstrap3.css" rel="stylesheet">
@stop
@section('page-content')
{!! Form::open(['action' => ['BookController@update', $book->id], 'files' => true]) !!}
<div class="row">
    <div class="col-md-7 col-md-offset-2">
        @include('partials.flash-messages')
        @include('partials.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('title', 'Título del libro') !!}
                    {!! Form::text('title', $book->title, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
            </div>    
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('author', 'Autor') !!}
                    {!! Form::select('author', $author, $book->author_id, ['class' => 'form-control autocomplete', 'data-url' => 'author-search']) !!}
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    {!! Form::label('publisher', 'Editorial') !!}
                    {!! Form::select('publisher', $publisher, $book->publisher_id, ['class' => 'form-control autocomplete', 'data-url' => 'publisher-search']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('language', 'Idioma') !!}
                    {!! Form::select('language', $bookLanguages, $book->language_id, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('edition_year', 'Año de la edición') !!}
                    {!! Form::text('edition_year', $book->edition_year, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'YYYY']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('pages', 'No. de páginas') !!}
                    {!! Form::text('pages', $book->pages, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('extract', 'Sinopsis') !!}
                    {!! Form::textarea('extract', $book->extract, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>    
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('condition', 'Condición del libro') !!}
                    {!! Form::select('condition', $bookConditions, $book->book_condition_id, ['class' => 'form-control', 'placeholder' => 'selecciona']) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('price', 'Precio de venta') !!}
                    <div class="input-group">
                        {!! Form::text('price', $book->sale_price, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        <div class="input-group-addon">.00</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-md-offset-1">
                <div class="form-group forsale">
                   {!! Form::label('for-sale', 'En venta') !!}
                   {!! Form::checkbox('for-sale', '1', $book->for_sale) !!}
               </div>
           </div>
       </div>
       <div class="row">
           <div class="col-md-12">
               <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title text-right">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Agregar comentarios
                        <span class="pull-right "><i class="fa fa-plus-square"></i></span>
                      </a>
                  </h4>
              </div>
              <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    {!! Form::textarea('comments', $book->comments, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-12">
        {!! Form::submit('Actualizar Libro', ['id' => 'publish', 'class' => 'btn btn-info btn-md btn-block']) !!}
    </div>
</div>
</div>
</div>
{!! Form::close() !!}
@stop
@section('custom-scripts')
<script src="/lib/bootstrap-switch/bootstrap-switch.min.js"></script>
<script src="/lib/bootstrap-filestyle/bootstrap-filestyle.min.js"></script>
<script src="/lib/selectize/selectize.min.js"></script>
<script>
    $("[name='for-sale']").bootstrapSwitch({
        animate: false,
        onColor: 'success',
        offColor: 'danger',
        onText: 'Sí',
        offText: 'No',
        size: 'large'
    });

    $('#cover').filestyle({
        buttonText: '',
        buttonName: 'btn-success',
        size: 'lg',
        iconName: 'fa fa-picture-o',
        placeholder: 'seleccione un archivo de imagen'
    });

    $('#publish').on('click', function(e){
        e.preventDefault();
        $(this).prop('disabled', true);
        $('form').first().submit();
    });
    
    $('#collapseOne').on('show.bs.collapse', function () {
        $(this).siblings().find('i').removeClass('fa-plus-square').addClass('fa-minus-square');
    });
    $('#collapseOne').on('hidden.bs.collapse', function () {
        $(this).siblings().find('i').removeClass('fa-minus-square').addClass('fa-plus-square');
    });

    $('.autocomplete').each(function(){
        var searchUrl = $(this).data('url');

        $(this).selectize({
            valueField: 'id',
            labelField: 'name',
            searchField: ['name'],
            create: true,
            persist: false,
            highlight: false,

            render: {
                option_create: function(data, escape){
                    return '<div class="create">Agregar <strong>' + escape(data.input) + '</strong>&hellip;</div>';
                }
            },

            load: function(query, callback){
                if (!query.length) return callback();
                $.ajax({
                    url: '/' + searchUrl,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query
                    },
                    error: function(){
                        callback();
                    },
                    success: function(data){
                        callback(data);
                    }
                });
            }

        });
    });
</script>
@stop