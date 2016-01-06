@extends('layouts.master')
@section('page-title', 'Inicio de Sesión')
@section('custom-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/4.12.0/bootstrap-social.min.css">
@stop
@section('page-content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div>
            @include('partials.flash-messages')
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                
            </div>
            <div class="panel-body text-center">
                <a href="{{ action('SessionController@authUserLogin') }}" class="btn btn-block btn-lg btn-social btn-facebook fb-login">
                    <span class="fa fa-facebook fb-login-icon"></span> iniciar sesión con Facebook
                </a>
            </div>
        </div>
    </div>
</div>
@stop