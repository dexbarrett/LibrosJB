@extends('layouts.master')
@section('page-title', 'Agregar fotos')
@section('custom-meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
@section('custom-styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/dropzone.css" rel="stylesheet">
<link href="/lib/sweetalert/sweetalert.css" rel="stylesheet">
@stop
@section('page-content')
<div class="row">
    <ul class="img-list">
        @if($book->photos->count() > 0)
                @foreach($book->photos as $photo)
                    <li>
                        <img src="/{{ $photo->thumbnail_path }}" alt="" class="img-responsive">
                        <div class="delete-photo">
                            <a href="#" class="btn btn-sm btn-danger" data-photo-id="{{ $photo->id }}"><i class="fa fa-trash fa-4x"></i></a>
                        </div>
                    </li>
                @endforeach
        @endif
    </ul>
</div>
<div class="row">
<hr>
</div>
<div class="row">
    {!! Form::open(['action' => ['BookPhotosController@store', $book->id], 'class' => 'dropzone']) !!}
    {!! Form::close() !!}
</div>
@stop
@section('custom-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/dropzone.js"></script>
<script src="/lib/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.2.1/mustache.min.js"></script>
<script id="photo-template" type="x-tmpl-mustache">
 <li>
    <img src="/@{{ thumbnailPath }}" class="img-responsive">
    <div class="delete-photo">
        <a href="#" class="btn btn-sm btn-danger" data-photo-id="@{{ photoID }}"><i class="fa fa-trash fa-4x"></i></a>
    </div>
</li>
</script>
<script>
    photoTemplate = $('#photo-template').html();
    photoList = $('.img-list');

    Dropzone.autoDiscover = false;

    var uploader = new Dropzone('.dropzone', {
        paramName: 'photo',
        acceptedFiles: 'image/*',
        dictInvalidFileType: 'tipo de archivo inválido',
        dictDefaultMessage: 'Haz clic aquí o arrastra imágenes directamente',
        dictMaxFilesExceeded: 'número de imágenes excedido'
    });

    uploader.on('success', function(file, photoData){
        this.removeFile(file);
        var photoItem = $(Mustache.render(photoTemplate, photoData));
        photoItem.hide().appendTo(photoList).fadeIn();
    });

    $('.img-list').on('click', '.delete-photo a', function(e){
        e.preventDefault();
        var deleteLink = $(this);
        swal({
            title:'¿Realmente deseas eliminar la foto?',
            type:'warning',
            confirmButtonText:'Sí',
            cancelButtonText:'No',
            showCancelButton: true
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'DELETE',
                    cache: false,
                    url: '/admin/photos/delete',
                    data: {
                        photoID: deleteLink.data('photo-id')
                    },
                    success: function () {
                        deleteLink.closest('li').fadeOut('fast')
                        .promise().done(function(el){
                            el.remove();
                        });
                    },
                    error: function () {
                        swal("¡Ups!", "Ocurrió un error al tratar de eliminar la imagen", "error");
                    }
                });
            }
        }
        );
    });
</script>
@stop