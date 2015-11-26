@extends('layouts.master')
@section('page-title', 'Iniciar Sesión')
@section('page-content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div>
            @include('partials.flash-messages')
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                {!! Form::open(['action' => 'SessionController@authAdminLogin']) !!}
                    <fieldset>
                        <div class="form-group">
                            {!! Form::text('email', null, ['class' => 'form-control text-center', 'placeholder' => 'usuario@correo.com', 'autocomplete' => 'off']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::password('password', ['class' => 'form-control text-center', 'placeholder' => 'password']) !!}
                        </div>
                        {!! Form::submit('iniciar sesión', ['class' => 'btn btn-danger btn-block']) !!}
                    </fieldset>
                {!! Form::close() !!}
            </div>  
        </div>
    </div>
</div>
@stop