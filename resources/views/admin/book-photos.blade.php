@extends('layouts.master')
@section('page-title', 'Agregar fotos')
@section('custom-styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/dropzone.css" rel="stylesheet">
@stop
@section('page-content')
{!! Form::open(['action' => ['BookPhotosController@store', $bookID], 'class' => 'dropzone']) !!}
{!! Form::close() !!}
@stop
@section('custom-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/dropzone.js"></script>
<script>
    Dropzone.autoDiscover = false;
    $('.dropzone').dropzone({
        paramName: 'photo',
        acceptedFiles: 'image/*',
        maxFiles: 5,
        dictInvalidFileType: 'tipo de archivo inválido',
        dictDefaultMessage: 'Haz clic aquí o arrastra imágenes directamente',
        dictMaxFilesExceeded: 'número de imágenes excedido'
    });
</script>
@stop