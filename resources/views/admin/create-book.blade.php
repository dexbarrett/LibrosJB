@extends('layouts.master')
@section('page-title', 'Agregar nuevo libro')
@section('custom-styles')
<link href="/lib/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
<link href="/lib/selectize/selectize.css" rel="stylesheet">
<link href="/lib/selectize/selectize.bootstrap3.css" rel="stylesheet">
@stop
@section('page-content')
{!! Form::open(['action' => 'BookController@store', 'files' => true]) !!}
<div class="row">
    <div class="col-md-7 col-md-offset-2">
        @include('partials.flash-messages')
        @include('partials.validation-errors')
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    {!! Form::label('title', 'Título del libro') !!}
                    {!! Form::text('title', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('format', 'Formato') !!}
                    {!! Form::select('format', $bookFormats, null, ['class' => 'form-control', 'placeholder' => 'seleccionar']) !!}
                </div>
            </div>   
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('author', 'Autor') !!}
                    {!! Form::select('author', [], null, ['class' => 'form-control autocomplete', 'data-url' => 'author-search']) !!}
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    {!! Form::label('publisher', 'Editorial') !!}
                    {!! Form::select('publisher', [], null, ['class' => 'form-control autocomplete', 'data-url' => 'publisher-search']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('language', 'Idioma') !!}
                    {!! Form::select('language', $bookLanguages, null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('edition_year', 'Año de la edición') !!}
                    {!! Form::text('edition_year', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'YYYY']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('pages', 'No. de páginas') !!}
                    {!! Form::text('pages', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('extract', 'Sinopsis') !!}
                    {!! Form::textarea('extract', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>    
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('cover', 'Imagen de portada') !!}
                    {!! Form::file('cover', ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('condition', 'Condición del libro') !!}
                    {!! Form::select('condition', $bookConditions, null, ['class' => 'form-control', 'placeholder' => 'selecciona']) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('price', 'Precio de venta') !!}
                    <div class="input-group">
                        {!! Form::text('price', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        <div class="input-group-addon">.00</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-md-offset-1">
                <div class="form-group forsale">
                   {!! Form::label('for-sale', 'En venta') !!}
                   {!! Form::checkbox('for-sale', '1', true) !!}
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
                    {!! Form::textarea('comments', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-12">
        {!! Form::submit('Publicar Libro', ['id' => 'publish', 'class' => 'btn btn-info btn-md btn-block']) !!}
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